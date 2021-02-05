<style media="screen">
.table-outer th, td { white-space: nowrap; }
.table-outer div.dataTables_wrapper {
    margin: 0 auto;
}
</style>
<div class="container-fluid">
  <div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['access_regions'] == 'yes' || $_SESSION['access_offices'] == 'yes'){ ?>
            <h6 class="m-0 font-weight-bold text-primary">User Accounts -
              <select id="userregion_" onchange="admin_change_region($('#userregion_').val(),$('#useroffice_').val(),1);" title="Select to change region">
                <option value="<?php echo $this->encrypt->encode($_SESSION['region']); ?>"><?php echo $_SESSION['region']; ?></option>
                <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['access_regions'] == 'yes'){ ?>
                  <?php foreach ($regions as $key => $value): ?>
                    <option value="<?php echo $this->encrypt->encode($value['rgnnum']); ?>"><?php echo $value['rgnnum']; ?></option>
                  <?php endforeach; ?>
                <?php } ?>
              </select>
              <?php if($_SESSION['access_offices'] == 'yes' || $_SESSION['superadmin_rights'] == 'yes'){ ?>
                <select id="useroffice_" onchange="admin_change_region($('#userregion_').val(),$('#useroffice_').val(),1);" title="Select to change office">
                  <option value="<?php echo $this->encrypt->encode($_SESSION['office']); ?>"><?php echo $_SESSION['office']; ?></option>
                  <?php foreach ($office as $key => $value): ?>
                    <option value="<?php echo $this->encrypt->encode($value['office_code']); ?>"><?php echo $value['office_code']; ?></option>
                  <?php endforeach; ?>
                </select>
              <?php } ?>
              <span style="color:red;font-size:7pt;"><i>*Select to change region & office*</i></span>
            </h6>
          <?php }else{ ?>
            <h6 class="m-0 font-weight-bold text-primary">User Accounts - <?php echo $_SESSION['region']; ?></h6>
          <?php } ?>
        </div>
        <?php $activetab = (!empty($this->session->userdata('uactivetabno'))) ? $this->session->userdata('uactivetabno') : '1'; ?>
        <!-- Card Body -->
          <div class="card-body">
            <ul class="nav nav-tabs" id="areaofassignment" role="tablist" style="font-size: 10pt;font-weight: 100;">
              <li class="nav-item">
                <a class="nav-link <?= ($activetab == '1') ? 'active' : ''; ?>" onclick="uactivetab('<?php echo $this->encrypt->encode('1'); ?>');" id="document-header-tab" data-toggle="tab" href="#u" role="tab" aria-controls="u" aria-selected="true">Document Header</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($activetab == '2') ? 'active' : ''; ?>" onclick="uactivetab('<?php echo $this->encrypt->encode('2'); ?>');" id="document-footer-tab" data-toggle="tab" href="#doc-footer" role="tab" aria-controls="doc-footer" aria-selected="true">Document Footer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($activetab == '3') ? 'active' : ''; ?>" onclick="uactivetab('<?php echo $this->encrypt->encode('3'); ?>');" id="employe-esignature-tab" data-toggle="tab" href="#employe-esignature" role="tab" aria-controls="employe-esignature" aria-selected="false">Employee e-Signatures</a>
              </li>
            </ul>
            <div class="tab-content" id="areaofassignmentContent">

              <!-- Document Header -->
              <div class="tab-pane fade <?= ($activetab == '1') ? 'show active' : ''; ?>" id="u" role="tabpanel" aria-labelledby="document-header-tab"><br>


                <div class="col-xl-12 col-lg-12">
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Example size of Document Header</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <img src="<?php echo base_url(); ?>../iis-images/document-header/instruction-header.png" style="width: 100%;">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-12 col-lg-12">
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Current Document Header</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                      <form action="<?php echo base_url(); ?>Admin/Submissions/Filesuploads_postdata/document_header" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <?php if($header_name != ''){ ?>
                              <label>Replace Document header:</label>
                            <?php }else{ ?>
                              <label>Upload Document header:</label>
                            <?php } ?>
                          </div>
                          <div class="col-md-10">
                            <input type="file" class="form-control" name="document_header" required>
                          </div>
                          <?php if($header_name != ''){ ?>
                            <div class="col-md-2">
                              <input type="submit" class="btn btn-sm btn-success" style="height:35px;width:100%;" value="Upload">
                            </div>
                          <?php }else{ ?>
                            <div class="col-md-2">
                              <input type="submit" class="btn btn-sm btn-success" style="height:35px;width:100%;" value="Upload">
                            </div>
                          <?php } ?>
                        </div>
                        <div class="row" style="margin-top:30px;border:1px solid #D1D3E2;margin: 30px 0px 30px 0px;">
                          <?php if($header_name != ''){ ?>
                          <div class="col-md-12">
                            <img src="<?php echo base_url(); ?>../iis-images/document-header/<?php echo $header_name; ?>" style="width: 100%;">
                          </div>
                          <?php }else{ ?>
                            <div class="col-md-12" style="text-align:center;padding:20px;">
                              <span style="color:red;">No file uploaded.</span>
                            </div>
                          <?php } ?>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>
              <!-- Document Header -->

              <!-- Document Footer -->
              <div class="tab-pane fade <?= ($activetab == '2') ? 'show active' : ''; ?>" id="doc-footer" role="tabpanel" aria-labelledby="document-footer-tab"><br>

                <div class="col-xl-12 col-lg-12">
                  <span style="color: blue;font-size: 12pt;font-style: italic;">*This is Optional. You may or may not upload any footer file*</span><br /><br />
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Example size of Document Footer</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <img src="<?php echo base_url(); ?>../iis-images/document-footer/instruction-footer.jpg" style="width: 100%;">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-12 col-lg-12">
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Current Document Footer</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                      <form action="Submissions/Filesuploads_postdata/document_footer" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <?php if($footer_name != ''){ ?>
                              <label>Replace Document Footer:</label>
                            <?php }else{ ?>
                              <label>Upload Document Footer:</label>
                            <?php } ?>
                          </div>
                          <div class="col-md-10">
                            <input type="file" class="form-control" name="document_footer" required>
                          </div>
                          <?php if($footer_name != ''){ ?>
                            <div class="col-md-2">
                              <input type="submit" class="btn btn-sm btn-success" style="height:35px;width:100%;" value="Upload">
                            </div>
                          <?php }else{ ?>
                            <div class="col-md-2">
                              <input type="submit" class="btn btn-sm btn-success" style="height:35px;width:100%;" value="Upload">
                            </div>
                          <?php } ?>
                        </div>
                        <div class="row" style="margin-top:30px;border:1px solid #D1D3E2;margin: 30px 0px 30px 0px;">
                          <?php if($footer_name != ''){ ?>
                          <div class="col-md-12">
                            <img src="<?php echo base_url(); ?>../iis-images/document-footer/<?php echo $footer_name; ?>" style="width: 100%;">
                          </div>
                          <?php }else{ ?>
                            <div class="col-md-12" style="text-align:center;padding:20px;">
                              <span style="color:red;">No file uploaded.</span>
                            </div>
                          <?php } ?>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>
              <!-- Document Footer -->

              <!-- Employee E-Signatures -->
              <div class="tab-pane fade <?= ($activetab == '3') ? 'show active' : ''; ?>" id="employe-esignature" role="tabpanel" aria-labelledby="employe-esignature-tab"><br>
                <div class="col-xl-12 col-lg-12">
                  <span style="color: blue;font-size: 12pt;font-style: italic;">*Upload only the e-signature without name and designation*</span><br /><br />
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Uploaded e-Signatures</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <form action="<?php echo base_url('Admin/Submissions/Filesuploads_postdata/esignatures'); ?>" method="post" enctype="multipart/form-data">
                            <br>
                            <div class="row">
                              <div class="col-md-6">
                                <label>Name of Employee</label>
                                <select id="name_of_employee" class="form-control" name="name_of_employee" required>
                                  <option value=""></option>
                                    <?php
                                      foreach ($active_employees as $key => $value) {
                                        if(!empty($value['mname'])){ $mname = $value['mname'][0].". "; }else{ $mname = ""; }
                                        if(!empty($value['suffix'])){ $suffix = " ".$value['suffix']; }else{ $suffix = ""; }
                                        $name      = utf8_encode(strtolower($value['fname']." ".$mname.$value['sname']));
                                        $full_nm = str_replace('ã±', '&ntilde;', $name.$suffix);
                                        $full_name = str_replace('Ã±', '&ntilde;', $full_nm);
                                    ?>
                                      <option value="<?php echo $this->encrypt->encode($value['userid']); ?>"><?php echo ucwords($full_name); ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label>Upload E-signature:</label>
                                <input type="file" class="form-control" name="esignature" required>
                              </div>
                              <div class="col-md-2">
                                <label style="color:#FFF;">-</label>
                                <input type="submit" class="btn btn-sm btn-success" style="height:35px;width:100%;" value="Upload">
                              </div>
                            </div>
                          </form><hr>
                          <div class="table-responsive" style="zoom:80%;">
                            <table id="table_esignatures" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th> Name </th>
                                  <th> e-Signature </th>
                                  <th> Action </th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



              </div>
              <!-- Employee E-Signatures -->

            </div>
          </div>
        <!-- Card Body -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#name_of_employee').selectize();

    $(document).ready(function(){
        var table = $('#table_esignatures').DataTable({
            responsive: true,
            paging: true,
            language: {
              "infoFiltered": "",
            },
            "serverSide": true,
            "order": [[ 0, "asc"]],
            "ajax": "<?php echo base_url(); ?>Admin/Serverside_uploads",
            scrollX: true,
            "columns": [
              { "data": 0,"searchable": true},
              {
                "data": null,
                  "render": function(data, type, row, meta){
                      var path = '<?php echo base_url()."../iis-images/e-signatures/"; ?>';
                      data = '<span><img style="max-width: 15%; max-height:15%; min-width: 15%; min-height:15%; text-align: center;" src='+path+row['file_name']+'></span>';

                    return data;
                  }
              },
              {
                "data": null,
                  "render": function(data, type, row, meta){

                      //remove esig
                      data = "<button class='btn btn-success btn-sm' href='#' data-toggle='modal' data-target='#edit_esig' onclick=edit_esig_btn('"+row['userid']+"')>Edit Positioning/Height/Width</button>&nbsp;";
                      data += "<button class='btn btn-danger btn-sm' href='#' data-toggle='modal' data-target='#Remove_esig' onclick=Remove_esig_btn('"+row['userid']+"')>Remove</button>";

                    return data;
                  }
              },
            ]
        });
      });
</script>
