<?php $this->load->view('templates/new_header');?>
<div class="container" style="width:90%;">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">

    <!-- counties -->
    <?php if ($current_role == '1' || $current_role == '9'): ?>

      <!-- counties -->
      <div class="col-10 m-2 mx-auto">
        <label>縣市</label>
        <div class="input-group">
          <select class="form-select" name="counties" id="counties" onchange="location = this.value;">
            <option <?php echo ($county == null) ? 'selected' : '' ?> value="<?php echo site_url($url); ?>">全部</option>
          <?php foreach ($counties as $i) { ?>
            <option <?php echo ($county == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url($url . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
          <?php } ?>
          </select>
        </div>
      </div>
          
      <?php endif; ?>

				<?php if ($current_role == '1' || $current_role == '9'): ?>

          <h4 class="text-dark text-center">教育部青年發展署</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">姓名</th>
								<th scope="col">電話</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
             
								<?php if ($current_role == '9'): ?>
									<th scope="col">要項</th>
								<?php endif; ?>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($ydaUsers as $i) { ?>
							<tr>
								<td>青年署專員</td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['ydaPhone'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
                    echo '是';
                  else:
                    echo '否';
                  endif;?></td>
              <?php if ($current_role == '9'): ?>
                <td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
                    <?php if ($i['usable'] == '0'):
                      echo '停用';
                    else:
                      echo '啟用';
                  endif; ?></a></td>
								<?php endif; ?>
							</tr>
						<?php } ?>
          </tbody>
				</table>

        <h4 class="text-dark text-center">支援計畫人員</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">姓名</th>
								<th scope="col">電話</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
								<th scope="col">要項</th>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($ydaSupportUsers as $i) {?>
							<tr>
								<td>支援計畫人員</td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['ydaPhone'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
        echo '是';
    else:
        echo '否';
    endif;?></td>
								<td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
									<?php if ($i['usable'] == '1'):
        echo '停用';
    else:
        echo '啟用';
    endif;?></a></td>
							</tr>
						<?php }?>
          </tbody>
				</table>

				<?php endif;?>

				<?php if ($current_role == '1' || $current_role == '2' || $current_role == '9'): ?>
					<h4 class="text-dark text-center">縣市政府主管</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">縣市</th>
								<th scope="col">承辦單位</th>
								<th scope="col">姓名</th>
								<th scope="col">電話</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
								<?php if ($current_role == '1' || $current_role == '9'): ?>
									<th scope="col">要項</th>
								<?php endif;?>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($countyManageUsers as $i) {?>
							<tr>
								<td>縣市主管</td>
								<td><?php echo $i['countyName'] ?></td>
								<td><?php echo $i['countyOrgnizer'] ?></td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['office_phone'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
        echo '是';
    else:
        echo '否';
    endif;?></td>
								<?php if ($current_role == '1' || $current_role == '9'): ?>
									<td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
										<?php if ($i['usable'] == '1'):
        echo '停用';
    else:
        echo '啟用';
    endif;?></a></td>
								<?php endif;?>
							</tr>
						<?php }?>
          </tbody>
				</table>

				<?php endif;?>

				<?php if ($current_role == '1' || $current_role == '2' || $current_role == '3' || $current_role == '9'): ?>
					<h4 class="text-dark text-center">縣市政府承辦人</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">縣市</th>
								<th scope="col">承辦單位</th>
								<th scope="col">姓名</th>
								<th scope="col">電話</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
								<?php if ($current_role == '2'): ?>
									<th scope="col">要項</th>
								<?php endif;?>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($countyUsers as $i) {?>
							<tr>
								<td>縣市承辦人</td>
								<td><?php echo $i['countyName'] ?></td>
								<td><?php echo $i['countyOrgnizer'] ?></td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['office_phone'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
        echo '是';
    else:
        echo '否';
    endif;?></td>
								<?php if ($current_role == '1' || $current_role == '2' || $current_role == '9'): ?>
									<td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
										<?php if ($i['usable'] == '1'):
        echo '停用';
    else:
        echo '啟用';
    endif;?></a></td>
								<?php endif;?>
							</tr>
						<?php }?>
          </tbody>
				</table>

				<?php endif;?>

				<?php if ($current_role == '1' || $current_role == '2' || $current_role == '3' || $current_role == '4' || $current_role == '9'): ?>
					<h4 class="text-dark text-center">機構主管</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">縣市</th>
								<th scope="col">機構</th>
								<th scope="col">姓名</th>
								<th scope="col">電話</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
								<?php if ($current_role == '3'): ?>
									<th scope="col">要項</th>
								<?php endif?>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($organizationManageUsers as $i) {?>
							<tr>
								<td>機構主管</td>
								<td><?php echo $i['countyName'] ?></td>
								<td><?php echo $i['organizationName'] ?></td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['office_phone'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
        echo '是';
    else:
        echo '否';
    endif;?></td>
								<?php if ($current_role == '3'): ?>
									<td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
										<?php if ($i['usable'] == '1'):
        echo '停用';
    else:
        echo '啟用';
    endif;?></a></td>
								<?php endif;?>
							</tr>
						<?php }?>
          </tbody>
				</table>

				<?php endif;?>

				<?php if ($current_role == '1' || $current_role == '2' || $current_role == '3' || $current_role == '4' || $current_role == '5' || $current_role == '9'): ?>
					<h4 class="text-dark text-center">機構承辦人</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">縣市</th>
								<th scope="col">機構</th>
								<th scope="col">姓名</th>
								<th scope="col">電話</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
								<?php if ($current_role == '4'): ?>
									<th scope="col">要項</th>
								<?php endif;?>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($organizationUsers as $i) {?>
							<tr>
								<td>機構承辦人</td>
								<td><?php echo $i['countyName'] ?></td>
								<td><?php echo $i['organizationName'] ?></td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['office_phone'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
        echo '是';
    else:
        echo '否';
    endif;?></td>
								<?php if ($current_role == '4'): ?>
									<td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
										<?php if ($i['usable'] == '1'):
        echo '停用';
    else:
        echo '啟用';
    endif;?></a></td>
								<?php endif?>
							</tr>
						<?php }?>
          </tbody>
				</table>

				<?php endif;?>

				<?php if ($current_role == '1' || $current_role == '2' || $current_role == '3' || $current_role == '4' || $current_role == '5' || $current_role == '6' || $current_role == '9'): ?>
					<h4 class="text-dark text-center">輔導員</h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
								<th scope="col">身分</th>
								<th scope="col">縣市</th>
								<th scope="col">機構</th>
								<th scope="col">姓名</th>
								<th scope="col">信箱</th>
								<th scope="col">是否啟用</th>
								<?php if ($current_role == '5'): ?>
									<th scope="col">要項</th>
								<?php endif;?>
						  </tr>
            </thead>
          <tbody>
					  <?php foreach ($counselorUsers as $i) {?>
							<tr>
								<td>輔導員</td>
								<td><?php echo $i['countyName'] ?></td>
								<td><?php echo $i['organizationName'] ?></td>
								<td><?php echo $i['name'] ?></td>
								<td><?php echo $i['email'] ?></td>
								<td><?php if ($i['usable'] == '1'):
        echo '是';
    else:
        echo '否';
    endif;?></td>
								<?php if ($current_role == '5'): ?>
									<td><a class="btn btn-info" href="<?php echo site_url('user/update_manage_usable/' . $i['id'] . '/' . $i['usable']); ?>">
										<?php if ($i['usable'] == '1'):
        echo '停用';
    else:
        echo '啟用';
    endif;?></a></td>
								<?php endif;?>
							</tr>
						<?php }?>
          </tbody>
				</table>

				<?php endif;?>

      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
