<li>
  <a href="#pageSubmenuYouth" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">路跑活動</a>
  <ul class="collapse list-unstyled" id="pageSubmenuYouth">
    <li>
      <a href="<?php echo site_url('/run/run_list'); ?>"
        <?php echo $url == '/run/run_list' ? 'active' : ''; ?>>路跑活動清單</a>
    </li>
    <li>
      <a href="<?php echo site_url('/run/workgroup'); ?>"
        <?php echo $url == '/run/workgroup' ? 'active' : ''; ?>>工作組別&項目</a>
    </li>
    <li>
      <a href="<?php echo site_url('/run/intake/new'); ?>"
        <?php echo $url == '/run/intake/new' ? 'active' : ''; ?>>路跑組別 & 禮品</a>
    </li>
    <li>
      <a href="<?php echo site_url('/run/intake/new'); ?>"
        <?php echo $url == '/run/intake/new' ? 'active' : ''; ?>>路跑經過點</a>
    </li>
    <li>
      <a href="<?php echo site_url('/run/intake/new'); ?>"
        <?php echo $url == '/run/intake/new' ? 'active' : ''; ?>>路跑路線</a>
    </li>
  </ul>
</li>
<li>
  <a href="#pageSubmenuCouselorA" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Beacon</a>
  <ul class="collapse list-unstyled" id="pageSubmenuCouselorA">
    <li>
      <a href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>"
        <?php echo $url == '/member/get_member_table_by_counselor' ? 'active' : ''; ?>>新增Beacon</a>
    </li>
    <li>
      <a href="<?php echo site_url('/member/get_group_counseling_table_by_organization'); ?>"
        <?php echo $url == '/member/group_counseling_participants' ? 'active' : ''; ?>>查看Beacon放置點</a>
    </li>
  </ul>
</li>

<li>
  <a href="<?php echo site_url('/meeting/meeting_table'); ?>"
    <?php echo $url == '/meeting/meeting_table' ? 'active' : ''; ?>>救護車資訊</a>
</li>

<li>
  <a href="<?php echo site_url('/meeting/meeting_table'); ?>"
    <?php echo $url == '/meeting/meeting_table' ? 'active' : ''; ?>>列印參賽證明</a>
</li>

<li>
  <a href="<?php echo site_url('/meeting/meeting_table'); ?>"
    <?php echo $url == '/meeting/meeting_table' ? 'active' : ''; ?>>動態位置圖表</a>
</li>

<li>
  <a href="<?php echo site_url('/meeting/meeting_table'); ?>"
    <?php echo $url == '/meeting/meeting_table' ? 'active' : ''; ?>>跨局處會議及預防性講座</a>
</li>

<li>
  <a href="#pageSubmenuCouselorC" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">檢核</a>
  <ul class="collapse list-unstyled" id="pageSubmenuCouselorC">
    <li>
      <a href="<?php echo site_url('/work/get_company_table_by_organization'); ?>"
        <?php echo $url == '/work/get_company_table_by_organization' ? 'active' : ''; ?>>工作人員申請活動</a>
    </li>
    <li>
      <a href="<?php echo site_url('/work/get_work_experience_table_by_organization'); ?>"
        <?php echo $url == '/work/get_work_experience_table_by_organization' ? 'active' : ''; ?>>繳費狀態</a>
    </li>
  </ul>
</li>
