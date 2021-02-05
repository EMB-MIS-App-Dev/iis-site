<main>
   <style>
   legend {
      font-size: 18px;
      font-weight: bold;
      margin: 0;
      font-family: 'times';
      color: black
   }
   fieldset label {
      color: black;
      font-weight: 650;
   }
   fieldset label:not([for=:empty]) {
      color: red;
   }
   div.box-body {
      padding: 15px 15px;
   }
   div.box-head {
      padding: 3px 0; border-bottom: 3px solid gray;
   }
   .box-head label {
      font-size: 15px;
   }
   </style>

   <div class="col-md-12">
      <div class="card shadow">
         <div class="card-body">

            <?=form_open_multipart('Admin/Pds/Main/submit1')?>
            <fieldset>
               <legend> I. PERSONAL INFORMATION</legend>
               <hr />
               <div class="row no-gutters align-items-center justify-content-md-center">
                  <div class="col-md-10 mr-2">
                     <div class="box-head">
                        <label>Personal Details</label>
                     </div>
                     <div class="box-body">
                        <div class="row">
                           <div class="col-md-3">
                              <label>Surname</label>
                              <input class="form-control form-control-sm" name="surname" required />
                           </div>
                           <div class="col-md-4">
                              <label>First Name</label>
                              <input class="form-control form-control-sm" name="first_name" required />
                           </div>
                           <div class="col-md-3">
                              <label>Middle Name</label>
                              <input class="form-control form-control-sm" name="middle_name" />
                           </div>
                           <div class="col-md-2">
                              <label>Suffix (Jr, Sr, etc.)</label>
                              <input class="form-control form-control-sm" name="name_extension" />
                           </div>
                        </div> <br />
                        <div class="row">
                           <div class="col-md-4">
                              <label>Date of Birth</label>
                              <input class="form-control form-control-sm" type="date" name="date_of_birth" required />
                           </div>
                           <div class="col-md-4">
                              <label>Place of Birth</label>
                              <input class="form-control form-control-sm" type="text" name="place_of_birth" required />
                           </div>
                        </div> <br />
                        <div class="row">
                           <div class="col-md-4">
                              <label>Sex</label> <br />
                              <div class="col-md-12">
                                 <input type="radio" name="sex" value="M" checked required/> Male <br />
                                 <input type="radio" name="sex" value="F" /> Female
                              </div>
                           </div>
                           <div class="col-md-8">
                              <label>Civil Status</label> <br />
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="col-md-3">
                                       <input type="radio" name="civil_status" value="SINGLE" checked required/> Single <br />
                                       <input type="radio" name="civil_status" value="SEPARATED" /> Separated <br />
                                    </div>
                                    <div class="col-md-3">
                                       <input type="radio" name="civil_status" value="MARRIED" /> Married <br />
                                       <input type="radio" name="civil_status" value="WIDOWED" /> Widowed <br />
                                    </div>
                                    <div class="col-md-3">
                                       <input type="radio" name="civil_status" value="OTHERS" /> Others
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> <br />
                        <div class="row">
                           <div class="col-md-4">
                              <label>Height ( in <b>Meters</b> )</label>
                              <div class="input-group input-group-sm mb-3">
                                 <input type="number" class="form-control form-control-sm" name="height" step=".01" required>
                                 <div class="input-group-prepend">
                                    <span class="input-group-text">m</span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label>Weight ( in <b>Kilograms</b> )</label>
                              <div class="input-group input-group-sm mb-3">
                                 <input type="number" class="form-control form-control-sm" name="weight" step=".01" required>
                                 <div class="input-group-prepend">
                                    <span class="input-group-text">kg</span>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Blood Type</label>
                                 <input class="form-control form-control-sm" type="text" name="blood_type" />
                              </div>
                           </div>
                        </div> <br />
                        <div class="row">
                           <div class="col-md-4">
                              <label>Citizenship</label> <br />
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <input id="filipino" type="radio" name="citizenship" value="1" checked required /> Filipino <br />
                                    <input id="dual_citizenship" type="radio" name="citizenship" value="2" /> Dual Citizenship
                                 </div>
                              </div>
                           </div>
                           <div class="dual_citizen col-md-4" style="display: none">
                              <label>If Holder of Dual Citizenship</label> <br />
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <input type="radio" name="has_dual_citizenship" value="1" /> by Birth <br />
                                    <input type="radio" name="has_dual_citizenship" value="2" /> by Naturalization
                                 </div>
                              </div>
                           </div>
                           <div class="dual_citizen col-md-4" style="display: none">
                              <div class="form-group">
                                 <label>Please Indicate Country</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="indicate_country"/>
                              </div>
                           </div>
                        </div> <br />
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Telephone No.</label> <br />
                                 <input class="form-control form-control-sm" type="tel" name="telephone_no" />
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Mobile No.</label> <br />
                                 <input class="form-control form-control-sm" type="tel" name="cellphone_no" />
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>E-mail Address</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="email_address"/>
                              </div>
                           </div>
                        </div>
                     </div> <br />
                     <div class="box-head">
                        <label>Government Issued IDs:</label>
                     </div>
                     <div class="box-body">
                        <div class="row justify-content-md-center">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>GSIS ID No.</label>
                                 <input class="form-control form-control-sm" type="text" name="gsis_id" />
                              </div>
                              <div class="form-group">
                                 <label>Philhealth No</label>
                                 <input class="form-control form-control-sm" type="text" name="philhealth_no" />
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Pag-ibig ID No</label>
                                 <input class="form-control form-control-sm" type="text" name="pag_ibig_id" />
                              </div>
                              <div class="form-group">
                                 <label>TIN No</label>
                                 <input class="form-control form-control-sm" type="text" name="tin_no" />
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>SSS No</label>
                                 <input class="form-control form-control-sm" type="text" name="sss_no" />
                              </div>
                              <div class="form-group">
                                 <label>Agency Employee No</label>
                                 <input class="form-control form-control-sm" type="text" name="agency_employee_no" />
                              </div>
                           </div>
                        </div>
                     </div> <br />
                     <div class="box-head">
                        <label>Residential Address</label>
                     </div>
                     <div class="box-body">
                        <div class="row col-md-12">
                           <div class="form-group">
                              <label>Region</label> <br />
                              <input class="form-control form-control-sm" type="text" name="region" />
                           </div>
                        </div>
                        <div class="row justify-content-md-center">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>House/Block/Lot No.</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="r_house_block_lot_no" />
                              </div>
                              <div class="form-group">
                                 <label>Subdivision/Village</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="r_subdivision_village" />
                              </div>
                              <div class="form-group">
                                 <label>City</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="r_city" />
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Street</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="r_street" />
                              </div>
                              <div class="form-group">
                                 <label>Barangay</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="r_barangay" />
                              </div>
                              <div class="row">
                                 <div class="col-md-9">
                                    <div class="form-group">
                                       <label>Province</label> <br />
                                       <input class="form-control form-control-sm" type="text" name="r_province" />
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>Zip Code</label> <br />
                                       <input class="form-control form-control-sm" type="text" name="r_zip_code" />
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div> <br />
                     <div class="box-head">
                        <label>Permanent Address</label>
                     </div>
                     <div class="box-body">
                        <div >
                           <input type="checkbox" name="permanent_address" /> <label>Same as Residential Address</label>
                        </div><br />
                        <div id="residentialAddressDiv" class="row justify-content-md-center">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>House/Block/Lot No.</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="p_house_block_lot_no" />
                              </div>
                              <div class="form-group">
                                 <label>Subdivision/Village</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="p_subdivision_village" />
                              </div>
                              <div class="form-group">
                                 <label>City</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="p_city" />
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Street</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="p_street" />
                              </div>
                              <div class="form-group">
                                 <label>Barangay</label> <br />
                                 <input class="form-control form-control-sm" type="text" name="p_barangay" />
                              </div>
                              <div class="row">
                                 <div class="col-md-9">
                                    <div class="form-group">
                                       <label>Province</label> <br />
                                       <input class="form-control form-control-sm" type="text" name="p_province" />
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>Zip Code</label> <br />
                                       <input class="form-control form-control-sm" type="text" name="p_zip_code" />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <br />
                  </div>
               </div>
            </fieldset>
            <hr />
            <button class="btn btn-success float-right" type="submit">Submit and Proceed</button>
            <br />
            <?=form_close()?>
         </div>
      </div>
   </div>

</main>

<script>
$(document).ready(function(){
   function citizenship() {
      if($('input[name="citizenship"]:checked').val() == 2) {
         $('div.dual_citizen').show();
      } else {
         $('div.dual_citizen').hide();
      }
   }
   $('input[name="citizenship"]').change( function(){
      citizenship();
   }).change();


   function permanent_address() {
      if($('input[name="permanent_address"]').is(':checked')) {
         $('div#residentialAddressDiv').hide();
      } else {
         $('div#residentialAddressDiv').show();
      }
   }
   $('input[name="permanent_address"]').change( function(){
      permanent_address();
   }).change();
});
</script>
