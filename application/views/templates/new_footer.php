</div>

        
</div>
<?php 
$fixedFooter = ''; 
?>
<footer class="text-center text-lg-start page-footer <?php echo $fixedFooter;?>">
  <!-- Grid container -->
  <!-- <div class="container p-4">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase mb-0">重要資訊</h5>
        <ul class="list-unstyled">
        <li>
          <a class="text-dark" href="<?php echo site_url('/user/contact_us'); ?>">聯絡我們</a>
        </li>
        </ul>
      </div>
    </div>
  </div> -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: #A6A9B6;">
    © 2020 Copyright:
    <a class="text-dark" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>
  <!-- Copyright -->
</footer>

<!-- jQuery CDN - Slim version (=without AJAX) -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<!-- <script type="text/javascript" src="<?php echo site_url(); ?>/assets/js/general.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo site_url(); ?>/assets/js/datepicker.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/all.js"></script>

<!-- <script src="<?php echo site_url(); ?>/assets/js/jquery-1.9.1.js"></script> -->
  <script src="<?php echo site_url(); ?>/assets/js/jquery-ui-1.10.3.custom.js"></script>
  <script src="<?php echo site_url(); ?>/assets/js/JQueryDatePickerTW.js"></script>
  <script src="<?php echo site_url(); ?>/assets/js/script.js"></script>
  <script src="<?php echo site_url(); ?>/assets/js/jquery-timepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        
        $(".time-picker-start").hunterTimePicker();
        $(".time-picker-end").hunterTimePicker();
        
    });

</script>

</body>

</html>