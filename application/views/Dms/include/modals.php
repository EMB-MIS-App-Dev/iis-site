
<!-- DMS ADD COMPANY -->
<div id="dmsAddCompanyModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Company</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('Dms/Dms/create_transaction'); ?>" method="POST">
        <div class="modal-body">
        </div>
      </form>

    </div>
  </div>
</div>


<!-- TRANSACTION VIEW -->
<div id="viewTransactionModal" class="modal fade" role="dialog" style="zoom:90%">
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
