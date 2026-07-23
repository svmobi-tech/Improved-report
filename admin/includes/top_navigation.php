<div class="hp-topnav">
  <div class="hp-topnav-left">
    <button class="hp-sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
      <i class="fa fa-bars"></i>
    </button>
    <div class="hp-topnav-title">
      <i class="fa <?php echo $pageIcon ?? 'fa-bolt'; ?>"></i> <?php echo $pageTitle ?? 'Report'; ?>
    </div>
  </div>
  <div class="hp-topnav-right">
    <div class="hp-user-chip">
      <img src="images/dp.jpg" class="hp-user-avatar" alt="<?php echo htmlspecialchars(ucfirst($_SESSION['username'] ?? 'User')); ?>">
      <span><?php echo htmlspecialchars(ucfirst($_SESSION['username'] ?? 'User')); ?></span>
    </div>
    <span class="hp-date-badge">
      <i class="fa fa-calendar"></i> <?php echo date('d M Y'); ?>
    </span>
    <a href="logout.php" class="hp-logout-btn" title="Logout">
      <i class="fa fa-sign-out"></i>
    </a>
  </div>
</div>
<style>
.hp-logout-btn {
  display:inline-flex; align-items:center; gap:5px;
  background:#e53e3e; color:#fff;
  padding:6px 14px; border-radius:20px; text-decoration:none;
  font-size:13px; font-weight:600; margin-left:8px;
  transition:background 0.2s;
}
.hp-logout-btn:hover { background:#c53030; color:#fff; text-decoration:none; }
</style>
