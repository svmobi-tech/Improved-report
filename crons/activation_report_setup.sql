-- ============================================================================
-- Prerequisite for the Activation Report performance work.
--
-- crons/cron_activation_today.php UPSERTs today's rows with
--   INSERT ... ON DUPLICATE KEY UPDATE
-- which only dedupes when activation_report has a UNIQUE key on (date, hour).
-- Run this ONCE against the production DB before scheduling the new cron.
-- ============================================================================

-- 1) Check for existing duplicate (date, hour) rows. If this returns any rows,
--    resolve them (step 2) before adding the unique index, or the ALTER fails.
SELECT `date`, `hour`, COUNT(*) AS n
FROM gamebardb_vodafone_qatar_report.activation_report
GROUP BY `date`, `hour`
HAVING n > 1;

-- 2) OPTIONAL — only if step 1 returned duplicates. Keeps the newest row per
--    (date, hour) by max primary id. Adjust the id column name if different.
-- DELETE a
-- FROM gamebardb_vodafone_qatar_report.activation_report a
-- JOIN (
--     SELECT `date`, `hour`, MAX(id) AS keep_id
--     FROM gamebardb_vodafone_qatar_report.activation_report
--     GROUP BY `date`, `hour`
-- ) k ON a.`date` = k.`date` AND a.`hour` = k.`hour`
-- WHERE a.id < k.keep_id;

-- 3) Add the unique index. This also speeds the report's range read
--    (WHERE date BETWEEN ... AND hour = ...).
ALTER TABLE gamebardb_vodafone_qatar_report.activation_report
    ADD UNIQUE KEY uq_activation_date_hour (`date`, `hour`);
