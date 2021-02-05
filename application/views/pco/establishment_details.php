
  <div class="col-lg-12">
    <div class="card-body">
      <?php echo $step_header; ?>
      <br>
      <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'establishment_details_form')); ?>

        <?php echo validation_errors(); ?>
        <div class="row">
          <div class="col-md-12 card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
              <div>
                <h6 class="m-0 font-weight-bold text-primary" align="center">ESTABLISHMENT DETAILS</h6>
              </div>
            </div>
            <div class="card-body">
              <fieldset>
                <div class="row float-right">
                  <span class="set_note"> Please fill-out the required fields indicated with ( <span class="set_error">*</span> ). </span><br>
                </div>
                <br>
                <div>
                  <hr>
                  <label>Managing Head</label>
                  <hr>
                  <div class="row smlab">
                    <div class="col-md-3">
                      <label>Lastname <span> * </span> </label>
                      <input type="text" class="form-control" name="last_name" value="<?=trim(!empty(set_value('last_name')) ? set_value('last_name') : $establishment_details[0]['last_name'])?>" autofocus >
                    </div>
                    <div class="col-md-3">
                      <label>Firstname <span> * </span> </label>
                      <input type="text" class="form-control" name="first_name" value="<?=(!empty(set_value('first_name')) ? set_value('first_name') : $establishment_details[0]['first_name'])?>" >
                    </div>

                    <div class="col-md-3">
                      <label>Middle Name</label>
                      <input type="text" class="form-control" name="middle_name" value="<?=(!empty(set_value('middle_name')) ? set_value('middle_name') : $establishment_details[0]['middle_name'])?>" >
                    </div>

                    <div class="col-md-3">
                      <label>Suffix( ex. Jr., Sr., III, etc. )</label>
                      <input type="text" class="form-control" name="suffix" value="<?=(!empty(set_value('suffix')) ? set_value('suffix') : $establishment_details[0]['suffix'])?>" >
                    </div>
                  </div> <br />


                  <hr>
                  <label>Establishment Details</label>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <label>Name of Establishment: <span> * </span> </label>
                      <textarea class="form-control" name="establishment_name" ><?=trim((!empty(set_value('establishment_name')) ? set_value('establishment_name') : $establishment_details[0]['establishment_name']))?></textarea>
                    </div>
                    <div class="col-md-6">
                      <label>Nature of Business: <span> * </span> </label>
                      <textarea class="form-control" name="nature_of_business" ><?=trim((!empty(set_value('nature_of_business')) ? set_value('nature_of_business') : $establishment_details[0]['nature_of_business']))?></textarea>
                    </div>
                  </div> <br>

                  <div class="row">
                    <div class="col-md-5">
                      <label>Establishment Category based on DAO 2014-02: <span> * </span> </label>
                      <select class="form-control" name="establishment_category" >

                        <?php
                          if(!empty(set_radio('establishment_category', '1')) || !empty(set_radio('establishment_category', '2'))) {
                            $category_a = '';
                            $category_b = '';
                          }
                          else {
                            $category_a = $category_a;
                            $category_b = $category_b;
                          }
                        ?>
                        <option value="" selected>-select an option-</option>
                        <option value="1" <?=set_select('establishment_category', '1').' '.$category_a?> >Category A</option>
                        <option value="2" <?=set_select('establishment_category', '2').' '.$category_b?> >Category B</option>
                      </select>
                    </div>
                    <div class="col-md-1">
                      <label>Reference:</label> <br>
                      <a href="<?php echo base_url('uploads/requirements/dao-2014-02.pdf');?>" target="_blank"><button type="button" class="form-control btn btn-primary" title="VIEW"> <i class="far fa-eye"></i> </button></a>
                    </div>
                  </div> <br>

                  <div class="row">
                    <div class="col-md-4">
                      <label>Telephone No.: <span> * </span> </label>
                      <input class="form-control" type="text" name="tel_no" value="<?=(!empty(set_value('tel_no')) ? set_value('tel_no') : $establishment_details[0]['tel_no'])?>" >
                    </div>
                    <div class="col-md-4">
                      <label>Fax No.: <span> * </span> </label>
                      <input class="form-control" type="text" name="fax_no" value="<?=(!empty(set_value('fax_no')) ? set_value('fax_no') : $establishment_details[0]['fax_no'])?>" >
                    </div>
                    <div class="col-md-4">
                      <label>Website: </label>
                      <input class="form-control" type="text" name="website" value="<?=(!empty(set_value('website')) ? set_value('website') : $establishment_details[0]['website'])?>">
                    </div>
                  </div> <br>

                  <hr>
                  <label>Establishment Address Where the PCO is assigned</label>
                  <hr>
                  <div class="address-selections">

                    <div class="row smlab">
                      <div class="col-md-6">
                        <label>Region <span> * </span> </label>
                        <?php ; ?>
                        <select class="form-control region-select" name="region_id" data-selected="<?=(!empty($user_info[0]['region_id']) ? $user_info[0]['region_id'] : 0)?>">
                          <?php
                            foreach ($get_region as $key => $value) {
                              if(!empty($user_info[0]['region_id']) && $user_info[0]['region_id'] == $value['rgnid']) {
                                echo '<option value="'.$value['rgnid'].'" selected>'.$value['rgnnam'].'</option>';
                              }
                              else {
                                echo '<option value="'.$value['rgnid'].'">'.$value['rgnnam'].'</option>';
                              }
                            }
                          ?>
                        </select><br>
                      </div>
                    </div>

                    <div class="row smlab">
                      <div class="col-md-4">
                        <label>Province <span> * </span> </label>
                        <select class="form-control province-select" name="prov_id" data-selected="<?=(!empty($user_info[0]['prov_id']) ? $user_info[0]['prov_id'] : 0)?>" ></select><br>
                      </div>
                      <div class="col-md-4">
                        <label>City <span> * </span> </label>
                        <select class="form-control city-select" name="city_id" data-selected="<?=(!empty($user_info[0]['city_id']) ? $user_info[0]['city_id'] : 0)?>" ></select><br>
                      </div>
                      <div class="col-md-4">
                        <label>Barangay <span> * </span> </label>
                        <select class="form-control barangay-select" name="brgy_id" data-selected="<?=(!empty($user_info[0]['brgy_id']) ? $user_info[0]['brgy_id'] : 0)?>" ></select><br>
                      </div>
                    </div>
                    <div class="row smlab">
                      <div class="col-md-8">
                        <label>House No. & Street Name </label>
                        <input class="form-control" type="text" name="hsno_street" value="" ><br>
                      </div>
                      <div class="col-md-4">
                        <label>Zip Code <span> * </span> </label>
                        <input class="form-control" type="text" name="zip_code" value="<?=(!empty(set_value('zip_code')) ? set_value('zip_code') : $establishment_details[0]['zip_code'])?>" ><br>
                      </div>
                    </div>

                  </div>

                </div>
              </fieldset>
              <!-- Improvised Card Footer -->
              <hr />
              <div class="col-md-12">
                <button id="pco_submit" type="submit" class="btn btn-success float-right" name="est_details"><i class="fas fa-save"></i> SAVE</button>
              </div>
              <br /><br />
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
