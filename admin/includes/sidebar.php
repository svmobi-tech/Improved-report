<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
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
    <li class="<?php echo $currentPage === 'report.php' ? 'active' : ''; ?>">
      <a href="report.php"><i class="fa fa-file-text-o"></i> Main Report</a>
    </li>
    <li class="<?php echo $currentPage === 'activationreport.php' ? 'active' : ''; ?>">
      <a href="activationreport.php"><i class="fa fa-bolt"></i> Activation Report</a>
    </li>
    <li class="<?php echo $currentPage === 'perform.php' ? 'active' : ''; ?>">
      <a href="perform.php"><i class="fa fa-line-chart"></i> Perform Report</a>
    </li>
    <li class="<?php echo $currentPage === 'trend_report.php' ? 'active' : ''; ?>">
      <a href="trend_report.php"><i class="fa fa-bar-chart"></i> Trend Report</a>
    </li>
    <li class="<?php echo $currentPage === 'last_activityreport.php' ? 'active' : ''; ?>">
      <a href="last_activityreport.php"><i class="fa fa-clock-o"></i> Last Activity</a>
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
      $contestPages = ['contest.php','contest_charging.php','promotional_activity.php','engagement_activity.php'];
      $contestOpen  = in_array($currentPage, $contestPages) ? 'open' : '';
    ?>
    <li class="has-submenu <?php echo $contestOpen; ?>">
      <a href="#"><i class="fa fa-trophy"></i> Contest</a>
      <ul class="hp-submenu">
        <li class="<?php echo $currentPage === 'contest.php'           ? 'active' : ''; ?>">
          <a href="contest.php">Leaderboard</a>
        </li>
        <li class="<?php echo $currentPage === 'contest_charging.php'       ? 'active' : ''; ?>">
          <a href="contest_charging.php">Charging Report</a>
        </li>
        <li class="<?php echo $currentPage === 'promotion.php'  ? 'active' : ''; ?>">
          <a href="promotion.php">Promotional Activity</a>
        </li>
        <li class="<?php echo $currentPage === 'engagement_activity.php'   ? 'active' : ''; ?>">
          <a href="engagement_activity.php">Engagement Activity</a>
        </li>
      </ul>
    </li>
    <li class="<?php echo $currentPage === 'api.php' ? 'active' : ''; ?>">
      <a href="api.php"><i class="fa fa-plug"></i> API</a>
    </li>
    <li class="<?php echo $currentPage === 'other_reports.php' ? 'active' : ''; ?>">
      <a href="other_reports.php"><i class="fa fa-folder-open-o"></i> Other Reports</a>
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
