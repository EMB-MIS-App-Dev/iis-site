<div class="modal fade addEducAttainModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('Pco/Data/add_estdetails_form')?>" id="estdetailsform">
        <fieldset id="fieldset">
          <div class="modal-body">
            <input class="form-control" name="school" placeholder="school"/>
            <input class="form-control" name="inclusive_date" placeholder="inclusive_date"/>
            <input class="form-control" name="degree_units_earned" placeholder="degree_units_earned"/>
            <textarea class="form-control" name="address"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="add_est_details_btn">Add</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<div class="modal fade editEducAttainModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('Pco/Data/edit_estdetails_form')?>" id="editestdetailsform">
        <fieldset>
          <div id="editeducatn_div" class="modal-body">
            loading..
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="edit_est_details_btn">Save changes</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
