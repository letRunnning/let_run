<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!-- <link rel="icon" href="<?php echo site_url(); ?>/assets/img/yda_logo.png" type="image/png"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?php echo site_url(); ?>files/photo/logo_temp.png" type="image/x-icon" />


  <title><?php echo $title; ?></title>

  <!-- Bootstrap CSS CDN -->
  <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <!-- Bootstrap CSS timepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
  <!-- Our Custom CSS -->
  <link href="<?php echo site_url(); ?>/assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/jquery-ui-1.10.3.custom.css">
  <!-- Font Awesome JS -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
  
  <link data-require="jqueryui@*" data-semver="1.10.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
  <link href="<?php echo site_url(); ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?php echo site_url(); ?>/assets/css/timePicker.css" rel="stylesheet">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3></h3>
      </div>

      <ul class="list-unstyled components">
        
        <li>
          <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁 </a>
        </li>

        <?php if(!empty($role)) :?>
          <li>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">個人資訊
            <!-- <i class="fas fa-angle-down"></i> -->
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
              <li>
                <a href="<?php echo site_url('/user/member_info'); ?>" <?php echo $url == '/user/member_info' ? 'active' : ''; ?>>會員資訊</a>
              </li>
              <li>
                <a href="<?php echo site_url('/user/staff_info'); ?>" <?php echo $url == '/user/staff_info' ? 'active' : ''; ?>>工作人員資訊</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#pageSubmenuYouth" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">路跑活動</a>
            <ul class="collapse list-unstyled" id="pageSubmenuYouth">
              <li>
                <a href="<?php echo site_url('/run/run_active_table'); ?>"
                  <?php echo $url == '/run/run_active_table' ? 'active' : ''; ?>>路跑活動清單</a>
              </li>
              <li>
                <a href="<?php echo site_url('/run/workcontent_table'); ?>"
                  <?php echo $url == '/run/workcontent_table' ? 'active' : ''; ?>>工作項目</a>
              </li>
              <li>
                <a href="<?php echo site_url('/run/workgroup_table'); ?>"
                  <?php echo $url == '/run/workgroup_table' ? 'active' : ''; ?>>工作組別</a>
              </li>
              <li>
                <a href="<?php echo site_url('/run/rungroup_gift_table'); ?>"
                  <?php echo $url == '/run/rungroup_gift_table' ? 'active' : ''; ?>>路跑組別 & 禮品</a>
              </li>
              <li>
                <a href="<?php echo site_url('/run/pass_point_table'); ?>"
                  <?php echo $url == '/run/pass_point_table' ? 'active' : ''; ?>>路跑經過點</a>
              </li>
              <li>
                <a href="<?php echo site_url('/run/route_table'); ?>"
                  <?php echo $url == '/run/route_table' ? 'active' : ''; ?>>路跑路線</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#pageSubmenuCouselorA" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Beacon</a>
            <ul class="collapse list-unstyled" id="pageSubmenuCouselorA">
              <li>
                <a href="<?php echo site_url('/beacon/beacon_table'); ?>"
                  <?php echo $url == '/beacon/beacon_table' ? 'active' : ''; ?>>Beacon清單</a>
              </li>
              <li>
                <a href="<?php echo site_url('/beacon/beacon_place_table'); ?>"
                  <?php echo $url == '/beacon/beacon_place_table' ? 'active' : ''; ?>>Beacon放置點清單</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#pageSubmenuCouselorB" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">報到</a>
            <ul class="collapse list-unstyled" id="pageSubmenuCouselorB">
              <li>
                <a href="<?php echo site_url('/checkin/staff_checkin_table'); ?>"
                  <?php echo $url == '/checkin/staff_checkin_table' ? 'active' : ''; ?>>工作人員</a>
              </li>
              <li>
                <a href="<?php echo site_url('/checkin/member_checkin_table'); ?>"
                  <?php echo $url == '/checkin/member_checkin_table' ? 'active' : ''; ?>>會員</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#pageSubmenuCouselorC" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">救護車資訊</a>
            <ul class="collapse list-unstyled" id="pageSubmenuCouselorC">
              <li>
                <a href="<?php echo site_url('/ambulance/ambulance_table'); ?>"
                <?php echo $url == '/ambulance/ambulance_table' ? 'active' : ''; ?>>救護車清單</a>
              </li>
              <li>
                <a href="<?php echo site_url('/ambulance/ambulance_place_table'); ?>"
                <?php echo $url == '/ambulance/ambulance_place_table' ? 'active' : ''; ?>>救護車停置點</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="<?php echo site_url('/run/print_join_proof'); ?>"
              <?php echo $url == '/run/print_join_proof' ? 'active' : ''; ?>>列印參賽證明</a>
          </li>

          <li>
            <a href="<?php echo site_url('/run/dynamic_position_graph'); ?>"
              <?php echo $url == '/run/dynamic_position_graph' ? 'active' : ''; ?>>動態位置圖表</a>
          </li>

          <li>
            <a href="#pageSubmenuCouselorD" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">檢核</a>
            <ul class="collapse list-unstyled" id="pageSubmenuCouselorD">
              <li>
                <a href="<?php echo site_url('/check/staff_apply_table'); ?>"
                  <?php echo $url == '/check/staff_apply_table' ? 'active' : ''; ?>>工作人員申請活動</a>
              </li>
              <li>
                <a href="<?php echo site_url('/check/member_pay_status_table'); ?>"
                  <?php echo $url == '/check/member_pay_status_table' ? 'active' : ''; ?>>繳費狀態</a>
              </li>
              <li>
                <a href="<?php echo site_url('/check/gift_status_table'); ?>"
                  <?php echo $url == '/check/gift_status_table' ? 'active' : ''; ?>>兌換禮品狀態</a>
              </li>
            </ul>
          </li>
   
        <?php endif;?>
        </nav>

    <!-- Page Content  -->
    <div id="content">
      <nav class="navbar navbar-expand-lg navbar-light header-bg header_bar">
        <div class="container-fluid ">
          <button type="button" id="sidebarCollapse" class="btn">
          <!-- &#9776; -->
          <!-- <i class="fas fa-align-justify text-white fa-2x"></i>　 -->
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list text-white " viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg>
            <span class="h2 text-white">Let_running</span>
          </button>
          <button class="btn btn-light d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent" >
            
            <ul class="nav navbar-nav ms-auto">
              <li class="nav-item active">
                <a class="nav-link text-white" href="#"><?php echo $userTitle; ?></a>
              </li>
              <?php if (empty($role)): ?>
                <li class="nav-item">
                  <a class="nav-link text-white" href="<?php echo site_url('/user/login'); ?>">登入</a>
                </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link btn btn-light" style="color:#03256c;width:80px" href="<?php echo site_url('/user/logout'); ?>">登出</a>
                  <!-- <button class="btn" style="background-color:white" href="<?php echo site_url('/user/logout'); ?>">123</buton> -->
                </li>
              <?php endif;?>
              
                    
            </ul>
          </div>
        </div>
      </nav>