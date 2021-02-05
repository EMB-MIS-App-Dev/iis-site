<!-- for disapproving client request modal -->
<div class="modal fade" id="disapprove_client_request" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">DISAPPROVE CLIENT ESTABLISHMENT REQUEST</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url('Company/Disapprove/disaprove_client_request'); ?>" method="post">
      <div class="modal-body">
          <input type="hidden" name="req_id" value="" id="userreqid">
          <input type="hidden" name="email" value="" id="useremail">
          <input type="hidden" name="reqtoken" value="" id="reqtokenid">
          <textarea name="reason" rows="8" cols="80"></textarea>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >SUBMIT</button>
      </div>
          </form>
    </div>
  </div>
</div>
<!-- end modal -->
<!-- for disapproving ficility request modal -->
<div class="modal fade" id="disapprove_ficility" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">DISAPPROVE CLIENT ESTABLISHMENT REQUEST</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url('Company/Disapprove/disaprove_facility'); ?>" method="post">
      <div class="modal-body">
          <input type="hidden" name="req_id" value="" id="req_id">
          <textarea name="reasonfacility" rows="8" cols="80"></textarea>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >SUBMIT</button>
      </div>
          </form>
    </div>
  </div>
</div>
<!-- end modal -->
<!-- for viewing company modal -->
<div class="modal fade" id="comp_edit_data" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">EDIT COMPANY DATA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="">
        <h1 style="text-align:center">UNDER DEVELOPMENT</h1>
      </div>
      <!-- <div id="edi_company_container">

      </div> -->
    </div>
  </div>
</div>

<!-- for adding client as user  -->

<div class="modal fade add_client_data" id="add_client_data" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#018E7F;">
          <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">ADD CLIENT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="" action="<?php echo base_url('Company/Company_list/add_client_as_user_per_company'); ?>" method="post">


          <div class="modal-body" >
            <div class="" id="add_client_as_user"></div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >Save</button>
          </div>
          </form>
    </div>
  </div>
</div>
<!-- client request details -->
<div class="modal fade" id="user_id_attch" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">CLIENT DETAILS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form name="emb_assign_requested_comp" id="emb_assign_requested_comp_id" class="" action="<?php echo base_url('Company/Company_list/emb_assign_requested_comp'); ?>" method="post">
            <input type="hidden" name="req_id" value="" id="view_client_est_id">
            <div class="modal-body" >
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                <div class="" id="user_attch_govid" ></div>
                <h7 >GOVERNMENT ID:</h7>
              </div>
              <div class="col-md-6">
                <div class="" id="user_attch_compid" ></div>
                <h7 >COMPANY ID:</h7>
              </div>
          </div>
        </div>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                  <h7 >FIRST NAME:</h7>
                <input type="text" name=""  id="requ_fname" value="" class="form-control" readonly>
              </div>
              <div class="col-md-6">
                  <h7 >LAST NAME:</h7>
                <input type="text" name=""  id="requ_lname" value="" class="form-control" readonly>
              </div>
          </div>
        </div>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                  <h7 >CONTACT NO:</h7>
                <input type="text" name=""  id="requ_cont" value="" class="form-control" readonly>
              </div>
              <div class="col-md-6">
                  <h7 >POSITION:</h7>
                <input type="text" name=""  id="requ_position" value="" class="form-control" readonly>
              </div>
          </div>
        </div>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                  <h7 >REGION:</h7>
                <input type="text" name=""  id="requ_region" value="" class="form-control" readonly>
              </div>
              <div class="col-md-6">
                  <h7 >EMAIL:</h7>
                <input type="text" name=""  id="requ_email" value="" class="form-control" readonly>
              </div>
          </div>
        </div>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
              </div>
              <div class="col-md-6">
                  <h7 >AUTHORIZATION LETTER:<div class="" id="authorization_letter_id" style="display:inline-block"></div></h7>

              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id='approved_ext_requested_establishment'>Approved Request</button>
        <button data-toggle='modal' data-target='#disapprove_client_request' type="button" class="btn btn-danger btn-icon-split" style="float: right;"><span class="text">DISAPPROVED</span></button>
      </div>
        </form>
  </div>
</div>
</div>

<div class="modal fade bd-example-modal-lg" id="company-details-modal" tabindex="-1" role="dialog" aria-labelledby="company-details-modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-top modal-lg" role="document"  style="width: 1500px!important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">COMPANY DETAILS</h5>
      </div>
      <form class="" action="<?php echo base_url('Company/Company_list/emb_assign_existing_comp'); ?>" method="post">
        <input type="text" name="company_id" value="" id="company_id">
        <input type="text" name="user_id" value="" id="user_id">
        <input type="text" name="facility_id" value="" id="facility_id">
        <div class="modal-body" id="company_details_id">
          <div class="row">

            <div class="col-md-12">
              <label for="">COMPANY NAME</label>
              <input type="text" name="" value="" class="form-control"  id="company_details_name">
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="">REGION:</label>
              <input type="text" name="" value="" class="form-control"  id="company_details_region">
            </div>
            <div class="col-md-3">
              <label for="">PROVINCE:</label>
              <input type="text" name="" value="" class="form-control"  id="company_details_province">
            </div>
            <div class="col-md-3">
              <label for="">CITY:</label>
              <input type="text" name="" value="" class="form-control"  id="company_details_city">
            </div>
            <div class="col-md-3">
              <label for="">BRGY:</label>
              <input type="text" name="" value="" class="form-control"  id="company_details_brgy">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="">STREET:</label>
              <input type="text" name="" value=""  class="form-control"  id="company_details_street">
            </div>
          </div>
        </div>
        <input type="hidden" name="company_token" value="" id="company_details_company_id">
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
          <button type="submit" class="btn btn-primary" name="save_client_req_btn">SUBMIT REQUEST</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- for disapproving client request modal -->
<div class="modal fade" id="view_disapprove_client_request" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog" role="document" style="max-width: 677px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">VIEW DISAPPROVED REASON</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url('Company/Disapprove/disaprove_client_request'); ?>" method="post">
      <div class="modal-body">
          <p id="view_disapprove_client_request_reason">sample</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
          </form>
    </div>
  </div>
</div>
<!-- for disapproving ficility request modal -->
<div class="modal fade" id="add_requested_company_option_update" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">COMPANY AFFILLIATION OPTION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Company/Company_list/emb_assign_existing_comp" method="post">
      <div class="modal-body">
      <div class="col-md-12">
          <div class="row">
            <!-- <h1>UNDER DEVELOPMENT</h1> -->
            <input type="hidden" name="req_id" value="<?= $this->encrypt->encode($_GET['req_id']) ?>">
            <input type="hidden" name="est_data" value="" id="selected_registered_est">
            <span>Note: <span id='assign_selected_company_affiliation'></span> will be udpdated base on the option that will be selected below.</span>
            <select class="form-control" name="company_req_update_option">
              <option value="" selected disabled>----</option>
              <option value="1">INPUTED FROM CLIENT</option>
              <option value="2">INPUTED FROM EMB</option>
            </select>
          </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >SUBMIT</button>
      </div>
          </form>
    </div>
  </div>
</div>



<style media="screen">
#user_attch_govid img {
   max-height: 385px;
    min-height: 383px;
    min-width: 450px;
    max-width: 450px;
}

#user_attch_compid img {
  max-height: 450px;
    min-height: 383px;
    min-width: 450px;
    max-width: 450px;
}
</style>
