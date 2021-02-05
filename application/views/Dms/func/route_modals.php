
<!-- TRANSACTION ADD PERSONNEL -->
<div class="modal fade addPersonnelsModal" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add Multiple Personnel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br />
      <div class="col-md-3">
        <button type="button" class='btn btn-primary btn-sm waves-effect waves-light' onclick="Dms.add_more_prsnl();"><i class="fas fa-plus"></i> Add Personnel</button>
      </div>
      <form id="multiprsnl_select_form" action="<?php echo base_url('Dms/Dms/multipersonnels'); ?>" method="POST">
        <span id="multislct_span" class="col-md-3 set_error"></span>
        <div class="modal-body">
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 8%">Remove</th>
                  <th style="width: 15%">Region</th>
                  <th style="width: 15%">Division</th>
                  <th style="width: 15%">Section</th>
                  <th style="width: 15%">Personnel</th>
                  <th title="Use this ONLY IF you have SPECIFIC REMARKS for that SPECIFIC PERSON. Blank/Empty remarks will be filled with the MAIN REMARKS LOCATED OUTSIDE OF THIS POP-UP." style="width: 32%"><i class="fa fa-question-circle"></i> Ind. Remarks</th>
                </tr>
              </thead>
              <tbody id="add_prsnl_tbody">
                <tr>
                  <td> </td>
                  <td>
                    <select class="form-control form-control-sm multi_region_id" name="region[]" onchange="Dms.select_region(this.value, $(this));">
                      <?php
                        foreach ($region as $key => $value) {
                          if($value['rgnnum']==$user_region)
                          {
                            echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                          }
                          else {
                            echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                          }
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select class="form-control form-control-sm multi_division_id" name="division[]" onchange="Dms.select_division(this.value, $(this));" >
                      <option selected value="">--</option>
                      <?php
                        foreach ($division as $key => $value) {
                          echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
                        }
                      ?>
                    </select> <br />
                  </td>
                  <td>
                    <select class="form-control form-control-sm multi_section_id" name="section[]" onchange="Dms.select_section(this.value, $(this));" >
                      <option selected value="">--</option>
                    </select> <br />
                  </td>
                  <td>
                    <select class="form-control form-control-sm multi_personnel_id" name="receiver[]" required>
                      <option selected value="">--</option>
                    </select>
                  </td>
                  <td>
                    <textarea class="form-control form-control-sm multi_remark_id" name="remarks[]"></textarea>
                  </td>
                </tr>
                <tr>
                  <td> </td>
                  <td>
                    <select class="form-control form-control-sm multi_region_id" name="region[]" onchange="Dms.select_region(this.value, $(this));">
                      <?php
                        foreach ($region as $key => $value) {
                          if($value['rgnnum']==$user_region)
                          {
                            echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                          }
                          else {
                            echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                          }
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select class="form-control form-control-sm multi_division_id" name="division[]" onchange="Dms.select_division(this.value, $(this));" >
                      <option selected value="">--</option>
                      <?php
                        foreach ($division as $key => $value) {
                          echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
                        }
                      ?>
                    </select> <br />
                  </td>
                  <td>
                    <select class="form-control form-control-sm multi_section_id" name="section[]" onchange="Dms.select_section(this.value, $(this));" >
                      <option selected value="">--</option>
                    </select> <br />
                  </td>
                  <td>
                    <select class="form-control form-control-sm multi_personnel_id" name="receiver[]" required>
                      <option selected value="">--</option>
                    </select>
                  </td>
                  <td>
                    <textarea class="form-control form-control-sm multi_remark_id" name="remarks[]" ></textarea>
                  </td>
                </tr>
              </tbody>
              <tr id="add_prsnl_tr" style="display: none">
                <td>
                  <button class='btn btn-danger btn-sm waves-effect waves-light' onclick="this.closest('tr').remove();"> - Remove</button>
                </td>
                <td>
                  <select class="form-control form-control-sm multi_region_id" name="region[]" onchange="Dms.select_region(this.value, $(this));">
                    <?php
                      foreach ($region as $key => $value) {
                        if($value['rgnnum']==$user_region)
                        {
                          echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                        }
                        else {
                          echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                        }
                      }
                    ?>
                  </select>
                </td>
                <td>
                  <select class="form-control form-control-sm multi_division_id" name="division[]" onchange="Dms.select_division(this.value, $(this));">
                    <option selected value="">--</option>
                    <?php
                      foreach ($division as $key => $value) {
                        echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
                      }
                    ?>
                  </select> <br />
                </td>
                <td>
                  <select class="form-control form-control-sm multi_section_id" name="section[]" onchange="Dms.select_section(this.value, $(this));">
                    <option selected value="">--</option>
                  </select> <br />
                </td>
                <td>
                  <select class="form-control form-control-sm multi_personnel_id" name="receiver[]" >
                    <option selected value="">--</option>
                  </select>
                </td>
                <td>
                  <textarea class="form-control form-control-sm multi_remark_id" name="remarks[]" ></textarea>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-success" name="add" onclick="Dms.saveSelectedPrsnl()"><i class="fas fa-check-circle"></i> Yes</button>
              <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i> No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
