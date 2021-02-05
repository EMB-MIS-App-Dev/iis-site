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

              <h6 class="m-0 font-weight-bold text-primary">ADD REQUESTED COMPANY - <?php echo $_SESSION['region']; ?></h6>
            </div>
            <!-- Card Body -->
              <div class="card-body">
                <?php //echo validation_errors(); ?>
                <!-- <form class="" action="<?php //echo base_url(); ?>/Company/Add_company/add_company" method="post" enctype="multipart/form-data"> -->

                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary">CLIENT DETAILS <?php echo  $this->session->flashdata('add_comp_messsage')?></h6>
                    </div>
                      <div class="card shadow h-100 " style="border-radius:0px!important">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col-xl-12 mb-3">
                              <div class="row">
                                  <div class="col-xl-4">
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">NAME</div>
                                    <input  readonly class="form-control" type="text" name="first_name" value="<?= strtoupper($users_data[0]['first_name'].' '.$users_data[0]['last_name'])?>">
                                  </div>
                                  <div class="col-xl-4">
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">EMAIL</div>
                                    <input readonly class="form-control" type="text" name="first_name" value="<?= $users_data[0]['email']?>">
                                  </div>
                                  <div class="col-xl-4">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">CONTACT #</div>
                                    <input readonly class="form-control" type="text" name="first_name" value="<?= $users_data[0]['contact_no']?>">
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-12 mb-3">
                              <div class="row">


                                  <div class="col-xl-4">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">DATE REGISTERED</div>
                                    <input readonly class="form-control" type="text" name="first_name" value="<?= $users_data[0]['date_registered']?>">
                                  </div>
                                  <div class="col-xl-4">
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">POSITION</div>
                                    <input readonly class="form-control" type="text" name="first_name" value="<?= $users_data[0]['position']?>">
                                  </div>
                                  <div class="col-xl-2">
                                    <div class="h6 mb-0 font-weight-bold text-gray-800" >ATTACHMENT:</div>
                                            <div class="dropdown show">
                                              <a class="btn btn-secondary dropdown-toggle"  style="width:50%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i>
                                              </a>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <?php foreach ($users_attch_data as $key => $uattch): ?>
                                                  <?php $attchname = str_replace(' ', '_', $uattch['name']); ?>
                                                  <?php $subfolder = $uattch['type'] == '1' ? 'gov_id' : 'company_id';
                                                  ?>
                                                  <a target="_blank" class="dropdown-item" href="../../../crs/uploads/user_attch_id/<?= $subfolder ?>/<?=$uattch['user_id']?>/<?=$attchname?>"><?=$attchname?></a>
                                                <?php endforeach; ?>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-xl-2">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800" >AUTHORIZATION LETTER:</div>
                                          <a target='_blank' href='../../../../crs/uploads/authorization_letter/<?= $dec_fc_data[0]['req_id'] ?>/authorization_letter.pdf'><i class='fa fa-eye' aria-hidden='true' style='padding-left:10px'></i></a>
                                          </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <div class="col-xl-12  mb-4" style="padding:0!important">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #ccc;">
                      <h6 class="m-0 font-weight-bold text-primary"> REGISTERED EMB COMPANIES</h6>
                    </div>

                    <div class="card shadow h-100 py-2" style="border-radius:0px!important">

                      <div class="card-body">
                        <div class="row no-gutters align-items-center">

                          <div class="col-xl-12 mb-3">

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">
                                      <!-- <div class="col-md-12 h6 text-gray-800">APPLICANT COMPANY NAME: <span class="text-primary"><?= $drafted_comp_data[0]['establishment']?></span></div> -->

                                      <div class="col-md-12 h7 text-gray-800"><span style="color:red;font-weight:bold">NOTE :</span>
                                         PLEASE CHECK THIS ESBTABLISHMENT NAME <span style="color:black;font-weight:bold">(<?=$drafted_comp_data[0]['establishment'];?>)</span> IN THE LIST OF CHOICES. IF EXISTS SELECT IT AND CLICK <span style="color:black;font-weight:bold">ASSIGN</span> BUTTON, OTHERWISE SELECT <span style="color:black;font-weight:bold">NOT IN THE LIST</span> TO PROCEED ON ADDING OF NEW ESTABLISHMENT .
                                    </div>
                                    </div>
                                  <!-- <input type="rad" name="" value="" class="form-control"  readonly> -->
                                  <form class="" action="<?php echo base_url(); ?>Company/Company_list/emb_assign_existing_comp" method="post">
                                    <input type="hidden" name="req_id" value="<?= $this->encrypt->encode($dec_fc_data[0]['req_id'])?>">
                                    <div class="row">
                                          <div class="col-md-11">
                                              <select class="form-control registered_companies_checking" name="est_data" id="main_comp_id" required>
                                              <option value="">-- Search Registered Companies here --</option>
                                                <option value="0">-- NOT IN THE LIST --</option>
                                              <?php foreach ($companies_per_reg as $key => $valuecmop): ?>
                                                   <option value="<?= $this->encrypt->encode($valuecmop['company_id'])?>"><?php echo $valuecmop['company_name']; ?></option>
                                                  <?php endforeach; ?>
                                                </select>
                                          </div>
                                          <div class="col-md-1">
                                            <button type="button" id="send_ext_est_btn" class="btn btn-success btn-icon-split" disabled> <span class="text">ASSIGN</span></button>
                                          </div>
                                    </div>

                                  </form>
                                  <div id="selected_company_data_container" style="display:none">
                                        <h2 class="est-title-cont" style="font-size: 19px;padding-left: 10px;"><span class="est-text-title">SELECTED COMPANY ADDRESS</span></h2>
                                        <div class="col-xl-12 mb-3">
                                          <div class="form-group row">
                                            <div class="col-xl-6">
                                              <h7 class="">REGION: <span style="color:black;font-weight: 600;" id="selected_company_data_region">R7</span> </h7>
                                            </div>
                                            <div class="col-xl-6">
                                              <h7 class=""> PROVINCE: <span style="color:black;font-weight: 600;" id="selected_company_data_province">BULACAN</span></h7>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                          <div class="form-group row">
                                            <div class="col-xl-6">
                                              <h7 class="">CITY: <span style="color:black;font-weight: 600;" id="selected_company_data_city">SAN MIGUEL</span></h7>
                                            </div>
                                            <div class="col-xl-6">
                                              <h7 class=""> BARANGAY: <span style="color:black;font-weight: 600;" id="selected_company_data_brgy">Camias</span></h7>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-xl-12 mb-3" style="display:none" id="selected_company_street_container">
                                          <h7 class="">STREET: <span style="color:black;font-weight: 600;" id="selected_company_street">37</span></h7>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                    <div id="establishment_container" style="display:none">
                      <hr style="background:#0B4F86">
                        <div class="col-xl-12  mb-4" style="padding:0!important">
                            <h6 class="m-0 font-weight-bold text-primary">ADD APPLICANT NEW ESTABLISHMENT<span style="color:red"></span></h6>
                      </div>
                      <?php echo form_open_multipart('Company/Add_drafted_company/add_drafted_company/'); ?>
                      <input type="hidden" name="est_date_registered" value="<?= $this->encrypt->encode($drafted_comp_data[0]['input_date']);?>">
                      <input type="hidden" name="req_id" value="<?= $this->encrypt->encode($dec_fc_data[0]['req_id']);?>">
                        <input type="hidden" name="system_inquery" value="<?=$dec_fc_data[0]['system_inquery'];?>">
                        <input type="hidden" name="client_id" value="<?= $this->encrypt->encode($drafted_comp_data[0]['client_id']);?>">
                        <input type="hidden" name="clientemail" value="<?= $users_data[0]['email'] ?>">
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
                                          <input type="rad" name="" value="" class="form-control"  readonly>
                                        </div>
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Company Type:</div>
                                          <div class="row">
                                            <div class="col-xl-6">
                                                <?php if (!empty($drafted_comp_data[0]['main_company_id'])): ?>
                                                      <input type="radio" name="comp_type" value="1" id="show_main_comp_id" onclick="show_main_comp()" class="btn btn-success btn-circle btn-sm">
                                                  <?php else: ?>
                                                        <input type="radio" name="comp_type" value="1" id="show_main_comp_id" onclick="show_main_comp()" class="btn btn-success btn-circle btn-sm" checked>
                                                <?php endif; ?>
                                                <label for="">MAIN</label>
                                            </div>
                                            <div class="col-xl-6">
                                              <?php if (!empty($drafted_comp_data[0]['main_company_id'])): ?>
                                                  <input type="radio" name="comp_branch" value="" id="show_branch_comp_id" onclick="show_branch_comp()" class="btn btn-success btn-circle btn-sm show_branch_comp" checked>
                                                  <?php else: ?>
                                                    <input type="radio" name="comp_branch" value="" id="show_branch_comp_id" onclick="show_branch_comp()" class="btn btn-success btn-circle btn-sm show_branch_comp" >
                                              <?php endif; ?>
                                              <label for="">BRANCH</label>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-xl-12 mb-3">
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Company/Proponent name: <span class="error_req">( required )</div>
                                    <input type="text" name="compname" value="<?= $drafted_comp_data[0]['establishment']?>" class="form-control" id='maincompname'>
                                    <span class="error_req"><?php echo form_error('compname'); ?></span>
                                  </div>
                                  <!-- for branch_comp -->
                                  <div class="branch_comp col-xl-12 mb-3">
                                    <div class="col-xl-12 mb-3">
                                      <div class="row">
                                          <div class="col-xl-6">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Select Main Company: <span class="error_req">( required )</div>
                                            <input type="text" class="form-control" name="main_comp" value="<?= $main_company_data[0]['company_name'] ?>" readonly>
                                          <input type="hidden" name="" value="<?= $main_company_data[0]['company_id'] ?>">
                                            <!-- <select class="form-control" name="main_comp" id="main_comp_id">
                                              <option value="">SELECT MAIN COMPANY</option>
                                              <?php //foreach ($companies as $key => $valuecmop): ?>
                                                <?php //if ($drafted_comp_data[0]['main_company_id'] == $valuecmop['company_id']): ?>
                                                   <option value="<?php //echo $valuecmop['company_id']; ?>" selected><?php //echo $valuecmop['company_name']; ?></option>
                                                  <?php //else: ?>
                                                   <option value="<?php //echo $valuecmop['company_id']; ?>"><?php //echo $valuecmop['company_name']; ?></option>
                                                <?php //endif; ?>
                                                <?php //endforeach; ?>
                                            </select> -->
                                              <span class="error_req"><?php echo form_error('main_comp'); ?></span>
                                          </div>
                                          <div class="col-xl-6">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Project Name: <span class="error_req">( required )</div>
                                            <input type="text" name="project_name" value="<?= $drafted_comp_data[0]['establishment']?>" class="form-control project_name" placeholder="Enter Project name">
                                            <span class="error_req"><?php echo form_error('project_name'); ?></span>
                                          </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-xl-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Establishment Name:</div>
                                          <input type="text" name="estnam" value="<?php echo set_value('estnam'); ?>" class="form-control">
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
                                      <span class="error_req"><?php echo form_error('project_type'); ?></span>
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
                                        <input type="text" name="comp_tel" value="<?= $drafted_comp_data[0]['ceo_phone_no']?>" class="form-control">
                                          <span class="error_req"></span>
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Company Email Address</div>
                                        <input type="emial" name="comp_email" value="<?= $drafted_comp_data[0]['ceo_email']?>" class="form-control">
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
                                      <div class="col-xl-12">
                                        <div class="row">
                                          <div class="col-xl-3">

                                          </div>
                                          <div class="col-xl-6" style="margin-bottom: 20px;">
                                              <div class="h6 mb-0 font-weight-bold text-gray-800">REGION: <span class="error_req">( required )</div>

                                              <select class="form-control" name="region_id"  onchange=select_region(this.value)>
                                                <option value="">SELECT REGION</option>
                                                <?php foreach ($region as $key => $rgnval): ?>
                                                  <?php if ($drafted_comp_data[0]['est_region'] == $rgnval['rgnid']): ?>
                                                      <option value="<?php echo $rgnval['rgnnum']; ?>" selected><?php echo $rgnval['rgnnam']; ?></option>
                                                    <?php else: ?>
                                                      <option value="<?php echo $rgnval['rgnnum']; ?>"><?php echo $rgnval['rgnnam']; ?></option>
                                                  <?php endif; ?>

                                                <?php endforeach; ?>
                                              </select>
                                                  <span class="error_req"><?php echo form_error('region_id'); ?></span>
                                          </div>
                                          <div class="col-xl-3">

                                          </div>
                                        </div>

                                      </div>
                                        <div class="col-xl-4">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Province: <span class="error_req">( required )</div>
                                          <!-- <select id="select_comp_province_id" class="form-control" name="prov_id"  onchange=select_province(this.value) >
                                            <option value="" >-</option>
                                            <?php //foreach ($provinces as $key => $provalue): ?>
                                                <option value="<?php //echo $provalue['id']; ?>"><?php //echo $provalue['name']; ?></option>
                                            <?php //endforeach; ?>
                                          </select> -->
                                          <select name="prov_id" class="form-control">
                                            <option value="" >--</option>
                                            <?php foreach ($province as $key => $proval): ?>
                                              <?php if ( $drafted_comp_data[0]['est_province'] == $proval['id']): ?>
                                                  <option value="<?= $proval['id']?>" selected><?= $proval['name']?></option>
                                                <?php else: ?>
                                                  <option value="<?= $proval['id']?>"><?= $proval['name']?></option>
                                              <?php endif; ?>

                                            <?php endforeach; ?>
                                          </select>
                                          <span class="error_req"><?php echo form_error('prov_id'); ?></span>
                                        </div>
                                        <div class="col-xl-4">

                                            <div class="h6 mb-0 font-weight-bold text-gray-800">CITY:<span class="error_req">( required )</div>
                                            <!-- <select class="form-control " name="cityid" id="select_comp_city_id" onchange=select_comp_city(this.value) >
                                                <option value="">-</option>
                                            </select> -->
                                            <select name="cityid" class="form-control" id="select_city_sample" onchange=select_comp_city(this.value)>
                                              <option value="" >--</option>
                                              <?php foreach ($city as $key => $cityval): ?>
                                                  <?php if ( $drafted_comp_data[0]['est_city'] == $cityval['id']): ?>
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
                                                <?php if ( $drafted_comp_data[0]['est_barangay'] == $brgyval['id']): ?>
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
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Street:</div>
                                          <input type="text" name="street" value="<?= $drafted_comp_data[0]['est_street'] ?>" class="form-control">
                                        </div>
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Hs No:</div>
                                          <input type="text" name="hsno" value="<?php echo set_value('hsno'); ?>" class="form-control">
                                        </div>
                                    </div>

                                  </div>
                                  <div class="col-xl-12 mb-3">
                                    <div class="row">
                                        <div class="col-xl-6">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Latitude:</div>
                                          <?php  $latitude = str_replace(" ","",$drafted_comp_data[0]['latitude']) ;?>
                                          <input type="number" name="latitude" value="<?=$latitude?>" class="form-control" step="any">
                                        </div>
                                        <div class="col-xl-6">
                                               <div class="h6 mb-0 font-weight-bold text-gray-800">Longitude:</div>
                                               <?php  $longitude = str_replace(" ","",$drafted_comp_data[0]['longitude']) ;?>
                                          <input type="number" name="longitude" value="<?=$longitude?>" class="form-control" step="any">
                                        </div>
                                    </div>
                                  </div>
                                <div class="col-xl-12 mb-3">
                                  <a href="https://www.gps-coordinates.net/" class="btn btn-success btn-icon-split" target="_blank">
                                            <span class="icon text-gray-800">
                                              <i class="fas fa-map-marker"></i>
                                            </span>
                                            <span class="text">GEO COORDINATES</span>
                                  </a>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Location Photo:</div>
                                    <input type="file" name="compic[]" value="" class="form-control" multiple>
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
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Lastname</div>
                                        <input type="text" name="ceo_last_name" value="<?= $drafted_comp_data[0]['ceo_last_name'] ?>" class="form-control">
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Firstname:</div>
                                        <input type="text" name="ceo_first_name" value="<?= $drafted_comp_data[0]['ceo_first_name'] ?>" class="form-control">
                                      </div>
                                  </div>

                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">MI:</div>
                                        <input type="text" name="ceo_mi" value="<?= $drafted_comp_data[0]['ceo_mi'] ?>" class="form-control">
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
                                        <input type="text" name="ceo_phone_no" value="<?= $drafted_comp_data[0]['ceo_phone_no'] ?>" class="form-control">
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
                                        <input type="text" name="pollution_officer" value="<?= $drafted_comp_data[0]['pollution_officer'] ?>" class="form-control">
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Certificate of Accreditation No.:</div>
                                        <input type="text" name="pollution_officer_coa_no" value="<?= $drafted_comp_data[0]['pollution_officer_coa_no'] ?>" class="form-control">
                                      </div>
                                  </div>
                                </div>
                                  <div class="col-xl-12 mb-3">
                                      <div class="row">
                                          <div class="col-xl-6">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Tel #:</div>

                                            <input type="text" name="pollution_officer_phone_no" value="<?= $drafted_comp_data[0]['pollution_officer_phone_no'] ?>" class="form-control">
                                          </div>
                                          <div class="col-xl-6">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Fax #:</div>
                                            <input type="text" name="pollution_officer_fax_no" value="<?= $drafted_comp_data[0]['pollution_officer_fax_no'] ?>" class="form-control">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xl-12 mb-3">
                                      <div class="row">
                                          <div class="col-xl-6">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Email Address:</div>
                                            <input type="text" name="pollution_officer_email" value="<?= $drafted_comp_data[0]['pollution_officer_email'] ?>" class="form-control">
                                          </div>
                                          <div class="col-xl-6">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Mobile No.  1:</div>
                                            <input type="text" name="pollution_officer_mobile_no" value="<?= $drafted_comp_data[0]['pollution_officer_mobile_no'] ?>" class="form-control">
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
                                        <input type="text" name="plant_manager" value="<?= $drafted_comp_data[0]['plant_manager'] ?>" class="form-control">
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Certificate of Accreditation No.:</div>
                                        <input type="text" name="plant_manager_coa_no" value="<?= $drafted_comp_data[0]['plant_manager_coa_no'] ?>" class="form-control">
                                      </div>
                                  </div>
                                </div>
                                  <div class="col-xl-12 mb-3">
                                      <div class="row">
                                        <div class="col-xl-4">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Tel #:</div>
                                          <input type="text" name="plant_manager_phone_no" value="<?= $drafted_comp_data[0]['plant_manager_phone_no'] ?>" class="form-control">
                                        </div>
                                        <div class="col-xl-4">
                                          <div class="h6 mb-0 font-weight-bold text-gray-800">Fax #:</div>
                                          <input type="text" name="plant_manager_fax_no" value="<?= $drafted_comp_data[0]['plant_manager_fax_no'] ?>" class="form-control">
                                        </div>
                                        <div class="col-xl-4">
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
                            <h6 class="m-0 font-weight-bold text-primary">MANAGING HEAD</h6>
                          </div>
                          <div class="card shadow h-100 py-2" style="border-radius:0px!important">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">

                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Name:</div>
                                        <input type="text" name="managing_head" value="<?= $drafted_comp_data[0]['managing_head'] ?>" class="form-control">
                                      </div>
                                      <div class="col-xl-6">
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">Email:</div>
                                        <input type="text" name="managing_head_email" value="<?= $drafted_comp_data[0]['managing_head_email'] ?>" class="form-control">
                                      </div>
                                  </div>
                                </div>
                                  <div class="col-xl-12 mb-3">
                                      <div class="row">
                                          <div class="col-xl-4">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Fax #:</div>

                                            <input type="text" name="managing_head_fax_no" value="<?= $drafted_comp_data[0]['managing_head_fax_no'] ?>" class="form-control">
                                          </div>
                                          <div class="col-xl-4">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Tel #:</div>
                                            <input type="text" name="managing_head_tel_no" value="<?= $drafted_comp_data[0]['managing_head_tel_no'] ?>" class="form-control">
                                          </div>
                                          <div class="col-xl-4">
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Mobile #:</div>
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
                                      <input type="text" class="form-control" name="dp_num" value="<?= $drafted_comp_data[0]['dp_num'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                      <a target="_blank" href="../../../../crs/uploads/permits/<?= $drafted_comp_data[0]['client_id'].'/'.$drafted_comp_data[0]['est_id'].'/'.$drafted_comp_data[0]['dp_attch']?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <input type="hidden" name="dp_attch" value="<?= $drafted_comp_data[0]['dp_attch'] ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <div class="">Permit to Operate #</div>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="po_num" value="<?= $drafted_comp_data[0]['po_num'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                          <a target="_blank" href="../../../../crs/uploads/permits/<?= $drafted_comp_data[0]['client_id'].'/'.$drafted_comp_data[0]['est_id'].'/'.$drafted_comp_data[0]['po_attch'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                              <input type="hidden" name="po_attch" value="<?= $drafted_comp_data[0]['po_attch'] ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xl-12 mb-3">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <div class="">ECC #</div>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="ecc_num" value="<?= $drafted_comp_data[0]['ecc_num'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                          <a target="_blank" href="../../../../crs/uploads/permits/<?= $drafted_comp_data[0]['client_id'].'/'.$drafted_comp_data[0]['est_id'].'/'.$drafted_comp_data[0]['ecc_attch'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                          <input type="hidden" name="ecc_attch" value="<?= $drafted_comp_data[0]['ecc_attch'] ?>">
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-icon-split" style="float: right;margin-left:5px" id='approved_new_requested_establishment'><span class="text">APPROVED</span></button>
                      </form>
                      <button data-toggle='modal' data-target='#disapprove_client_request' type="button" class="btn btn-danger btn-icon-split" style="float: right;" onclick=disapprove_request('<?=$dec_fc_data[0]['req_id']?>')><span class="text">DISAPPROVED</span></button>
                    </div>

              </div>
            <!-- Card Body -->

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
    $(document).ready(function() {
      $('.registered_companies_checking').on('change',function(){
        if ($(this).val() == 0 || $(this).val() == '') {
          $('#establishment_container').show();
          $('#send_ext_est_btn').attr('disabled',true);
          $('#selected_company_data_container').hide();
        }else {
          $('#establishment_container').hide();
          $('#send_ext_est_btn').attr('disabled',false);
          $('#selected_company_data_container').show();
          $.ajax({
                url: base_url+"/Company/Company_list/selected_company_data",
                type: 'POST',
                async : true,
                data: {"company_id": $(this).val()},
                success:function(response)
                  {
                    var comp_data = JSON.parse(response);
                    $('#selected_company_data_region').html(comp_data[0].region_name);
                    $('#selected_company_data_province').html(comp_data[0].province_name);
                    $('#selected_company_data_city').html(comp_data[0].city_name);
                    $('#selected_company_data_brgy').html(comp_data[0].barangay_name);
                    $('#selected_company_street').html(comp_data[0].street);
                  }
            });
        }
      })
      if ($('input.show_branch_comp').is(':checked')) {
        $('#maincompname').val(' ');
        $('input.show_branch_comp').val('2');
      }
      $('#main_comp_id').selectize();

      // for disabling assign button
      $('#send_ext_est_btn').on('click',function(){
        if (!confirm('Are you sure ?')) {
          return false;
        }else {
          $('#assign_selected_company_affiliation').text($( "#main_comp_id option:selected" ).text())
          $('#selected_registered_est').val($("#main_comp_id option:selected" ).val());
          $('#add_requested_company_option_update').modal('show');
         // this.form.submit();
        }
      });

    });
  </script>
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
  });

</script>
<?php endif; ?>

<?php if ($this->session->flashdata('ext_est_msg') != ''): ?>
<script type="text/javascript">
 $(document).ready(function() {
   Swal.fire({
     title: 'ESTABLISHMENT SUCCESSFULY ASSIGN:',
     imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
     imageWidth: 135,
     imageHeight: 50,
     imageAlt: 'Custom image',
     })
 });

</script>
<?php endif; ?>

<?php if ($this->session->flashdata('add_comp_messsage') != ''): ?>
<script type="text/javascript">
 $(document).ready(function() {
   Swal.fire({
     title: 'COMPANY HAS BEEN SUCCESSFULY ASSIGNED TO USER:',
     text: '<?php echo $this->session->flashdata('add_comp_messsage'); ?>',  // title: 'Sweet!',
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
