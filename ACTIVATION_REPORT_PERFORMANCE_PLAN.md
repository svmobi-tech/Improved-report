# Activation Report — Performance Improvement Plan

## Context

The Activation Report (`admin/activationreport.php`) is slow **only when the selected range includes today**. The page has two data paths:

- **Historical dates** — a single `SELECT` from the pre-aggregated table `gamebardb_vodafone_qatar_report.activation_report`. Fast (tens of ms).
- **Today** (`activationreport.php:263-345`) — computes activations **live** by firing **~58 stored procedures sequentially** (`call_sp()` → `CALL <db>.get_activation(start,end,hours)`), many countries summing 2–3 SPs. Every call is a blocking round-trip on one mysqli connection with **no parallelism**, and the SPs themselves scan large per-operator transaction tables. This is the bottleneck.

A recent band-aid caches today's result in `$_SESSION` for 5 min (`activationreport.php:267-345`), but it is **per-user** (each new session pays the full ~58-SP cost) and PHP's session write-lock **serializes** a user's concurrent requests.

The same numbers are **already precomputed** into `activation_report` by `crons/cron_activation.php` (24 hours × ~90 SPs → one INSERT per hour) — but that cron only runs for **past dates**, which is exactly why today falls back to the live fan-out.

**Decisions confirmed with user:** a 5–15 minute lag on today's data is acceptable, and an OS scheduler already runs the `cron_*.php` jobs.

**Goal:** make the report a pure, indexed table read for *all* dates (including today) so it always loads in milliseconds, and move today's SP fan-out into a cheap, frequently-scheduled background refresh.

## Approach (recommended)

Precompute today into `activation_report` on a short interval, and change the report to read the table for today too — with a live fallback so there is never a regression when the cron is momentarily behind.

### Change 1 — Report reads today from the table (`admin/activationreport.php`)

- Restructure the date-branch logic (currently `$b`/`$c` at lines 219-261 and the live block 263-345) so the **table `SELECT` covers the full requested range including today**. Today's rows now come from the same `SELECT * FROM ...activation_report WHERE date BETWEEN ... AND ... AND hour=...` used for historical data (lines 244-246), reusing the existing `$columns`/`$ll` render loop and the `glambar_poland = glambar_pl + glambar_pldmc` derivation (line 250).
- **Keep the live path only as a fallback:** extract the ~58 `call_sp()` block into a function (e.g. `compute_today_live($con1,...)`) and invoke it **only when today is requested but the table has no row for (today, selected hour)** — e.g. cron hasn't populated yet. This guarantees correctness with zero regression risk if the refresh cron is down.
- **Remove the `$_SESSION` cache** (lines 267-345, 343-344) — it becomes dead weight once the normal path is a table read. If the live fallback is kept, the cache may optionally wrap only that rare fallback.
- Reuse `call_sp()` (lines 101-109) as-is inside the fallback.

### Change 2 — Cheap, frequent "today refresh" cron (`crons/`)

The existing `crons/cron_activation.php` does a full-day recompute: `DELETE WHERE date=today` then re-INSERT 24 hourly rows over minutes. Running that every few minutes is both expensive (24 × ~90 ≈ 2000+ SP calls) **and racy** (the report can read the table mid-wipe and see empty/partial today).

Add a slim variant — **`crons/cron_activation_today.php`** (or a `?mode=today` flag on the existing cron) that:

- Recomputes **only the current hour** (and the previous 1 hour, to catch late-arriving data), not all 24 — past hours of today don't change once elapsed. Cuts each run from ~2000+ to ~90–270 SP calls.
- **UPSERTs** those specific `(date, hour)` rows (`INSERT ... ON DUPLICATE KEY UPDATE`) instead of deleting the whole day — eliminates the read-during-wipe race. Requires a unique index on `activation_report(date, hour)` (see Change 4).
- Guards against overlap with a lock file (skip if a previous run is still in progress), since the scheduler fires it every few minutes.
- Reuses the exact SP list and column mapping already in `cron_activation.php:78-218`.

Schedule this new cron every **~10 minutes** via the existing scheduler (well within the 5–15 min lag budget). Keep the full-day `cron_activation.php` for yesterday's finalization as today.

### Change 3 (optional, background-speed) — Parallelize SP calls in the cron

If even the slim per-hour refresh is slow, fan the independent SP calls out across a small pool (~8–10) of mysqli connections using `MYSQLI_ASYNC` + `mysqli_poll`, instead of one serial connection. ~8–10× wall-clock reduction. This affects only the background cron, never the request thread, so it carries no user-facing risk. Defer unless the slim refresh proves too slow.

### Change 4 — DB indexing (investigation, biggest true lever)

The real per-SP cost lives inside `get_activation`/`getactivation` (bodies are **not in this repo** — they're on the MySQL server). Two checks on the server:

- Ensure `activation_report` has a **unique index on `(date, hour)`** (needed for the UPSERT in Change 2 and to keep the report read fast).
- `EXPLAIN` a representative `get_activation` SP; confirm the per-operator transaction tables are **indexed on the datetime column** used in its `WHERE start/end/hour` filter. Missing indexes here slow both the cron and any live fallback.

## Critical files

- `admin/activationreport.php` — Change 1 (unify today onto the table read; extract live block to a fallback function; drop session cache).
- `crons/cron_activation.php` — reference for SP list / column mapping / INSERT (`:78-218`); source for the new slim cron.
- **new** `crons/cron_activation_today.php` — Change 2 (current-hour UPSERT refresh + lock).
- `admin/includes/config.php` — DB connections (`$con` = `DB_HOST`; cron uses `DB_PROD_HOST`); no change expected, but confirm the report and the refresh cron write/read the **same** server (`activation_report` must be visible to `$con` used by the page).
- Scheduler config (OS-level, outside repo) — register the new cron every ~10 min.

## Verification

1. **Correctness parity:** For today, capture the report's numbers via the current live path (temporarily), run the new refresh cron, then load the report reading from the table — the per-country values must match for the same `hours` value.
2. **Speed:** Time an AJAX "Generate Report" for a today-inclusive range before vs. after. Expect a drop from many seconds (~58 serial SPs) to sub-second (single indexed SELECT). Measure with browser devtools Network tab or `curl -w '%{time_total}'` against `admin/activationreport.php` with the AJAX header + POST body.
3. **Fallback:** Clear today's rows from `activation_report`, load the report → should transparently fall back to live compute and still render (slower, but correct). Re-run the cron → next load is fast again.
4. **No race:** Hammer the report while the refresh cron runs; confirm today never renders empty/partial (validates the UPSERT-vs-DELETE change).
5. **Cron cost/interval:** Log the slim cron's wall time; confirm it finishes comfortably under the 10-min interval and the overlap lock prevents stacking.
