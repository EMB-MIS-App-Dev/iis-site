<div class="modal fade addWorkExpModal" tabindex="-1" role="dialog">asd
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('Pco/Data/add_workexp_form')?>">
        <fieldset id="fieldset">
          <div class="modal-body">
            <input type="hidden" name="cnt" value=""/>
            <textarea class="form-control" name="company" placeholder="company"></textarea>
            <input class="form-control" name="position" placeholder="position" value=""/>
            <input class="form-control" name="inclusive_date" placeholder="inclusive_date" value=""/>
            <textarea class="form-control" name="employment_status" placeholder="employment_status"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="add_work_exp_btn">Add</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<div class="modal fade editWorkExpModal" tabindex="-1" role="dialog">123
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('Pco/Data/edit_workexp_form')?>" >
        <fieldset>
          <div id="editwrkxp_div" class="modal-body">
            loading..
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="edit_work_exp_btn">Save changes</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
