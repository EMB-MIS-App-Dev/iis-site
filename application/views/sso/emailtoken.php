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

    .alert.alert-info, .button
    { 
    max-width: 600px; 
    margin: 40px auto;
    text-align: center;
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
            <span class="login100-form-title" >

            <span class="login100-form-title p-b-40" >
                <span style="color:green; text-align: center; font-size: 20px;">
                <?php $userid=$this->session->userdata('userid'); ?>
                    <p>
                        Part of improving the system security, we are implementing the two-factor authentication. Click from the button below to recieve the confirmation code.
                    </p>
            
                    <button type="submit" class="btn btn-primary btn-sm" value="email" name="action" class="btn btn-primary btn-md">
                      <span class="text"> Send via Email</span>
                    </button>

                    <button type="submit" class="btn btn-primary btn-sm" value="sms" name="action" class="btn btn-primary btn-md">
                      <span class="text">Send via SMS</span>
                    </button>

                    <!-- <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url('sendtoken/').$userid; ?>">   
                    Send via Email
                    </a>
                    <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url('sendtokensms/').$userid; ?>">   
                    Send via SMS
                    </a> -->
                    <div style="text-align:left">
                        <p>Email: <?php echo $email = substr($email,0,2). '******' . substr( $email, strpos($email,'@')); ?></p>
                        <p>Mobile no.: <select name="numbs" id="numbs">
                                            <?php foreach($number as $nm) : ?>
                                                <option value="<?php echo $nm['number']; ?>" ><?php echo '******' . substr($nm['number'], -4); ?></option>
                                                
                                            <?php endforeach; ?>
                                        </select>
                        </p>
                    </div>
                </span>
            </span>

            <!-- <span style="color:green; text-align: center; font-size: 20px;">Please enter your Confirmation Code</span> -->
            <p>Please enter your Confirmation Code and click the Continue button.</p>
            </span>

            <div>
                <div class="row SMSArea">
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input1" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" autocomplete="off" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input2" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" autocomplete="off" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input3" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" autocomplete="off" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input4" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" autocomplete="off" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input5" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" autocomplete="off" />
                    
                        <input style="width: 50px; margin: 6px" type="text" name="input6" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}" class="smsCode text-center rounded-lg inputs" autocomplete="off" />
                </div>
            </div>

            <?php if($this->session->flashdata('flashmsg')): ?> 
                <span style="color:green; text-align: center; font-size: 20px;">
                    <p style='color: red'><?php echo $this->session->flashdata('flashmsg'); ?></p>
                </span>
            <?php endif; ?>

            <span class="login100-form-title p-b-40" >
                <!-- <span style="color:green; text-align: center; font-size: 20px;">
                    <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>Index/logout_user">
                        Back         
                    </a>
                </span> -->
                <span style="color:green; text-align: center; font-size: 20px;">
                    <button type="submit" value="continue" name="action" id="cont" class="btn btn-primary btn-md">
                      <span class="text">Continue</span>
                    </button>
                </span>
            </span>
            <!-- <span class="login100-form-title p-b-40" >
                <span style="color:green; text-align: center; font-size: 20px;">
                <?php $userid=$this->session->userdata('userid'); ?>
                    <a href="<?php echo base_url('sendtoken/').$userid; ?>">
                        Resend code         
                    </a>
                </span>
            </span> -->
            

        
        </form>
  </div>
</div>

<!-- modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Single Sign-on (SSO)</h4>
      
      </div>
      
      <div class="modal-body">
	  <div class="modal-split">
            <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label><b>Single sign-on (SSO) is an authentication scheme that allows a user to log in with a single ID and password to any of several related, yet independent, software systems.</b></label>
                </div>
            </div>
		</div>

        <div class="modal-split">
            <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label> 1.) Update your email and mobile number registered on IIS.</label>
                </div>
                <div class="col-md-12" id="bulletincnt_">
                    <img src="<?php echo base_url().'assets/images/tutorial/update.png'?>" alt="User" style="width:100%">
                </div>
            </div>
		</div>
		
		<div class="modal-split">
        <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label> 2.) On the IIS sidebar, click Online Systems.</label>
                </div>
                <div class="col-md-12" id="bulletincnt_">
                    <img src="<?php echo base_url().'assets/images/tutorial/sidebar.png'?>" alt="User" style="width:100%">
                </div>
            </div>
		</div>
		
		<div class="modal-split">
        <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label> 3.) Enroll your sub-system you want to link to your IIS account.</label><br>
                    <label> a. Select the sub-system you want to add.</label><br>
                    <label> b. Add a nickname to your user account.</label><br>
                    <label> c. Type your sub-system username and password.</label><br>
                    <label> d. Click "Add sub-system" button, then wait for the user validation of the account.</label>
                </div>
                <div class="col-md-12" id="bulletincnt_">
                    <img src="<?php echo base_url().'assets/images/tutorial/enrollment1.png'?>" alt="User" style="width:100%">
                </div>
            </div>
		</div>	
        <div class="modal-split">
            <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label> 4.) Once validated, your account will be added to the list below.</label>
                </div>
                <div class="col-md-12" id="bulletincnt_">
                    <img src="<?php echo base_url().'assets/images/tutorial/enrollment2.png'?>" alt="User" style="width:100%">
                </div>
            </div>
		</div>	
        <div class="modal-split">
            <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label> 5.) Re-login to your account, then you will be redirected to the OTP page.</label>
                </div>
                <div class="col-md-12" id="bulletincnt_">
                    <img src="<?php echo base_url().'assets/images/tutorial/otp.png'?>" alt="User" style="width:100%">
                </div>
            </div>
		</div>	
        <div class="modal-split">
            <div class="row">
                <div class="col-md-12" id="bulletincnt_">
                    <label> 6.) Once verified, you can now select the sub-system you want to access.</label>
                </div>
                <div class="col-md-12" id="bulletincnt_">
                    <img src="<?php echo base_url().'assets/images/tutorial/select.png'?>" alt="User" style="width:100%">
                </div>
            </div>
		</div>	

      </div>

      <div class="modal-footer">
 <!--Nothing Goes Here but is needed! -->
      </div>
    </div>
  </div>
</div>
<!-- modal -->

<script type="text/javascript">
    $(".inputs").keyup(function () {
        if (this.value.length == this.maxLength) {
            $(this).next('.inputs').focus();
            $(this).next('.inputs').select();
        }
    });

    // modal for instructions
    $(window).on('load', function() {
        // $('#myModal').modal('show');
    });

    $(document).ready(function() {
    prep_modal();
    });

    function prep_modal()
    {
    $(".modal").each(function() {

    var element = this;
        var pages = $(this).find('.modal-split');

    if (pages.length != 0)
    {
            pages.hide();
            pages.eq(0).show();

            var b_button = document.createElement("button");
                    b_button.setAttribute("type","button");
                        b_button.setAttribute("class","btn btn-primary");
                        b_button.setAttribute("style","display: none;");
                        b_button.innerHTML = "Back";

            var n_button = document.createElement("button");
                    n_button.setAttribute("type","button");
                        n_button.setAttribute("class","btn btn-primary");
                        n_button.innerHTML = "Next";

            $(this).find('.modal-footer').append(b_button).append(n_button);


            var page_track = 0;

            $(n_button).click(function() {
                if($(n_button).text() == "Finish"){
                    $('#myModal').modal('hide');
                }
            
            this.blur();

                if(page_track == 0)
                {
                    $(b_button).show();
                }

                if(page_track == pages.length-2)
                {
                    $(n_button).text("Finish");
                }

            if(page_track == pages.length-1)
            {
            $(element).find("form").submit();
            }

                if(page_track < pages.length-1)
                {
                    page_track++;

                    pages.hide();
                    pages.eq(page_track).show();
                }


            });

            $(b_button).click(function() {

                if(page_track == 1)
                {
                    $(b_button).hide();
                }

                if(page_track == pages.length-1)
                {
                    $(n_button).text("Next");
                }

                if(page_track > 0)
                {
                    page_track--;

                    pages.hide();
                    pages.eq(page_track).show();
                }


            });

    }

    });
    }
</script>

