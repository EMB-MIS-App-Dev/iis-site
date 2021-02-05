<style type="text/css">
  #details-style{
    margin-top: 5px;
  }
  label#viewtitle {
    font-size: 9pt;
    font-weight: bold;
  }
  textarea#viewtextarea {
      color: #000;
      font-size: 9pt;
  }
</style>
<?php
  if($to_trans[0]['travel_cat'] == "Yes"){ $travel_cat = "Regional"; }else{ $travel_cat = "National"; }
 ?>
<?php echo form_open(base_url().'Travel/SubmitTicket'); ?>
   <div class="modal-body">
    <div class="row">
        <input type="hidden" name="er_no" value="<?php echo $this->encrypt->encode($to_trans[0]['er_no']); ?>">
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Travel Number:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $to_trans[0]['toid']; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Travel Category:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $travel_cat; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Travel Type:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $to_trans[0]['travel_type']; ?>">
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Issue ticket to:</label>
        <input type="text" class="form-control" value="<?php echo $to_trans[0]['name']; ?>" readonly>
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Expiry Date:</label>
        <input type="date" class="form-control" name="expiry_date" required>
        <span class="error_message" ><?php echo form_error('expiry_date'); ?></span>
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Ticket Office:</label>
        <input type="text" class="form-control" name="ticket_office" placeholder="e.g Philippine Airlines" required>
      </div>
      <div class="col-md-8" id="details-style">
        <label id="viewtitle">Amount in words:</label>
        <input type="text" class="form-control" name="amount" placeholder="e.g Five thousand five hundred" required>
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Amount in figures:</label>
        <input type="text" class="form-control" name="amount_figures" placeholder="e.g 5,500.00" required>
      </div>
    </div>
  </div>
  <div class="modal-footer">
      <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-success btn-sm">Submit</button>
  </div>
</form>
