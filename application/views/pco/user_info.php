
  <div class="col-lg-12">
    <div class="card-body">
      <?php echo $step_header; ?>
      <br />
        <div class="row">

          <div class="col-md-12 card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
              <div>
                <h6 class="m-0 font-weight-bold text-primary" align="center">BASIC INFORMATION</h6>
              </div>
            </div>
            <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'user_info_form')); ?>

              <?php echo validation_errors(); ?>
              <div class="card-body">
                <fieldset id="fieldset">
                  <div class="row float-right">
                    <span class="set_note"> Please fill-out the required fields indicated with ( <span class="set_error">*</span> ). </span><br>
                  </div>
                  <br>
                  <div>
                    <hr>
                    <label>User Profile</label>
                    <hr>
                    <div class="row smlab">
                      <div class="col-md-3">
                        <label>Lastname <span> * </span> </label>
                        <input type="text" class="form-control" name="last_name" value="<?=trim(!empty(set_value('last_name')) ? set_value('last_name') : $user_info[0]['last_name'])?>" autofocus >
                      </div>
                      <div class="col-md-3">
                        <label>Firstname <span> * </span> </label>
                        <input type="text" class="form-control" name="first_name" value="<?=(!empty(set_value('first_name')) ? set_value('first_name') : $user_info[0]['first_name'])?>" >
                      </div>

                      <div class="col-md-3">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" value="<?=(!empty(set_value('middle_name')) ? set_value('middle_name') : $user_info[0]['middle_name'])?>" >
                      </div>

                      <div class="col-md-3">
                        <label>Suffix( ex. Jr., Sr., III, etc. )</label>
                        <input type="text" class="form-control" name="suffix" value="<?=(!empty(set_value('suffix')) ? set_value('suffix') : $user_info[0]['suffix'])?>" >
                      </div>
                    </div> <br>

                    <div class="row">
                      <div class="col-md-4">
                        <label>Sex: <span> * </span> </label>
                        <?php
                          if(!empty(set_radio('sex', '0')) || !empty(set_radio('sex', '1'))) {
                            $sex_m_check = '';
                            $sex_f_check = '';
                          }
                          else {
                            $sex_m_check = $sex_m_check;
                            $sex_f_check = $sex_f_check;
                          }
                        ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="custom-control custom-radio">
                              <input type="radio" id="male_radio" name="sex" class="custom-control-input" value="0" <?=set_radio('sex', '0').' '.$sex_m_check?> >
                              <label class="custom-control-label" for="male_radio">Male</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="custom-control custom-radio">
                              <input type="radio" id="female_radio" name="sex" class="custom-control-input" value="1" <?=set_radio('sex', '1').' '.$sex_f_check?> >
                              <label class="custom-control-label" for="female_radio">Female</label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label>Citizenship: <span> * </span> </label>
                        <input class="form-control" type="text" name="citizenship" value="<?=(!empty(set_value('citizenship')) ? set_value('citizenship') : $user_info[0]['citizenship'])?>" ><br>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <label>Telephone No: </label>
                        <input class="form-control" type="text" name="tel_no" value="<?=(!empty(set_value('tel_no')) ? set_value('tel_no') : $user_info[0]['tel_no'])?>"><br>
                      </div>
                      <div class="col-md-4">
                        <label>Cellphone No: <span> * </span> </label>
                        <input class="form-control" type="text" name="cel_no" value="<?=(!empty(set_value('cel_no')) ? set_value('cel_no') : $user_info[0]['cel_no'])?>" ><br>
                      </div>
                      <div class="col-md-4">
                        <label>Email: <span> * </span> </label>
                        <input class="form-control" type="text" name="email" value="<?=(!empty(set_value('email')) ? set_value('email') : $user_info[0]['email'])?>" ><br>
                      </div>
                    </div>

                    <hr>
                    <label>Employment Details</label>
                    <hr>
                    <div class="row">
                      <div class="col-md-4">
                        <label>Employment Status: <span> * </span> </label>
                        <?php
                          if(!empty(set_radio('employment_status', '1')) || !empty(set_radio('employment_status', '0'))) {
                            $stat_f_check = '';
                            $stat_o_check = '';
                          }
                          else {
                            $stat_f_check = $stat_f_check;
                            $stat_o_check = $stat_o_check;
                          }
                        ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="ftime_radio" name="employment_status" value="1" <?=set_radio('employment_status', '1').' '.$stat_f_check?> >
                              <label class="custom-control-label" for="ftime_radio">Full-Time</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="otime_radio" name="employment_status" value="0" <?=set_radio('employment_status', '0').' '.$stat_o_check?> >
                              <label class="custom-control-label" for="otime_radio">Others</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <br>

                    <div class="row">
                      <div class="col-md-7">
                        <label>Current Position: <span> * </span> </label>
                        <input class="form-control" type="text" name="position" value="<?=(!empty(set_value('position')) ? set_value('position') : $user_info[0]['position'])?>" ><br> <!-- 10 - PCO -->
                      </div>
                      <div class="col-md-5">
                        <label>No. of Years in Current Position: <span> * </span> </label>
                        <input class="form-control" type="number" name="years_in_position" min="0" value="<?=(!empty(set_value('years_in_position')) ? set_value('years_in_position') : $user_info[0]['years_in_position'])?>" ><br>
                      </div>
                    </div>

                    <hr>
                    <label>Home Address</label>
                    <hr>
                    <div class="address-selections">

                      <div class="row smlab">
                        <div class="col-md-6">
                          <label>Region <span> * </span> </label>
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
                          <select class="form-control province-select" name="prov_id" data-selected="<?=(!empty($user_info[0]['prov_id']) ? $user_info[0]['prov_id'] : (!empty(set_value('prov_id')) ? set_value('prov_id') : 0))?>" ></select><br>
                        </div>
                        <div class="col-md-4">
                          <label>City <span> * </span> </label>
                          <select class="form-control city-select" name="city_id" data-selected="<?=(!empty($user_info[0]['city_id']) ? $user_info[0]['city_id'] : (!empty(set_value('city_id')) ? set_value('city_id') : 0))?>" ></select><br>
                        </div>
                        <div class="col-md-4">
                          <label>Barangay <span> * </span> </label>
                          <select class="form-control barangay-select" name="brgy_id" data-selected="<?=(!empty($user_info[0]['brgy_id']) ? $user_info[0]['brgy_id'] : (!empty(set_value('brgy_id')) ? set_value('brgy_id') : 0))?>" ></select><br>
                        </div>
                      </div>

                      <div class="row smlab">
                        <div class="col-md-8">
                          <label>House No. & Street Name </label>
                          <input class="form-control" type="text" name="hsno_street" value="" ><br>
                        </div>
                        <div class="col-md-4">
                          <label>Zip Code <span> * </span> </label>
                          <input class="form-control" type="text" name="zip_code" value="<?=(!empty(set_value('zip_code')) ? set_value('zip_code') : $user_info[0]['zip_code'])?>" ><br>
                        </div>
                      </div>

                    </div>

                  </div>
                </fieldset>
                <!-- Improvised Card Footer -->
                <hr />
                <div class="col-md-12">
                  <button id="pco_submit" type="submit" class="btn btn-success float-right" name="user_info" ><i class="fas fa-save"></i> SAVE</button>
                </div>
                <br /><br />
              </div>

            </form>
          </div>

        </div>
    </div>
  </div>
