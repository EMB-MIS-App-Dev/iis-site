<div class="modal fade" id="add_user_to_chat" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header" style="background-color: #08507E;">
        <h5 class="modal-title" id="useraccountsModalLabel" style="color: #FFF;"><i class="icon-lg fe-users" style="font-size: 12pt!important;">+</i>&nbsp;Add someone to chat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div id="add_user_to_chat_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success btn-sm" onclick="addusertochat($('#employee_msg_selectize').val(),$('#addmsgtoken').val());">Add</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="remove_user_to_chat" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
    <div class="modal-content" style="border: none;">
      <div class="modal-header" style="background-color: #08507E;">
        <h5 class="modal-title" id="useraccountsModalLabel" style="color: #FFF;"><i class="icon-lg fe-users" style="font-size: 12pt!important;">+</i>&nbsp;Remove someone to chat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div id="remove_user_to_chat_body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success btn-sm" onclick="rmvusertochat($('#employeelisted_msg_selectize').val(),$('#rmvmsgtoken').val());">Remove</button>
        </div>
    </div>
  </div>
</div>
