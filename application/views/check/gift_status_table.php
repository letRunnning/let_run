<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">檢核</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container">
  <div class="col-md-3 mx-auto">
    <label for="runActive" style="text-align:right;" class="col-form-label">搜尋</label>
    <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋路跑活動">
  </div>
  <br>
  
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">會員編號</th>
        <th scope="col">姓名</th>
        <th scope="col">參加之路跑編號</th>
        <th scope="col">組別</th>
        <th scope="col">狀態</th>
        <th scope="col">連絡電話</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="col">M000001</th>
        <td scope="col">會員依</td>
        <td scope="col">A1</td>
        <td scope="col">休閒組</td>
        <td scope="col">已領取</td>
        <td scope="col">0900000000</td>
      </tr>
      <tr>
        <th scope="col">M000002</th>
        <td scope="col">會員貳</td>
        <td scope="col">A1</td>
        <td scope="col">休閒組</td>
        <td scope="col">已領取</td>
        <td scope="col">0900000001</td>
      </tr>
      <tr>
        <th scope="col">M000003</th>
        <td scope="col">會員參</td>
        <td scope="col">A1</td>
        <td scope="col">挑戰組</td>
        <td scope="col">尚未領取</td>
        <td scope="col">0900000002</td>
      </tr>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer');?>