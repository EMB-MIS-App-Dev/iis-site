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
</style>

<div class="limiter">
  <canvas id="xmas_canvas"></canvas>
  <div class="container-login100">
    <div class="text-center w-full  p-b-22"> <!-- p-t-42 -->
        <span class="txt1" style="color:#ffffff;font-size:30px;font-weight:bold;">

        </span>
    </div>

    <!-- <form class="" action="<?php //echo base_url(); ?>Index/login" method="post"> -->
      <div class="wrap-login100 p-l-50 p-r-50 p-t-50 p-b-30">
      <form class="login100-form validate-form">
        <span class="login100-form-title p-b-40">
          <span style="color:green;">ENVIRONMENTAL MANAGEMENT BUREAU</span>
        </span>

        <!-- ---------------------------- select sub system ---------------------------- -->
        <span class="login100-form-title p-b-40" >
          <span style="color:green; text-align: center; font-size: 20px;">SELECT FROM THE FOLLOWING SYSTEMS</span>
        </span>


        <!-- ------------------------ SUBSYSTEMS ------------------------ -->
            <div class="w3-card-4" style="width:50%; padding: 10px;">
                <a href="<?php echo base_url('dashboard')?>">
                    <img src="<?php echo base_url().'assets/images/systems/iis.png'?>" alt="User" style="width:100%">
                    <div class="w3-container w3-center">
                    <p style="text-align: center"><b>IIS</b></p>
                    </div>
                </a>
            </div>

            
            <?php foreach ($getsub as $gs): ?>
                <?php if ($gs['iis_id'] == $this->session->userdata('userid')): ?>
                    <div class="w3-card-4" style="width:50%; padding: 10px;">

                    <?php
                    if($gs['subsys_id'] == "PCB"){
                        $link = 'http://'.$gs['subsys_link'] . "?username=" . $gs['username'] . "&password=" . $gs['password'] ;
                      
                    }
                    ?>
                        <a href="<?php echo($link); ?>">
                            <img src="<?php echo($gs['subsys_img']); ?>" alt="User" style="width:100%">
                            <div class="w3-container w3-center">
                            <p style="text-align: center"><b><?php echo($gs['subsys_id']); ?></b></p>
                            <p style="text-align: center"><b><?php echo($gs['nickname']); ?></b></p>
                            
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <span class="login100-form-title p-b-40" >
              <span style="color:green; text-align: center; font-size: 20px;">
                <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>Index/logout_user">
                  Back         
                </a>
              </span>
            </span>
            
                    
        </div>
    </div>
    <!-- ---------------------------- end select sub system ---------------------------- -->
    </form>
  </div>
</div>
