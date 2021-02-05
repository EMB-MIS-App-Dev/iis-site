<div class="modal fade" id="clog_confirmation_message" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">New Log</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure to log new client?</h6></center>
        </div>
        <div class="modal-footer">
          <a href="<?php echo base_url(); ?>Logs/Form/new_trans" style="float:left;" class="btn btn-success btn-sm">Confirm</a>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="clog_timeout" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Time out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url()."Logs/Form/timeoutinfo"; ?>" method="post">
        <div class="modal-body" id="timeoutlog_"></div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>
