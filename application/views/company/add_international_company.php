<!-- Begin Page Content -->
  <div class="container-fluid">
      <div class="row">
        <style media="screen">
          .error_req{color:red}
        </style>
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary">ADD COMPANY - <?php echo $_SESSION['region']; ?>
                <?php if ($_SESSION['company_rights'] == 'yes'): ?>

                  <a href="<?= base_url('Company/Add_company?data=2')?>" style="padding-left: 10px;color: red;text-decoration:underline;"  id="add_local_company">ADD LOCAL COMPANY</a>

                  <a href="<?= base_url('Company/Add_company/international_company?data=1')?>" style="padding-left: 15px;color: red;" id="add_international_company">ADD INTERNATIONAL COMPANY</a>
                <?php endif; ?>
              </h6>


            </div>

            <!-- Card Body -->
              <div class="card-body">
                <?php //echo validation_errors(); ?>
                <!-- <form class="" action="<?php //echo base_url(); ?>/Company/Add_company/add_company" method="post" enctype="multipart/form-data"> -->    <div class="col-xl-12  mb-4" style="padding:0!important" >
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                    <h6 class="m-0 font-weight-bold text-primary">COMPANIES  - <span style="color:red">Note: Please check if the Company existed before adding new Company</span></h6>
                  </div>
                  <div class="card shadow h-100 py-2 bg-gradient-primary" style="border-radius:0px!important">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-xl-12 mb-3">
                          <div class="row">
                            <select class="form-control" name="main_comp" id="existing_companies-per_region">
                              <option value="">COMPANIES</option>
                              <?php foreach ($companies as $key => $valuecmop): ?>
                                  <option value="<?php echo $valuecmop['company_id']; ?>"><?php echo $valuecmop['company_name']." | ".$valuecmop['province_name']." , ".$valuecmop['city_name']." , ".$valuecmop['barangay_name']." | ".$valuecmop['emb_id']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <?php echo form_open_multipart('Company/Add_company/international_company?data=2'); ?>
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">COMPANY INFORMATION</h6>
                    </div>
                      <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                  <div class="col-xl-6">
                                    <div class="add_comp_label">EMB ID: (Auto-generated)</div>
                                    <input type="rad" name="" value="" class="form-control"  readonly>
                                  </div>
                                  <div class="col-xl-6">
                                    <div class="add_comp_label">Company Type:</div>
                                    <div class="row">
                                      <div class="col-xl-6">
                                          <input type="radio" name="comp_type" value="" id="show_main_comp_id" onclick="show_main_comp()" class="btn btn-success btn-circle btn-sm" <?php if (!empty($_POST['comp_type'])) echo 'checked'; ?>>
                                          <label for="" class="add_comp_label">MAIN</label>
                                      </div>
                                      <div class="col-xl-6">
                                          <input type="radio" name="comp_branch" value="" id="show_branch_comp_id" onclick="show_branch_comp()" class="btn btn-success btn-circle btn-sm" <?php if (!empty($_POST['comp_branch'])) echo 'checked'; ?>>
                                          <label for="" class="add_comp_label">BRANCH</label>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="add_comp_label">Company/Proponent name: <span class="error_req">( required )</div>
                              <input type="text" name="compname" value="<?php echo set_value('compname'); ?>" class="form-control" id='maincompname'>
                              <span class="error_req"><?php echo form_error('compname'); ?></span>
                            </div>
                            <!-- for branch_comp -->
                            <div class="branch_comp col-xl-12 mb-3">
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="add_comp_label">Select Main Company: <span class="error_req">( required )</div>
                                      <select class="form-control" name="main_comp" id="main_comp_id">
                                        <option value="">SELECT MAIN COMPANY</option>
                                        <?php foreach ($companies as $key => $valuecmop): ?>
                                            <option value="<?php echo $valuecmop['company_id']; ?>"><?php echo $valuecmop['company_name']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                        <span class="error_req"><?php echo form_error('main_comp'); ?></span>
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="add_comp_label">Project Name: <span class="error_req">( required )</div>
                                      <input type="text" name="project_name" value="" class="form-control project_name" placeholder="Enter Project name">
                                      <span class="error_req"><?php echo form_error('project_name'); ?></span>
                                    </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                  <div class="col-md-6">
                                    <div class="add_comp_label">Establishment Name:</div>
                                    <input type="text" name="estnam" value="<?php echo set_value('estnam'); ?>" class="form-control">
                                  </div>
                                  <div class="col-md-6">
                                    <div class="add_comp_label">Date Established:</div>
                                    <input type="date" name="date_estab" value="<?php echo set_value('date_estab'); ?>" class="form-control">
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="add_comp_label">Project Type: <span class="error_req">( required )</div>
                              <select class="form-control" name="project_type" id="comp_project_type_id" onchange='comp_project_type(this.value)'>
                                <option value="">-</option>
                                <?php foreach ($queryproject_type as $key => $ptval): ?>
                                  <?php if ($ptval['header'] === '1'): ?>
                                    <optgroup label="<?php echo $ptval['prj'] ?>">
                                      <?php $display='none'; ?>
                                    <?php else: ?>
                                      <?php $display='block'; ?>
                                  <?php endif; ?>
                                  <?php if ($ptval['chap'] == '0') {
                                          $ptval['chap'] = ' ';
                                        } if ($ptval['part'] == '0') {
                                          $ptval['part'] = ' ';
                                        } if ($ptval['branch'] == '0') {
                                          $ptval['branch'] = ' ';
                                        }; ?>

                                        <?php if ($ptval['header'] === '1'): ?>
                                          <?php else: ?>
                                            <option style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid']?>">
                                              <?php echo $ptval['base'].'.'.$ptval['chap'].'.'.$ptval['part'].'.'.$ptval['branch'].'-'.$ptval['prj']; ?></option>
                                        <?php endif; ?>

                                <?php endforeach; ?>
                              </select>
                                <span class="error_req"><?php echo form_error('project_type'); ?></span>
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                  <div class="col-xl-6">
                                    <div class="add_comp_label">Project Size Parameters / Remarks:</div>
                                    <input type="textarea" name="" value="" class="form-control" id="prsizrem" readonly>
                                  </div>
                                  <div class="col-xl-6">
                                    <div class="add_comp_label">Category: <span class="error_req">( required )</div>
                                   <!--  <select class="form-control" name="category" id="comp_category_id">
                                      <option value="">SELECT CATEGORY</option>
                                    </select> -->
                                      <div id="comp_category_id">

                                    </div>
                                      <span class="error_req"><?php echo form_error('category'); ?></span>
                                  </div>
                              </div>
                            </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Company Telephone Number: <span class="error_req">( required )</div>
                                  <input type="number" name="comp_tel" value="" class="form-control">
                                    <span class="error_req"><?php echo form_error('comp_tel'); ?></span>
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Company Email Address</div>
                                  <input type="emial" name="comp_email" value="<?php echo set_value('comp_email'); ?>" class="form-control">
                                </div>
                            </div>
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- SC -->
                  <!-- comapny address -->
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">COMPANY ADDRESS</h6>
                    </div>
                      <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                <div class="col-xl-12">
                                        <div class="add_comp_label">ADDRESS: <span class="error_req">( required )</div>
                                <input type="text" name="int_comp_address" value="" class="form-control">
                                <span class="error_req"><?php echo form_error('int_comp_address'); ?></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                  <div class="col-xl-6">
                                    <div class="add_comp_label">Latitude:</div>
                                    <input type="number" name="lat" value="<?php echo set_value('lat'); ?>" class="form-control" step="any">
                                  </div>
                                  <div class="col-xl-6">
                                    <div class="add_comp_label">Longitude:</div>
                                    <input type="number" name="long" value="<?php echo set_value('long'); ?>" class="form-control" step="any">
                                  </div>
                              </div>
                            </div>
                          <div class="col-xl-12 mb-3">
                            <a href="https://www.gps-coordinates.net/" class="btn btn-success btn-icon-split" target="_blank">
                                      <span class="icon text-white-50">
                                        <i class="fas fa-map-marker"></i>
                                      </span>
                                      <span class="text">GEO COORDINATES</span>
                                    </a>
                            </div>
                          <div class="col-xl-12 mb-3">
                              <!-- <div class="add_comp_label">Location Photo:</div>
                              <input type="file" name="compic[]" value="" class="form-control" multiple> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- SC -->
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">HEAD OF OFFICE</h6>
                    </div>
                    <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">

                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Lastname</div>
                                  <input type="text" name="sname" value="<?php echo set_value('sname'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Firstname:</div>
                                  <input type="text" name="fname" value="<?php echo set_value('fname'); ?>" class="form-control">
                                </div>
                            </div>

                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Middlename:</div>
                                  <input type="text" name="mname" value="<?php echo set_value('mname'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Suffix:</div>
                                  <input type="text" name="suffix" value="<?php echo set_value('suffix'); ?>" class="form-control">
                                </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="add_comp_label">Sex:</div>
                            <div class="row">
                              <div class="col-xl-6">
                                <input type="radio" name="sex" value="male" class="btn btn-success btn-circle btn-sm">
                                <label for="" class="add_comp_label">MALE</label>
                              </div>
                              <div class="col-xl-6">
                                <input type="radio" name="sex" value="female" class="btn btn-success btn-circle btn-sm">
                                <label for="" class="add_comp_label">FEMALE</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Personal Contact Number:</div>
                                  <input type="number" name="pertel" value="<?php echo set_value('pertel'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Personal Email Address:</div>
                                  <input type="text" name="per_email" value="<?php echo set_value('per_email'); ?>" class="form-control">
                                </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <button type="submit" class="btn btn-success btn-icon-split" style="float: right;"><span class="text">SAVE</span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            <!-- Card Body -->

          </div>
        </div>
      </div>
</div>

 <script type="text/javascript">
    $('#existing_companies-per_region').selectize();
    $('#main_comp_id').selectize();
  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <style media="screen">
  h2#swal2-title {
  font-size: 0.875em;
}
  </style>
  <script type="text/javascript">
    $(document).ready(function(){
        var data = ' <?php echo $_GET['data']; ?>';
        if (data = 1) {
          $('#add_international_company').css({'text-decoration':'underline','font-size':'16px','font-weight':'bolder'});
          $('#add_local_company').css({'text-decoration':'unset'});
        }
        // else {
        //     $('#add_local_company').css({'text-decoration':'unset'});
        //   $('#add_international_company').css({'text-decoration':'underline'});
        // }
    });
  </script>
 <?php if ($this->session->flashdata('messsage') != ''): ?>
<script type="text/javascript">
  $(document).ready(function() {
    Swal.fire({
      title: 'Your company has been successfully added with EMB ID:',
      text: '<?php echo $this->session->flashdata('messsage'); ?>',  // title: 'Sweet!',
      // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
      imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
      imageWidth: 135,
      imageHeight: 50,
      imageAlt: 'Custom image',
    });
      // for validations
      // for main and branch

      $('#add_local_company').click(function(e){
      $(this).addClass('clicked');
      })

  });


</script>
<?php endif; ?>
