<li>
  <a href="#pageSubmenuSystemAccount" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">系統帳號管理</a>
  <ul class="collapse list-unstyled" id="pageSubmenuSystemAccount">
    <li>
      <a href="<?php echo site_url('/user/create_organization_manager_account'); ?>"
        <?php echo $url == '/user/create_organization_manager_account' ? 'active' : ''; ?>>建立機構主管帳號</a>
    </li>
    <li>
      <a href="<?php echo site_url('/user/account_manage_table'); ?>"
        <?php echo $url == '/user/account_manage_table' ? 'active' : ''; ?>>系統帳號清單</a>
    </li>
  </ul>
</li>
<li>
  <a href="#pageSubmenuPlan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">計畫案管理</a>
  <ul class="collapse list-unstyled" id="pageSubmenuPlan">
    <li>
      <a href="<?php echo site_url('/project/create_project'); ?>"
        <?php echo $url == '/project/create_project' ? 'active' : ''; ?>>開設計畫案</a>
    </li>
    <li>
      <a href="<?php echo site_url('/organization/create_organization'); ?>"
        <?php echo $url == '/organization/create_organization' ? 'active' : ''; ?>>新增計畫執行機構</a>
    </li>
    <li>
      <a href="<?php echo site_url('/county/delegate_project_to_organization'); ?>"
        <?php echo $url == '/county/delegate_project_to_organization' ? 'active' : ''; ?>>委託計畫執行機構</a>
    </li>
    <li><a href="<?php echo site_url('/project/project_and_county'); ?>"
      <?php echo $url == '/project/project_and_county' ? 'active' : ''; ?>>計畫與其執行單位紀錄清單</a>
    </li>
  </ul>
</li>

<li>
  <a href="<?php echo site_url('/county/county_contact_table'); ?>"
    <?php echo $url == '/county/county_contact_table' ? 'active' : ''; ?>>聯繫窗口管理</a>
</li>

<li>
  <a href="#pageSubmenuYouth" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">需關懷追蹤青少年與開案學員清單</a>
  <ul class="collapse list-unstyled" id="pageSubmenuYouth">
    <li>
      <a href="<?php echo site_url('/youth/get_all_source_youth_table'); ?>"
        <?php echo $url == '/youth/get_all_source_youth_table' ? 'active' : ''; ?>>原始來源清單</a>
    </li>
    <li>
      <a href="<?php echo site_url('/youth/get_all_youth_table/track/trend'); ?>"
        <?php echo $url == '/youth/get_all_youth_table/track/trend' ? 'active' : ''; ?>>需關懷追蹤青少年清單</a>
    </li>
    <li>
      <a href="<?php echo site_url('/member/get_member_table_by_county'); ?>"
        <?php echo $url == '/member/get_member_table_by_county' ? 'active' : ''; ?>>開案學員清單</a>
    </li>
  </ul>
</li>

<li>
  <a href="<?php echo site_url('/review/review_table'); ?>"
    <?php echo $url == '/review/review_table' ? 'active' : ''; ?>>審核管理</a>
</li>

<li>
  <a href="#pageSubmenuReport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">報表管理</a>
  <ul class="collapse list-unstyled" id="pageSubmenuReport">
    <li>
      <a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
        <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>>每月執行進度表清單</a>
    </li>
    <li>
      <a href="<?php echo site_url('/report/county_report_table'); ?>"
        <?php echo $url == '/report/county_report_table' ? 'active' : ''; ?>>即時數據統計</a>
    </li>
  </ul>
</li>