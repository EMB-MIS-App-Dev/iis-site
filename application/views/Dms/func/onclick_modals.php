
<!-- TRANSACTION FILTER -->
<?php if($modal == 'dms_filter') { ?>

  <form id="transtable_filter_form" action="<?php echo base_url('Dms/Dms/transtable_filter'); ?>" method="POST">
    <div class="modal-body">
      <div class="col-md-12">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th style="width: 50%" rowspan="2">SORT BY:</th>
              <th></th>
              <th style="width: 50%">Selection:</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Company</td>
              <td>:</td>
              <td>
                <select class="form-control form-control-sm" name="filter_company">
                  <option selected value="">--</option>
                  <?php
                    foreach ($fltr_comp as $key => $value) {
                      if($value['token'] == $trans_filter['fltr_comp']) {
                        echo '<option selected value="'.$value['token'].'">'.$value['company_name'].'</option>';
                      }
                      else {
                        echo '<option value="'.$value['token'].'">'.$value['company_name'].'</option>';
                      }
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>Transaction Type</td>
              <td>:</td>
              <td>
                <select class="form-control form-control-lg" onchange="Dms.system_select(this.value);">
                  <option selected value="">- system -</option>
                  <?php
                    foreach ($fltr_systm as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                    }
                  ?>
                </select>
                <br />
                <select id="type" class="form-control form-control-lg" name="filter_transtype">
                  <option selected value="">- sub-system -</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Status</td>
              <td>:</td>
              <td>
                <select class="form-control form-control-sm" name="filter_status">
                  <option selected value="">--</option>
                  <?php
                    foreach ($fltr_stat as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                    }
                  ?>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-danger" onclick="Dms.transtable_filter('reset')" data-dismiss="modal"><i class="fas fa-redo-alt"></i> Reset</button>
          <button type="button" class="btn btn-primary" onclick="Dms.transtable_filter('filter')" data-dismiss="modal"><i class="fas fa-filter"></i> Filter</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
  </form>

  <script>
    $('select[name="filter_company"]').selectize({
      onChange: function(value, isOnInitialize) {
        console.log("Selectize event: Change");
      }
    });
    $('select[name="filter_status"]').selectize({
      onChange: function(value, isOnInitialize) {
        console.log("Selectize event: Change");
      }
    });
  </script>

<?php } ?>
