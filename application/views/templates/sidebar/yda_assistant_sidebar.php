<li>
  <a href="#pageSubmenuReport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">報表管理</a>
  <ul class="collapse list-unstyled" id="pageSubmenuReport">
    <li>
      <a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>"
        <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>>每月執行進度表清單</a>
    </li>
    <li>
      <a href="<?php echo site_url('/report/yda_report_table'); ?>"
        <?php echo $url == '/report/yda_report_table' ? 'active' : ''; ?>>即時數據統計</a>
    </li>
  </ul>
</li>

<li>
  <a href="<?php echo site_url('/messager/messager_table'); ?>"
    <?php echo $url == '/messager/messager_table' ? 'active' : ''; ?>>消息管理</a>
</li>

<li>
  <a href="<?php echo site_url('/project/manage_county_and_project_table'); ?>"
    <?php echo $url == '/project/manage_county_and_project_table' ? 'active' : ''; ?>>縣市與計畫案管理</a>
</li>
