
<!-- TRANSACTION ADD -->
<div class="modal fade" role="dialog" id="add_transaction_confirm">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Add Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('Dms/Dms/create_transaction'); ?>" method="POST">
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure you want to add a new transaction?</h6></center>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-success" name="create_trans_btn" >Yes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" >No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- TRANSACTION DELETE  -->
<div class="modal fade deleteTransModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Transaction(s)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="multidlte_trans_form" action="<?php echo base_url('Dms/Dms/delete_transaction'); ?>" method="POST">
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure you want to delete this/these transaction(s)?</h6></center>
            <div class="container"></div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-danger" name="delete_trans_btn"><i class="fas fa-check-circle"></i> Yes</button>
              <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i> No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- TRANSACTION SET CONFIDENTIAL STATUS ON / OFF -->
<div class="modal fade confidentialTransModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">SET/UNSET Confidential Transaction(s)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="multiconfidential_trans_form" action="<?php echo base_url('Dms/Dms/confidential_transaction'); ?>" method="POST">
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure you want to set/unset this/these transaction(s)?</h6></center>
            <div class="container"></div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-danger" name="confidential_trans_btn"><i class="fas fa-check-circle"></i> Yes</button>
              <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i> No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- TRANSACTION VIEW -->
<div class="modal fade" role="dialog" id="view" style="zoom:90%">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="addTitle"><i class="glyphicon glyphicon-floppy-save">&nbsp;</i>View Transaction</h4>
      </div>
      <div id="prcv">
        <div class="text-center">
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade viewTransactionModal" tabindex="-1" role="dialog" aria-labelledby="viewTransLabel" aria-hidden="true" style="width: 100% !important" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title">View Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="view_transaction_modal" class="modal-body">
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button id="view_trans_dfbtn" type="button" class="btn btn-secondary mr-auto">Print DF</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Process Travel Order -->
  <div class="modal fade" id="process_travelorder" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="useraccountsModalLabel">Process Travel Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div id="travel-order-modal"></div>
      </div>
    </div>
  </div>
<!-- Process Travel Order -->

<!-- TRANSACTION FILTER -->
<div class="modal fade transFilterModal" tabindex="-1" role="dialog" aria-labelledby="transFilterModal" aria-hidden="true">
  <div class="modal-dialog " >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-filter"></i> Filter Table Option</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="transtable_filter_div">
        <div class="d-flex justify-content-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TRANSACTION RECORDS UPDATE  -->
<div class="modal fade updateRecordsModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Update Records</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('Dms/Dms/update_transrec'); ?>" method="POST">
        <div class="modal-body">
            <center><span class="set_note">- Updating this will remove any previously stated data. Continue? -</span></center>
            <input id="transrec_no" type="hidden" name="transrec_no" value="" readonly/> <br />
            <div style="text-align: center">
              <p>IIS No. to be Updated: </p><span id="transrec_token" style="font-weight: bold"></span>
            </div>
            <div>
              Location : <input class="form-control form-control-sm" name="transrec_location" />
            </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-success btn-lg" name="relocate_transrec"><i class="fas fa-check-circle"></i> Yes</button>
              <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i> No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- LOG COUNT MODAL  -->
<div class="modal fade logCountSectionModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Sections</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          <table id="logcount_modaltb" class="table table-borderless">
          </table>
      </div>

    </div>
  </div>
</div>

<!-- MULTIPLE TRANSACS ROUTED TO ME(USER) MODAL  -->
<div class="modal fade multprcToUserModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Selection Processing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <span>Select One(1) to process:</span> <br>
          <table id="mprctouser_table" class="table table-borderless">

          </table>
      </div>

    </div>
  </div>
</div>

<!-- PLANNING MODALS -->

<!-- PLANNING FILTER -->
<div class="modal fade planningReportFilterModal" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Filter Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br />
      <fieldset id="planning_report_filter">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-borderless">
                <tbody>
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
              <button type="button" class="btn btn-danger" data-dismiss="modal" name="reset"><i class="fas fa-redo-alt"></i> Reset</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" name="filter"><i class="fas fa-filter"></i> Filter</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
            </div>
          </div>
        </div>
      </fieldset>

    </div>
  </div>
</div>
