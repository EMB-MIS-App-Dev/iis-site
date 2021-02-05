<div class="modal fade addTrainSemAttendedModal" tabindex="-1" role="dialog">asd
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('Pco/Data/add_tsatnded_form')?>">
        <fieldset id="fieldset">
          <div class="modal-body">
            <textarea class="form-control" name="title" placeholder="title"></textarea>
            <textarea class="form-control" name="venue" placeholder="venue"></textarea>
            <input class="form-control" name="conductor" placeholder="conductor" value=""/>
            <input class="form-control" name="date_conducted" placeholder="date_conducted" value=""/>
            <input class="form-control" name="no_hours" placeholder="no_hours" value=""/>
            <input class="form-control" name="cert_no" placeholder="cert_no" value=""/>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="add_ts_attend_btn">Add</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<div class="modal fade editTrainSemAttendedModal" tabindex="-1" role="dialog">123
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('Pco/Data/edit_tsatnded_form')?>" >
        <fieldset>
          <div id="edittsatnd_div" class="modal-body">
            loading..
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="edit_ts_attend_btn">Save changes</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
