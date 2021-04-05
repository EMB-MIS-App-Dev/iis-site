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
    #errmsg
    {
    color: red;
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
      <!-- <?=form_open_multipart(base_url('update_accountinfo'))?> -->
        <form action="<?= base_url('update_accountinfo'); ?>" method="post" accept-charset="utf-8">
            <!-- <form class="login100-form validate-form "> -->
            <span class="login100-form-title p-b-40">
            <span style="color:green;">ENVIRONMENTAL MANAGEMENT BUREAU</span>
            </span>

            <!-- ---------------------------- select sub system ---------------------------- -->
            <span class="login100-form-title p-b-40" >
            <span style="color:green; text-align: center; font-size: 20px;">Please update your contact information.</span>
            </span>

            <div>
                <!-- <div class="row"> -->
                
                       
                <input class="form-control" type="email" value="<?php echo $email; ?>" name="email" placeholder="Email Address" required>
               
                <!-- <div class="input-group">
                    <span class="input-group-addon">+63</span>
                    <input type="text" maxlength="10" value="<?php echo $number; ?>" name="cell_no" id="cell_no" class="form-control" placeholder="ex. 9191234567" aria-label="number" required>
                    &nbsp;<span id="errmsg"></span>
                </div> -->

                <!-- </div> -->

                <table class="table table-bordered table-hover" id="dynamic_field">
                <tr>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">+63</span>
                            <input type="text" maxlength="10" value="<?php echo $number; ?>" name="cell_no[]" id="cell_no" class="form-control" placeholder="ex. 9191234567" aria-label="number" required>
                            &nbsp;<span id="errmsg"></span>
                        </div>
                    </td>
                    <td><button type="button" name="add" id="add" class="btn btn-primary">Add More</button></td>  
                </tr>
                </table>
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
                      <span class="text">Update</span>
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

<script>
$(document).ready(function () {
  //called when key is pressed in textbox
  $("#cell_no").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });


   
    var i = 1;

    $("#add").click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><div class="input-group"><span class="input-group-addon">+63</span><input type="text" maxlength="10" name="cell_no[]" id="cell_no" class="form-control" placeholder="ex. 9191234567" aria-label="number" required>&nbsp;<span id="errmsg"></span></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
    });

    $(document).on('click', '.btn_remove', function(){  
    var button_id = $(this).attr("id");   
    $('#row'+button_id+'').remove();  
    });
});
</script>


