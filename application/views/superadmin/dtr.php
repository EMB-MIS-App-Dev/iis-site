<style media="screen">
  .h2ctrw{
    margin: 1px 1px 11px 1px;
    padding: 7px;
  }
  .h2ct{
    font-size:50px;font-family: 'Times New Roman', Times, serif;
    font-weight:bold;
    color:#FFF;
    background-color:#0F4E90;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #card-text{
    font-size: 14pt;text-align:center;color: #000;font-weight: 100;
  }
  .row .h2ctrw{
    padding:0px;
  }

  .visibletext{
    color:#000;
  }

  #dtrnotifno_{
    position: absolute;
    margin-top: -15px;
    margin-left: 0px;
    background-color: #E74A3B;
    padding: 0px 5px 0px 5px;
    border-radius: 7px;
    color: #FFF;
    font-size: 8pt;
    font-weight: 700;
  }
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Today's Record</h6>
          <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <div class="row h2ctrw">
              <div class="col-md-5" style="padding:0px;">
                  <div class="card" style="height: 100%;border: 0px;">
                    <div class="card-body" style="padding:0px;">
                      <h2 class="h2ct" id="time"><?php echo date('h:i A'); ?></h2>
                    </div>
                    <div style="background-color: #EDEEF1;padding: 10px;">
                      <p class="card-text" id="card-text"><?php echo date('l - d F Y'); ?></p>
                    </div>

                      <div style="display: flex; margin-top: 10px;">
                        <button type="button" id="timeinbtnido" onclick="timelog('<?php echo $this->encrypt->encode('punch_in'); ?>','<?php echo $this->encrypt->encode('1'); ?>');" style="width:50%;font-size:15pt;font-weight:100;" class="btn btn-success btn-sm" disabled>TIME IN</button>&nbsp;&nbsp;
                        <button type="button" id="timeoutbtnidt" onclick="timelog('<?php echo $this->encrypt->encode('punch_out'); ?>','<?php echo $this->encrypt->encode('2'); ?>');" style="width:50%;font-size:15pt;font-weight:100;" class="btn btn-danger btn-sm" disabled>BREAK OUT</button>&nbsp;&nbsp;
                        <button type="button" id="timeinbtnidh" onclick="timelog('<?php echo $this->encrypt->encode('punch_in'); ?>','<?php echo $this->encrypt->encode('3'); ?>');" style="width:50%;font-size:15pt;font-weight:100;" class="btn btn-success btn-sm" disabled>BREAK IN</button>&nbsp;&nbsp;
                        <button type="button" id="timeoutbtnidf" onclick="timelog('<?php echo $this->encrypt->encode('punch_out'); ?>','<?php echo $this->encrypt->encode('4'); ?>');" style="width:50%;font-size:15pt;font-weight:100;" class="btn btn-danger btn-sm" disabled>TIME OUT</button>
                      </div>

                  </div>
              </div>
              <div class="col-md-7" style="padding-right:0px;">
                <div id="table-responsive" style="margin-top:0px;zoom: 75%;font-weight: 100;">
                  <table class="table table-hover table-striped" id="time_logs_table" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Date</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>IN</th>
                        <th>OUT</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <!-- Card Body -->
      </div>
    </div>

    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Documents</h6>
          <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <ul class="nav nav-tabs" id="routedtrans" role="tablist" style="font-size: 10pt;font-weight: 100;">
            <li class="nav-item">
              <a class="nav-link active" id="tabone-tab" data-toggle="tab" href="#tabone" role="tab" aria-controls="tabone" aria-selected="true">My Documents</a>
            </li>
            <li class="nav-item" id="forapproval_"></li>
            <li class="nav-item" id="forpayroll_"></li>
            <li class="nav-item" id="allpayroll_"></li>
            <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
              <li class="nav-item">
                <a class="nav-link" id="tabsix-tab" data-toggle="tab" href="#tabsix" role="tab" aria-controls="tabsix" aria-selected="false">Employee Additional Info</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabfour-tab" data-toggle="tab" href="#tabfour" role="tab" aria-controls="tabfour" aria-selected="false">Add-on / Deduction</a>
              </li>
            <?php } ?>
          </ul>
          <div class="tab-content" id="routedtransContent">
            <div class="tab-pane fade show active" id="tabone" role="tabpanel" aria-labelledby="tabone-tab"><br />
              <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
                <button type="button" data-toggle="modal" data-target="#addtransdtr" class="btn btn-success btn-sm" style="font-size: 10pt;font-weight: 100;"><span class="fa fa-plus"></span>&nbsp;Submit Daily Time Record</button>
              <?php } ?>
              <div id="table-responsive" style="zoom: 90%;font-weight: 100;">
              <table class="table table-hover table-striped" id="dtr_routed" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;">
                <thead>
                  <tr>
                    <th>IIS No.</th>
                    <th>IIS No.</th>
                    <th>Date Submitted</th>
                    <th>For the month of</th>
                    <th>Receiver</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              </div>
            </div>
            <div class="tab-pane fade" id="tabtwo" role="tabpanel" aria-labelledby="tabtwo-tab">
              <div id="table-responsive" style="zoom: 90%;font-weight: 100;">
                <table class="table table-hover table-striped" id="dtr_routed_forapproval" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;">
                  <thead>
                    <tr>
                      <th>IIS No.</th>
                      <th>IIS No.</th>
                      <th>Date Submitted</th>
                      <th>For the month of</th>
                      <th>Employee</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="tabthree" role="tabpanel" aria-labelledby="tabthree-tab"><br />
                <table class="table table-hover table-striped" id="dtr_routed_forpayroll" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;zoom:90%;">
                  <thead>
                    <tr>
                      <th>IIS No.</th>
                      <th>Employee</th>
                      <th>For the month of</th>
                      <th>Days Worked</th>
                      <th>Daily Rate</th>
                      <th>Gross Income</th>
                      <th>Add-on(s)</th>
                      <th>Total Compensation</th>
                      <th>Late / Undertime</th>
                      <th>Deduction(s)</th>
                      <th>Total Deduction(s)</th>
                      <th>Net Pay</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $total_undertimeminutes = "";
                      for ($i=0; $i < sizeof($forpayroll); $i++) {
                        if(!empty($forpayroll[$i]['trans_no'])){
                          $grossincome = number_format($forpayroll[$i]['p_days_worked'] * $forpayroll[$i]['p_daily_rate'], 2);
                          $total_compensation = ($forpayroll[$i]['p_days_worked'] * str_replace(',','',$forpayroll[$i]['p_daily_rate'])) + str_replace(',','',$forpayroll[$i]['p_total_addon']);
                          $undertime_deduction = str_replace(',','',$forpayroll[$i]['undertime_total']) * str_replace(',','',$forpayroll[$i]['p_daily_rate']) / 480;
                          // $total_deduction =  $total_deductions_p + number_format($undertime_deduction,2);
                          $total_deductions_p = str_replace(',','',$forpayroll[$i]['p_total_deductions']);
                          $total_deduction = str_replace(',','',$total_deductions_p) + str_replace(',','',$undertime_deduction);

                          $net_home_pay = str_replace(',','',$total_compensation) - str_replace(',','',$total_deduction);
                      ?>
                        <tr>
                          <td><?php echo $forpayroll[$i]['trans_no']; ?></td>
                          <td><?php echo $forpayroll[$i]['staff_name']; ?></td>
                          <td><?php echo $forpayroll[$i]['dtr_span']; ?></td>
                          <td>
                            <input type="number" id="dtrdysworked" onkeyup="dtrdyswrkd('<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>',this.value,$('#dtrdlyrate').val());" value="<?php echo $forpayroll[$i]['p_days_worked']; ?>">
                          </td>
                          <td>
                            <input type="number" id="dtrdlyrate" onkeyup="dtrdlyrt('<?php echo $this->encrypt->encode($forpayroll[$i]['staff']); ?>',this.value,'<?php echo $this->encrypt->encode($forpayroll[$i]['staff_name']); ?>','<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>',$('#dtrdysworked').val());" value="<?php echo $forpayroll[$i]['p_daily_rate']; ?>">
                          </td>
                          <td>
                            <span id="gi<?php echo $forpayroll[$i]['trans_no']; ?>"><?php echo '₱'.$grossincome; ?></span>
                          </td>
                          <td style="text-align:right;">
                            <span id="<?php echo 'addon'.$forpayroll[$i]['trans_no']; ?>"><?php echo (!empty($forpayroll[$i]['p_total_addon']) ? '₱'.$forpayroll[$i]['p_total_addon'] : '₱00.00' ); ?></span>
                            <button type="button" data-toggle="modal" data-target="#addonmdl" class="btn btn-warning btn-sm" onclick="addondtr('<?php echo $this->encrypt->encode($forpayroll[$i]['staff']); ?>','<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>'); addonchkr('<?php echo $this->encrypt->encode($forpayroll[$i]['staff']); ?>','<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>');">
                              <span class="fa fa-edit"></span>
                            </button>
                          </td>
                          <td><?php echo '₱'.number_format($total_compensation,2); ?></td>
                          <td><?php echo '₱'.number_format($undertime_deduction,2); ?></td>
                          <td>
                            <span id="<?php echo 'deduction'.$forpayroll[$i]['trans_no']; ?>"><?php echo (!empty($forpayroll[$i]['p_total_deductions']) ? '₱'.$forpayroll[$i]['p_total_deductions'] : '₱00.00' ); ?></span>
                            <button type="button" data-toggle="modal" data-target="#deductionmdl" class="btn btn-warning btn-sm" onclick="deductiondtr('<?php echo $this->encrypt->encode($forpayroll[$i]['staff']); ?>','<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>'); deductionchkr('<?php echo $this->encrypt->encode($forpayroll[$i]['staff']); ?>','<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>');">
                              <span class="fa fa-edit"></span>
                            </button>
                          </td>
                          <td><span id="<?php echo 'total_deduction'.$forpayroll[$i]['trans_no'] ?>"><?php echo '₱'.number_format($total_deduction,2); ?></span></td>
                          <td><?php echo number_format($net_home_pay,2); ?></td>
                          <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#dtrsummarymdl" onclick="dtrsummary('<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>');" style="margin-top:3px;">Summary</button>
                            <button type="button" class="btn btn-success btn-sm" onclick="dtrpayrollapprove('<?php echo $this->encrypt->encode($forpayroll[$i]['trans_no']); ?>');" style="margin-top:3px;">Approve</button>
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tabfour" role="tabpanel" aria-labelledby="tabfour-tab"><br />
              <button type="button" data-toggle="modal" data-target="#credebmdl" class="btn btn-success btn-sm" style="font-size: 10pt;font-weight: 100;"><span class="fa fa-edit"></span>&nbsp;Add New</button>
              <div id="table-responsive" style="zoom: 90%;font-weight: 100;">
                <table class="table table-hover table-striped" id="dtr_credeb" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;">
                  <thead>
                    <tr>
                      <th>cnt</th>
                      <th>Item</th>
                      <th>Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade" id="tabsix" role="tabpanel" aria-labelledby="tabsix-tab"><br />
              <div id="table-responsive" style="zoom: 90%;font-weight: 100;">
                <table class="table table-hover table-striped" id="dtr_addtional_info" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;">
                  <thead>
                    <tr>
                      <th>userid</th>
                      <th>Employee</th>
                      <th>Daily Rate</th>
                      <th>Total Add-on(s)</th>
                      <th>Total Add-on(s)</th>
                      <th>Total Deduction(s)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade" id="tabfive" role="tabpanel" aria-labelledby="tabfive-tab">
              <div id="table-responsive" style="zoom: 90%;font-weight: 100;">
                <table class="table table-hover table-striped" id="dtr_allapproved_payroll" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;">
                  <thead>
                    <tr>
                      <th>cnt</th>
                      <th>IIS No.</th>
                      <th>Date Submitted</th>
                      <th>Employee</th>
                      <th>For the month of</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
        <!-- Card Body -->
      </div>
    </div>

    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Personal Records</h6>
          <div class="col-md-3" style="float:right;display:flex;padding:0px;">
            <label style="text-align: right;width:100%;margin: 7px 7px 0px 0px;font-weight: 100">Filtered by month of</label>
            <input type="month" class="form-control" onchange="filterdtr(this.value);" value="<?php echo (!empty($_SESSION['filterdtr'])) ? $_SESSION['filterdtr'] : date('Y-m'); ?>">
          </div>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <ul class="nav nav-tabs" id="dtrecord" role="tablist" style="font-size: 10pt;font-weight: 100;">
              <li class="nav-item">
                <a class="nav-link active" id="dtrrecord-tab" data-toggle="tab" href="#u" role="tab" aria-controls="u" aria-selected="true">Daily Time Record</a>
              </li>
              <?php if($_SESSION['hr_rights'] == 'yes'  OR $_SESSION['superadmin_rights'] == 'yes'){ ?>
                <li class="nav-item">
                  <a class="nav-link" id="taballedtr-tab" data-toggle="tab" href="#taballedtr" role="tab" aria-controls="taballedtr" aria-selected="false">All Employee Daily Time Record</a>
                </li>
              <?php } ?>
            </ul>
            <div class="tab-content" id="dtrecordContent">
              <div class="tab-pane fade show active" id="u" role="tabpanel" aria-labelledby="dtrrecord-tab"><br>
                <div class="col-md-12" style="padding:0px;">
                  <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
                    <button type="button" data-toggle="modal" data-target="#addtimelogs" class="btn btn-success btn-sm" style="font-size: 10pt;font-weight: 100;"><span class="fa fa-plus"></span>&nbsp;Add Attachment(s)</button>&nbsp;
                  <?php } ?>
                  <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
                    <button type="button" data-toggle="modal" data-target="#timelogsoptions" onclick="chkdtroptions();" class="btn btn-secondary btn-sm" style="font-size: 10pt;font-weight: 100;"><span class="fa fa-cog"></span>&nbsp;Options</button>
                  <?php } ?>
                  <button type="button" data-toggle="modal" data-target="#prevcscform48mdl" onclick="prevcscformbtn();" class="btn btn-info btn-sm" style="font-size: 10pt;font-weight: 100;"><span class="fa fa-eye"></span>&nbsp;Preview DTR (CSC FORM 48)</button>
                </div><br>
                <div id="table-responsive" style="margin-top:0px;zoom: 90%;font-weight: 100;">
                  <table class="table table-hover table-striped" id="dtr_table" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;text-align:center;">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Order by</th>
                        <th>Date log</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hrs. Worked</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hrs. Worked</th>
                        <th>Total Hrs. Worked</th>
                        <th>Remarks</th>
                        <th>Remarks</th>
                        <th>Attachments</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="taballedtr" role="tabpanel" aria-labelledby="dtrrecord-tab"><br />
                <div class="row">
                  <div class="col-md-4">
                    <label>From:</label>
                    <input type="date" class="form-control" id="prevfromdate" onchange="cscform48prev();">
                  </div>
                  <div class="col-md-4">
                    <label>To:</label>
                    <input type="date" class="form-control" id="prevatodate" onchange="cscform48prev();">
                  </div>
                  <div class="col-md-4" id="prevcscform_">
                    <button type="button" style="width: 100%;margin-top: 30px;font-size: 12pt;" class="btn btn-info btn-sm" disabled>PREVIEW ALL DTR</button>
                  </div>
                  <div class="col-md-12" id="prevempdtrrng_"></div>
                </div><br /><br />
              </div>
            </div>
          </div>
        <!-- Card Body -->
      </div>
    </div>
  </div>
</div>

<!-- modal -->
<div class="modal fade" id="addtimelogs" tabindex="-1" role="dialog" aria-labelledby="timelogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="timelogModalLabel">Add time logs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label class="visibletext">* Date log:</label>
              <input type="date" id="datelog" class="form-control" onchange="chktimelog(this.value); chkdtrattached(this.value);"><hr />
            </div>
            <div class="col-md-12">
              <div class="row" id="divtimelog_">
                <div class="col-md-3">
                  <label>Time in (AM):</label>
                  <input type="time" class="form-control" disabled>
                </div>
                <div class="col-md-3">
                  <label>Time out (AM):</label>
                  <input type="time" class="form-control" disabled>
                </div>
                <div class="col-md-3">
                  <label>Time in (PM):</label>
                  <input type="time" class="form-control" disabled>
                </div>
                <div class="col-md-3">
                  <label>Time out (PM):</label>
                  <input type="time" class="form-control" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-md" id="savetimelogsbtn" style="width: 100%;" disabled onclick="savetimelog($('#datelog').val(),$('#timeinam').val(),$('#timeoutam').val(),$('#timeinpm').val(),$('#timeoutpm').val(),$('#attachmentcounter').val(),$('#dtrcatselectize').val());"><span class="fa fa-sticky-note"></span>&nbsp;Save</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addtransdtr" tabindex="-1" role="dialog" aria-labelledby="timelogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="timelogModalLabel">Route Daily Time Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label class="visibletext">* Please select date range to preview:</label>
            </div>
            <div class="col-md-6">
              <input type="date" class="form-control" id="fromdtrroute" onchange="generatedtrrange();cscform48();">
            </div>
            <div class="col-md-6">
              <input type="date" class="form-control" id="todtrroute" onchange="generatedtrrange();cscform48();">
            </div>
            <div class="col-md-4">
              <label class="visibletext">* Route document to:</label>
              <select class="form-control" id="routedoctoselectize">
                <option value="">-</option>
                <?php for ($i=0; $i < sizeof($users); $i++) {
                  $mname = !empty($users[$i]['mname']) ? $users[$i]['mname'][0].'. ' : '';
                  $suffix = !empty($users[$i]['suffix']) ? ' '.$users[$i]['suffix'] : '';
                  $title = !empty($users[$i]['title']) ? $users[$i]['title'].' ' : '';
                  $name = $title.$users[$i]['fname'].' '.$mname.$users[$i]['sname'].$suffix;
                ?>
                  <option value="<?php echo $this->encrypt->encode($users[$i]['userid']); ?>"><?php echo $name; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="visibletext">* In-charge:</label>
              <select class="form-control" id="signatorydtrselectize"onchange="cscform48();">
                <option value="">-</option>
                <?php for ($i=0; $i < sizeof($users); $i++) {
                  $mname = !empty($users[$i]['mname']) ? $users[$i]['mname'][0].'. ' : '';
                  $suffix = !empty($users[$i]['suffix']) ? ' '.$users[$i]['suffix'] : '';
                  $title = !empty($users[$i]['title']) ? $users[$i]['title'].' ' : '';
                  $name = $title.$users[$i]['fname'].' '.$mname.$users[$i]['sname'].$suffix;
                ?>
                  <option value="<?php echo $this->encrypt->encode($users[$i]['userid']); ?>"><?php echo $name; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-4" id="cscform48_">
              <label class="visibletext">CSC FORM 48:</label>
              <button type="button" class="btn btn-danger btn-sm" style="width:100%;height:34px;" disabled><span class="fa fa-eye"></span>&nbsp;Preview to Print</button>
            </div>
            <div class="col-md-12" id="generatedtrrange_"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-md" style="width: 100%;" onclick="routedtrselected($('#fromdtrroute').val(),$('#todtrroute').val(),$('#routedoctoselectize').val(),$('#signatorydtrselectize').val());"><span class="fa fa-sticky-note"></span>&nbsp;Process</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="prevcscform48mdl" tabindex="-1" role="dialog" aria-labelledby="timelogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="timelogModalLabel">Please select date range</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row" id="prevcscformbtn_"></div>
        </div>
        <div class="modal-footer" id="prevcscformbtnftr_">
          <button type="button" class="btn btn-secondary btn-sm" style="width: 100%;" disabled><span class="fa fa-eye"></span>&nbsp;Preview DTR (CSC Form 48)</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="timelogsoptions" tabindex="-1" role="dialog" aria-labelledby="timelogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="timelogModalLabel">Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row" id="chkdtroptions_"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-md" onclick="savetimelogoptions($('#earliest_timein_').val(),$('#latest_timein_').val(),$('#earliest_timeout_').val(),$('#latest_timeout_').val());" style="width: 100%;"><span class="fa fa-save"></span>&nbsp;Save</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="viewcscformmodal" tabindex="-1" role="dialog" aria-labelledby="timelogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="timelogModalLabel">CSC Form 48</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label class="visibletext">* Please select your supervisor</label>
              <select class="form-control" id="surpervisorselectize" onchange="cscformrange($('#firstrangedtr').val(),$('#secondrangedtr').val(),$('#surpervisorselectize').val());">
                <option value="">-</option>
                <?php for ($i=0; $i < sizeof($selectusers); $i++) {
                  $mname = (!empty($selectusers[$i]['mname'])) ? $selectusers[$i]['mname'][0].'. ' : '';
                  $suffix = (!empty($selectusers[$i]['suffix'])) ? ' '.$selectusers[$i]['suffix'] : '';
                  $usersname = $selectusers[$i]['fname'].' '.$mname.$selectusers[$i]['sname'].$suffix;
                 ?>
                  <option value="<?php echo $this->encrypt->encode($selectusers[$i]['userid']); ?>"><?php echo $usersname; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12">
              <label class="visibletext">* Please select date range to preview:</label>
            </div>
            <div class="col-md-6">
              <input type="date" class="form-control" onchange="cscformrange($('#firstrangedtr').val(),$('#secondrangedtr').val(),$('#surpervisorselectize').val());" id="firstrangedtr">
            </div>
            <div class="col-md-6">
              <input type="date" class="form-control" onchange="cscformrange($('#firstrangedtr').val(),$('#secondrangedtr').val(),$('#surpervisorselectize').val());" id="secondrangedtr">
            </div>
          </div>
        </div>
        <div class="modal-footer" id="previewcsc_">
          <button type="button" class="btn btn-success btn-sm" disabled><span class="fa fa-eye"></span>&nbsp;Preview</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="credebmdl" tabindex="-1" role="dialog" aria-labelledby="credebModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="credebModalLabel">Add-on / Deduction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label>Item description</label>
              <input type="text" class="form-control" id="itemcredeb">
            </div>
            <div class="col-md-12">
              <label>Type</label>
              <select class="form-control" id="addonselectized">
                <option value="">-</option>
                <option value="<?php echo $this->encrypt->encode('Add-on'); ?>">Add-on</option>
                <option value="<?php echo $this->encrypt->encode('Deduction'); ?>">Deduction</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-md" onclick="savecredeb($('#itemcredeb').val(),$('#addonselectized').val());" style="width: 100%;"><span class="fa fa-save"></span>&nbsp;Save</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addonmdl" tabindex="-1" role="dialog" aria-labelledby="credebModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="credebModalLabel">Add-on(s)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div id="addondtr_"></div>
          <div id="addonchkr_"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="chkaddondtrmdl" tabindex="-1" role="dialog" aria-labelledby="credebModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="credebModalLabel">Add-on(s)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div id="chkaddon_"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deductionmdl" tabindex="-1" role="dialog" aria-labelledby="credebModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="credebModalLabel">Deduction(s)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div id="deductiondtr_"></div>
          <div id="deductionchkr_"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dtrsummarymdl" tabindex="-1" role="dialog" aria-labelledby="credebModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="credebModalLabel">Compensation Summary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div id="dtrsummarymdl_"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- modal -->

<script type="text/javascript">
  $(document).ready(function(){
    $('#surpervisorselectize').selectize();
    $('#routedoctoselectize').selectize();
    $('#signatorydtrselectize').selectize();
    $('#addonselectized').selectize();
    var timeDisplay = document.getElementById("time");
    // function refreshTime() {
    //   var dateString = new Date().toLocaleTimeString("en-US", {timeZone: "Asia/Manila"});
    //   timeDisplay.innerHTML = dateString;
    // }
    // setInterval(refreshTime, 1000);

    function timenow(){
      $.ajax({
        url: base_url+"/Admin/Dtr_ajax/timenow",
        type: 'POST',
        async : true,
        data: { },
        success:function(response){
          var obj = JSON.parse(response);
          timeDisplay.innerHTML = obj.result;
        }
      });
    }

    setInterval(timenow, 20000);

    $.ajax({
      url: base_url+"/Admin/DTR/checknotif",
      type: 'POST',
      async : true,
      data: { },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.forapproval > 0){
          dataapproval = '<a class="nav-link" id="tabtwo-tab" data-toggle="tab" href="#tabtwo" role="tab" aria-controls="tabtwo" aria-selected="false">For Approval<span id="dtrnotifno_">'+obj.forapproval+'</span></a>';
          $('#forapproval_').html(dataapproval);
        }

        if(obj.forpayroll > 0){
          dataforpayroll = '<a class="nav-link" id="tabthree-tab" data-toggle="tab" href="#tabthree" role="tab" aria-controls="tabthree" aria-selected="false">For Payroll<span id="dtrnotifno_">'+obj.forpayroll+'</span></a>';
          $('#forpayroll_').html(dataforpayroll);
        }

        if(obj.allpayroll > 0){
          datapayroll = '<a class="nav-link" id="tabfive-tab" data-toggle="tab" href="#tabfive" role="tab" aria-controls="tabfive" aria-selected="false">All Approved Payroll</a>';
          $('#allpayroll_').html(datapayroll);
        }

      }
    });

    var time_logs_table = $('#time_logs_table').DataTable({
      responsive: true,
      paging: true,
      scrollX: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      "order": [[ 0, "asc"] ],
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/dtr",
          "type": 'POST',
          "data": { datetoday : '<?php echo date('F d, Y'); ?>'  },
      },
      "columns": [
        { "data": "cnt"  ,"searchable": true,"visible": false},
        { "data": "punch_date"  ,"searchable": true,"sortable": true},
        { "data": "in"  ,"searchable": true,"sortable": false},
        { "data": "out"  ,"searchable": true,"sortable": false},
        { "data": "in_pm"  ,"searchable": true,"sortable": false},
        { "data": "out_pm"  ,"searchable": true,"sortable": false},
        // {
        //   "data": null,
        //     "render": function(data, type, row, meta){
        //
        //         data = "<button class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#view_line_of_authority' onclick=view_line_of_authority('"+row[5]+"');>View</button>";
        //       return data;
        //     }
        // },
      ]
    });





    var dtr_routed = $('#dtr_routed').DataTable({
      responsive: true,
      paging: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      "order": [[ 0, "asc"] ],
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/routed",
          "type": 'POST',
          "data": {  },
      },
      "columns": [
        { "data": "trans_no"  ,"searchable": true,"visible": true},
        { "data": 5,"searchable": true,"visible": false},
        { "data": "date_submitted"  ,"searchable": true,"visible": true},
        { "data": "dtr_span"  ,"searchable": true,"visible": true},
        { "data": "routedto_name"  ,"searchable": true,"visible": true},
        { "data": "status"  ,"searchable": true,"visible": true},
        {
          "data": null,
            "render": function(data, type, row, meta){

                data = "<button class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#view_routed_dtr_details' onclick=routed_dtr_details('"+row[5]+"');>View DTR Details</button>";
                if(row['status'] == 'Returned'){
                  data += "&nbsp;<button class='btn btn-success btn-sm' href='#' data-toggle='modal' data-target='#edit_routed_dtr_details' onclick=editdtrfulldetails('"+row[5]+"');>Process</button>";
                }

                if(row['status'] == 'Approved'){
                  data += "&nbsp;<button class='btn btn-danger btn-sm' href='#' data-toggle='modal' data-target='#dtrsummarymdl' onclick=dtrsummary('"+row[5]+"');>View Compensation Summary</button>";
                }
              return data;
            }
        },
      ]
    });

    var dtr_routed_forapproval = $('#dtr_routed_forapproval').DataTable({
      responsive: true,
      paging: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      "order": [[ 0, "asc"] ],
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/routed",
          "type": 'POST',
          "data": { routedtome : '<?php echo $this->session->userdata('userid'); ?>' },
      },
      "columns": [
        { "data": "trans_no"  ,"searchable": true,"visible": true},
        { "data": 5,"searchable": true,"visible": false},
        { "data": "date_submitted"  ,"searchable": true,"visible": true},
        { "data": "dtr_span"  ,"searchable": true,"visible": true},
        { "data": "staff_name"  ,"searchable": true,"visible": true},
        { "data": "status"  ,"searchable": true,"visible": true},
        {
          "data": null,
            "render": function(data, type, row, meta){

                data = "<button class='btn btn-success btn-sm' href='#' data-toggle='modal' data-target='#check_routed_dtr_details' onclick=checkrouted_dtr_details('"+row[5]+"');>Process</button>";
              return data;
            }
        },
      ]
    });

    var dtr_routed_forpayroll = $('#dtr_routed_forpayroll').DataTable();

    var dtr_allapproved_payroll = $('#dtr_allapproved_payroll').DataTable({
      responsive: true,
      paging: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      "order": [[ 3, "asc"] ],
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/dtr_allapproved_payroll",
          "type": 'POST',
          "data": { routedtome : '<?php echo $this->session->userdata('userid'); ?>' },
      },
      "columns": [
        { "data": 0 ,"searchable": true,"visible": false},
        { "data": "trans_no"  ,"searchable": true,"visible": true},
        { "data": "date_submitted"  ,"searchable": true,"visible": true},
        { "data": "staff_name"  ,"searchable": true,"visible": true},
        { "data": "dtr_span"  ,"searchable": true,"visible": true},
        { "data": "status"  ,"searchable": true,"visible": true},
        {
          "data": null,
            "render": function(data, type, row, meta){

                data = "<button class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#dtrsummarymdl' onclick=dtrsummary('"+row[0]+"');>View Details</button>";

              return data;
            }
        },
      ]
    });

    var dtr_credeb = $('#dtr_credeb').DataTable({
      responsive: true,
      paging: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      "order": [[ 0, "asc"] ],
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/dtr_credeb",
          "type": 'POST',
          "data": { },
      },
      "columns": [
        { "data": "cnt"  ,"searchable": true,"visible": false},
        { "data": "item"  ,"searchable": true,"visible": true},
        { "data": "type"  ,"searchable": true,"visible": true},
        {
          "data": null,
            "render": function(data, type, row, meta){

                data = "<button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editcredeb' href='#' onclick=editcredebbtm('"+row['cnt']+"')>Edit Details</button>";
              return data;
            }
        },
      ]
    });

    var dtr_addtional_info = $('#dtr_addtional_info').DataTable({
      responsive: true,
      paging: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      "order": [[ 0, "asc"] ],
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/dtr_addtional_info",
          "type": 'POST',
          "data": { },
      },
      "columns": [
        { "data": "userid"  ,"searchable": true,"visible": false},
        { "data": "name"  ,"searchable": true,"visible": true},
        { "data": "daily_rate"  ,"searchable": true,"visible": true},
        { "data": "add_on_total"  ,"searchable": true,"visible": false},
        {
          "data": null,
            "render": function(data, type, row, meta){

                data = row['add_on_total']+"&nbsp;<button type='button' data-toggle='modal' data-target='#chkaddondtrmdl' class='btn btn-warning btn-sm' onclick=chkaddondtr('"+row[5]+"');><span class='fa fa-edit'></span></button>";
              return data;
            }
        },
        { "data": "deduction_total"  ,"searchable": true,"visible": true},
        {
          "data": null,
            "render": function(data, type, row, meta){

                data = "";
              return data;
            }
        },
      ]
    });




    var dtr_table = $('#dtr_table').DataTable({
      responsive: true,
      paging: true,
      language: {
        infoFiltered: "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
      },
      processing: true,
      "serverSide": true,
      ajax: {
          "url": "<?php echo base_url(); ?>Admin/Serverside_dtr/dtr",
          "type": 'POST',
          "data": { filterdate : '<?php echo (!empty($_SESSION['filterdtr'])) ? $_SESSION['filterdtr'] : date('Y-m'); ?>'  },
      },
      "order": [[ 1, "asc"]],
      "lengthMenu": [[31, 50, 100, -1], [31, 50, 100, "All"]],
      "columns": [
        { "data": "cnt"  ,"searchable": true,"visible": false},
        { "data": "order_by"  ,"searchable": true,"visible": false},
        { "data": "punch_date"  ,"searchable": true},
        { "data": "in"  ,"searchable": true,"sortable": false},
        { "data": "out"  ,"searchable": true,"sortable": false},
        { "data": "am_hrsworked"  ,"searchable": true,"sortable": false},
        { "data": "in_pm"  ,"searchable": true,"sortable": false},
        { "data": "out_pm"  ,"searchable": true,"sortable": false},
        { "data": "pm_hrsworked"  ,"searchable": true,"sortable": false},
        { "data": "total_hrsworked"  ,"searchable": true,"sortable": false},
        { "data": "with_attachments"  ,"searchable": true,"visible": false},
        { "data": 10  ,"searchable": true,"sortable": false},
        { "data": "attachment_file"  ,"searchable": true,"visible": false},
        {
          "data": null, "sortable": false,
            "render": function(data, type, row, meta){
              if(row['attachment_file'] == null){
                data = "";
              }else{
                data = "<button class='btn btn-info btn-sm' data-toggle='modal' data-target='#dtrattachments' href='#' onclick=viewdtrattachments('"+row['cnt']+"')>View Attachment(s)</button>";
              }
              return data;
            }
        },
      ]
    });
  });
</script>

<div class="modal fade" id="dtrattachments" tabindex="-1" role="dialog" aria-labelledby="dtrattchmntsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="dtrattchmntsModalLabel">Attachment(s)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div id="dtrattchments_"></div>
        </div>
        <div class="modal-footer"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="editcredeb" tabindex="-1" role="dialog" aria-labelledby="dtrattchmntsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%!important;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header">
        <h5 class="modal-title" id="dtrattchmntsModalLabel">Edit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div id="editcredeb_"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success btn-sm" onclick="saveeditedcredeb($('#credebitem').val(),$('#credebtoken').val(),$('#typecredebselectize').val());">Save</button>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function timelog(token, button){
  $.ajax({
    url: base_url+"/Admin/Dtr_ajax/timelog",
    type: 'POST',
    async : true,
    data: { token : token, button : button },
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        var time_logs_table = $('#time_logs_table').DataTable();
        time_logs_table.ajax.reload( null, false );
        var dtr_table = $('#dtr_table').DataTable();
        dtr_table.ajax.reload( null, false );
      }
      chkbtntime();
    }
  });
}

$(document).ready(function() {
  chkbtntime();
});

function chkbtntime(){
  $.ajax({
      url: base_url+"/Admin/Dtr_ajax/chkbtntime",
      type: 'POST',
      async : true,
      data: { },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.stat == '1'){
          $('#timeinbtnido').removeAttr('disabled');
        }
        if(obj.stat == '2'){
          $('#timeoutbtnidt').removeAttr('disabled');
          document.getElementById("timeinbtnido").disabled = true;
        }
        if(obj.stat == '3'){
          $('#timeinbtnidh').removeAttr('disabled');
          document.getElementById("timeoutbtnidt").disabled = true;
        }
        if(obj.stat == '4'){
          $('#timeoutbtnidf').removeAttr('disabled');
          document.getElementById("timeinbtnidh").disabled = true;
        }
        if(obj.stat == '5'){
          document.getElementById("timeinbtnido").disabled = true;
          document.getElementById("timeoutbtnidt").disabled = true;
          document.getElementById("timeinbtnidh").disabled = true;
          document.getElementById("timeoutbtnidf").disabled = true;
        }
      }
  });
}
</script>
