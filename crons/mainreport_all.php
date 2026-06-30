<?php
//exit;
ini_set('max_execution_time', 400000000);

ini_set('mysql.connect_timeout', 400000000);
ini_set('default_socket_timeout', 400000000);
$con1 = mysqli_connect('10.34.240.214', 'webserveruser', 'K&dN&r4a8N@du0') or die(mysqli_error()); //cluster 2

$con2 = $con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
//$con=mysql_connect('10.34.240.3','webserveruser','K&dN&r4a8N@du0');
$con6 = mysqli_connect('10.34.240.214', 'webserveruser', 'K&dN&r4a8N@du0');

// Batch-insert flush size (single source of truth). Lower = smaller INSERT statements
// / lower per-statement memory. Used by both the all and adv insert paths.
if (!defined('MAINREPORT_BATCH_SIZE')) {
	define('MAINREPORT_BATCH_SIZE', 200);
}

date_default_timezone_set("Asia/Calcutta");
// Daily log file: one file per run-date, e.g. logs/mainreport_all_2026-05-30.log.
// Timezone is set first so the filename date matches the in-line timestamps.
// Existing single-file logs are left untouched; rotation/cleanup is handled externally.
$logFile = __DIR__ . '/../../logs/mainreport_all_' . date('Y-m-d') . '.log';
$logDebug = true;
if (!is_dir(dirname($logFile))) {
	@mkdir(dirname($logFile), 0775, true);
}
function log_line($level, $msg)
{
	global $logFile;
	@file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] [' . $level . '] ' . $msg . PHP_EOL, FILE_APPEND);
}
echo  $date1 = date('Y-m-d', strtotime("-1 days"));
$runStart = microtime(true);
log_line('INFO', 'run start date=' . $date1);
$txnFailed = false;
$userdate = date('dmY', strtotime("-1 days"));
$start_date = $date1 . ' 00:00:00';
$end_date = $date1 . ' 23:59:59';

$report = 'gamebardb_vodafone_qatar_report';

$currdate = date('Y-m-d');
//$currdate=date('Y-m-d',strtotime("+1 days"));
$currdate2 = date('Y-m-d H:i:s');

$main = 0;

//mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' and operator not like '%vodacom%' ;") or die(mysqli_error($con1));

//echo"hi";exit;
//all


$sql1 = "select * from gamebardb_vodafone_qatar_report.mainreportquery where (lastrun<'" . $currdate . "' or lastrun is null or lastrun='') and (mainreport_all is not null and mainreport_all !='') order by id asc limit 8";
//echo $sql1;exit;


$operatorsProcessed = 0;
if ($result1 = $con1->query($sql1)) {
	$main++;

	while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
		$operatorsProcessed++;


		$product = $row1['product'];
		$country = $row1['Country'];
		$operator = $row1['operator'];
		$mainreport_all = $row1['mainreport_all'];
		$mainreport_advertiser = $row1['mainreport_advertiser'];

		mysqli_query($con1, "DELETE FROM " . $report . ".`mainreport` WHERE `date`='" . $date1 . "'  and product='" . $product . "' and operator='" . $operator . "' ;") or die(mysqli_error($con1));

		//all

		$url = str_replace("[startdate]", $start_date, $mainreport_all);
		$url = str_replace("[enddate]", $end_date, $url);

		$adve = '';
		$query = str_replace("[advid]", $adve, $url);


		echo "<br>====" . date('Y-m-d H:i:s') . "==" .	 $query;



		$batchValues = [];
		$con6->begin_transaction();
		$iterStart = microtime(true);
		log_line('INFO', 'source query (all) product=' . $product . ' operator=' . $operator);
		if ($logDebug) {
			log_line('DEBUG', 'sql(all)=' . $query);
		}
		echo "<br>====" . date('Y-m-d H:i:s') . "==" .	 $query;
		if ($result = $con1->query($query)) {
			$con1->next_result();
			mysqli_query($con1, "update " . $report . ".`mainreportquery` set lastrun='" . $currdate2 . "' WHERE product='" . $product . "' and operator='" . $operator . "'");
			$main++;
			echo "====" . date('Y-m-d H:i:s') . "==<br>";
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$pcsent = $clicks = $uniq = $cg = $actcount = $actamount = $renewcount = $renewamount = $churn = $park = $pcsent = $cbsent = $conversion = $totalcount = $totalamount = $cbsentpercent = $advamount = 0;
				$pcsent = 0;
				$Date = $row['dt'];
				$clicks = $row['clicks'];

				$uniq = $row['uniq'];
				$cg = $row['cg'];
				$actcount = $row['act'];
				$actamount = $row['actamnt'];
				$renewcount = $row['ren'];
				$renewamount = $row['renamnt'];
				$churn = $row['churn'];
				$park = $row['Low'];
				$pcsent = $row['pcsent'];
				$cbsent = $row['cbsent'];
				$advertiser = 0;



				$advname = 'all';
				$conversion = ($row['act'] * 100) / $row['clicks'];
				$totalcount = $row['act'] + $row['ren'];
				$totalamount = $row['actamnt'] + $row['renamnt'];
				if ($row['act'] == 0) {
					$cbsentpercent = 0;
				} else {
					$cbsentpercent = ($cbsent * 100) / $row['act'];
				}
				$advamount = $row['cbsent'] * 12.75;

				//echo "hi";
				$batchValues[] = "('" . $Date . "','" . $clicks . "','" . $uniq . "','" . $cg . "','" . $conversion . "','" . $actcount . "','" . $actamount . "','" . $renewcount . "','" . $renewamount . "','" . $totalcount . "','" . $totalamount . "','" . $churn . "','" . $park . "','" . $cbsent . "','" . $cbsentpercent . "','" . $advamount . "','" . $advertiser . "','" . $operator . "','" . $product . "','" . $advname . "','" . $country . "','" . $pcsent . "')";
				if (count($batchValues) >= MAINREPORT_BATCH_SIZE) {
					$n = count($batchValues);
					if (!$con6->query("INSERT INTO " . $report . ".`mainreport`(`Date`,`clicks`,`uniq`,`cg`,`conversion`,`actcount`,`actamount`,`renewcount`,`renewamount`,`totalcount`,`totalamount`,`churn`,`park`,`cbsent`,`cbsentpercent`,`advamount`,`advertiser`,`operator`,`product`,`advname`,`country`,`pcsent`) VALUES " . implode(',', $batchValues))) {
						log_line('ERROR', 'batch insert failed (all) product=' . $product . ' operator=' . $operator . ' err=' . $con6->error);
						$txnFailed = true;
					} else {
						log_line('DEBUG', 'inserted batch rows=' . $n . ' product=' . $product . ' advname=all');
					}
					$batchValues = [];
				}
			}
			if (!empty($batchValues)) {
				$n = count($batchValues);
				if (!$con6->query("INSERT INTO " . $report . ".`mainreport`(`Date`,`clicks`,`uniq`,`cg`,`conversion`,`actcount`,`actamount`,`renewcount`,`renewamount`,`totalcount`,`totalamount`,`churn`,`park`,`cbsent`,`cbsentpercent`,`advamount`,`advertiser`,`operator`,`product`,`advname`,`country`,`pcsent`) VALUES " . implode(',', $batchValues))) {
					log_line('ERROR', 'batch insert failed (all tail) product=' . $product . ' operator=' . $operator . ' err=' . $con6->error);
					$txnFailed = true;
				} else {
					log_line('DEBUG', 'inserted batch rows=' . $n . ' product=' . $product . ' advname=all');
				}
				$batchValues = [];
			}
		} else {
			log_line('ERROR', 'source query failed (all) product=' . $product . ' operator=' . $operator . ' err=' . $con1->error);
			$txnFailed = true;
		}
		//	$result->close();
		//$result1->close();




		//advertiser wise

		// Per-source advertiser list: derive this operator's source DB from its proc
		// template and fetch only the advertisers that actually exist in that DB.
		// (Restores legacy mainreport.php behaviour; the global advertiserdb list
		// caused ~200 no-op proc calls per operator.)
		//
		// The DB MUST come from $mainreport_advertiser because the loop below executes
		// that template. When it is empty (some operators have no per-advertiser
		// proc) or unparseable, skip the loop entirely — the "all" row above is still
		// produced. This also kills the blank-err 'source query failed (adv)' lines
		// those empty-template operators logged 211x each (e.g. Ethiopia, KSA_All_*).
		$sourcedb = '';
		if (!empty($mainreport_advertiser) && preg_match('/call\s+([A-Za-z0-9_]+)\./i', $mainreport_advertiser, $mDb)) {
			$sourcedb = $mDb[1];
		}

		$advertisers = [];
		if ($sourcedb !== '') {
			$sqlAdv = "SELECT advertiserid, advname FROM `" . $sourcedb . "`.advertiser ORDER BY advertiserid ASC";
			if ($rAdv = $con1->query($sqlAdv)) {
				while ($rRow = mysqli_fetch_array($rAdv, MYSQLI_ASSOC)) {
					$advertisers[] = $rRow;
				}
				$con1->next_result();
			} else {
				// Skip the advertiser loop (the all row above is still produced).
				// Do NOT fall back to the global list.
				log_line('ERROR', 'advertiser list query failed product=' . $product . ' operator=' . $operator . ' sourcedb=' . $sourcedb . ' err=' . $con1->error);
			}
		} else if (!empty($mainreport_advertiser)) {
			log_line('ERROR', 'could not parse sourcedb from advertiser template product=' . $product . ' operator=' . $operator);
		} else {
			log_line('INFO', 'no advertiser template; skipping advertiser loop product=' . $product . ' operator=' . $operator);
		}

		$advLoopStart = microtime(true);

		foreach ($advertisers as $row22) {

			$advid = $row22['advertiserid'];
			$advname = $row22['advname'];

			$url1 = str_replace("[startdate]", $start_date, $mainreport_advertiser);
			$url1 = str_replace("[enddate]", $end_date, $url1);

			$query1 = str_replace("[advid]", $advid, $url1);





			//echo "<br>".$query1;

			log_line('INFO', 'source query (adv) product=' . $product . ' operator=' . $operator . ' advid=' . $advid);
			if ($logDebug) {
				log_line('DEBUG', 'sql(adv)=' . $query1);
			}
			echo "<br>====" . date('Y-m-d H:i:s') . "==" .	 $query1;

			if ($result = $con1->query($query1)) {
				$main++;
				echo "====" . date('Y-m-d H:i:s') . "==<br>";
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$pcsent = $clicks = $uniq = $cg = $actcount = $actamount = $renewcount = $renewamount = $churn = $park = $pcsent = $cbsent = $conversion = $totalcount = $totalamount = $cbsentpercent = $advamount = 0;
					$pcsent = 0;
					$Date = $row['dt'];
					$clicks = $row['clicks'];

					$uniq = $row['uniq'];
					$cg = $row['cg'];
					$actcount = $row['act'];
					$actamount = $row['actamnt'];
					$renewcount = $row['ren'];
					$renewamount = $row['renamnt'];
					$churn = $row['churn'];
					$park = $row['Low'];
					$pcsent = $row['pcsent'];
					$cbsent = $row['cbsent'];
					$advertiser = $advid;



					$conversion = ($row['act'] * 100) / $row['clicks'];
					$totalcount = $row['act'] + $row['ren'];
					$totalamount = $row['actamnt'] + $row['renamnt'];
					if ($row['act'] == 0) {
						$cbsentpercent = 0;
					} else {
						$cbsentpercent = ($cbsent * 100) / $row['act'];
					}
					$advamount = $row['cbsent'] * 12.75;

					//echo "hi";
					$batchValues[] = "('" . $Date . "','" . $clicks . "','" . $uniq . "','" . $cg . "','" . $conversion . "','" . $actcount . "','" . $actamount . "','" . $renewcount . "','" . $renewamount . "','" . $totalcount . "','" . $totalamount . "','" . $churn . "','" . $park . "','" . $cbsent . "','" . $cbsentpercent . "','" . $advamount . "','" . $advertiser . "','" . $operator . "','" . $product . "','" . $advname . "','" . $country . "','" . $pcsent . "')";
					if (count($batchValues) >= MAINREPORT_BATCH_SIZE) {
						$n = count($batchValues);
						if (!$con6->query("INSERT INTO " . $report . ".`mainreport`(`Date`,`clicks`,`uniq`,`cg`,`conversion`,`actcount`,`actamount`,`renewcount`,`renewamount`,`totalcount`,`totalamount`,`churn`,`park`,`cbsent`,`cbsentpercent`,`advamount`,`advertiser`,`operator`,`product`,`advname`,`country`,`pcsent`) VALUES " . implode(',', $batchValues))) {
							log_line('ERROR', 'batch insert failed (adv) product=' . $product . ' advid=' . $advid . ' err=' . $con6->error);
							$txnFailed = true;
						} else {
							log_line('DEBUG', 'inserted batch rows=' . $n . ' product=' . $product . ' advname=' . $advname);
						}
						$batchValues = [];
					}
				}
				if (!empty($batchValues)) {
					$n = count($batchValues);
					if (!$con6->query("INSERT INTO " . $report . ".`mainreport`(`Date`,`clicks`,`uniq`,`cg`,`conversion`,`actcount`,`actamount`,`renewcount`,`renewamount`,`totalcount`,`totalamount`,`churn`,`park`,`cbsent`,`cbsentpercent`,`advamount`,`advertiser`,`operator`,`product`,`advname`,`country`,`pcsent`) VALUES " . implode(',', $batchValues))) {
						log_line('ERROR', 'batch insert failed (adv tail) product=' . $product . ' advid=' . $advid . ' err=' . $con6->error);
						$txnFailed = true;
					} else {
						log_line('DEBUG', 'inserted batch rows=' . $n . ' product=' . $product . ' advname=' . $advname);
					}
					$batchValues = [];
				}
			} else {
				log_line('ERROR', 'source query failed (adv) product=' . $product . ' operator=' . $operator . ' advid=' . $advid . ' err=' . $con1->error);
				$txnFailed = true;
			}
			//	$result->close();
			//$result1->close();
			$con1->next_result();
		}
		log_line('INFO', 'advertiser loop done product=' . $product . ' operator=' . $operator . ' advertisers=' . count($advertisers) . ' iter_secs=' . round(microtime(true) - $iterStart, 3) . ' adv_loop_secs=' . round(microtime(true) - $advLoopStart, 3));
		if ($txnFailed) {
			$con6->rollback();
			log_line('ERROR', 'transaction rolled back product=' . $product . ' operator=' . $operator);
			$txnFailed = false;
		} else if (!$con6->commit()) {
			log_line('ERROR', 'commit failed product=' . $product . ' operator=' . $operator . ' err=' . $con6->error);
		} else {
			log_line('INFO', 'commit ok product=' . $product . ' operator=' . $operator);
		}
	}
}

echo "<br>main=" . $main;

// Completion signal: deleteduplicate must run once every operator has been processed for today.
// The old `$main>=244` threshold counted proc calls, which Lever 1 slashes (~26k -> hundreds),
// so it would stop firing. Instead check whether any operator still has lastrun before today.
$pending = 0;
$sqlPending = "select count(*) as c from gamebardb_vodafone_qatar_report.mainreportquery where (lastrun<'" . $currdate . "' or lastrun is null or lastrun='') and (mainreport_all is not null and mainreport_all !='')";
if ($rPending = $con1->query($sqlPending)) {
	$rowPending = mysqli_fetch_array($rPending, MYSQLI_ASSOC);
	$pending = (int)$rowPending['c'];
}
log_line('INFO', 'run end main=' . $main . ' operators_processed=' . $operatorsProcessed . ' pending_operators=' . $pending . ' duration_secs=' . round(microtime(true) - $runStart, 3));

// Fire only on the invocation that finished the last operators, not on later idle
// runs (which would otherwise redirect to deleteduplicate.php repeatedly all day).
if ($operatorsProcessed > 0 && $pending === 0) {

	$cur_date = date('Y-m-d H-i:s');
	$sql = "update gamebardb_vodafone_qatar_report.cron_report set ran=1, date='" . $cur_date . "' where cron_name='mainreport'";
	$result = mysqli_query($con1, $sql);

	log_line('INFO', 'cron_report marked ran=1, redirecting to deleteduplicate.php');
	mysqli_close($con1);
	mysqli_close($con6);
	Header("location:deleteduplicate.php");
}
