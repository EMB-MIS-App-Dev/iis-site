
<!-- Begin Page Content -->
<div class="container-fluid">
  <div id="overlay" style="margin:auto">
       <img src="<?php echo base_url(); ?>assets/images/embloader.gif" alt="Loading" />
       Loading...
  </div>
    <div class="row">
      <style media="screen">
        .error_req{color:red}
      </style>
      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

            <h6 class="m-0 font-weight-bold text-primary">COMPANY NAME :  <?php echo $drafted_comp_data[0]['company_name']; ?></h6>
          </div>
          <!-- Card Body -->
            <div class="card-body">
              <?php //echo validation_errors(); ?>
              <!-- <form class="" action="<?php //echo base_url(); ?>/Company/Add_company/add_company" method="post" enctype="multipart/form-data"> -->



                  <div id="establishment_container" >
                    <?php echo form_open_multipart('Company/edit_company/update_company/'); ?>
                      <input type="hidden" name="input_date" value="<?php echo $drafted_comp_data[0]['input_date']; ?>" class="form-control" >
                    <input type="hidden" name="company_id" value="<?= $drafted_comp_data[0]['company_id'] ?>">
                      <input type="hidden" name="jurisdiction" value="<?= $drafted_comp_data[0]['jurisdiction'] ?>">
                      <div class="col-xl-12  mb-4" style="padding:0!important">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                          <h6 class="m-0 font-weight-bold text-primary">COMPANY INFORMATION</h6>
                        </div>
                          <div class="card shadow h-100" style="border-radius:0px!important">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">EMB ID: (Auto-generated)</div>
                                        <input type="rad" name="emb_id" value="<?= $drafted_comp_data[0]['emb_id'] ?>" class="form-control"  readonly>
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Company Type:</div>
                                        <div class="row">
                                          <div class="col-xl-6">
                                              <?php if ($drafted_comp_data[0]['company_id'] == $drafted_comp_data[0]['company_type']): ?>
                                                    <input type="radio" name="comp_type" value="1" id="show_main_comp_id" onclick="show_main_comp()" class="btn btn-success btn-circle btn-sm" checked>
                                                <?php else: ?>
                                                      <input type="radio" name="comp_type" value="1" id="show_main_comp_id" onclick="show_main_comp()" class="btn btn-success btn-circle btn-sm" >
                                              <?php endif; ?>
                                              <label for="">MAIN</label>
                                          </div>
                                          <div class="col-xl-6">
                                              <?php if ($drafted_comp_data[0]['company_id'] == $drafted_comp_data[0]['company_type']): ?>
                                                <input type="radio" name="comp_branch" value="2" id="show_branch_comp_id" onclick="show_branch_comp()" class="btn btn-success btn-circle btn-sm show_branch_comp" >
                                                <?php else: ?>
                                                  <input type="radio" name="comp_branch" value="2" id="show_branch_comp_id" onclick="show_branch_comp()" class="btn btn-success btn-circle btn-sm show_branch_comp" checked>
                                            <?php endif; ?>
                                            <label for="">BRANCH</label>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="h6 mb-0 font-weight-bold text-gray-800">Company/Proponent name: <span class="error_req">( required )</div>
                                  <input type="text" id="edit_main_compname" name="compname" value="<?= $drafted_comp_data[0]['company_name']?>" class="form-control">
                                  <span class="error_req"><?php echo form_error('compname'); ?></span>
                                </div>
                                <!-- for branch_comp -->
                                <div class="branch_comp col-xl-12 mb-3">
                                  <hr>
                                    <div class="row">
                                      <div class="col-xl-11">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Main Company: <span class="error_req">( required )</div>
                                          <input type="hidden" name="main_comp" value="<?= $main_company[0]['company_id']?>">
                                          <input readonly type="text" name="main_company" value="<?= $main_company[0]['company_name']?>" class="form-control project_name" placeholder="Enter Project name">
                          <!-- <select class="form-control" name="main_comp" id="main_comp_id">
                                          <option value="">SELECT MAIN COMPANY</option>
                                          <?php foreach ($companies as $key => $valuecmop): ?>
                                            <?php if ($drafted_comp_data[0]['company_type'] == $valuecmop['company_id']): ?>
                                               <option value="<?php echo $valuecmop['company_id']; ?>" selected><?php echo $valuecmop['company_name']; ?></option>
                                              <?php else: ?>
                                               <option value="<?php echo $valuecmop['company_id']; ?>"><?php echo $valuecmop['company_name']; ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select> -->
                                      </div>
                                      <div class="col-xl-1">
                                        <button type="button" style="margin-top:22px" data-toggle='modal' data-target='#edit_main_company' class="btn btn-primary" name="button"><i class="fas fa-pencil-alt"></i></button>
                                      </div>
                                    </div>
                                  <hr>
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="h6 mb-0 font-weight-bold text-gray-800">Project Name: <span class="error_req">( required )</div>
                                  <input type="text" name="project_name" value="<?= $drafted_comp_data[0]['company_name']?>" class="form-control project_name" placeholder="Enter Project name">
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                      <div class="col-md-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Establishment Name:</div>
                                        <input type="text" name="estnam" value="<?= $drafted_comp_data[0]['establishment_name']?>" class="form-control">
                                      </div>
                                      <div class="col-md-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Date Established:</div>
                                        <input type="date" name="date_estab" value="<?php echo set_value('date_estab'); ?>" class="form-control">
                                      </div>
                                  </div>
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="h6 mb-0 font-weight-bold text-gray-800">Project Type: <span class="error_req">( required )</div>
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
                                              <?php if ($drafted_comp_data[0]['project_type'] == $ptval['proid']): ?>
                                                <option style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid']?>" selected>
                                                  <?php echo $ptval['base'].'.'.$ptval['chap'].'.'.$ptval['part'].'.'.$ptval['branch'].'-'.$ptval['prj']; ?></option>
                                              <?php endif; ?>
                                                <option style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid']?>">
                                                  <?php echo $ptval['base'].'.'.$ptval['chap'].'.'.$ptval['part'].'.'.$ptval['branch'].'-'.$ptval['prj']; ?></option>
                                            <?php endif; ?>

                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Project Size Parameters / Remarks:</div>
                                        <input type="textarea" name="" value="" class="form-control" id="prsizrem" readonly>
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Category: <span class="error_req">( required )</div>
                                        <select class="form-control" name="category" id="comp_category_id">
                                            <option value="0">Not in list</option>
                                          <?php foreach ($category as $key => $catva): ?>
                                              <option value=""><?= $catva['pd']?></option>
                                          <?php endforeach; ?>
                                        </select>
                                          <span class="error_req"><?php echo form_error('category'); ?></span>
                                      </div>
                                  </div>
                                </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Company Telephone Number: <span class="error_req">( required )</div>
                                      <input type="text" name="comp_tel" value="<?= $drafted_comp_data[0]['contact_no']?>" class="form-control">
                                        <span class="error_req"></span>
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Company Email Address</div>
                                      <input type="emial" name="comp_email" value="<?= $drafted_comp_data[0]['email']?>" class="form-control">
                                    </div>
                                </div>
                              </div>


                              </div>
                            </div>
                          </div>
                        </div>
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
                                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="e.g. 55102" name="psi_code_no" value="<?= $drafted_comp_data[0]['psi_code_no']?>">
                                  </div>
                                  <div class="col-xl-12 mb-3">
                                    <div class="">Philippine Standard Industry Descriptor.</div>
                                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="e.g. 55102" name="psi_descriptor" value="<?= $drafted_comp_data[0]['psi_descriptor']?>">
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
                          <div class="card shadow h-100" style="border-radius:0px!important">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                    <?php if ($this->session->userdata('region') === 'NCR' || $this->session->userdata('userid') === '1' || $drafted_comp_data[0]['jurisdiction'] == 2): ?>
                                      <div class="col-xl-12">
                                        <div class="row">
                                          <div class="col-xl-3">

                                          </div>
                                          <div class="col-xl-6" style="margin-bottom: 20px;">
                                              <div class="h6 mb-0 font-weight-bold text-gray-800">REGION: <span class="error_req">( required )</div>
                                              <select class="form-control" name="region_id"  onchange=select_region_edit(this.value)>
                                                <option value="">SELECT REGION</option>
                                                <?php foreach ($region as $key => $rgnval): ?>
                                                  <?php if ($drafted_comp_data[0]['region_name'] == $rgnval['rgnnum']): ?>
                                                      <option value="<?php echo $rgnval['rgnnum']; ?>" selected><?php echo $rgnval['rgnnam']; ?></option>
                                                    <?php else: ?>
                                                      <option value="<?php echo $rgnval['rgnnum']; ?>"><?php echo $rgnval['rgnnam']; ?></option>
                                                  <?php endif; ?>

                                                <?php endforeach; ?>
                                              </select>
                                          </div>
                                          <div class="col-xl-3">

                                          </div>
                                        </div>

                                      </div>
                                    <?php endif; ?>

                                      <div class="col-xl-4" id='prov_containter_ext'>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Province: <span class="error_req">( required )</div>
                                        <select name="prov_id" class="form-control" onchange=select_province(this.value)>
                                          <option value="" >--</option>
                                          <?php foreach ($province as $key => $proval): ?>
                                            <?php if ( $drafted_comp_data[0]['province_id'] == $proval['id']): ?>
                                                <option value="<?= $proval['id']?>" selected><?= $proval['name']?></option>
                                              <?php else: ?>
                                                <option value="<?= $proval['id']?>"><?= $proval['name']?></option>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>
                                      <div class="col-xl-4" id='prov_containter_new' style="display:none">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Province: <span class="error_req">( required )</div>
                                          <div id="select_comp_province_id_edit"></div>
                                      </div>

                                      <div class="col-xl-4">

                                          <div class="h6 mb-0 font-weight-bold text-gray-800">CITY:<span class="error_req">( required )</div>
                                          <!-- <select class="form-control " name="cityid" id="select_comp_city_id" onchange=select_comp_city(this.value) >
                                              <option value="">-</option>
                                          </select> -->
                                          <select name="cityid" class="form-control" id="select_city_sample" onchange=select_comp_city(this.value)>
                                            <option value="" >--</option>
                                            <?php foreach ($city as $key => $cityval): ?>
                                                <?php if ( $drafted_comp_data[0]['city_id'] == $cityval['id']): ?>
                                                     <option value="<?= $cityval['id'] ?>" selected> <?= $cityval['name'] ?></option>
                                                  <?php else: ?>
                                                      <option value="<?= $cityval['id'] ?>"> <?= $cityval['name'] ?></option>
                                              <?php endif; ?>

                                            <?php endforeach; ?>
                                          </select>
                                          <div id="select_comp_city_id">

                                          </div>
                                          <span class="error_req"><?php echo form_error('cityid'); ?></span>
                                      </div>
                                      <div class="col-xl-4">

                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Brgy: <span class="error_req">( required )</div>
                                          <!-- <select class="form-control " name="brgyid" id="select_comp_brgy_id"  onchange="select_barangay(this.value)">
                                            <option value="">-</option>
                                          </select> -->
                                          <select name="brgyid" class="form-control" id="select_brgy_sample">
                                            <option value="" >--</option>
                                            <?php foreach ($baranggay as $key => $brgyval): ?>
                                              <?php if ( $drafted_comp_data[0]['barangay_id'] == $brgyval['id']): ?>
                                                  <option value="<?= $brgyval['id']?>" selected><?= $brgyval['name']?></option>
                                                  <?php else: ?>
                                                  <option value="<?= $brgyval['id']?>"><?= $brgyval['name']?></option>
                                              <?php endif; ?>

                                            <?php endforeach; ?>
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
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Street:</div>
                                        <input type="text" name="street" value="<?= $drafted_comp_data[0]['street'] ?>" class="form-control">
                                      </div>
                                  </div>

                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Latitude:</div>
                                        <input type="number" name="lat" value="<?= $drafted_comp_data[0]['latitude'] ?>" class="form-control" step="any">
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Longitude:</div>
                                        <input type="number" name="long" value="<?= $drafted_comp_data[0]['longitude'] ?>" class="form-control" step="any">
                                      </div>
                                  </div>
                                </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">

                                  <div class="col-md-6">
                                    <a href="https://www.gps-coordinates.net/" class="btn btn-success btn-icon-split" target="_blank">
                                      <span class="icon text-gray-800">
                                        <i class="fas fa-map-marker"></i>
                                      </span>
                                      <span class="text">GEO COORDINATES</span>
                                    </a>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Location Photo:     <a target="_blank" href="<?php echo base_url(); ?>/Company/Company_list/carousel?attachment_token=<?=$drafted_comp_data[0]['attachment_token']?>"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                    </div>
                                </div>
                              </div>
                                  <!-- <input type="file" name="compic[]" value="" class="form-control" multiple> -->
                                                  </div>
                                <div class="col-xl-12 mb-3">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Mailing Address: *</div>
                                    <div class="row">
                                      <div class="col-xl-6">
                                        <input type="radio" onclick="samemadd()" name="madd" value="" class="btn btn-success btn-circle btn-sm" checked>
                                        <label for="">current</label>
                                      </div>
                                      <div class="col-xl-6">
                                        <input type="radio" onclick="newmadd()" name="madd" value="" class="btn btn-success btn-circle btn-sm">
                                        <label for="">new</label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xl-12 mb-3">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Enter Mailing Address:</div>
                                      <input type="text" name="mailadd" value="" class="form-control" disabled id="mailadd">
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
                                    <div class="col-xl-4">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Lastname</div>
                                      <input type="text" name="ceo_sname" value="<?= $drafted_comp_data[0]['ceo_sname'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-4">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Firstname:</div>
                                      <input type="text" name="ceo_fname" value="<?= $drafted_comp_data[0]['ceo_fname'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-4">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">SUFFIX:</div>
                                      <input type="text" name="ceo_suffix" value="<?= $drafted_comp_data[0]['ceo_suffix'] ?>" class="form-control">
                                    </div>
                                </div>

                              </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">MIDDLE NAME:</div>
                                      <input type="text" name="ceo_mname" value="<?= $drafted_comp_data[0]['ceo_mname'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Fax Number:</div>
                                      <input type="number" name="ceo_fax_no" value="<?= $drafted_comp_data[0]['ceo_fax_no'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Personal Contact Number:</div>
                                      <input type="text" name="ceo_contact_num" value="<?= $drafted_comp_data[0]['ceo_contact_num'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Personal Email Address:</div>
                                      <input type="text" name="ceo_email" value="<?= $drafted_comp_data[0]['ceo_email'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12  mb-4" style="padding:0!important">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                          <h6 class="m-0 font-weight-bold text-primary">POLLUTION CONTROL OFFICER</h6>
                        </div>
                        <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">

                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Name:</div>
                                      <input type="text" name="pco" value="<?= $drafted_comp_data[0]['pco'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Certificate of Accreditation No.:</div>
                                      <input type="text" name="pco_coe" value="<?= $drafted_comp_data[0]['pco_coe'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="row">
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Tel #:</div>

                                          <input type="text" name="pco_tel_num" value="<?= $drafted_comp_data[0]['pco_tel_num'] ?>" class="form-control">
                                        </div>
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Fax #:</div>
                                          <input type="text" name="pco_fax_num" value="<?= $drafted_comp_data[0]['pco_fax_num'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="row">
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Email Address:</div>
                                          <input type="text" name="pco_email" value="<?= $drafted_comp_data[0]['pco_email'] ?>" class="form-control">
                                        </div>
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Mobile No.:</div>
                                          <input type="text" name="pco_mobile_num" value="<?= $drafted_comp_data[0]['pco_mobile_num'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12  mb-4" style="padding:0!important">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                          <h6 class="m-0 font-weight-bold text-primary">MANAGING HEAD</h6>
                        </div>
                        <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">

                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="add_comp_label">Full Name</div>
                                      <input type="text" name="managing_head" value="<?= $drafted_comp_data[0]['managing_head'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="add_comp_label">Email:</div>
                                      <input type="text" name="managing_head_email" value="<?= $drafted_comp_data[0]['managing_head_email'] ?>" class="form-control">
                                    </div>
                                </div>

                              </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-4">
                                      <div class="add_comp_label">Tel#:</div>
                                      <input type="text" name="managing_head_tel_no" value="<?= $drafted_comp_data[0]['managing_head_tel_no'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-4">
                                      <div class="add_comp_label">Fax #:</div>
                                      <input type="text" name="managing_head_fax_no" value="<?= $drafted_comp_data[0]['managing_head_fax_no'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-4">
                                      <div class="add_comp_label">Mobile No.</div>
                                      <input type="text" name="managing_head_mobile_no" value="<?= $drafted_comp_data[0]['managing_head_mobile_no'] ?>" class="form-control">
                                    </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12  mb-4" style="padding:0!important">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                          <h6 class="m-0 font-weight-bold text-primary">PLANT MANAGER</h6>
                        </div>
                        <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">

                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Name:</div>
                                      <input type="text" name="plant_manager_name" value="<?= $drafted_comp_data[0]['plant_manager_name'] ?>" class="form-control">
                                    </div>
                                    <div class="col-xl-6">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">Certificate of Accreditation No.:</div>
                                      <input type="text" name="plant_manager_coe" value="<?= $drafted_comp_data[0]['plant_manager_coe'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="row">
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Tel #:</div>

                                          <input type="text" name="plant_manager_tel_num" value="<?= $drafted_comp_data[0]['plant_manager_tel_num'] ?>" class="form-control">
                                        </div>
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Fax #:</div>
                                          <input type="text" name="plant_manager_fax_num" value="<?= $drafted_comp_data[0]['plant_manager_fax_num'] ?>" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="row">
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Mobile #:</div>
                                        <input type="text" name="plant_manager_mobile_num" value="<?= $drafted_comp_data[0]['plant_manager_mobile_num'] ?>" class="form-control">
                                      </div>
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Email Address:</div>
                                          <input type="text" name="plant_manager_email" value="<?= $drafted_comp_data[0]['plant_manager_email'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                              <div class="col-xl-12 mb-3">

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
                                  <div class="col-md-5">
                                    <input type="text" class="form-control" name="dp_num" value="<?= $drafted_comp_data[0]['dp_num'] ?>">
                                  </div>
                                  <div class="col-md-5">
                                  <?php if (!empty($drafted_comp_data[0]['dp_attch'])): ?>
                                    <a target="_blank" href="<?php echo base_url(); ?>uploads/permits/<?= $drafted_comp_data[0]['company_id'] ?>/<?= $drafted_comp_data[0]['dp_attch'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <button type="button" name="button" class="btn btn-success update_permit"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    <input type="file" onchange="ValidateSingleInput(this);" name="dp_file" style="display:none">
                                    <?php else: ?>
                                      <input type="file" onchange="ValidateSingleInput(this);" name="dp_file">
                                    <?php endif; ?>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                  <div class="col-md-2">
                                    <div class="">Permit to Operate #</div>
                                  </div>
                                  <div class="col-md-5">
                                    <input type="text" class="form-control" name="po_num" value="<?= $drafted_comp_data[0]['po_num'] ?>">
                                  </div>
                                  <div class="col-md-5">
                                          <?php if (!empty($drafted_comp_data[0]['po_attch'])): ?>
                                            <a target="_blank" href="<?php echo base_url(); ?>uploads/permits/<?= $drafted_comp_data[0]['company_id'] ?>/<?= $drafted_comp_data[0]['po_attch'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <button type="button" name="button" class="btn btn-success update_permit"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <input type="file" onchange="ValidateSingleInput(this);" name="po_file" style="display:none">
                                          <?php else: ?>
                                              <input type="file" onchange="ValidateSingleInput(this);" name="po_file">
                                        <?php endif; ?>

                                  </div>
                                </div>
                              </div>
                              <div class="col-xl-12 mb-3">
                                <div class="row">
                                  <div class="col-md-2">
                                    <div class="">ECC #</div>
                                  </div>
                                  <div class="col-md-5">
                                    <input type="text" class="form-control" name="ecc_num" value="<?= $drafted_comp_data[0]['ecc_num'] ?>">
                                  </div>
                                  <div class="col-md-5">
                                    <?php if (!empty($drafted_comp_data[0]['ecc_attch'])): ?>
                                      <a target="_blank" href="<?php echo base_url(); ?>uploads/permits/<?= $drafted_comp_data[0]['company_id'] ?>/<?= $drafted_comp_data[0]['ecc_attch'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                      <button type="button" name="button" class="btn btn-success update_permit"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        <input type="file" onchange="ValidateSingleInput(this);" name="ecc_file" style="display:none">
                                      <?php else: ?>
                                        <input type="file" onchange="ValidateSingleInput(this);" name="ecc_file">
                                    <?php endif; ?>
                                        <?php

                                        // get_instance()->load->helper('common_helper');
                                         // echo dp_permit($drafted_comp_data[0]['company_id']);
                                         ?>
                                        <input type="hidden" name="ecc_attch" value="<?= $drafted_comp_data[0]['ecc_attch'] ?>">
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success btn-icon-split" style="float: right;margin-left:5px"><span class="text">UPDATE</span></button>
                    </form>
                  </div>

            </div>
          <!-- Card Body -->

        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="edit_main_company" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h7 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">MAIN COMPANY - Check the checkbox to update main company.</h7>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">

              </div>
              <div class="col-md-6">

                <select class="form-control" name="" id="sort_by_company_region" style="float:right">
                  <option value="">--SEARCH REGION--</option>
                  <?php foreach ($region as $key => $rgnval): ?>
                    <!-- <?php //if ($this->session->userdata('main_company_region') ==  $rgnval['rgnnum']): ?>
                      <option value="<?php //echo $rgnval['rgnnum']; ?>" selected><?php //echo $rgnval['rgnnam']; ?></option>
                    <?php //else: ?>
                      <option value="<?php //echo $rgnval['rgnnum']; ?>" ><?php //echo $rgnval['rgnnam']; ?></option>
                    <?php //endif; ?> -->
                    <option value="<?php echo $rgnval['rgnnum']; ?>" ><?php echo $rgnval['rgnnam']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
          </div>
        </div>
        <div class="table-responsive" style="margin-top: 10px;">
          <table class="table table-hover" id="view_main_company_list" width="100%" cellspacing="0">
            <thead>
              <tr>
                <!-- <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> -->
                <td></td>
                <th>Emb Id</th>
                <th>Company Name</th>
                <th>Location</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<style media="screen">
h2#swal2-title {
font-size: 0.875em;
}
</style>
<script type="text/javascript">

$(window).on('load',function(){
   $('#overlay').fadeOut();
});
function ValidateSingleInput(filename) {
  var ext = filename.value.split('.').pop();
  if (ext != "pdf") {
    alert('UPLOADED FILE IS NOT PDF !');
    filename.value = null;
    return false;
  }
  return true;
};
  $(document).ready(function() {
    if ($('#show_branch_comp_id').is(':checked')) {
      $('#edit_main_compname').attr('readonly','readonly');
    }else {
      $('#edit_main_compname').removeAttr('readonly');
    }
    $('.update_permit').on('click',function(){
      $(this).next().show()
    })
    $('#main_comp_id').selectize();
  });

</script>
<?php if ($this->session->flashdata('update_messsage') != ''): ?>
<script type="text/javascript">
$(document).ready(function() {
  Swal.fire({
    title: 'Company has been successfully Updated with EMB-ID:',
    text: '<?php echo $this->session->flashdata('update_messsage'); ?>',  // title: 'Sweet!',
    // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
    imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
    imageWidth: 135,
    imageHeight: 50,
    imageAlt: 'Custom image',
    })
});

</script>
<?php endif; ?>


<script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$('#sort_by_company_id').selectize();
$(document).ready(function(){
    initDatatable();
});
$('#sort_by_company_region').on('change',function(){
  initDatatable($(this).val());
})
function initDatatable(region){
  var comp_id = '<?php echo $drafted_comp_data[0]['company_id']; ?>';
  var main_comp_id = '<?php echo $main_company[0]['company_id']; ?>';
  // console.log(main_comp_id);
  var table = $('#view_main_company_list').DataTable({
    responsive: true,
    orderFixed: [ 0, 'asc' ],
    paging: true,
    destroy:true,
    deferRender: true,
    lengthMenu:[[ 5,10, 25, 50, -1],[ 5,10, 25, 50, "ALL"]],
    pageLength: 5,

    "serverSide": true,
    "ajax": {
      "url": "<?php echo base_url(); ?>Company/Complist_server_side/main_company_list",
      "data": {
        "region": region
      }
    },
    "columns": [
      { "data": null, defaultContent: '' },
      { "data": "emb_id","searchable": true},
      { "data": "company_name","searchable": true},
      { "data": 'province_name',"searchable": false},
    ],
    'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
           if (main_comp_id == data.company_id) {
             return '<input type="checkbox" name="id[]" value="'+data.company_id+'" checked>';
           }else {
             return '<input type="checkbox" name="id[]" value="'+data.company_id+'" onclick="update_main_company('+comp_id+','+data.company_id+')">';
           }
         }
      }],
      'order': [[1, 'asc']]
  });

  // Handle click on "Select all" control
     $('#example-select-all').on('click', function(){
        // Get all rows with search applied
        var rows = table.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
     });

     // Handle click on checkbox to set state of "Select all" control
     $('#example tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
           var el = $('#example-select-all').get(0);
           // If "Select all" control is checked and has 'indeterminate' property
           if(el && el.checked && ('indeterminate' in el)){
              // Set visual state of "Select all" control
              // as 'indeterminate'
              el.indeterminate = true;
           }
        }
     });

     // Handle form submission event
     $('#frm-example').on('submit', function(e){
        var form = this;
        // Iterate over all checkboxes in the table
        table.$('input[type="checkbox"]').each(function(){
           // If checkbox doesn't exist in DOM
           if(!$.contains(document, this)){
              // If checkbox is checked
              if(this.checked){
                 // Create a hidden element
                 $(form).append(
                    $('<input>')
                       .attr('type', 'hidden')
                       .attr('name', this.name)
                       .val(this.value)
                 );
              }
           }
        });
     });

}

</script>
