<style type="text/css">
  i#info{
    color: orange;
  }
  .set_error {
      color: red;
  }
  canvas#xmas_canvas {
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    pointer-events: none;
  }


    .smsCode {
        text-align: center;
        line-height: 80px;
        font-size: 50px;
        border: solid 1px #ccc;
        box-shadow: 0 0 5px #ccc inset;
        width:150%;
        outline: none;
        border-radius: 3px;
    }
    
</style>

<div class="limiter">
  <canvas id="xmas_canvas"></canvas>
  <div class="container-login100">

    <div class="text-center w-full  p-b-22"> <!-- p-t-42 -->
        <span class="txt1" style="color:#ffffff;font-size:30px;font-weight:bold;">

        </span>
    </div>

    <!-- <form class="" action="<?php echo base_url(); ?>emailtoken" method="post"> -->
      <div class="wrap-login100 p-l-50 p-r-50 p-t-50 p-b-30">
        <form action="<?= base_url('emailtokenverify'); ?>" method="post" accept-charset="utf-8">
            <!-- <form class="login100-form validate-form "> -->
            <span class="login100-form-title p-b-40">
            <span style="color:green;">ENVIRONMENTAL MANAGEMENT BUREAU</span>
            </span>

            <!-- ---------------------------- select sub system ---------------------------- -->
            <span class="login100-form-title p-b-40" >
            <span style="color:green; text-align: center; font-size: 20px;">Please enter your OTP</span>
            </span>

            <div>
                <div class="row SMSArea">
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input1" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input2" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input3" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input4" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input5" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input6" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" />
                </div>
            </div>

            <?php if($this->session->flashdata('flashmsg')): ?> 
                <span style="color:green; text-align: center; font-size: 20px;">
                    <p style='color: red'><?php echo $this->session->flashdata('flashmsg'); ?></p>
                </span>
            <?php endif; ?>

            <span class="login100-form-title p-b-40" >
                <span style="color:green; text-align: center; font-size: 20px;">
                    <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>Index/logout_user">
                        Back         
                    </a>
                </span>
                <span style="color:green; text-align: center; font-size: 20px;">
                    <button type="submit" class="btn btn-primary btn-sm">
                      <span class="text">Verify</span>
                    </button>
                </span>
            </span>
        
        </form>
  </div>
</div>

<script type="text/javascript">
    $(".inputs").keyup(function () {
    if (this.value.length == this.maxLength) {
            $(this).next('.inputs').focus();
            $(this).next('.inputs').select();
            }
    });
    
</script>