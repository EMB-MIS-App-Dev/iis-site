
  <div class="col-lg-12">
    <div class="card-body">
      <br>
      <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'other_req_form')); ?>

        <div class="row">
          <div class="col-md-12 card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary" align="center">ORDER OF PAYMENT</h6>
            </div>
            <div class="card-body">
              <fieldset>
                <div class="row float-right">
                  <span class="reqfields"> Please fill-out the required fields *. </span><br>
                </div> <br>
                <hr />
                  <label>Payment Information</label>
                <hr />
                <div>
                <span style="font-size: 14px; color: red">
                  * Download the Order of Payment and print three(3) copies. Then present the Order of Payment to the EMB Cashier and pay the assessed amount. Go back to this site and update the information below. Also, take a picture of the Order of Payment and attach it, then click "SUBMIT". <br>
                  ** If payment has been done, disregard the downloading and printing of Order of Payment and proceed to filling up of fields and attachment of receipt.
                </span>
                <hr> <br>

                <div class="col-md-8 offset-md-2">
                  <a href="orderpay.php" target="_blank"><button type="button" class="form-control btn btn-info"> <i class="fas fa-download"></i> Download Order of Payment</button></a>
                </div><br> <hr>
                <div class="row">

                  <div class="col-md-4">
                    <label>OR No.: <span> * </span> </label>
                    <input class="form-control" type="text" name="orno" required>
                  </div>
                  <div class="col-md-4">
                    <label>Amount: <span> * </span> </label>
                    <input class="form-control" type="text" name="amnt" required>
                  </div>
                  <div class="col-md-4">
                    <label>Date of Payment: <span> * </span> </label>
                    <input class="form-control" type="date" name="dat" required>
                  </div>
                </div> <br><br>

                <hr />
                  <label>Attachment</label>
                <hr />

                </div>
                <span style="font-size: 14px; color: red">
                  * Please attach the listed files below. (pdf / image files only)
                </span> <br><br>
                <div class="row">
                  <div class="col-md-3 offset-md-1">
                    <label>Attach Files Here: <span> * </span> </label>
                    <input class="form-control" type="file" name="orpd" accept="image/*, application/pdf" required>
                  </div>
                  <div class="col-md-6 ">
                    <label>Attachment Description:</label>
                    <input type="text" class="form-control" value="Order of Payment (Paid) *" readonly>
                  </div>
                </div> <br>
                <div class="row">
                  <div class="col-md-3 offset-md-1">
                    <input class="form-control" type="file" name="ofrec" accept="image/*, application/pdf" required>
                  </div>
                  <div class="col-md-6 ">
                    <input type="text" class="form-control" value="Official Receipt *" readonly>
                  </div>
                </div> <br> <br>
              </fieldset>
              <!-- Improvised Card Footer -->
              <hr />
              <div class="col-md-12">
                <button id="pco_submit" type="submit" class="btn btn-success float-right" name="pco_payment" ><i class="fas fa-save"></i> SAVE</button>
              </div>
              <br /><br />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
