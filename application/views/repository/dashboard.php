<style media="screen">
  ul.dropdown-menu.action.show {
    transform: translate3d(-101px, 26px, 0px)!important;
  }
</style>
<div class="container-fluid">
  <div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><span class="fa fa-file"></span> IIS TRANSACTIONS WITH QR CODE</h6>
            <!-- <a href="#" data-toggle='modal' style="float:right;" data-target='#deposit_file_modal' onclick=frfldpfnc('<?= $this->encrypt->encode($this->session->userdata('userid')); ?>'); class="btn btn-success btn-sm"><i class="fas fa-plus"></i>&nbsp;Store Files</a> -->
        </div>
        <!-- Card Body -->
          <div class="card-body" id="table-responsive">
            <table id="table_repository" class="table table-hover table-responsive-custom" width="100%" cellspacing="0" style="zoom:80%;">
              <thead>
                <tr>
                  <th> IIS No. </th>
                  <th> Company Name </th>
                  <th> EMB ID </th>
                  <th> Subject </th>
                  <th> Transaction Type </th>
                  <th> Status </th>
                  <th> Sender Name </th>
                  <th> Time/Date Forwarded </th>
                  <th> Receiver Name </th>
                  <th> token </th>
                  <th> QR Code </th>
                  <th> Action </th>
                </tr>
              </thead>
            </table>
          </div>
        <!-- Card Body -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      var table = $('#table_repository').DataTable({
          responsive: true,
          paging: true,
          language: {
            infoFiltered: "",
            processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
          },
          processing: true,
          "serverSide": true,
          "order": [[ 0, "desc"]],
          "ajax": "<?php echo base_url(); ?>Repository/Serverside",
          "scrollX":true,
          "columns": [
            { "data": "token","searchable": true},
            { "data": "company_name","searchable": true},
            { "data": "emb_id","searchable": true},
            { "data": "subject","searchable": true},
            { "data": "type_description","searchable": true},
            { "data": "status_description","searchable": true},
            { "data": "sender_name","searchable": true},
            { "data": "date_out","searchable": true},
            { "data": "receiver_name","searchable": true},
            { "data": "qr_code_token","visible": false},
            {
              "data": null,"visible": false,
                "render": function(data, type, row, meta){
                    var qr_code = "iis.emb.gov.ph/verify?token="+row['token'];
                    data = '  <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2F'+qr_code+'%2F&choe=UTF-8" style="width:100px;">';
                    // data += "<button class='btn btn-danger btn-sm' href='#' data-toggle='modal' data-target='#Remove_esig' onclick=Remove_esig_btn('"+row['userid']+"')>Remove</button>"
                  return data;
                }
            },
            {
              "data": null,
                "render": function(data, type, row, meta){
                    var qr_code = "iis.emb.gov.ph/verify?token="+row['qr_code_token'];
                    data = '<div class="dropdown"><button class="btn btn-info btn-sm dropdown-toggle" onclick=rpvwattmnt("'+row['trans_no']+'","'+row[0]+'"); type="button" data-toggle="dropdown">View Attachment History<span class="caret"></span></button><ul class="dropdown-menu action"><div id="rpvwattmnt_body_'+row[0]+'"></div></ul></div>';
                    data += '<img style="border: 3px solid #51514F; width:149px;margin-top: 10px;" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2F'+qr_code+'%2F&choe=UTF-8">';
                  return data;
                }
            },
          ]
      });
    });
</script>
