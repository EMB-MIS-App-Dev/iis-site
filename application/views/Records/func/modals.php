<!-- TRANSACTION FILTER -->
<div class="modal fade filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModal" aria-hidden="true">
  <div class="modal-dialog " >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-filter"></i> Filter Table Option</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td colspan="3">Approved Date Range <hr /></td>
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
            <button id="permitfilter_reset" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-redo-alt"></i> Reset</button>
            <button id="permitfilter" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-filter"></i> Filter</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
