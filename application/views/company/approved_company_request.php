<!-- Begin Page Content -->
  <div class="container-fluid">


    <!-- Content Row -->


    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->

          <!-- Card Body -->
          <div class="card-header">
              <div class="col-md-12"  style="margin-bottom: 9px;">
                <div class="row">
                  <div class="col-md-6">
                      <span style="color:green">APPROVED CLIENT ESTABLISHMENT REQUESTS</span> |
                        <a target="_blank" href="<?php echo base_url(); ?>uploads/STEPS ON HOW TO APPROVED REQUESTED COMPANIES (EMB PERSONNEL) IN IIS.pdf">USER MANUAL <i class="fa fa-book" aria-hidden="true"></i></a>
                  </div>
                </div>
            </div>


          </div>
            <div class="card-body">
              <table class="table table-hover" id="approved_client_request" cellspacing="0">
                <thead>
                  <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Emb id</th>
                    <th>Establishment</th>
                    <th>Approved by</th>
                    <th>Date submitted</th>
                    <th>Date approved</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

        </div>
      </div>
    </div>


    <div class="modal fade" id="unbind_est_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
          <div class="modal-header" style="background-color:#018E7F;">
            <h5 class="modal-title" style="color:#FFF;" >Binding Establishment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="" id="resubmit_smr_msg" style="font-size: 11px;"></div>
                  <div class="col-md-12">
                    <label for="selected_est_name"> Establishment Name:  <span class="binded_client_data" id="selected_est_name"></span></label>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="current_binded_client">Current Client: <span class="binded_client_data" id="current_binded_client"></span></label>
                      </div>
                      <div class="col-md-6">
                        <label for="current_binded_client">Email:  <span class="binded_client_data" id="current_binded_client_email"></span></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12" style="border-top:solid #808080 1px">
                      <label for="">Note: To bind this establishment to a new Client, select new in the list below.</label>
                  </div>
                  <hr>
                  <input type="hidden" name="" value="" id="apr_est_id">
                  <div class="col-md-12">
                    <select class="form-control" name="" id="client_list">
                      <option value="" selected disabled>---Client list---</option>
                      <?php foreach ($user_list as $key => $uval): ?>
                            <option value="<?=$uval['client_id'] ?>"><?=$uval['first_name'].' '.$uval['last_name'].' - '.$uval['email'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

              </div>
          </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="rebind_new_client()">Bind</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>
    <style media="screen">
        div.dataTables_wrapper div.dataTables_processing {
         top: 5%;
        }
        th { font-size: 12px; }
        td { font-size: 11px; }
        .binded_client_data{
          background: gray;
    color: black;
    font-size: 14px;
    font-weight: 700;
        }
    </style>
    <script type="text/javascript">
    var userid =  '<?= $this->session->userdata('userid'); ?>';
    // console.log(userid);
    var table2 = $('#approved_client_request').DataTable({
      responsive: true,
      paging: true,
      destroy:true,
      deferRender: true,
      // searching: false,
      lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
      pageLength: 50,
      // recordsTotal: 10,
      processing: true,
      language: {
        "infoFiltered": "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
      },
      "serverSide": true,
    "ordering": false,
      "ajax": "<?php echo base_url(); ?>Company/Serverside/client_binded_companies",
      "columns": [
        { "data": "first_name","searchable": true},
        { "data": "last_name","searchable": true},
        { "data": 'email',"searchable": true},
        { "data": "emb_id","searchable": true},
        { "data": "company_name","searchable": true},
        { "data": 'approved_by',"searchable": true},
        { "data": 'date_submitted',"searchable": true},
        { "data": 'date_approved',"searchable": true},
        {
          // className: "btn-group",
          "data": null,
              "render": function(data, type, row, meta){
                console.log(userid);
                if (userid == '157') {
                    data = "<a onClick='resend_hwms_email("+row['client_req_id']+")'  style='color:#08507E;cursor:pointer' title='resend HWMS credentials' ><i class='fa fa-paper-plane' aria-hidden='true'></i></a> | <a onClick='unbind_est_client("+row['client_req_id']+",this)'  style='color:red;cursor:pointer' title='unbind establishment' ><i class='fas fa-user-slash'></i></a>";
                }else {
                  data = "<a onClick='resend_hwms_email("+row['client_req_id']+")'  style='color:#000;cursor:pointer' title='resend HWMS credentials' ><i class='fa fa-paper-plane' aria-hidden='true'></i></a>";

              }
                return data;
          },
        },
      ]
    });
    // $(document).ready(function(){
    //   $('#client_list').selectize();
    // })
    </script>
