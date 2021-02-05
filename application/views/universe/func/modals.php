
<!-- TRANSACTION ADD PERSONNEL -->
<div class="modal fade accompFilterModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Filter Accomplishments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br />
      <form id="accomp_filter_form" action="<?php echo base_url('Universe/Universe/accomp_filter'); ?>" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-borderless">
                <tbody>
                  <?php if($user_func[0]['func'] == 'Director' || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['userid'] == '111') { ?>
                    <tr>
                      <td>Region</td>
                      <td> : </td>
                      <td>
                        <select class="form-control form-control-sm" name="region" onchange="Universe.select_region(this.value);">
                          <option selected value="">--</option>
                          <?php
                            foreach ($region as $key => $value) {
                              echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                            }
                          ?>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                  <?php if(in_array($user_func[0]['func'], array('Director', 'Regional Director'))  || $_SESSION['userid'] == '111' || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['universe_admin'] == 'yes') { ?>
                    <tr>
                      <td>Division</td>
                      <td> : </td>
                      <td>
                        <select id="division_id" class="form-control form-control-sm" name="division" onchange="Universe.select_division(this.value);" >
                          <option selected value="">--</option>
                          <?php
                            foreach ($division as $key => $value) {
                              echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
                            }
                          ?>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                  <?php if(in_array($user_func[0]['func'], array('Director', 'Regional Director', 'Division Chief')) || $_SESSION['userid'] == '111' || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['universe_admin'] == 'yes') { ?>
                    <tr>
                      <td>Section</td>
                      <td> : </td>
                      <td>
                        <select id="section_id" class="form-control form-control-sm" name="section" onchange="Universe.select_section(this.value);">
                          <option selected value="">--</option>
                          <?php
                            foreach ($section as $key => $value) {
                              echo '<option value="'.$value['secno'].'">'.$value['secname'].'</option>';
                            }
                          ?>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                  <?php if(in_array($user_func[0]['func'], array('Director', 'Regional Director', 'Division Chief')) || $_SESSION['userid'] == '111' || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['universe_admin'] == 'yes') { ?>
                    <tr>
                      <td>Personnel</td>
                      <td> : </td>
                      <td>
                        <select id="personnel_id" class="form-control form-control-sm" name="personnel" >
                          <option selected value="">-</option>
                          <?php
                            // foreach ($personnel as $key => $value) {
                            //   echo '<option value="'.$value['token'].'">'.$value['fname'].' '.$value['mname'][0].'. '.$value['sname'].'</option>';
                            // }
                          ?>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="3">Date Range <hr /></td>
                  </tr>
                  <tr>
                    <td>
                      Start Date: <input class="form-control form-control-sm" type="date" name="start_date" />
                    </td>
                    <td> : </td>
                    <td>
                      End Date: <input class="form-control form-control-sm" type="date" name="end_date" />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-danger" onclick="Universe.accomp_filter('reset')" data-dismiss="modal"><i class="fas fa-redo-alt"></i> Reset</button>
              <button type="button" class="btn btn-primary" onclick="Universe.accomp_filter('filter')" data-dismiss="modal"><i class="fas fa-filter"></i> Filter</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
