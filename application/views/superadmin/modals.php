<style media="screen">
  .modal-content{
    border:none;
  }
</style>
<!-- Edit Section or Unit -->
<div class="modal fade" id="edit_details_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Edit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/edit_section_details" method="post">
        <div class="modal-body">
            <div id="edit_details_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Section or Unit -->

<!-- Edit Plantilla -->
<div class="modal fade" id="edit_plantilla_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Edit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/edit_plantilla" method="post">
        <div class="modal-body">
            <div id="edit_plantilla_details_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Plantilla -->

<!-- Delete Line of Authority -->
<div class="modal fade" id="delete_line_of_authority" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Remove Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/remove_line_of_authority" method="post">
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure to remove this entry?</h6></center>
            <div id="delete_line_of_authority_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Line of Authority -->

<!-- Edit Line of Authority -->
<div class="modal fade" id="edit_line_of_authority" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Edit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/edit_line_of_authority" method="post">
        <div class="modal-body">
            <div id="edit_line_of_authority_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Line of Authority -->

<!-- Edit Line of Authority -->
<div class="modal fade" id="view_line_of_authority" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">View Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div id="view_line_of_authority_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- Edit Line of Authority -->

<!-- Add New Section or Unit -->
<div class="modal fade" id="add_details_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Add Section/Unit/PEMU</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_section_details" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Division</label>
            <select id="division_selectize" class="form-control" name="division" required="">
              <option></option>

                <?php foreach ($division as $key => $value) { ?>
                  <optgroup label="<?php echo $value['cat']; ?>">
                    <option value="<?php echo $value['divno']; ?>"><?php echo $value['divname']; ?></option>
                  </optgroup>
                <?php } ?>

            </select>
          </div>
          <div class="col-md-12" style="margin-top:10px;">
            <label>Section/Unit/PEMU</label>
            <input type="text" class="form-control" name="section" required="">
          </div>
          <div class="col-md-12" style="margin-top:10px;">
            <label>Section/Unit/PEMU Code</label>
            <input type="text" class="form-control" placeholder="eg AQMS, OD, etc." name="secode" required="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Save</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Add New Section or Unit -->

<!-- Add New Division -->
<div class="modal fade" id="add_detailsdv_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Add Division</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_division_details" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Division</label>
            <input type="text" class="form-control" name="division">
          </div>
          <div class="col-md-12" style="margin-top:10px;">
            <label>Division Abbreviation</label>
            <input type="text" class="form-control" name="divcode" placeholder="e.g (CPD,SWM,EMED)">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Save</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Add New Division -->

<!-- Add Plantilla -->
<div class="modal fade" id="add_details_plantilla_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Add Plantilla Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_plantilla" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Plantilla Position</label>
            <input type="text" class="form-control" name="plantilla_pos" required="">
          </div>
          <div class="col-md-12" style="margin-top:10px;">
            <label>Plantilla Abbreviation</label>
            <input type="text" class="form-control" name="plantilla_abbreviation" placeholder="e.g (ENGR,DIR,EMS)" required="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Save</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Add Plantilla -->

<!-- Employee Designation -->
<div class="modal fade" id="designate_employee" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Employee Assignment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_function" method="post">
      <div class="modal-body">
        <div class="row">
        <div class="col-md-6">
            <label>User Function</label>
            <select id="user_function_selectize" class="form-control" name="function" required>
                <option></option>
              <?php foreach ($usertype as $key => $value) { ?>
                <option value="<?php echo $this->encrypt->encode($value['token']); ?>"><?php echo $value['dsc']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-6">
            <label>Employee</label>
            <select id="employee_selectizee" class="form-control" name="employee_userid" required>
                <option></option>
              <?php
                foreach ($useraccounts as $key => $value) {
                  if(!empty($value['mname'])){ $mname = $value['mname'][0].". "; }else{ $mname = ""; }
                  if(!empty($value['suffix'])){ $suffix = " ".$value['suffix']; }else{ $suffix = ""; }
                  $name      = utf8_encode(strtolower($value['fname']." ".$mname.$value['sname']));
                  $full_name = str_replace('ã±', '&ntilde;', $name.$suffix);
              ?>
                <option value="<?php echo $this->encrypt->encode($value['userid']); ?>"><?php echo ucwords(str_replace('Ã±', '&ntilde;',$full_name)); ?></option>
              <?php } ?>
            </select>
          </div>
            <div class="col-md-12" style="margin-top:10px;">
              <label>Division</label>
              <select class="form-control" id="division_selectize_assign" name="division" onchange="sec_details(this.value);" required>
                <option></option>
                <?php foreach ($division as $key => $value) { ?>
                  <optgroup label="<?php echo $value['cat']; ?>">
                    <option value="<?php echo $this->encrypt->encode($value['token']); ?>"><?php echo $value['divname']; ?></option>
                  </optgroup>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12" id="sec_user_val_body" style="margin-top:10px;">
              <label>Section</label>
              <select class="form-control" disabled>
                <option></option>
              </select>
            </div>
            <div class="col-md-6" style="margin-top:10px;">
              <label>Designation / Position Title</label>
              <input type="text" class="form-control" name="designation" required>
            </div>
            <div class="col-md-6" style="margin-top:10px;">
              <label>Date Started</label>
              <input type="date" class="form-control" name="start_date" value="<?php echo date("Y-m-d"); ?>" required>
            </div>
            <div class="col-md-6" style="margin-top:10px;">
              <label>Plantilla Position <span style="color:red;">(if applicable)</span></label>
              <select id="plantilla_selectize" class="form-control" name="plantilla_pos">
                <option></option>
                <?php for($i=0; $i < sizeof($qryplantilla); $i++){ ?>
                  <option value="<?php echo $qryplantilla[$i]['planpstn_id']; ?>"><?php echo $qryplantilla[$i]['planpstn_desc']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6" style="margin-top:10px;">
              <label>Plantilla Rank <span style="color:red;">(if applicable)</span></label>
              <select id="rank_selectize" class="form-control" name="rank">
                <option></option>
                <?php for($i=0; $i < sizeof($qryrank); $i++){ ?>
                  <option value="<?php echo $qryrank[$i]['rank_desc']; ?>"><?php echo $qryrank[$i]['rank_desc']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12" style="margin-top:10px;">
              <label>Select Immediate Supervisor of Employee <span class="fa fa-info-circle" style="color:orange;" title="Highest to lowest ranking superior"></span></label>
              <select id="rule_selectize" onchange="ruledetails(this.value,3);" class="form-control" required>
                <option></option>
                <option value="<?php echo $this->encrypt->encode('notinthelist'); ?>">Not in the list?</option>
                <optgroup label="Hierarchy of Superiors Template/s">
                <?php for($i=0; $i < sizeof($rule_name); $i++){ ?>
                  <option value="<?php echo $this->encrypt->encode($rule_name[$i]['rule_name']); ?>"><?php echo $rule_name[$i]['rule_name']; ?></option>
                <?php } ?>
                </optgroup>
              </select>
            </div>
            <div id="ruledetails_body" class="col-md-12" style="margin-top:10px;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Employee Designation -->

<!-- Add Rule -->
<div class="modal fade" id="add_rule_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Hierarchy of Superiors</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_rule" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10">
            <label>Description</label>&nbsp;&nbsp;<span style="font-size:9pt;" id="error_msg_hierarchy"></span>
            <input type="text" class="form-control" onkeyup="check_hierarchy_name(this.value);" name="rule_name" required="">
          </div>
          <div class="col-md-2">
            <label>No. Rows</label>
            <select class="form-control" id="no_rows_hierarchy" onchange="rule_rows(this.value,1);" name="no_rows" required="">
              <option></option>
              <option value="<?php echo $this->encrypt->encode('1'); ?>">1</option>
              <option value="<?php echo $this->encrypt->encode('2'); ?>">2</option>
              <option value="<?php echo $this->encrypt->encode('3'); ?>">3</option>
              <option value="<?php echo $this->encrypt->encode('4'); ?>">4</option>
              <option value="<?php echo $this->encrypt->encode('5'); ?>">5</option>
              <option value="<?php echo $this->encrypt->encode('6'); ?>">6</option>
              <option value="<?php echo $this->encrypt->encode('7'); ?>">7</option>
              <option value="<?php echo $this->encrypt->encode('8'); ?>">8</option>
              <option value="<?php echo $this->encrypt->encode('9'); ?>">9</option>
            </select>
          </div>
          <div id="rule_rows_body" class="col-md-12"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" id="hierarchy_save_btn" class="btn btn-success btn-sm">Save</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Add Rule -->

<!-- Employee Settings -->
<div class="modal fade" id="employee_settings" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel"><span class="fa fa-cog">&nbsp;</span>Employee Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/employee_actions" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label>Action</label>
            <select name="action" id="action_selectize" class="form-control" onchange="employee_settings_comment(this.value); emp_action_res(this.value);" required>
                <option value=""></option>
              <?php for($i=0; $i<sizeof($user_actions); $i++){ ?>
                <option value="<?php echo $user_actions[$i]['token']; ?>"><?php echo $user_actions[$i]['acc_desc']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div id='emp-act-res' class="col-md-6"><label>Employee List</label><input type="text" class="form-control" value="Please select action" disabled></div>
          <div class="col-md-12" id="chkhierarchy_body"></div>
          <div class="col-md-12" id="employee_settings_comment_body"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Employee Settings -->

<!-- Reset Account -->
<div class="modal fade" id="edit_account_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Edit Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/edit_account" method="post">
        <div class="modal-body">
            <div id="edit_account_modal_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Reset Account -->

<!-- Employee Designation -->
<div class="modal fade" id="edit_user_accounts_details_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Employee Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <div id="edit_user_accounts_details_modal_body"></div>
    </div>
  </div>
</div>
<!-- Employee Designation -->

<!-- Hierarchy of superiors -->
<div class="modal fade" id="view_user_accounts_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Hierarchy of Superiors</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <div id="view_user_accounts_modal_body"></div>
    </div>
  </div>
</div>
<!-- Hierarchy of superiors -->

<!-- Hierarchy of superiors -->
<div class="modal fade" id="edit_user_accounts_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel">Employee Assignment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <div id="edit_user_accounts_modal_body"></div>
    </div>
  </div>
</div>
<!-- Hierarchy of superiors -->

<!-- Add user right -->
<div class="modal fade" id="add_user_right" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Add User Privilege</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_user_right" method="post">
        <div class="modal-body">
            <div class="col-md-12">
            <label>Employee</label>
            <select id="employee_selectize_user_right" class="form-control" name="employee" required>
                <option></option>
              <?php
                foreach ($useraccounts_right as $key => $value) {
                  if(!empty($value['mname'])){ $mname = $value['mname'][0].". "; }else{ $mname = ""; }
                  if(!empty($value['suffix'])){ $suffix = " ".$value['suffix']; }else{ $suffix = ""; }
                  $name      = utf8_encode(strtolower($value['fname']." ".$mname.$value['sname']));
                  $full_name = str_replace('ã±', '&ntilde;', $name.$suffix);
              ?>
                <option value="<?php echo $this->encrypt->encode($value['userid']); ?>"><?php echo ucwords(str_replace('Ã±', '&ntilde;',$full_name)); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Add user right -->

<div class="modal fade" id="not_applicable_secorunit" tabindex="-1" role="dialog" aria-labelledby="not_applicable_secorunit" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">List of not applicable section / unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="notapplicablebody"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="module_updates_administrative" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Module Updates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div id="module_updates_administrative_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<!-- Transfer Users -->
<div class="modal fade" id="transferusers" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:90%;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel"><span class="fa fa-cog">&nbsp;</span style="font-size: 12pt;">Exchange Functions&nbsp;<span>(applicable to same level of user function only)</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/transfer_user" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group"  style="margin-bottom:0px;">
              <label>Select user to transfer:</label>
              <select id="dfltuserselectize" class="form-control" name="dflt_user" onchange="chkdfltexstfnc(this.value); undrprsnnlt($('#dfltuserselectize').val(),$('#rplcmntselectize').val(),'a');" required>
                <option value="">-</option>
                <?php for ($lg=0; $lg < sizeof($employee_list_active_trans) ; $lg++) {
                    $mname = !empty($employee_list_active_trans[$lg]['mname']) ? $employee_list_active_trans[$lg]['mname'][0].". " : '';
                    $suffix = !empty($employee_list_active_trans[$lg]['suffix']) ? " ".$employee_list_active_trans[$lg]['suffix'] : '';
                    $prefix = !empty($employee_list_active_trans[$lg]['title']) ? $employee_list_active_trans[$lg]['title']." " : '';
                    $name = $prefix.ucwords($employee_list_active_trans[$lg]['fname']." ".$mname." ".$employee_list_active_trans[$lg]['sname']).$suffix;
                  ?>
                  <optgroup label="<?php echo $employee_list_active_trans[$lg]['func']; ?>">
                    <option value="<?php echo $this->encrypt->encode($employee_list_active_trans[$lg]['userid']); ?>"><?php echo $name; ?></option>
                  </optgroup>
                  <?php } ?>
              </select>
            </div>
            <div id="_chkdfltexstfnc"></div>
          </div>
          <div class="col-md-6">
            <div id="chkdfltexstfnc_">
              <div class="form-group"  style="margin-bottom:0px;">
                <label>Please select another user to swap:</label>
                <input type="text" class="form-control" value="-" disabled>
              </div>

            </div>
          </div>
          <div class="col-md-12" id="undrprsnnlt_"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Transfer Users -->

<!-- Change Hierarchy-->
<div class="modal fade" id="transferusersdom" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="useraccountsModalLabel"><span class="fa fa-cog">&nbsp;</span style="font-size: 12pt;">Change Hierarchy of Superiors</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/changehierarchybulk" method="post">
      <div class="modal-body">
        <div id="trmsusrsdm_"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Change Hierarchy -->

<!-- VIEW DTR DETAILS -->
<div class="modal fade" id="view_routed_dtr_details" tabindex="-1" role="dialog" aria-labelledby="dtrdetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="dtrdetailsModalLabel">Routed Daily Time Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="routed_dtr_details_"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- VIEW DTR DETAILS -->

<!-- CHECK DTR DETAILS -->
<div class="modal fade" id="check_routed_dtr_details" tabindex="-1" role="dialog" aria-labelledby="dtrdetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:90%;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="dtrdetailsModalLabel">Routed Daily Time Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="checkrouted_dtr_details_"></div>
      <div class="modal-footer" id="checkrouted_dtr_footer_">
        <button type="button" class="btn btn-danger btn-sm" onclick="returntosenderdtr($('#checkrouted_dtr_token').val()); returntosenderfooter($('#checkrouted_dtr_token').val());">Return to Sender</button>
        <button type="button" class="btn btn-success btn-sm" onclick="approve_routed_dtr_details($('#checkrouted_dtr_token').val(),$('#rdocprocessselectize').val(),$('#statusprocessselectize').val(),$('#remarksroutedtrr').val(),$('#dtrdaysworked').val());">Process</button>
      </div>
    </div>
  </div>
</div>
<!-- CHECK DTR DETAILS -->

<!-- CHECK DTR DETAILS -->
<div class="modal fade" id="edit_routed_dtr_details" tabindex="-1" role="dialog" aria-labelledby="dtrdetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#08507E;color:#FFF;">
        <h5 class="modal-title" id="dtrdetailsModalLabel">Process Daily Time Record </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="editrouted_dtr_details_"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-sm" onclick="processeditdtrrouted($('#routedocprocessselectize').val(),$('#routedocprocessselectizesig').val(),$('#editdtrtranstoken').val(),$('#routedocremarks').val());">Process</button>
      </div>
    </div>
  </div>
</div>
<!-- CHECK DTR DETAILS -->

<script>
  $(document).ready( function(){
    $('#employee_selectize_user_right').selectize();
    $('#user_function_selectize').selectize();
    $('#employee_selectizee').selectize();
    $('#employee_selectize').selectize();
    $('#division_selectize').selectize();
    $('#action_selectize').selectize();
    $('#rule_selectize').selectize();
    $('#no_rows_hierarchy').selectize();
    $('#dfltuserselectize').selectize();
  });
</script>
