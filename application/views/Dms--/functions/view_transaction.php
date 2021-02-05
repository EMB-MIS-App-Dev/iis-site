          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-add-tab" data-toggle="tab" href="#nav-add" role="tab" aria-controls="nav-add" aria-selected="true">Add</a>
              <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">History</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-add" role="tabpanel" aria-labelledby="nav-add-tab">
              <div class="row">
                <div class="col-md-4"><br />
                  <div class="form-group">
                    <label>Transaction No.:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['trans_no']; ?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>System:</label>
                    <input class="form-control" value="<?php echo $system[0]['name']; ?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Sub-System:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['type_description']; ?>" readonly />
                  </div>
                  <div class="form-group" id="permit_no_id">
                    <label>Permit No.:</label>
                    <input class="form-control" value="<?php echo trim($trans_data[0]['permit_no']); ?>" readonly/>
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
                    <input class="form-control" id="company_embid" readonly />
                  </div>
                  <div class="form-group">
                    <label>Company:</label>
                    <input class="form-control" value="<?php echo $trans_data[0]['company_id'];?>" readonly />
                  </div>
                  <div class="form-group">
                    <label>Company Address:</label>
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
                  <table class="table table-striped" style="zoom: 85%">
                    <thead class="thead-dark">
                      <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>From</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Date Rcvd.</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                          foreach ($trans_history as $key => $value) {
                              if($value['route_order'] == $attachment_view[0]['route_order'])
                              {
                                if(count($attachment_view) > 1)
                                {
                                  $att = "<div class='dropdown'><button class='btn btn-info btn-sm waves-effect waves-light' type='button' data-toggle='dropdown'>View <i class='far fa-caret-square-down'></i></button>
                                  <ul class='dropdown-menu'>";
                                      $filecount = 1;
                                      while(count($value) != $filecount)
                                      {
                                        $att .= "<li><a href='".base_url('uploads/dms/'.date('Y').'/CO/'.$trans_no.'/'.$attachment_view[$key]['file_name'])."' target='_blank'>File</a></li>";
                                        $filecount++;
                                      }
                                  $att .= "</ul></div>";
                                }
                                else {
                                  $att = "<a href='".base_url('uploads/dms/'.date('Y').'/CO/'.$trans_no.'/'.$attachment_view[0]['file_name'])."' target='_blank'><button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light'>View</button></a>";
                                }
                              }
                              else {
                                $att = '--';
                              }

                              if(!empty($value['receiver_name'])){ $receiver = $value['receiver_name']; }else{ $receiver = "---"; }

                            if($value['receiver_id'] != '' || $value['status'] == '24') {
                              echo "<tr>
                                <td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
                                <td>".$value['action_taken']."</td>
                                <td>".$value['sender_name']."</td>
                                <td>".$value['status_description']."</td>
                                <td>".$receiver."</td>
                                <td>".date("M j Y, g:i a", strtotime($value['date_out']))."</td>
                                <td>".$att."</td>
                              </tr>";
                            }
                          }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
