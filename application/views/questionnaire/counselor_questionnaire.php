<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">輔導成效問卷</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
			<h4 class="card-title text-center"><?php echo $title ?></h4>
			<div class="card-content">
      <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
            value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="red-text text-darken-3 text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="green-text text-darken-3 text-center">' . $success . '</p>' : ''; ?>
        <h5 class="card-title text-center">於當年度12/31前可隨時修改與暫存，請於計畫結束前完成問卷填寫。</h5>
        <h5 class="card-title text-center">請檢視貴縣市110年度服務的學生，根據他們的特質類型進行填寫，每一個學生可有多種問題類型。</h5>

        <h5 class = "text-center">一、學生特質(可複選)</h5>
        <!-- <table class="highlight centered"> -->
        <table class="table table-hover align-middle text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">特質範疇</th>
              <th scope="col">類型</th>
              <th scope="col">說明</th>
              <th scope="col">人數統計</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($partOneProblems as $i) {?>
              <tr>
                <td><?php echo $i['tag_one'] . '-' . $i['tag_two']; ?></td>
                <td><?php echo $i['type']; ?></td>
                <td><?php echo $i['content']; ?></td>
                <td>
                  <!-- trendDescription -->
                    <div class="row">
                      <div class="input-field col s10 offset-m2 m8">
                        <input type="number" id="formAnswer" name="answer[]"  value="<?php echo $answerList ? $i['answer'] : '' ?>">
                        <label for="formAnswer"></label>
                      </div>
                    </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>

        <h5 class = "text-center">二、自我成效評估</h5>
        <table class="table table-hover align-middle text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">題目</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($partTwoProblems as $i) {?>
              <tr>
                <td><?php echo $i['content']; ?></td>
                <td>
                    <p>
                      <label>
                        <span>完全不符合</span>
                        <input class="with-gap" name="<?php echo $i['no'] ?>answer" value="1" type="radio" <?php echo $answerList ? $i['answer'] == "1" ? 'checked' : '' : '' ?>/>
                      </label>
                    </p>
                    <p>
                      <label>
                        <span>有些不符合</span>
                        <input class="with-gap" name="<?php echo $i['no'] ?>answer" value="2" type="radio" <?php echo $answerList ? $i['answer'] == "2" ? 'checked' : '' : '' ?>/>
                      </label>
                    </p>
                    <p>
                      <label>
                        <span>沒意見</span>
                        <input class="with-gap" name="<?php echo $i['no'] ?>answer" value="3" type="radio" <?php echo $answerList ? $i['answer'] == "3" ? 'checked' : '' : '' ?>/>
                      </label>
                    </p>
                    <p>
                      <label>
                        <span>有些符合</span>
                        <input class="with-gap" name="<?php echo $i['no'] ?>answer" value="4" type="radio" <?php echo $answerList ? $i['answer'] == "4" ? 'checked' : '' : '' ?>/>
                      </label>
                    </p>
                    <p>
                      <label>
                        <span>完全符合</span>
                        <input class="with-gap" name="<?php echo $i['no'] ?>answer" value="5" type="radio" <?php echo $answerList ? $i['answer'] == "5" ? 'checked' : '' : '' ?>/>
                      </label>
                    </p>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <h5 class = "text-center">本問卷到此結束，感謝作答！</h5>
        <div class="row justify-content-center">
          <div class="d-grid gap-2 col-sm-6 col-md-4 mb-3">
            <button class="btn btn-primary" name="save" value="Save" type="submit">送出</button>
          </div>
        </div>
              </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>