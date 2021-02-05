<div class="modal fade systemModal" tabindex="-1" role="dialog" style="zoom:90%">
    <div class="modal-dialog modal-notice" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DMS Data Management - System</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="<?php echo base_url('Dms/Main/settings_system'); ?>" method="POST">
              <div id="system_div" class="modal-body">
                <input type="hidden" name="modal_id" value="1"/>
                <div class="instruction">
                    <div class="row">
                        <div class="col-md-12">
                             <label>System Code:</label>
                             <input class="form-control" name="system_code[]" placeholder="Ex. EEIU" />
                             <br />
                            <label>Name:</label>
                            <input class="form-control" name="name[]" placeholder="Ex. EEIU SYSTEM" />
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer text-center">
                  <button type="submit" class="btn btn-info btn-round" >Save</button>
              </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade subSystemModal" tabindex="-1" role="dialog" style="zoom:90%">
    <div class="modal-dialog modal-notice" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DMS Data Management - Sub-System</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo base_url('Dms/Main/settings_system'); ?>" method="POST">
              <div id="system_div" class="modal-body">
                <input type="hidden" name="modal_id" value="2"/>
                <div class="instruction">
                    <div class="row">
                        <div class="col-md-12">
                           <label>System:</label>
                           <select class="form-control" name="sysid">
                             <?php
                              foreach ($system as $key => $value) {
                                echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                              }
                             ?>
                           </select>
                           <br />
                           <div class="row col-md-12 border">
                             <div class="col-md-6">
                                <label>Header Type:</label>
                                <select class="form-control" name="header[]">
                                  <option value="0" selected>-Not a Header-</option>
                                  <option value="1">-Main Header-</option>
                                </select>
                             </div>
                             <div class="col-md-6">
                               <label>Under What Header:</label>
                               <select class="form-control" name="ssysid[]">
                                 <option value="1" selected>-Under No Header-</option>
                                 <?php
                                  foreach ($sub_system as $key => $value) {
                                    if($value['header'] == 1) {
                                      echo '<option value="'.$value['ssysid'].'">'.$value['name'].'</option>';
                                    }
                                  }
                                 ?>
                               </select>
                             </div>
                             <div class="col-md-12">
                               <label>Name:</label>
                               <input class="form-control" name="name[]" placeholder="Ex. MEMORANDUM" />
                             </div>
                            </div>
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer text-center">
                  <button type="submit" class="btn btn-info btn-round" >Save</button>
              </div>
            </form>
        </div>
    </div>
</div>
