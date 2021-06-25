<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="<?php echo site_url(); ?>/assets/img/yda_logo.png" type="image/png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="young department administration">
  <title><?php echo $title; ?></title>
  <!-- Font Awesome -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="<?php echo site_url(); ?>/assets/css/general.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.css" rel="stylesheet" />
  <style>
    canvas {
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
    }
  </style>
</head>

<body class="brown lighten-5">
<div id="gotop">˄</div>
  <?php if ($password == '000000' && $title != '修改個人密碼'):
      redirect('user/user_password');
    elseif($updatePwd && $title != '修改個人密碼') :
      redirect('user/user_password');
endif;?>
  <div id="id_wrapper">
  <nav>
    <div class="nav-wrapper amber darken-3">
      <a class="logo brand-logo left">教育部青年發展署<i class="material-icons left">menu <img class="yda_logo right"
            src="<?php echo site_url(); ?>/images/yda_logo.png" /></i></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a class="left-align" href="#!"><?php echo $userTitle ?><i class="material-icons left">perm_identity</i></a>
        </li>
        <?php if (empty($role)): ?>
        <li><a href="<?php echo site_url('/user/login'); ?>">登入</a></li>
        <?php else: ?>
        <li><a href="<?php echo site_url('/user/logout'); ?>">登出</a></li>
        <?php endif;?>
      </ul>
    </div>
  </nav>
  <ul class="sidenav orange lighten-5">
    <li>
      <div class="amber darken-3 sidenav-logo">
        <a class="logo grey-text text-darken-3"><?php echo $userTitle ?></a>
      </div>
    </li>
    <li><a href="<?php echo site_url('/user/index'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/index' ? 'active' : ''; ?>">首頁</a></li>

    <?php if (!empty($role)): ?>
      <li>
      <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">個人帳號管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/user/user_info'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/user_info' ? 'active' : ''; ?>">修改個人資訊</a></li>
                <li><a href="<?php echo site_url('/user/user_password'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/user_password' ? 'active' : ''; ?>">修改個人密碼</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <?php if ($role === 1): ?>
    <li>
      <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">系統帳號管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <!-- <li><a href="<?php echo site_url('/user/create_yda_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_yda_account' ? 'active' : ''; ?>">建立青年署專員帳號</a>
              </li> -->
              <li><a href="<?php echo site_url('/user/create_yda_support_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_yda_support_account' ? 'active' : ''; ?>">建立支援計畫人員帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/create_county_manager_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_county_manager_account' ? 'active' : ''; ?>">建立縣市主管帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/create_county_contractor_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_county_contractor_account' ? 'active' : ''; ?>">建立本縣市承辦人帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/account_manage_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>">系統帳號清單</a>
              </li>
              <li><a href="<?php echo site_url('/user/audit_record_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/audit_record_table' ? 'active' : ''; ?>">稽核管理</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>


    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/yda_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/yda_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>



    <li><a href="<?php echo site_url('/messager/messager_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/messager/messager_table' ? 'active' : ''; ?>">消息管理</a></li>
    <li><a href="<?php echo site_url('/project/manage_county_and_project_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/manage_county_and_project_table' ? 'active' : ''; ?>">縣市與計畫案管理</a></li>

        <?php elseif ($role === 9): ?>
    <li>
      <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">系統帳號管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/user/create_yda_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_yda_account' ? 'active' : ''; ?>">建立青年署專員帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/create_yda_support_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_yda_support_account' ? 'active' : ''; ?>">建立支援計畫人員帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/create_county_manager_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_county_manager_account' ? 'active' : ''; ?>">建立縣市主管帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/create_county_contractor_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_county_contractor_account' ? 'active' : ''; ?>">建立本縣市承辦人帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/account_manage_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>">系統帳號清單</a>
              </li>
              <li><a href="<?php echo site_url('/user/audit_record_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/audit_record_table' ? 'active' : ''; ?>">稽核管理</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>

    <ul class="collapsible">
    <li>
      <div class="collapsible-header grey-text text-darken-3">需關懷追蹤青少年與開案學員清單</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/youth/get_all_source_youth_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_source_youth_table/1' ? 'active' : ''; ?>">原始來源清單</a>
            </li>
            <li><a href="<?php echo site_url('/youth/get_all_youth_table/track/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/trend' ? 'active' : ''; ?>">需關懷追蹤青少年清單</a>
            </li>
            <li><a href="<?php echo site_url('/member/get_member_table_by_county/1'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/get_member_table_by_county/1' ? 'active' : ''; ?>">開案學員清單</a>
            </li>
          </ul>
      </div>
    </li>
    </ul>


    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/yda_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/yda_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>



    <li><a href="<?php echo site_url('/messager/messager_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/messager/messager_table' ? 'active' : ''; ?>">消息管理</a></li>
    <li><a href="<?php echo site_url('/project/manage_county_and_project_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/manage_county_and_project_table' ? 'active' : ''; ?>">縣市與計畫案管理</a></li>
    
    <?php elseif ($role === 2): ?>
    <li>
      <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">系統帳號管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/user/create_county_contractor_account'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_county_contractor_account' ? 'active' : ''; ?>">建立本縣市承辦人帳號</a>
              </li>
              <li><a href="<?php echo site_url('/user/account_manage_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>">系統帳號清單</a>
              </li>

            </ul>
          </div>
        </li>
      </ul>

      <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">計畫案管理</div>
            <div class="collapsible-body orange lighten-5">
              <ul>
                <!-- <li><a href="<?php echo site_url('/project/create_project'); ?>"
                    class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/create_project' ? 'active' : ''; ?>">開設計畫案</a>
                </li>
                <li><a href="<?php echo site_url('/organization/create_organization'); ?>"
                    class="waves-effect grey-text text-darken-3 <?php echo $url == '/organization/create_organization' ? 'active' : ''; ?>">新增計畫執行機構</a>
                </li>
                <li><a href="<?php echo site_url('/county/delegate_project_to_organization'); ?>"
                    class="waves-effect grey-text text-darken-3 <?php echo $url == '/county/delegate_project_to_organization' ? 'active' : ''; ?>">委託計畫執行機構</a>
                </li> -->
                <li><a href="<?php echo site_url('/project/project_and_county'); ?>"
          class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/project_and_county' ? 'active' : ''; ?>">計畫與其執行單位紀錄清單</a>
                </li>
              </ul>
            </div>
        </li>
      </ul>
    </li>
    <li><a href="<?php echo site_url('/county/county_contact_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/county/county_contact_table' ? 'active' : ''; ?>">聯繫窗口管理</a>
    </li>


    <ul class="collapsible">
    <li>
      <div class="collapsible-header grey-text text-darken-3">需關懷追蹤青少年與開案學員清單</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/youth/get_all_source_youth_table/1'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_source_youth_table/1' ? 'active' : ''; ?>">原始來源清單</a>
            </li>
            <li><a href="<?php echo site_url('/youth/get_all_youth_table/1/track/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/trend' ? 'active' : ''; ?>">需關懷追蹤青少年清單</a>
            </li>
            <li><a href="<?php echo site_url('/member/get_member_table_by_county/1'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/get_member_table_by_county/1' ? 'active' : ''; ?>">開案學員清單</a>
            </li>
          </ul>
      </div>
    </li>
    </ul>

    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/county_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/county_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>


    <?php elseif ($role === 3): ?>
    <ul class="collapsible">
      <li>
        <div class="collapsible-header grey-text text-darken-3">系統帳號管理</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/user/create_organization_manager_account'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_organization_manager_account' ? 'active' : ''; ?>">建立機構主管帳號</a>
            </li>
            <li><a href="<?php echo site_url('/user/account_manage_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>">系統帳號清單</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>

    <li><a href="<?php echo site_url('/county/county_contact_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/county/county_contact_table' ? 'active' : ''; ?>">聯繫窗口管理</a>
    </li>
    <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">計畫案管理</div>
            <div class="collapsible-body orange lighten-5">
              <ul>
                <li><a href="<?php echo site_url('/project/create_project'); ?>"
                    class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/create_project' ? 'active' : ''; ?>">開設計畫案</a>
                </li>
                <li><a href="<?php echo site_url('/organization/create_organization'); ?>"
                    class="waves-effect grey-text text-darken-3 <?php echo $url == '/organization/create_organization' ? 'active' : ''; ?>">新增計畫執行機構</a>
                </li>
                <li><a href="<?php echo site_url('/county/delegate_project_to_organization'); ?>"
                    class="waves-effect grey-text text-darken-3 <?php echo $url == '/county/delegate_project_to_organization' ? 'active' : ''; ?>">委託計畫執行機構</a>
                </li>
                <li><a href="<?php echo site_url('/project/project_and_county'); ?>"
          class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/project_and_county' ? 'active' : ''; ?>">計畫與其執行單位紀錄清單</a>
                </li>
              </ul>
            </div>
        </li>
      </ul>

    <ul class="collapsible">
    <li>
      <div class="collapsible-header grey-text text-darken-3">需關懷追蹤青少年與開案學員清單</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/youth/get_all_source_youth_table/1'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_source_youth_table/1' ? 'active' : ''; ?>">原始來源清單</a>
            </li>
            <li><a href="<?php echo site_url('/youth/get_all_youth_table/1/track/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/trend' ? 'active' : ''; ?>">需關懷追蹤青少年清單</a>
            </li>
            <li><a href="<?php echo site_url('/member/get_member_table_by_county/1'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/get_member_table_by_county/1' ? 'active' : ''; ?>">開案學員清單</a>
            </li>
          </ul>
      </div>
    </li>
    </ul>

    <li><a href="<?php echo site_url('/meeting/meeting_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/meeting/meeting_table' ? 'active' : ''; ?>">跨局處會議及預防性講座</a>
    </li>

    <li><a href="<?php echo site_url('/review/review_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/review/review_table' ? 'active' : ''; ?>">審核管理</a>
    </li>

  
    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/county_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/county_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>


    <?php elseif ($role === 4): ?>
    <ul class="collapsible">
      <li>
        <div class="collapsible-header grey-text text-darken-3">系統帳號管理</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/user/create_organization_contractor_account'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_organization_contractor_account' ? 'active' : ''; ?>">建立本機構承辦人帳號</a>
            </li>
            <li><a href="<?php echo site_url('/user/account_manage_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>">系統帳號清單</a>
             </li>
          </ul>
        </div>
      </li>
    </ul>

    <li><a href="<?php echo site_url('/project/project_and_county'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/project_and_county' ? 'active' : ''; ?>">計畫與其執行單位紀錄清單</a>
    </li>
    <ul class="collapsible">
    <li>
      <div class="collapsible-header grey-text text-darken-3">需關懷追蹤青少年與開案學員清單</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/youth/get_all_source_youth_table/1'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_source_youth_table/1' ? 'active' : ''; ?>">原始來源清單</a>
            </li>
            <li><a href="<?php echo site_url('/youth/get_all_youth_table/1/track/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/trend' ? 'active' : ''; ?>">需關懷追蹤青少年清單</a>
            </li>
            <li><a href="<?php echo site_url('/member/get_member_table_by_organization'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/get_member_table_by_organization' ? 'active' : ''; ?>">開案學員清單</a>
            </li>
          </ul>
      </div>
    </li>
    </ul>
    <li><a href="<?php echo site_url('/review/review_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/review/review_table' ? 'active' : ''; ?>">審核管理</a>
    </li>

    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/organization_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/organization_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>


    <?php elseif ($role === 5): ?>
    <li><a href="<?php echo site_url('/user/create_counselor_account'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/create_counselor_account' ? 'active' : ''; ?>">建立輔導員帳號</a>
    </li>
    <li><a href="<?php echo site_url('/user/account_manage_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>">系統帳號清單</a>
    </li>
    <ul class="collapsible">
    <li>
      <div class="collapsible-header grey-text text-darken-3">需關懷追蹤青少年與開案學員清單</div>
        <div class="collapsible-body orange lighten-5">
          <ul>
            <li><a href="<?php echo site_url('/youth/get_all_source_youth_table/1'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_source_youth_table/1' ? 'active' : ''; ?>">原始來源清單</a>
            </li>
            <li><a href="<?php echo site_url('/youth/get_all_youth_table/1/track/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/trend' ? 'active' : ''; ?>">需關懷追蹤青少年清單</a>
            </li>
            <li><a href="<?php echo site_url('/member/get_member_table_by_organization'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/get_member_table_by_organization' ? 'active' : ''; ?>">開案學員清單</a>
            </li>
          </ul>
      </div>
    </li>
    </ul>

    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/organization_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/organization_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>

    <?php elseif ($role === 6): ?>
    <li>
      <ul class="collapsible">
        <li>
          <div class="collapsible-header grey-text text-darken-3">評估開案</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/youth/get_all_source_youth_table/1'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_source_youth_table/1' ? 'active' : ''; ?>">原始來源清單</a>
              </li>
              <li><a href="<?php echo site_url('/youth/get_all_youth_table/1/track/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/trend' ? 'active' : ''; ?>">需關懷追蹤青少年清單</a>
              </li>
              <li><a href="<?php echo site_url('/youth/get_all_youth_table/1/track/case_trend/trend'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/youth/get_all_youth_table/1/track/case_trend/trend' ? 'active' : ''; ?>">歷年度開案學員名單</a>
              </li>
              <li><a href="<?php echo site_url('/youth/intake/new'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/youth/intake/new' ? 'active' : ''; ?>">青少年初評表</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header grey-text text-darken-3">輔導會談(措施A)</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/get_member_table_by_counselor' ? 'active' : ''; ?>">開案學員清單</a>
              </li>
              <li><a href="<?php echo site_url('/member/get_group_counseling_table_by_organization'); ?>"
                  class="waves-effectgrey-text text-darken-3 <?php echo $url == '/member/group_counseling_participants' ? 'active' : ''; ?>">團體輔導紀錄清單</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header grey-text text-darken-3">生涯探索課程或活動(措施B)</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/course/get_course_reference_table_by_organization'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/course/get_course_reference_table_by_organization' ? 'active' : ''; ?>">課程參考清單(歷年資料)</a>
              </li>
              <li><a href="<?php echo site_url('/course/get_course_table_by_organization'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/course/get_course_table_by_organization' ? 'active' : ''; ?>">課程開設清單(今年度資料)</a>
              </li>
              <li><a href="<?php echo site_url('/course/get_course_attendance_table_by_organization'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/course/get_course_attendance_table_by_organization' ? 'active' : ''; ?>">課程時數表(執行當日更新、每月自動統計報表數據)</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header grey-text text-darken-3">工作體驗(措施C)</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
              <li><a href="<?php echo site_url('/work/get_company_table_by_organization'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/work/get_company_table_by_organization' ? 'active' : ''; ?>">店家參考清單(歷年資料)</a>
              </li>
              <li><a href="<?php echo site_url('/work/get_work_experience_table_by_organization'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/work/get_work_experience_table_by_organization' ? 'active' : ''; ?>">工作體驗清單(今年度資料)</a>
              </li>
              <li><a href="<?php echo site_url('/work/get_work_attendance_table_by_organization'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/work/get_work_attendance_table_by_organization' ? 'active' : ''; ?>">工作體驗時數表(執行當日更新、每月自動統計報表數據)</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>

    <li><a href="<?php echo site_url('/meeting/meeting_table'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/meeting/meeting_table' ? 'active' : ''; ?>">跨局處會議及預防性講座</a>
    </li>

    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/counselor_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counselor_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>

    <li><a href="<?php echo site_url('/questionnaire/counselor_questionnaire'); ?>"
                  class="waves-effect grey-text text-darken-3 <?php echo $url == '/questionnaire/counselor_questionnaire' ? 'active' : ''; ?>">輔導成效問卷</a>
    </li>


    <?php elseif ($role === 8): ?>
    <li><a href="<?php echo site_url('/messager/messager_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/messager/messager_table' ? 'active' : ''; ?>">消息管理</a></li>

    <li>
      <ul class="collapsible">
      <li>

          <div class="collapsible-header grey-text text-darken-3">報表管理</div>
          <div class="collapsible-body orange lighten-5">
            <ul>
            <li><a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>">每月執行進度表清單</a>
            </li>
            <li><a href="<?php echo site_url('/report/yda_report_table'); ?>"
                class="waves-effect grey-text text-darken-3 <?php echo $url == '/report/yda_report_table' ? 'active' : ''; ?>">即時數據統計</a>
            </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li><a href="<?php echo site_url('/project/manage_county_and_project_table'); ?>"
        class="waves-effect grey-text text-darken-3 <?php echo $url == '/project/manage_county_and_project_table' ? 'active' : ''; ?>">縣市與計畫案管理</a></li>
    <?php endif;?>
    <?php endif;?>


  </ul>

<script type="text/javascript">
  $("#gotop").click(function(){
    jQuery("html,body").animate({
        scrollTop:0
    },1000);
  });
  $(window).scroll(function() {
    if ( $(this).scrollTop() > 300){
        $('#gotop').fadeIn("fast");
    } else {
        $('#gotop').stop().fadeOut("fast");
    }
});</script>