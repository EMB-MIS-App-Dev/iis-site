<style type="text/css">
  .modal-header {
    background-color: #0B2750;
    color: #FFF;
  }
  .modal-header .close {
    color: #FFF;
  }
  .modal-content {
    border: none;
  }
</style>

<!-- TRANSACTION ADD -->
<div class="modal fade" role="dialog" id="add_transaction_confirm">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          Add Transaction?
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12">
            <button onclick="Dms.add_transaction();" type="button" class="btn btn-primary" name="prcbtn" data-dismiss="modal">Yes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >No</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- TRANSACTION VIEW -->
<div class="modal fade" role="dialog" id="view" style="zoom:90%">
  <div class="modal-dialog modal-lg" style="width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="addTitle"><i class="glyphicon glyphicon-floppy-save">&nbsp;</i>View Transaction</h4>
      </div>
      <div id="prcv">

      </div>
    </div>
  </div>
</div>

<div class="modal fade viewTransactionModal" tabindex="-1" role="dialog" aria-labelledby="viewTransLabel" aria-hidden="true" style="width: 100% !important" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-eye"></i> View Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="view_transaction_modal" class="modal-body">
        - loader -
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
