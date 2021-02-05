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

<!-- View Travel -->
<div class="modal fade" id="view_travel" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">View Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div id="view_travel_body"></div>
        </div>
        <div class="modal-footer"></div>
    </div>
  </div>
</div>
<!-- View Travel -->

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

<!-- Add Ticket Travel -->
<div class="modal fade" id="ticket_travel" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">TRANSPORTATION ORDER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="ticket_travel_body"></div>
    </div>
  </div>
</div>
<!-- Add Ticket Travel -->

<!-- Confirmation Travel -->
<div class="modal fade" id="confirmation_message" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Apply Travel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure to apply Travel Order?</h6></center>
        </div>
        <div class="modal-footer">
          <a href="<?php echo base_url(); ?>Travel/Order/travel_new_trans" style="float:left;" class="btn btn-success btn-sm">Confirm</a>
        </div>
    </div>
  </div>
</div>
<!-- Confirmation Travel -->

<!-- Add Travel Report -->
<div class="modal fade" id="travel_report" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">TRAVEL REPORT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="add_travel_report_body"></div>
    </div>
  </div>
</div>
<!-- Add Travel Report -->
