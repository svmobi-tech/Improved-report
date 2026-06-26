<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/ico" href="images/filllogo.png">
  <title><?php echo $pageTitle ?? 'Report'; ?> | SVMobi</title>

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <!-- DateRangePicker -->
  <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- DataTables -->
  <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <!-- Custom Theme -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/custom_css.css" rel="stylesheet">

  <style>
    /* ── HP Layout ─────────────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; }
    body {
      background: #f0f2f7 !important;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      margin: 0 !important; padding: 0 !important;
      color: #2d3748;
    }
    .hp-sidebar {
      position: fixed; top: 0; left: 0;
      width: 240px; height: 100vh;
      background: #1a1f3c;
      overflow-y: auto; overflow-x: hidden; z-index: 1050;
      display: flex; flex-direction: column;
      transition: transform .3s ease;
      box-shadow: 2px 0 12px rgba(0,0,0,.18);
      scrollbar-width: thin;
      scrollbar-color: rgba(102,126,234,.4) transparent;
    }
    .hp-sidebar::-webkit-scrollbar { width: 4px; }
    .hp-sidebar::-webkit-scrollbar-track { background: transparent; }
    .hp-sidebar::-webkit-scrollbar-thumb {
      background: rgba(102,126,234,.45);
      border-radius: 4px;
    }
    .hp-sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(102,126,234,.75);
    }
    .hp-main { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }

    /* ── Sidebar brand ───────────────────────────────────────────── */
    .hp-sidebar-brand {
      padding: 22px 20px 18px;
      border-bottom: 1px solid rgba(255,255,255,.08);
      flex-shrink: 0;
    }
    .hp-sidebar-brand img { height: 34px; display: block; }
    .hp-sidebar-brand .brand-name {
      color: #e2e8f0; font-size: 11px; font-weight: 700;
      letter-spacing: 1.2px; text-transform: uppercase;
      margin-top: 10px; display: block; opacity: .65;
    }

    /* ── Sidebar user profile ───────────────────────────────────────── */
    .hp-sidebar-profile {
      display: flex; align-items: center; gap: 11px;
      padding: 14px 18px 16px;
      border-bottom: 1px solid rgba(255,255,255,.08);
      flex-shrink: 0;
    }
    .hp-sidebar-avatar {
      width: 42px; height: 42px; border-radius: 50%; object-fit: cover;
      border: 2px solid #667eea; flex-shrink: 0;
    }
    .hp-sidebar-profile-info { display: flex; flex-direction: column; overflow: hidden; }
    .hp-sidebar-profile-name {
      color: #e2e8f0; font-size: 13px; font-weight: 600;
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .hp-sidebar-profile-role {
      color: #667eea; font-size: 10px; font-weight: 600;
      letter-spacing: .5px; text-transform: uppercase; margin-top: 2px;
    }

    /* ── Sidebar nav ─────────────────────────────────────────────── */
    .hp-nav { list-style: none; padding: 10px 0; margin: 0; flex: 1; }
    .hp-nav li a {
      display: flex; align-items: center; gap: 11px;
      padding: 10px 20px;
      color: #a0aec0; text-decoration: none !important; font-size: 13px;
      transition: all .18s; border-left: 3px solid transparent;
      white-space: nowrap; overflow: hidden;
    }
    .hp-nav li a:hover { background: rgba(102,126,234,.12); color: #e2e8f0 !important; text-decoration: none !important; }
    .hp-nav li.active > a {
      background: rgba(102,126,234,.2); color: #fff !important;
      border-left-color: #667eea; font-weight: 600;
    }
    .hp-nav li a .fa { width: 17px; text-align: center; font-size: 13px; flex-shrink: 0; }

    /* ── Submenu ─────────────────────────────────────────────────── */
    .hp-nav li.has-submenu > a::after {
      content: '\f107'; font-family: 'FontAwesome';
      margin-left: auto; font-size: 11px; flex-shrink: 0;
      transition: transform .2s ease;
    }
    .hp-nav li.has-submenu.open > a::after { transform: rotate(180deg); }
    .hp-nav li.has-submenu > a { cursor: pointer; }
    .hp-submenu {
      list-style: none; padding: 0; margin: 0;
      max-height: 0; overflow: hidden;
      transition: max-height .28s ease;
      background: rgba(0,0,0,.18);
    }
    .hp-nav li.has-submenu.open .hp-submenu { max-height: 600px; }
    .hp-submenu li a {
      padding: 8px 20px 8px 36px !important;
      font-size: 12.5px !important; color: #8898aa !important;
      border-left: 3px solid transparent !important;
      white-space: nowrap; overflow: hidden;
      display: flex; align-items: center; gap: 8px;
    }
    .hp-submenu li a .fa {
      font-size: 12px !important; width: 14px; text-align: center;
      color: #667eea; flex-shrink: 0;
    }
    .hp-submenu li a:hover { color: #e2e8f0 !important; background: rgba(102,126,234,.08) !important; }
    .hp-submenu li a:hover .fa { color: #e2e8f0; }
    .hp-submenu li.active a {
      color: #fff !important; background: rgba(102,126,234,.14) !important;
      border-left-color: #667eea !important;
    }
    .hp-submenu li.active a .fa { color: #fff; }

    /* ── Top navigation bar ──────────────────────────────────────── */
    .hp-topnav {
      background: #fff; height: 58px;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 20px;
      box-shadow: 0 1px 0 rgba(0,0,0,.08), 0 2px 8px rgba(0,0,0,.04);
      position: sticky; top: 0; z-index: 900; flex-shrink: 0;
    }
    .hp-topnav-left { display: flex; align-items: center; gap: 10px; }
    .hp-sidebar-toggle {
      background: none; border: none; cursor: pointer;
      width: 36px; height: 36px; border-radius: 8px;
      color: #4a5568; font-size: 17px; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      transition: background .18s, color .18s;
    }
    .hp-sidebar-toggle:hover { background: #f0f4ff; color: #667eea; }
    .hp-topnav-title {
      font-size: 17px; font-weight: 700; color: #2d3748;
      display: flex; align-items: center; gap: 10px;
    }
    .hp-topnav-title .fa { color: #667eea; font-size: 16px; }
    .hp-topnav-right { display: flex; align-items: center; gap: 14px; }

    /* ── Sidebar collapsed state ─────────────────────────────────── */
    body.sidebar-collapsed .hp-sidebar { transform: translateX(-240px); }
    body.sidebar-collapsed .hp-main   { margin-left: 0; }
    .hp-sidebar, .hp-main { transition: transform .28s ease, margin-left .28s ease; }
    .hp-date-badge {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff; padding: 5px 14px; border-radius: 20px;
      font-size: 12px; font-weight: 600; letter-spacing: .3px;
    }
    .hp-date-badge .fa { margin-right: 5px; }
    .hp-user-chip { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4a5568; font-weight: 500; }
    .hp-user-chip .fa { color: #667eea; font-size: 26px; }
    .hp-user-avatar {
      width: 34px; height: 34px; border-radius: 50%; object-fit: cover;
      border: 2px solid #667eea; flex-shrink: 0;
    }

    /* ── Content area ────────────────────────────────────────────── */
    .hp-content { padding: 22px 24px; flex: 1; }

    /* ── Cards ───────────────────────────────────────────────────── */
    .hp-card {
      background: #fff; border-radius: 12px;
      box-shadow: 0 2px 16px rgba(0,0,0,.08); margin-bottom: 22px; overflow: hidden;
      border: none;
    }
    .hp-card-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 14px 22px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .hp-card-header h4 { color: #fff; margin: 0; font-size: 14px; font-weight: 700; letter-spacing: .3px; }
    .hp-card-header h4 .fa { margin-right: 8px; opacity: .9; }
    .hp-card-body { padding: 22px; }

    /* ── Filter form ─────────────────────────────────────────────── */
    .hp-filter-card .hp-card-body { padding: 18px 22px 14px; }
    .hp-filter-label {
      display: block; font-size: 11px; font-weight: 700; color: #667eea;
      text-transform: uppercase; letter-spacing: .6px; margin-bottom: 5px;
    }
    .hp-filter-card .form-control {
      border-radius: 8px !important; border: 1.5px solid #e2e8f0 !important;
      height: 38px !important; font-size: 13px !important; color: #2d3748;
      transition: border-color .18s, box-shadow .18s; box-shadow: none !important;
    }
    .hp-filter-card .form-control:focus {
      border-color: #667eea !important; box-shadow: 0 0 0 3px rgba(102,126,234,.15) !important; outline: none;
    }
    /* Select2 */
    .select2-container .select2-selection--single {
      border-radius: 8px !important; border: 1.5px solid #e2e8f0 !important;
      height: 38px !important; box-shadow: none !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered { line-height: 36px !important; font-size: 13px; color: #2d3748 !important; }
    .select2-container .select2-selection--single .select2-selection__arrow { height: 36px !important; }
    .select2-container--open .select2-selection--single { border-color: #667eea !important; }
    .select2-results__option--highlighted[aria-selected] { background: #667eea !important; }
    /* Submit button */
    .btn-submit-report {
      display: block; width: 100%;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff !important; border: none; border-radius: 8px;
      height: 38px; padding: 0 20px; font-size: 13px; font-weight: 600;
      cursor: pointer; transition: opacity .18s, transform .18s, box-shadow .18s;
      letter-spacing: .3px; text-align: center;
    }
    .btn-submit-report:hover {
      opacity: .9; transform: translateY(-1px);
      box-shadow: 0 4px 14px rgba(102,126,234,.45);
    }
    .btn-submit-report:active { transform: translateY(0); box-shadow: none; }
    .btn-submit-report .fa { margin-right: 6px; }

    /* ── Transpose button ────────────────────────────────────────── */
    .btn-transpose {
      background: rgba(255,255,255,.18); color: #fff !important;
      border: 1.5px solid rgba(255,255,255,.45); border-radius: 6px;
      padding: 5px 13px; font-size: 12px; font-weight: 600; cursor: pointer;
      transition: background .18s; white-space: nowrap;
    }
    .btn-transpose:hover { background: rgba(255,255,255,.35); }
    .btn-transpose .fa { margin-right: 5px; }

    /* ── Loading spinner ─────────────────────────────────────────── */
    .hp-loading { text-align: center; padding: 60px 20px; }
    .hp-loading .hp-spin-icon {
      font-size: 34px; color: #667eea; display: inline-block;
      animation: hp-spin 0.9s linear infinite;
    }
    .hp-loading p { color: #a0aec0; margin-top: 14px; font-size: 14px; }
    @keyframes hp-spin { to { transform: rotate(360deg); } }

    /* ── DataTable overrides ─────────────────────────────────────── */
    #myTable thead th {
      background: #4a5568 !important; color: #fff !important;
      font-size: 11px; font-weight: 700; white-space: nowrap;
      border-color: #5a6578 !important; letter-spacing: .3px;
    }
    #myTable tbody tr:hover td { background: #f0f4ff; }
    #myTable tbody td { font-size: 12.5px; white-space: nowrap; }
    .dt-buttons .btn { border-radius: 6px !important; font-size: 12px !important; padding: 4px 10px !important; }
    div.dataTables_wrapper div.dataTables_filter input {
      border-radius: 7px; border: 1.5px solid #e2e8f0; padding: 4px 10px; font-size: 13px;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus { border-color: #667eea; outline: none; }
    div.dataTables_wrapper div.dataTables_info { font-size: 12px; color: #718096; }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
      background: linear-gradient(135deg, #667eea, #764ba2) !important;
      color: #fff !important; border-color: transparent !important; border-radius: 6px;
    }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover {
      background: #f0f4ff !important; color: #667eea !important; border-radius: 6px;
    }

    /* ── Transpose output ────────────────────────────────────────── */
    #output { margin-top: 16px; overflow-x: auto; }
    #output table { border-collapse: collapse; font-size: 12.5px; }
    #output table th, #output table td { padding: 8px 12px; border: 1px solid #dee2e6; white-space: nowrap; }
    #output table th { background: #4a5568; color: #fff; font-weight: 600; }
    #output table tr:nth-child(even) td { background: #f7f8fa; }

    /* ── Responsive ──────────────────────────────────────────────── */
    @media (max-width: 768px) {
      .hp-sidebar { transform: translateX(-240px); }
      .hp-main { margin-left: 0; }
      .hp-content { padding: 16px; }
    }
  </style>
</head>
<body>
