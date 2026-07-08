# Activation Report — today refresh (ops setup)

Makes `admin/activationreport.php` fast for **today** by keeping today's rows
current in `gamebardb_vodafone_qatar_report.activation_report`, so the page reads
the pre-aggregated table instead of firing ~58 stored procedures live per request.

## One-time setup

1. **Add the unique index** required by the UPSERT — run `activation_report_setup.sql`
   against the production DB (it first checks for, and helps remove, any duplicate
   `(date, hour)` rows).

2. **Schedule the refresh cron** every ~10 minutes (within the accepted 5–15 min
   freshness budget). Add it next to the existing `cron_*` jobs in the same scheduler.

   - Linux cron:
     ```
     */10 * * * * php /path/to/crons/cron_activation_today.php >/dev/null 2>&1
     ```
   - Windows Task Scheduler (this deployment): create a task that runs every 10 min:
     ```
     php.exe D:\LipiLogic\svmobi\projects\Improved-report\crons\cron_activation_today.php
     ```
   - Or, if crons are triggered by URL like the others, hit:
     ```
     /crons/cron_activation_today.php
     ```

## What it does

- Refreshes only the hour buckets that can still change (current hour → 24);
  elapsed hours of today are already final. Cost scales down as the day progresses.
- **UPSERTs** each `(date, hour)` row — no whole-day DELETE, so the report never
  sees a half-wiped today mid-refresh.
- Uses a lock file (`logs/cron_activation_today.lock`) to skip overlapping runs.
- Logs to `logs/cron_activation_today_YYYY-MM-DD.log`.
- Backfill a specific date with `?date=YYYY-MM-DD` (does the full 24h when not today).

## First deploy (seeding today)

The slim cron only writes hours **≥ the current hour**. If you deploy mid-day, the
earlier hours of *today* won't be in the table yet — the report handles this by
falling back to the live computation for those, so nothing breaks. To seed today's
earlier hours immediately, run the nightly job once for today:

```
php crons/cron_activation.php?date=YYYY-MM-DD   # today (full 24h)
```

From the next midnight onward the slim cron seeds each day naturally.

## Fallback safety

If the cron is ever behind or stopped, `admin/activationreport.php` still renders
correct today numbers by falling back to the live stored-procedure computation
(`compute_today_live()`), just more slowly. Once the cron catches up, loads are fast
again. The nightly `cron_activation.php` (full-day finalization for past dates) is
unchanged.
