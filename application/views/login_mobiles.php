<style type="text/css">
  i#info{
    color: orange;
  }
  .set_error {
      color: red;
  }
</style>
<div class="limiter">
  <div class="container-login100">
    <div class="text-center w-full  p-b-22"> <!-- p-t-42 -->
        <span class="txt1" style="color:#ffffff;font-size:30px;font-weight:bold;">

        </span>
    </div>
    <!-- <form class="" action="<?php //echo base_url(); ?>Index/login" method="post"> -->
      <?php echo form_open('Index/','id="login_mobile"'); ?>
      <div class="wrap-login100 p-l-50 p-r-50 p-t-50 p-b-30">
      <form class="login100-form validate-form" >
        <span class="login100-form-title p-b-40">
          <span style="color:green;">ENVIRONMENTAL MANAGEMENT BUREAU</span>
        </span>

        <div class="wrap-input100 validate-input m-b-16">
          <?php echo form_error('username'); ?>
          <?=$user_auth[0]['username']?>
          <input class="input100" type="text" name="username" placeholder="Username" autofocus value="<?=trim($_GET['username'])?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-user"></span>
          </span>

        </div>

        <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
          <?php echo form_error('password'); ?>
          <input class="input100" type="password" name="password" placeholder="Password" value="<?=trim($_GET['password'])?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-lock"></span>
          </span>
        </div>

        <div class="container-login100-form-btn p-t-25">
          <button class="login100-form-btn" onClick='submitDetailsForm()'>
            Login
          </button>

        </div>

        <div class="text-center w-full p-t-115">
          <span class="txt1">
            Not registered?
          </span>

          <a class="txt1 bo1 hov1" href="<?php echo base_url(); ?>Index/register">
            Register here
          </a>

        </div>

      </form>
    </div>
    </form>
  </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
var username = '<?= $_GET['username'] ?>';
var password = '<?= $_GET['password'] ?>';
document.getElementById('login_mobile').submit();
 window.location.href = 'https://iis.emb.gov.ph/embis/swm/dashboard';
</script>
