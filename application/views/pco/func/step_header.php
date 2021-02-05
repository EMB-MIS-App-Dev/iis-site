
<div class="container">
  <div class="row text-white" style="border: 0.5px solid #DDDDDD;">

    <div id="step_head1" class="mainstepper col-md-2">
      <br>
      <div class="col-md-12 d-flex justify-content-center">
        <ul class="stephead-list stephead-circle" >
            <li><a class="iconStepper btn-glow" href="<?=base_url('pco/application/'.$appli_id.'/1')?>"><i class="fas fa-user"></i></a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-center"><p><a href="<?=base_url('pco/application/'.$appli_id.'/1')?>">Basic Information</a></p></div>
    </div>

    <div id="step_head2" class="mainstepper col-md-2 ">
      <br>
      <div class="col-md-12 d-flex justify-content-center">
        <ul class="stephead-list stephead-circle" >
            <li><a class="iconStepper btn-glow" href="<?=base_url('pco/application/'.$appli_id.'/2')?>" ><i class="far fa-building"></i></a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-center "><p><a href="<?=base_url('pco/application/'.$appli_id.'/2')?>">Establishment Details</a></p></div>
    </div>

    <div id="step_head3" class="mainstepper col-md-2 " >
      <br>
      <div class="col-md-12 d-flex justify-content-center">
        <ul class="stephead-list stephead-circle" >
            <li><a class="iconStepper btn-glow" href="<?=base_url('pco/application/'.$appli_id.'/3')?>" ><i class="fas fa fa-file-contract"></i></a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-center"><p><a href="<?=base_url('pco/application/'.$appli_id.'/3')?>">Educational Attainment</a></p></div>
    </div>

    <div id="step_head4" class="mainstepper col-md-2 " >
      <br>
      <div class="col-md-12 d-flex justify-content-center">
        <ul class="stephead-list stephead-circle" >
            <li><a class="iconStepper btn-glow" href="<?=base_url('pco/application/'.$appli_id.'/4')?>"><i class="fas fa-briefcase"></i></a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-center"><p><a href="<?=base_url('pco/application/'.$appli_id.'/4')?>">Work Experience</a></p></div>
    </div>

    <div id="step_head5" class="mainstepper col-md-2 ">
      <br>
      <div class="col-md-12 d-flex justify-content-center">
        <ul class="stephead-list stephead-circle" >
            <li><a class="iconStepper btn-glow" href="<?=base_url('pco/application/'.$appli_id.'/5')?>" ><i class="fas fa-shoe-prints"></i></a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-center"><p><a href="<?=base_url('pco/application/'.$appli_id.'/5')?>">Trainings / Seminars Attended</a></p></div>
    </div>

    <div id="step_head6" class="mainstepper col-md-2 ">
      <br>
      <div class="col-md-12 d-flex justify-content-center">
        <ul class="stephead-list stephead-circle" >
            <li><a class="iconStepper btn-glow" href="<?=base_url('pco/application/'.$appli_id.'/6')?>" ><i class="fas fa-file-alt"></i></a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-center"><p><a href="<?=base_url('pco/application/'.$appli_id.'/6')?>">Other Requirements</a></p></div>
    </div>

  </div>
</div>

<?php if( $main_step == 7 ) { ?>
  <div class="container"><br>
    <div class="row justify-content-center">
      <button type='button' id='finalize_btn' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#finalize_modal' title='Finalize'><i class='fas fa-check-circle'></i> FINALIZE AND SUBMIT APPLICATION</button>
    </div>
  </div>
<?php } ?>

<!-- FINALIZE APPLICATION -->
<div class="modal fade" role="dialog" id="finalize_modal" >
  <div class="modal-dialog" style="width: 80%">
    <div class="modal-content">

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <button type="button" class="close" data-dismiss="modal"><i class="fas fa-window-close"></i></button>
          <h6 class="modal-title m-0 font-weight-bold text-primary">Finalize and Submit Application</h6>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="card-body" >
            <input type="hidden" name="final_accid" readonly value="<?php // echo $_SESSION['accid'];?>">
            <input type="hidden" name="final_apid" readonly value="<?php // echo $_SESSION['apid'];?>">
            <input type="hidden" name="final_tno" readonly value="<?php // echo $steppco_tno = !empty($step_fetch['olnum']) ? mysql_real_escape_string(trim($step_fetch['olnum'])) : '';?>">
            <input type="hidden" name="final_step" readonly value="<?php // echo $_SESSION['step'];?>">
            <input type="hidden" name="final_qual" readonly value="<?php // echo $accm_fetch['qual'];?>">
            <br><br>
            <div class="row justify-content-center ">
              <div class=" alert alert-warning col-md-12 justify-content-center" style="text-align: center">
                Submit your finalized application? <br>
                * Doing so will forward this application to the respective personnel of EMB 7. *
              </div> <br><br>
              <div>
                <button type="submit" class="btn btn-success" name="finalize_application" id="fnlz_id"><i class="far fa-check-circle"></i> Yes</button>&nbsp;&nbsp;
                <button type="button" data-dismiss="modal" class="btn btn-danger"><i class="far fa-times-circle"></i> No</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--End of view modal-->
