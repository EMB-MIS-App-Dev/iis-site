<form class="" action="<?php echo base_url(); ?>Company/Company_list/update_company" method="post" enctype="multipart/form-data">

<div class="modal-body">
  <div id="view_ticket_details">
    <div class="row">
      <!-- Company information -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3">
          <h6 class="m-0  text-primary">COMPANY INFORMATION</h6>
        </div>
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col-xl-12 mb-3 main_comp">
              <div class="h5 mb-0  text-gray-800" style="display:none">EMB ID</div>
              <input type="hidden" name="emb_id_name" value="<?php echo $company_data[0]['emb_id']; ?>" class="form-control" >
              <input type="hidden" name="token" value="<?php echo $company_data[0]['token']; ?>" class="form-control" >
            </div>
            <div class="col-xl-12 mb-3">
                  <div class="h5 mb-0  text-gray-800">Company Type:</div>
              <div class="row">
                <div class="col-xl-6">
                  <?php if ( $company_data[0]['company_type'] == $company_data[0]['company_id']): ?>
                    <input type="radio" name="comp_type" value="1" class="btn btn-success btn-circle btn-sm edit_show_branch_comp_class" id="edit_show_branch_comp_id" onclick="edit_show_main_comp()" checked>
                  <label for="">MAIN</label>
                </div>
                <div class="col-xl-6">
                    <input type="radio" name="comp_type" value="2" class="btn btn-success btn-circle btn-sm edit_show_main_comp_class" id="edit_show_main_comp_id" onclick="edit_show_branch_comp()">
                  <label for="">BRANCH</label>
                </div>
                <?php else: ?>
                  <input type="radio" name="comp_type" value="1" class="btn btn-success btn-circle btn-sm edit_show_branch_comp_class" id="edit_show_branch_comp_id" onclick="edit_show_main_comp()" >
                <label for="">MAIN</label>
              </div>
              <div class="col-xl-6">
                  <input type="radio" name="comp_type" value="2" class="btn btn-success btn-circle btn-sm edit_show_main_comp_class" id="edit_show_main_comp_id" onclick="edit_show_branch_comp()" checked>
                <label for="">BRANCH</label>
              </div>
                  <?php endif; ?>
              </div>
            </div>
            <!-- for min company details -->
            <div class="col-xl-12 mb-3 main_comp">
              <div class="h5 mb-0  text-gray-800">Company name: <span style="color:red">( required ):</span></div>
              <input type="text" name="compname" value="<?php echo $company_data[0]['company_name']; ?>" class="form-control" >
            </div>
            <!-- for branch_comp -->
            <div class="branch_comp col-xl-12 mb-3">
              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0  text-gray-800">Select Main Company: <span style="color:red">( required ):</span></div>
                <!-- <select class="form-control" name="main_comp" id="select_main_company_id"> -->
                <?php //echo '<pre>';print_r($companies);exit; ?>
                  <select class="form-control" name="main_comp" id="select_main_company_id" required>
                  <option value="">SELECT MAIN COMPANY</option>
                  <?php foreach ($companies as $key => $companval): ?>
                    <?php if ($company_data[0]['company_type']  == $companval['company_id']): ?>
                        <option value="<?php echo $companval['company_id']; ?>" selected><?php echo $companval['company_name']; ?></option>
                        <?php else: ?>
                          <option value="<?php echo $companval['company_id']; ?>"><?php echo $companval['company_name']; ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0  text-gray-800">Project Name: <span style="color:red">( required ):</span></div>
                <input type="text" name="project_name" value="<?php echo $company_data[0]['company_name']; ?>" class="form-control" placeholder="Enter Project name">
              </div>
            </div>

            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Establishment Name:</div>
              <input type="text" name="estnam" value="<?php echo $company_data[0]['establishment_name']; ?>" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Date Established:</div>
              <input type="date" name="date_estab" value="<?php echo $company_data[0]['date_established']; ?>" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Project Type: <span style="color:red">( required ):</span></div>

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
                              <?php if ($ptval['proid'] == $company_data[0]['project_type']): ?>
                                <option  style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid'];?>" selected=''><?php echo $ptval['prj']; ?></option>
                              <?php else: ?>
                                <option  style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid'];?>"><?php echo $ptval['prj']; ?></option>
                              <?php endif; ?>
                        <?php endif; ?>

                      <?php endforeach; ?>

              </select>
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Project Size Parameters / Remarks:</div>
              <input type="textarea" name="" value="" class="form-control" id="prsizrem" readonly>
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Category: <span style="color:red">( required ):</span>:</div>
              <select class="form-control" name="category" id="comp_category_id">
                <!-- <option value="">SELECT CATEGORY</option> -->
                <?php foreach ($category as $key => $catval): ?>
                  <?php if ($catval['proid'] == $company_data[0]['category']): ?>
                    <option value="<?php echo $catval['proid'];?>" selected=''><?php echo $catval['pd']; ?></option>
                  <?php endif; ?>
                  <option value="<?php echo $catval['proid'];?>"><?php echo $catval['pd']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Company Telephone Number: <span style="color:red">( required ):</span></div>
              <input type="textarea" name="comp_tel" value="<?php echo $company_data[0]['contact_no']; ?>" class="form-control" >
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Company Email Address</div>
              <input type="emial" name="comp_email" value="<?php echo $company_data[0]['company_name']; ?>" class="form-control" >
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- comapny address -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3">
          <h6 class="m-0  text-primary">COMPANY ADDRESS</h6>
        </div>
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Province: <span style="color:red">( required ):</span></div>
              <select class="form-control" name="prov_id" value="" id="select_comp_province_id" onchange=select_province(this.value)>
                <option value="">-</option>
                <?php foreach ($select_province as $key => $slpval): ?>
                  <?php if ($company_data[0]['province_id'] == $slpval['id']): ?>
                      <option value="<?php echo $slpval['id'];?>" selected><?php echo $slpval['name']; ?></option>
                      <?php else: ?>
                        <option value="<?php echo $slpval['id'];?>"><?php echo $slpval['name']; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">CITY:(required)</div>

              <select class="form-control select_comp_city" name="cityid" id="select_comp_city_id" onchange=select_comp_city(this.value)>
                  <option value="">-</option>
                  <?php foreach ($select_city as $key => $slc): ?>
                    <?php if ($company_data[0]['city_id'] == $slc['id']): ?>
                        <option value="<?php echo $slc['id']?>" selected><?php echo $slc['name']; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $slc['id']?>"><?php echo $slc['name']; ?></option>
                    <?php endif; ?>

                  <?php endforeach; ?>
              </select>
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Brgy: <span style="color:red">( required ):</span> </div>
              <select class="form-control select_comp_brgy_class" name="brgyid" id="select_comp_brgy_id">
                <option value="1">-</option>

                <?php foreach ($select_brgy as $key => $slcbrgy): ?>

                    <?php if ($company_data[0]['barangay_id'] == $slcbrgy['id']): ?>
                      <option value="<?php echo $slcbrgy['id']; ?>" selected><?php echo $slcbrgy['name']; ?></option>
                    <?php else: ?>
                      <option value="<?php echo $slcbrgy['id']; ?>"><?php echo $slcbrgy['name']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Street:</div>
              <input type="text" name="street" value="<?php echo  $company_data[0]['street']; ?>" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Hs No:</div>
              <input type="text" name="hsno" value="<?php echo  $company_data[0]['house_no']; ?>" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Latitude:</div>
              <input type="text" name="lat" value="<?php echo  $company_data[0]['latitude']; ?>" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Longitude:</div>
              <input type="text" name="long" value="<?php echo  $company_data[0]['longitude']; ?>" class="form-control" >
            </div>
          <div class="col-xl-12 mb-3">
            <a href="https://www.gps-coordinates.net/" class="btn btn-success btn-icon-split" target="_blank">
                      <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text">GEO COORDINATES</span>
                    </a>
            </div>
          <div class="col-xl-12 mb-3">
              <div class="h5 mb-0  text-gray-800">Location Photo:</div>
              <div class="col-xl-12 mb-3">
                    <div class="h5 mb-0  text-gray-800">CHANGE ?</div>
                <div class="row">
                  <div class="col-xl-6">
                    <input type="radio" name="locphoto" value="1" class="btn btn-success btn-circle btn-sm" onclick="new_photo()">
                    <label for="">YES</label>
                  </div>
                  <div class="col-xl-6">
                    <input type="radio" name="locphoto" value="2" class="btn btn-success btn-circle btn-sm" onclick="no_photo()" checked>
                    <label for="">NO</label>
                  </div>
                </div>
              </div>
              <?php //echo "<pre>";print_r($comphoto_data); ?>
              <a href="<?php echo base_url(); ?>uploads/company/<?php echo $company_data[0]['region_name'].'/'.$company_data[0]['token'].'/'.$comphoto_data[0]['photo_name']; ?>" class="btn btn-success btn-icon-split" target="_blank" id="current_comp_photo">
                        <span class="icon text-white-50">
                          <i class="fas fa-eye"></i>
                        </span>
                      </a>

              <input type="file" name="compic" value="" class="form-control" style="display:none" id="add_new_photo">
            </div>
              <div class="col-xl-12 mb-3">
                  <div class="h5 mb-0  text-gray-800">Enter Mailing Address:</div>
                  <input type="textarea" name="mailadd" value="<?php echo $company_data[0]['mailing_add']?>" class="form-control">
                </div>
          </div>
        </div>
      </div>
    </div>
    <!-- President -->
    <div class="col-xl-12 mb-12">
      <div class="modal-footer" style="float:right">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-sm">UPDATE</button>
          </div>
    </div>

    </div>
  </div>
</div>

  </form>
  <script type="text/javascript">
    $(document).ready(function(){
      if ($('#edit_show_main_comp_id').is(':checked')) {
        $('.main_comp').hide();
        $(".branch_comp").show();
      }

        var selectcompanies = $('#select_main_company_id').selectize();
        // var selectize = selectcompanies[0].selectize;
        // selectize.setValue(selectize.search(<?php echo $company_data[0]['company_type']; ?>).items[0].id);
    })
  </script>
