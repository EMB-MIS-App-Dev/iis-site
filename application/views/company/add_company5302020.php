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
                <!-- <form class="" action="<?php //echo base_url(); ?>/Company/Add_company/add_company" method="post" enctype="multipart/form-data"> -->
                    <div class="col-xl-12  mb-4" style="padding:0!important" >
                        FOR REFERENCE ONLY
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">

                    <h6 class="m-0 font-weight-bold text-primary">COMPANIES  - <span style="color:red">Note: Please check if company do not exist and proceed on adding. If exist, do not proceed to avoid duplication.</span></h6>
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
                <?php echo form_open_multipart('Company/Add_company/','id="add_new_company_id"'); ?>
                <input type="hidden" name="attachment_token" value="" id="attachment_token_id">
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    ADD NEW COMPANY
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
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">Type of Business/ Industry Classification</h6>
                    </div>
                      <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col-md-12 mb-3">
                                (Click <a href="https://psa.gov.ph/content/philippine-standard-industrial-classification-psic" target="_blank">here</a>  to search for your PSIC Code/Description) or search in pdf </label><a target="_blank" href="<?= base_url()?>uploads/PSA_PSIC_2009-CODES.pdf"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="">Philippine Standard Industry Classification Code. No.</div>
                              <input type="text" class="form-control form-control-user" id="" placeholder="e.g. 55102" name="psi_code_no" value="">
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="">Philippine Standard Industry Descriptor.</div>
                              <input type="text" class="form-control form-control-user" id="" placeholder="e.g. 55102" name="psi_descriptor" value="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
                                  <div class="row">
                                    <div class="col-xl-3">

                                    </div>
                                    <?php if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1'): ?>
                                    <div class="col-xl-6" style="margin-bottom: 20px;">
                                        <div class="add_comp_label">REGION: <span class="error_req">( required )</div>
                                        <select class="form-control" name="region_id"  onchange=select_region(this.value)>
                                          <option value="">SELECT REGION</option>
                                          <?php foreach ($region_data as $key => $rgnval): ?>
                                            <?php if ($rgnval['rgnnum'] === 'CO'): ?>
                                              <option value="<?php echo $rgnval['rgnnum']; ?>" style="display:none"><?php echo $rgnval['rgnnam']; ?></option>
                                              <?php else: ?>
                                              <option value="<?php echo $rgnval['rgnnum']; ?>"><?php echo $rgnval['rgnnam']; ?></option>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                        </select>
                                            <span class="error_req"><?php echo form_error('region_id'); ?></span>
                                    </div>
                                  <?php endif; ?>
                                    <div class="col-xl-3">

                                    </div>
                                  </div>

                                </div>
                                  <div class="col-xl-4">
                                    <div class="add_comp_label">Province: <span class="error_req">( required )</div>

                                  <?php if ($_SESSION['region'] == 'NCR' || $_SESSION['region'] == 'CO'): ?>
                                      <select name="" class="form-control" id="select_prov_sample" name="prov_id">
                                      <option value="" >--</option>
                                      </select>
                                      <div id="select_comp_province_id"></div>
                                  <?php else: ?>

                                    <select id="select_comp_province_id" class="form-control" name="prov_id"  onchange=select_province(this.value) >
                                      <option value="" >-</option>
                                      <?php foreach ($provinces as $key => $provalue): ?>
                                          <option value="<?php echo $provalue['id']; ?>"><?php echo $provalue['name']; ?></option>
                                      <?php endforeach; ?>
                                    </select>

                                    <?php endif; ?>

                                    <span class="error_req"><?php echo form_error('prov_id'); ?></span>
                                  </div>
                                  <div class="col-xl-4">

                                      <div class="add_comp_label">CITY:<span class="error_req">( required )</div>
                                      <!-- <select class="form-control " name="cityid" id="select_comp_city_id" onchange=select_comp_city(this.value) >
                                          <option value="">-</option>
                                      </select> -->
                                      <select name="" class="form-control" id="select_city_sample" name="cityid">
                                      <option value="" >--</option>
                                    </select>
                                    <div id="select_comp_city_id">

                                    </div>
                                      <span class="error_req"><?php echo form_error('cityid'); ?></span>
                                  </div>
                                  <div class="col-xl-4">

                                      <div class="add_comp_label">Brgy: <span class="error_req">( required )</div>
                                      <!-- <select class="form-control " name="brgyid" id="select_comp_brgy_id"  onchange="select_barangay(this.value)">
                                        <option value="">-</option>
                                      </select> -->
                                      <select name="" class="form-control" id="select_brgy_sample" name="brgyid">
                                      <option value="" >--</option>
                                    </select>
                                    <div id="select_comp_brgy_id">

                                    </div>
                                      <span class="error_req"><?php echo form_error('brgyid'); ?></span>
                                  </div>
                              </div>
                            </div>

                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                  <div class="col-xl-12">
                                    <div class="add_comp_label">Street:</div>
                                    <input type="text" name="street" value="<?php echo set_value('street'); ?>" class="form-control">
                                  </div>
                                  <!-- <div class="col-xl-6">
                                    <div class="add_comp_label">Hs No:</div>
                                    <input type="text" name="hsno" value="<?php //echo set_value('hsno'); ?>" class="form-control">
                                  </div> -->
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
                              <div class="add_comp_label">Location Photo:</div>
                              <div class="col-md-12" style="margin-top:10px;">
                                <div class="row">
                                  <div class="form-group erattdropzone" style="border:1px solid; border: 1px solid #D1D3E2;padding: 0px 0px 0px 10px;width: 100%;border-radius:5px;">
                                    <label>Attachment:</label><span class="set_note"> (max. 20mb / file)</span><br />
                                    <span class="set_note">* please upload attachment(s)</span>
                                    <div id="actions" class="row">
                                        <div class="col-md-12">
                                          <button type="button" class="btn btn-outline-primary btn-sm fileinput-button">
                                            <i class="fas fa-plus-circle"></i>
                                            <span>Add Files</span>
                                          </button>
                                          <button type="button" class="btn btn-outline-info btn-sm start">
                                            <i class="fas fa-upload"></i>
                                            <span>Upload All</span>
                                          </button>
                                          <button type="button" class="btn btn-outline-danger btn-sm cancel">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Remove All</span>
                                          </button>
                                        </div>

                                        <div class="col-lg-5">
                                          <!-- The global file processing state -->
                                          <span class="fileupload-process">
                                            <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                            </div>
                                          </span>
                                        </div>
                                    </div>

                                    <div class="table table-striped dropzone_table upload_div files" id="previews">
                                        <div id="att_template" class="file-row dz-image-preview row">
                                            <!-- file name, and error message -->
                                            <div class="col-md-5">
                                              <p class="name" data-dz-name></p>
                                              <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                            <!-- file size, and progress bar -->
                                            <div class="col-md-4">
                                              <p class="size" data-dz-size></p>
                                              <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                              </div>
                                            </div>
                                            <!-- file upload, remove, and delete button -->
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-info btn-sm start">
                                                  <i class="fas fa-upload"></i>
                                                </button>
                                                <button data-dz-remove type="button" class="btn btn-outline-warning btn-sm cancel">
                                                  <i class="fas fa-window-close"></i>
                                                </button>
                                                <button data-dz-remove type="button" class="btn btn-outline-danger btn-sm delete">
                                                  <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- SC -->
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">CEO/President/Owner</h6>
                    </div>
                    <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">

                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Lastname</div>
                                  <input type="text" name="ceo_sname" value="<?php echo set_value('sname'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Firstname:</div>
                                  <input type="text" name="ceo_fname" value="<?php echo set_value('fname'); ?>" class="form-control">
                                </div>
                            </div>

                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Middlename:</div>
                                  <input type="text" name="ceo_mname" value="<?php echo set_value('mname'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Suffix:</div>
                                  <input type="text" name="ceo_suffix" value="<?php echo set_value('suffix'); ?>" class="form-control">
                                </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Personal Contact Number:</div>
                                  <input type="number" name="ceo_contact_num" value="<?php echo set_value('pertel'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Fax #:</div>
                                  <input type="text" name="ceo_fax_no" value="<?php echo set_value('ceo_fax_no'); ?>" class="form-control">

                                    </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                              <div class="add_comp_label">Personal Email Address:</div>
                              <input type="text" name="ceo_email" value="<?php echo set_value('per_email'); ?>" class="form-control">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">Plant Manager</h6>
                    </div>
                    <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">

                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Name</div>
                                  <input type="text" name="plant_manager_name" value="<?php echo set_value('plant_manager'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Email:</div>
                                  <input type="text" name="plant_manager_email" value="<?php echo set_value('plant_manager_email'); ?>" class="form-control">
                                </div>
                            </div>

                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="add_comp_label">Certificate of Accreditation No:</div>
                            <input type="text" name="plant_manager_coe" value="<?php echo set_value('mname'); ?>" class="form-control">
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-4">
                                  <div class="add_comp_label">Tel#:</div>
                                  <input type="number" name="plant_manager_tel_num" value="<?php echo set_value('pertel'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-4">
                                  <div class="add_comp_label">Fax #:</div>
                                  <input type="text" name="plant_manager_fax_num" value="<?php echo set_value('per_email'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-4">
                                  <div class="add_comp_label">Mobile No.:</div>
                                  <input type="text" name="plant_manager_mobile_num" value="<?php echo set_value('per_email'); ?>" class="form-control">
                                </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">Pollution Control Officer</h6>
                    </div>
                    <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">

                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Full Name</div>
                                  <input type="text" name="pco" value="<?php echo set_value('pco'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-6">
                                  <div class="add_comp_label">Email:</div>
                                  <input type="text" name="pco_email" value="<?php echo set_value('pco_email'); ?>" class="form-control">
                                </div>
                            </div>

                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="add_comp_label">Certificate of Accreditation No:</div>
                            <input type="text" name="pco_coe" value="<?php echo set_value('pco_coe'); ?>" class="form-control">
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                                <div class="col-xl-4">
                                  <div class="add_comp_label">Tel#:</div>
                                  <input type="number" name="pco_tel_num" value="<?php echo set_value('pco_tel_num'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-4">
                                  <div class="add_comp_label">Fax #:</div>
                                  <input type="text" name="pco_fax_num" value="<?php echo set_value('pco_fax_num'); ?>" class="form-control">
                                </div>
                                <div class="col-xl-4">
                                  <div class="add_comp_label">Mobile No.::</div>
                                  <input type="text" name="pco_mobile_num" value="<?php echo set_value('pco_mobile_num'); ?>" class="form-control">
                                </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">Upload Permits<span style="color:red">( IF APPLICABLE )</span></h6>
                    </div>
                    <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                      <div class="card-body">
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                              <div class="col-md-2">
                                <div class="">Discharge Permit #</div>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" name="dp_num" value="">
                              </div>
                              <div class="col-md-3">
                                <input type="file" onchange="ValidateSingleInput(this);" name="dp_file">
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                              <div class="col-md-2">
                                <div class="">Permit to Operate #</div>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" name="po_num" value="">
                              </div>
                              <div class="col-md-3">
                                <input type="file" onchange="ValidateSingleInput(this);" name="po_file">
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <div class="row">
                              <div class="col-md-2">
                                <div class="">ECC #</div>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" name="ecc_num" value="">
                              </div>
                              <div class="col-md-3">
                                <input type="file" onchange="ValidateSingleInput(this);" name="ecc_file" >
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-12 mb-3">
                            <button type="submit" class="btn btn-success btn-icon-split" style="float: right;"><span class="text">SAVE</span></button>
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
    function ValidateSingleInput(filename) {
      var ext = filename.value.split('.').pop();
      if (ext != "pdf") {
        alert('UPLOADED FILE IS NOT PDF !');
        filename.value = null;
        return false;
      }
      return true;
    };

    $(document).ready(function(){

      var url = window.location.href ;
      if (url == 'https://iis.emb.gov.ph/embis/Company/Add_company' || url == 'https://iis.emb.gov.ph/embis/Company/Add_company?data=2') {
        var attachment_token_result  = '';
        attachment_token_result = Math.floor((Math.random() * 10000) + 1);
        var userid = '<?php echo $this->session->userdata('userid'); ?>'
        var d = new Date();
        var n = d.getDay()
        var m = d.getMonth();
        var y = d.getFullYear();
        $('#attachment_token_id').val('comp'+'-'+attachment_token_result+'-'+n+'-'+m+'-'+y);
      }


      $("#add_new_company_id").validate({
        ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
       rules: {
         project_type: "required",
         compname: "required",
          category: "required",
          comp_tel: "required",
          region_id: "required",
          prov_id: "required",
          cityid: "required",
          brgyid: "required",
       },
       messages:{
          project_type:  "Specify Project type",
          compname:    "Specify Company/Proponent name",
          category:    "Specify category",
          comp_tel:    "Specify Company Telephone no.",
          region_id:    "Specify Region",
          prov_id:    "Specify Province.",
          cityid:    "Specify City.",
          brgyid:    "Specify Baranggay.",
       },

      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <style media="screen">
  h2#swal2-title {
  font-size: 0.875em;
  }
  #add_new_company_id label{
    font-size: 12px;
    color: red;
  }
  #add_new_company_id select,input[type=text],input[type=number] {
    width: 100%!important
  }
  </style>
 <?php if ($this->session->flashdata('messsage') != ''): ?>
<script type="text/javascript">
  $(document).ready(function() {
    Swal.fire({
      title: 'Company has been successfully added with EMB ID:',
      text: '<?php echo $this->session->flashdata('messsage'); ?>',  // title: 'Sweet!',
      // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
      imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
      imageWidth: 135,
      imageHeight: 50,
      imageAlt: 'Custom image',
      })
      // for validations
      // for main and branch
  });


</script>
<?php endif; ?>
<script type="text/javascript">
      Dropzone.autoDiscover = false;
      $(document).ready(function() {
        //Dropzone
        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#att_template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone("div.erattdropzone", { // Make the whole body a dropzone
          url: "<?php echo base_url('Company/Add_company/fileUpload'); ?>", // Set the url
          params: {

          },
          maxFilesize: 20,
          parallelUploads: 20,
          timeout: 0,
          acceptedFiles: "image/*",
          previewTemplate: previewTemplate,
          autoQueue: false, // Make sure the files aren't queued until manually added
          previewsContainer: "#previews", // Define the container to display the previews
          clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        });


        myDropzone.on("addedfile", function(file) {
          // Hookup the start button
          file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
          document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file,xhr, formData) {

          formData.append('attachment_token', jQuery('#attachment_token_id').val());
          // Show the total progress bar when upload starts
          document.querySelector("#total-progress").style.opacity = "1";
          // And disable the start button
          file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
          document.querySelector("#total-progress").style.opacity = "0";
        });

        // for deleting uploaded file
        myDropzone.on("success", function(file, response) {
          $(file.previewTemplate).append('<span class="server_file" style="display:none">'+response+'</span>');
        });
        myDropzone.on("removedfile", function(file) {
          var server_file = $(file.previewTemplate).children('.server_file').text();
          var base_url = '<?php echo base_url(); ?>';
          $.post(base_url+"Comapany/Add_company/removeuploadedfile", { file_to_be_deleted: server_file } );
        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
          myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
          myDropzone.removeAllFiles(true);
        };

      });

    </script>
