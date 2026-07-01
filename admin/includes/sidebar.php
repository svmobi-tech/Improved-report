<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF'])); // 'admin' or 'adreports' etc.
?>
<div class="hp-sidebar">
  <div class="hp-sidebar-brand">
    <img src="images/logo.png" alt="SVMobi Logo">
    <span class="brand-name">SVMobi Reports</span>
  </div>

  <!-- User profile block -->
  <?php
    $displayName = ucfirst($_SESSION['username'] ?? 'User');
    $displayRole = !empty($_SESSION['admin']) ? 'Administrator' : 'User';
  ?>
  <div class="hp-sidebar-profile">
    <img src="images/dp.jpg" class="hp-sidebar-avatar" alt="<?php echo htmlspecialchars($displayName); ?>">
    <div class="hp-sidebar-profile-info">
      <span class="hp-sidebar-profile-name"><?php echo htmlspecialchars($displayName); ?></span>
      <span class="hp-sidebar-profile-role"><?php echo $displayRole; ?></span>
    </div>
  </div>
  <ul class="hp-nav">
    <li class="<?php echo $currentPage === 'dashboard.php' ? 'active' : ''; ?>">
      <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    </li>
    <li class="<?php echo $currentPage === 'subdash.php' ? 'active' : ''; ?>">
      <a href="subdash.php"><i class="fa fa-th-large"></i> Sub-Dashboard</a>
    </li>
    <li class="<?php echo ($currentPage === 'report.php' && $currentDir !== 'adreports') ? 'active' : ''; ?>">
      <a href="report.php"><i class="fa fa-file-text-o"></i> Main Report</a>
    </li>
    <li class="<?php echo $currentPage === 'activationreport.php' ? 'active' : ''; ?>">
      <a href="activationreport.php"><i class="fa fa-bolt"></i> Activation Report</a>
    </li>
    <li class="<?php echo ($currentPage === 'perform.php' && $currentDir !== 'adreports') ? 'active' : ''; ?>">
      <a href="perform.php"><i class="fa fa-line-chart"></i> Perform Report</a>
    </li>
    <li class="<?php echo $currentPage === 'trend_report.php' ? 'active' : ''; ?>">
      <a href="trend_report.php"><i class="fa fa-bar-chart"></i> Trend Report</a>
    </li>
    <li class="<?php echo $currentPage === 'last_activityreport.php' ? 'active' : ''; ?>">
      <a href="last_activityreport.php"><i class="fa fa-clock-o"></i> Last Activity</a>
    </li>
    <li class="<?php echo $currentPage === 'gamezop_report.php' ? 'active' : ''; ?>">
      <a href="gamezop_report.php"><i class="fa fa-gamepad"></i> Gamezop Report</a>
    </li>
    <li class="<?php echo $currentPage === 'performance.php' ? 'active' : ''; ?>">
      <a href="performance.php"><i class="fa fa-calendar"></i> Last 30 Days</a>
    </li>
    <li class="<?php echo $currentPage === 'performance2.php' ? 'active' : ''; ?>">
      <a href="performance2.php"><i class="fa fa-tachometer"></i> Current Month</a>
    </li>
    <li class="<?php echo $currentPage === 'urlmake.php' ? 'active' : ''; ?>">
      <a href="urlmake.php"><i class="fa fa-link"></i> Advertiser Urls</a>
    </li>
    <?php
      $contestPages = ['contest.php','contest_charging.php','promotion.php','engagement.php'];
      $contestOpen  = in_array($currentPage, $contestPages) ? 'open' : '';
    ?>
    <li class="has-submenu <?php echo $contestOpen; ?>">
      <a href="#"><i class="fa fa-trophy"></i> Contest</a>
      <ul class="hp-submenu">
        <li class="<?php echo $currentPage === 'contest.php'          ? 'active' : ''; ?>">
          <a href="contest.php"><i class="fa fa-trophy"></i> Leaderboard</a>
        </li>
        <li class="<?php echo $currentPage === 'contest_charging.php' ? 'active' : ''; ?>">
          <a href="contest_charging.php"><i class="fa fa-credit-card"></i> Charging Report</a>
        </li>
        <li class="<?php echo $currentPage === 'promotion.php'        ? 'active' : ''; ?>">
          <a href="promotion.php"><i class="fa fa-bullhorn"></i> Promotional Activity</a>
        </li>
        <li class="<?php echo $currentPage === 'engagement.php'       ? 'active' : ''; ?>">
          <a href="engagement.php"><i class="fa fa-users"></i> Engagement Activity</a>
        </li>
      </ul>
    </li>
    <?php
      $apiPages = ['api.php','apicharge.php'];
      $apiOpen  = in_array($currentPage, $apiPages) ? 'open' : '';
    ?>
    <li class="has-submenu <?php echo $apiOpen; ?>">
      <a href="#"><i class="fa fa-plug"></i> API</a>
      <ul class="hp-submenu">
        <li class="<?php echo $currentPage === 'api.php'       ? 'active' : ''; ?>">
          <a href="api.php"><i class="fa fa-code"></i> API Report</a>
        </li>
        <li class="<?php echo $currentPage === 'apicharge.php' ? 'active' : ''; ?>">
          <a href="apicharge.php"><i class="fa fa-percent"></i> API Charging %</a>
        </li>
      </ul>
    </li>
    <?php
      $otherPages = [
        'samedaydeactivation.php','samedaydeactivation2.php',
        'partner_tracking_report.php','pub_report.php',
        'activationsetting.php','callbackssetting.php',
        'cron_running_report.php','currency.php',
        'callbackreport.php','callbackanalysis.php',
        'adduat.php','alluat.php','checkactivation.php',
      ];
      $otherOpen = in_array($currentPage, $otherPages) ? 'open' : '';
    ?>
    <li class="has-submenu <?php echo $otherOpen; ?>">
      <a href="#"><i class="fa fa-folder-open-o"></i> Other Reports</a>
      <ul class="hp-submenu">
        <!-- <li class="<?php echo $currentPage === 'samedaydeactivation.php'    ? 'active' : ''; ?>">
          <a href="samedaydeactivation.php"><i class="fa fa-file-text-o"></i> SameDay Churn</a>
        </li>
        <li class="<?php echo $currentPage === 'samedaydeactivation2.php'   ? 'active' : ''; ?>">
          <a href="samedaydeactivation2.php"><i class="fa fa-file-text-o"></i> Churn Percentage Report</a>
        </li>
        <li class="<?php echo $currentPage === 'partner_tracking_report.php'? 'active' : ''; ?>">
          <a href="partner_tracking_report.php"><i class="fa fa-file-text-o"></i> Adnetwork Performance</a>
        </li>
        <li class="<?php echo $currentPage === 'pub_report.php'             ? 'active' : ''; ?>">
          <a href="pub_report.php"><i class="fa fa-file-text-o"></i> PubID wise Report</a> -->
        </li>
        <li class="<?php echo $currentPage === 'activationsetting.php'      ? 'active' : ''; ?>">
          <a href="activationsetting.php"><i class="fa fa-toggle-on"></i> Activation Report Setting</a>
        </li>
        <li class="<?php echo $currentPage === 'callbackssetting.php'       ? 'active' : ''; ?>">
          <a href="callbackssetting.php"><i class="fa fa-bell-o"></i> Callback Settings</a>
        </li>
        <!-- <li class="<?php echo $currentPage === 'cron_running_report.php'    ? 'active' : ''; ?>">
          <a href="cron_running_report.php"><i class="fa fa-clock-o"></i> Cron Analysis</a>
        </li> -->
        <li class="<?php echo $currentPage === 'currency.php'               ? 'active' : ''; ?>">
          <a href="currency.php"><i class="fa fa-money"></i> Currency</a>
        </li>
        <li class="<?php echo $currentPage === 'callbackreport.php'     ? 'active' : ''; ?>">
          <a href="callbackreport.php"><i class="fa fa-phone"></i> CallBackSent Report</a>
        </li>
        <!-- <li class="<?php echo $currentPage === 'callbackanalysis.php'       ? 'active' : ''; ?>">
          <a href="callbackanalysis.php"><i class="fa fa-bar-chart"></i> CallBackSent Analysis</a>
        </li> -->
        <li class="<?php echo $currentPage === 'adduat.php'                 ? 'active' : ''; ?>">
          <a href="adduat.php"><i class="fa fa-plus-circle"></i> Add UAT</a>
        </li>
        <li class="<?php echo $currentPage === 'alluat.php'                 ? 'active' : ''; ?>">
          <a href="alluat.php"><i class="fa fa-list-alt"></i> All UAT</a>
        </li>
        <li class="<?php echo $currentPage === 'checkactivation.php'        ? 'active' : ''; ?>">
          <a href="checkactivation.php"><i class="fa fa-check-circle-o"></i> Check Crons</a>
        </li>
      </ul>
    </li>
    <?php
      $adreportsPages = ['all_in_one_report.php', 'report.php', 'perform.php'];
      $adreportsOpen  = ($currentDir === 'adreports' && in_array($currentPage, $adreportsPages)) ? 'open' : '';
    ?>
    <li class="has-submenu <?php echo $adreportsOpen; ?>">
      <a href="#"><i class="fa fa-th"></i> AdNetwork Reports</a>
      <ul class="hp-submenu">
        <li class="<?php echo ($currentPage === 'all_in_one_report.php' && $currentDir === 'adreports') ? 'active' : ''; ?>">
          <a href="adreports/all_in_one_report.php"><i class="fa fa-list-alt"></i> All in One Report</a>
        </li>
        <li class="<?php echo ($currentPage === 'report.php' && $currentDir === 'adreports') ? 'active' : ''; ?>">
          <a href="adreports/report.php"><i class="fa fa-file-text-o"></i> Main Report</a>
        </li>
        <li class="<?php echo ($currentPage === 'perform.php' && $currentDir === 'adreports') ? 'active' : ''; ?>">
          <a href="adreports/perform.php"><i class="fa fa-line-chart"></i> Perform Report</a>
        </li>
        <li class="<?php echo ($currentPage === 'advertiser_publisher.php' && $currentDir === 'adreports') ? 'active' : ''; ?>">
          <a href="adreports/advertiser_publisher.php"><i class="fa fa-users"></i> Adv &amp; Pub Report</a>
        </li>
        <li class="<?php echo ($currentPage === 'trend_report.php' && $currentDir === 'adreports') ? 'active' : ''; ?>">
          <a href="adreports/trend_report.php"><i class="fa fa-bar-chart"></i> Trend Report</a>
        </li>
        <li class="<?php echo ($currentPage === 'pub_wise_act_dct.php' && $currentDir === 'adreports') ? 'active' : ''; ?>">
          <a href="adreports/pub_wise_act_dct.php"><i class="fa fa-exchange"></i> Pub wise Act &amp; Dct</a>
        </li>
        <li class="<?php echo $currentPage === 'counter_reset.php' ? 'active' : ''; ?>">
          <a href="counter_reset.php"><i class="fa fa-refresh"></i> Counter Reset</a>
        </li>
        <li>
          <a href="/adnetwork_admin/pending_cbs.php" target="_blank"><i class="fa fa-clock-o"></i> Pending Callbacks</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.hp-nav .has-submenu > a').forEach(function (a) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      this.closest('li').classList.toggle('open');
    });
  });
});
</script>
