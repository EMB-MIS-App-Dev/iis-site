<style>
  textarea {
    min-height: 130px;
  }
</style>
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-add-tab" data-toggle="tab" href="#nav-add" role="tab" aria-controls="nav-add" aria-selected="true">Transaction Details</a>
              <a id="vt_history_anchor" class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">History <input type="hidden" value="0" /> </a>
              <?php if($trans_data[0]['type'] == '83' AND ($this->session->userdata('token') == $trans_data[0]['receiver_id']) || $this->session->userdata('superadmin_rights') == 'yes' || $this->session->userdata('dms_all_view_attachment') == 'yes'){ ?>
              <a class="nav-item nav-link" id="nav-travel-tab" data-toggle="tab" href="#nav-travel" role="tab" aria-controls="nav-travel" aria-selected="false" onclick="view_trans_travel_details('<?php echo $this->encrypt->encode($trans_data[0]['trans_no']); ?>');">Travel Details</a>
              <?php } ?>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-add" role="tabpanel" aria-labelledby="nav-add-tab">
              <input id="view_trans_no_input" type="hidden" value="<?php echo $trans_data[0]['trans_no']; ?>" readonly />
              <div class="row">
                <div class="col-md-4"><br />
                  <div class="form-group">
                    <label>Transaction No.:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['token']; ?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>System:</label>
                    <input class="form-control" value="<?php echo $system[0]['name']; ?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Sub-System:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['type_description']; ?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Subject Name:</label>
                    <textarea class="form-control" id="subject" readonly><?php echo trim($trans_data[0]['subject']); ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Transaction Status:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['status_description']; ?>" readonly/>
                  </div>
                </div>

                <div class="col-md-4"> <br>
                  <div class="form-group">
                    <label>Company EMB ID:</label>
                    <input class="form-control" id="company_embid" value="<?php echo $trans_data[0]['emb_id'];?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Company:</label>
                    <textarea class="form-control" readonly><?php echo $trans_data[0]['company_name'];?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Company Address:</label>
                    <textarea class="form-control" id="company_address" readonly><?php echo ucwords(trim(strtoupper($company_details[0]['house_no'].' '.$company_details[0]['street'].' '.$company_details[0]['barangay_name'].', '.$company_details[0]['city_name'].' '.$company_details[0]['province_name']))); ?></textarea>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" href="#showGeoCoordinates">Show Geo-Coordinates</button>
                    <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" href="#showProjTypeAndCat">Show Project Type and Category</button>
                  </div>

                  <div class="collapse" id="showGeoCoordinates">
                    <div class="form-group">
                      <label>Latitude:</label>
                      <?php
                        // echo '<a style="padding: 0 7px" class="float-right" title="Get Google-Generated Geo-Coordinates" target="_blank" href="'.base_url().'"><i class="fas fa-map-pin"></i></a>';
                        if( !empty($company_details[0]['latitude']) && !empty($company_details[0]['longitude']) ) {
                          echo '<a class="float-right" title="Show Map" target="_blank" href="'.base_url().'"><i class="fas fa-map-marked-alt"></i></a>';
                        }
                      ?>
                      <input class="form-control" id="company_latitude" value="<?=!empty($company_details[0]['latitude']) ? $company_details[0]['latitude'] : '-'?>" readonly />
                    </div>
                    <div class="form-group">
                      <label>Longitude:</label>
                      <input class="form-control" id="company_longitude" value="<?=!empty($company_details[0]['longitude']) ? $company_details[0]['longitude'] : '-'?>" readonly />
                    </div>
                  </div>

                  <div class="collapse" id="showProjTypeAndCat">
                    <div class="form-group">
                      <label>Project Type:</label>
                      <textarea class="form-control" id="project_name" readonly><?php echo $company_details[0]['project_name']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Project Category:</label>
                      <textarea class="form-control" id="project_category" readonly></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-md-4"> <br>
                  <div class="form-group">
                    <label>Assigned to:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['receiver_name'];?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Action:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['action_taken'];?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Remarks:</label>
                    <textarea class="form-control" readonly><?php echo trim($trans_data[0]['remarks']);?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
              <div id="trans_view_history_tab" class="row">
                <div class="d-flex justify-content-center">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-travel" role="tabpanel" aria-labelledby="nav-travel-tab">
              <div class="row">
                <div id="view_alltrans_travel_details_body"></div>
              </div>
            </div>
          </div>
          
<script>
  $(document).ready(function(){
     $('button#view_trans_dfbtn').on('click', function(){
       $.ajax({
          url: Dms.base_url + 'Dms/set_trans_session',
          method: 'POST',
          data: { trans_no : $('input#view_trans_no_input').val() },
          success: function() {
            window.open(Dms.base_url + 'Dms/dispositionForm', "_blank");
          }
       });
     });

     $('a#vt_history_anchor').on('click', function(e){
       $.ajax({
          url: Dms.base_url + 'Modal_Data/trans_history',
          method: 'POST',
          data: { trans_no : <?=$trans_data[0]['trans_no']?> },
          success: function(data) {
            $('#view_transaction_modal').find('div#trans_view_history_tab').html(data);
            $('a#vt_history_anchor').off(e);
          }
       });
     });
  })
</script>
