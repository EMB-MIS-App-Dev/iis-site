<style>
  textarea {
    min-height: 130px;
  }
</style>
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-add-tab" data-toggle="tab" href="#nav-add" role="tab" aria-controls="nav-add" aria-selected="true">Transaction Details</a>
              <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">History</a>
              <?php if($trans_data[0]['type'] == '83' AND ($this->session->userdata('token') == $trans_data[0]['receiver_id']) || $this->session->userdata('superadmin_rights') == 'yes' || $this->session->userdata('dms_all_view_attachment') == 'yes'){ ?>
              <a class="nav-item nav-link" id="nav-travel-tab" data-toggle="tab" href="#nav-travel" role="tab" aria-controls="nav-travel" aria-selected="false" onclick="view_trans_travel_details('<?php echo $this->encrypt->encode($trans_data[0]['trans_no']); ?>');">Travel Details</a>
              <?php } ?>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-add" role="tabpanel" aria-labelledby="nav-add-tab">
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
                    <!-- <input class="form-control" value="<?php echo $trans_data[0]['company_name'];?>" readonly /> -->
                  </div>
                  <div class="form-group">
                    <label>Company Address:</label>
                    <textarea class="form-control" id="company_address" readonly><?php echo ucwords(trim(strtoupper($company_details[0]['house_no'].' '.$company_details[0]['street'].' '.$company_details[0]['barangay_name'].', '.$company_details[0]['city_name'].' '.$company_details[0]['province_name']))); ?></textarea>
                  </div>

                  <!-- <div class="form-group">
                    <label>Latitude:</label>

                    <input class="form-control" value="<?=!empty($company_details[0]['latitude']) ? $company_details[0]['latitude'] :$geocode->results[0]->geometry->location->lat?>" readonly />
                  </div>

                  <div class="form-group">
                    <label>Longitude:</label>
                    <input class="form-control" value="<?=!empty($company_details[0]['longitude']) ? $company_details[0]['longitude'] :$geocode->results[0]->geometry->location->lng?>" readonly />
                  </div> -->
                  <div class="form-group">
                    <label>Project Type:</label>
                    <textarea class="form-control" id="company_address" readonly><?php echo $company_details[0]['project_name']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Project Category:</label>
                    <textarea class="form-control" id="company_address" readonly></textarea>
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
              <div class="row">
                <div class="col-md-12" style="text-align: center">
                  <br /><h5>TRANSACTION HISTORY</h5><br />
                  <?php
                    if(!empty($trans_history[0]['receiver_id']) OR $trans_history[0]['type'] == '116' OR (empty($trans_history[0]['receiver_id']) AND $trans_history[0]['status'] == '24'))
                    {
                    ?>
                    <table class="table table-striped" style="zoom: 87%">
                      <thead class="thead-dark">
                        <tr>
                          <th>Date Rcvd/Created</th>
                          <th>Action</th>
                          <th style="min-width: 5% !important; width: 17% !important">Remarks</th>
                          <th>From</th>
                          <th>Status</th>
                          <th>Assigned</th>
                          <th>Date Forwarded</th>
                          <th>View Attachment</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $trns_date = date('Y', strtotime($trans_data[0]['start_date']));
                            foreach ($trans_history as $key => $value) {
                              if($value['main_multi_cntr'] == 0)
                              {
                                $rcvr = (!empty(trim($value['receiver_name']))) ? $value['receiver_name'] : '--';
                                $attach = '--';
                                $tnscalc=0;
                                $trans_no_calculated = $value['trans_no'];
                                if($value['date_in'] < '2020-02-16') {
                                  $trans_no_calculated = $value['trans_no'] - 10000000;
                                  $tnscalc=1;
                                }

                                if(!empty($attachment_view[$key]))
                                {
                                  if(sizeof($attachment_view[$key]) > 1)
                                  {
                                    $attach = "<div class='dropdown'><button class='btn btn-info btn-sm waves-effect waves-light' type='button' data-toggle='dropdown'>View <i class='far fa-caret-square-down'></i></button> <ul class='dropdown-menu' style='max-height: 500px; overflow: auto'>";

                                    foreach ($attachment_view[$key] as $att_key => $att_value) {
                                      if($special_view || !empty($prnl_inthread) || in_array($user_func['func'], array('Director', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
                                      {
                                        $attach .= "<li><a title='".$att_value['file_name']."' href='".base_url('uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'].'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION))."' target='_blank'>".$att_value['token']."</a></li>";
                                      }
                                      else {
                                        $attach .= "<li>".$att_value['token']."</li>";
                                      }
                                    }
                                    $attach .= "</ul></div>";

                                    if($special_view || !empty($prnl_inthread) || in_array($user_func['func'], array('Director', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes'){
                                      $attach .= "<a title='Bulk Download' href='".base_url('Dms/Dms/bulk_download/'.$value['trans_no']."_0_".$value['route_order']."_1_".$trans_data[0]['region']."_".$tnscalc)."' target='_blank'><i class='fa fa-download' value=''></i></a>";
                                    }
                                  }
                                  else {
                                    $att_value = $attachment_view[$key][0];

                                    if($special_view || !empty($prnl_inthread) || in_array($user_func['func'], array('Director', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
                                    {
                                      $attach = "<a title='".$att_value['file_name']."' href='".base_url('uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'].'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION))."' target='_blank'>".$att_value['token']."</a>";
                                    }
                                    else {
                                      $attach = $att_value['token'];
                                    }
                                  }
                                }
                                // if( $value['route_order'] != 0 && (!empty($value['receiver_id']) || $value['status'] == 24 || $value['type'] == 83 || $value['type'] == 116) )
                                $date_out = (!empty($value['date_out']) && $value['date_out'] != '0000-00-00 00:00:00') ? date("M j Y, g:i a", strtotime($value['date_out'])) : '--';
                                if( $value['multiprc'] != 1 && $value['route_order'] != 0) {
                                  echo "<tr>
                                    <td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
                                    <td>".$value['action_taken']."</td>
                                    <td title='".$value['remarks']."'>".substr($value['remarks'],0,60)."</td>
                                    <td>".$from_name[$key].$value['sender_name']."</td>
                                    <td>".$value['status_description']."</td>
                                    <td>".$receiver_name[$key].$rcvr."</td>
                                    <td>".$date_out."</td>
                                    <td>".$attach."</td>
                                  </tr>";
                                }
                              }
                            }
                          ?>
                      </tbody>
                    </table>
                    <?php
                    }
                  ?>
                  <?php
                    if(!empty($multitrans_histo)) {
                      echo '<span class="set_error">*This transaction was routed to multiple persons below*</span>';
                      foreach ($multitrans_histo as $key => $value) {
                        $umhist = ($value['receiver_id'] == $user_token || $value['sender_id'] == $user_token) ? 'user-multi-history' : '';
                        $multi_key = $value['trans_no'].'_'.$value['main_route_order'].'_'.$value['main_multi_cntr'].'_'.$value['multi_cntr'];
                        echo '
                          <button onclick="Dms.multitrans_div($(this))" class="btn btn-default btn-sm multitrans-div '.$umhist.'" type="button" data-toggle="collapse" data-target="#multitrans_'.$multi_key.'" id="buttonassignsec">
                            <span class="multi-name" tyle="color: white">Person '.$value['multi_cntr'].'</span>
                            <span class="fa fa-caret-down" id="btncaretsub"></span>
                          </button>

                          <div class="collapse" id="multitrans_'.$multi_key.'">
                            <div class="card card-body" style="margin-top:10px;padding-left:5px;padding-right:5px;border-color:#08507E;border-top-left-radius:0px;border-top-right-radius:0px;">
                              <div id="multitrans_'.$multi_key.'_insert" class="row" style="padding-top:5px;padding-left:2px;padding-right:2px; text-align: center">
                                <div class="col-md-12">- loader - </div>
                              </div>
                            </div>
                          </div>
                        ';
                      }
                    }
                  ?>
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
  $('a#nav-history-tab').click( function(){
    console.log('asdasdas');
  });
</script>
