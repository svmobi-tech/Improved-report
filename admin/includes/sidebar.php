<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<div class="hp-sidebar">
  <div class="hp-sidebar-brand">
    <img src="images/logo.png" alt="SVMobi Logo">
    <span class="brand-name">SVMobi Reports</span>
  </div>

  <!-- User profile block -->
  <div class="hp-sidebar-profile">
    <img src="images/dp.jpg" class="hp-sidebar-avatar" alt="Durgesh Panchal">
    <div class="hp-sidebar-profile-info">
      <span class="hp-sidebar-profile-name">Durgesh Panchal</span>
      <span class="hp-sidebar-profile-role">Administrator</span>
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
    <li class="<?php echo $currentPage === 'performreport.php' ? 'active' : ''; ?>">
      <a href="performreport.php"><i class="fa fa-line-chart"></i> Perform Report</a>
    </li>
    <li class="<?php echo $currentPage === 'trendreport.php' ? 'active' : ''; ?>">
      <a href="trendreport.php"><i class="fa fa-bar-chart"></i> Trend Report</a>
    </li>
    <li><a href="#"><i class="fa fa-clock-o"></i> Last Activity</a></li>
    <li><a href="#"><i class="fa fa-calendar"></i> Last 30 Days</a></li>
    <li><a href="#"><i class="fa fa-tachometer"></i> Current Month</a></li>
    <li><a href="#"><i class="fa fa-link"></i> Advertiser Urls</a></li>
    <li><a href="#"><i class="fa fa-trophy"></i> Contest</a></li>
    <li><a href="#"><i class="fa fa-plug"></i> API</a></li>
    <li><a href="#"><i class="fa fa-folder-open-o"></i> Other Reports</a></li>
  </ul>
</div>
