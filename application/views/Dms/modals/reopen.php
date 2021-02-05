

<!-- TRANSACTION VIEW -->
<div id="reopenTransactionModal" class="modal fade" role="dialog" style="zoom:90%">
  <div class="modal-dialog">
    <form action="<?php echo base_url('Dms/Form_Data_Test/reopenTransaction'); ?>" method="POST">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="addTitle"><i class="glyphicon glyphicon-floppy-save">&nbsp;</i>Re-Open Transaction</h4>
        </div>
        <div id="" class="modal-body">
          <div class="row">
            <div class="mx-auto">
              <span class="set_note">CONFIRM RE-OPENING OF THIS TRANSACTION?</span>
              <div id="reopenTransactionDiv"><textarea name="reopen_enc_tkey" style="display: none"></textarea><span style="text-align:center; color: red"></span></div>
              <div>
                <label>Remarks:</label>
                <textarea class="form-control" name="remarks"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-labeled btn-success float-right"><span class="btn-label"><i class="far fa-check-square"></i></span> <span id="btn_name">ReOpen</span></button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
  $(document).ready(function (){
    $('#reopenTransactionModal button[type="button"]').click( function() {
      let button = $(this);
      button.attr("disabled", true).find('span#btn_name').html('Loading...');
    });
  });
</script>
