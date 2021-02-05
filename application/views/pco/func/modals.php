
<!-- TRANSACTION ADD -->
<div class="modal fade" role="dialog" id="add_new_confirmation">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm New PCO Application</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('pco/application/new'); ?>" method="POST">
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Add New PCO Application?</h6></center>
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
