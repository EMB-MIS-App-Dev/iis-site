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
            <h6 class="m-0 font-weight-bold text-primary"><span class="fa fa-file"></span> VISITOR's LOG</h6>
            <a href="#" data-toggle='modal' style="float:right;" data-target='#clog_confirmation_message' class="btn btn-success btn-sm"><i class="fas fa-plus"></i>&nbsp;New Log</a>
        </div>
        <!-- Card Body -->
          <div class="card-body" id="table-responsive">
            <table id="client_logs_table" class="table table-hover table-striped" width="100%" cellspacing="0" style="zoom:90%;">
              <thead>
                <tr>
                  <th> IIS No. </th>
                  <th> IIS No. </th>
                  <th> IIS No. </th>
                  <th> Client Name </th>
                  <th style="width:25%;"> Client Name </th>
                  <th> Company Name </th>
                  <th> Address </th>
                  <th> Contact No. </th>
                  <th> Purpose </th>
                  <th> Other Info. </th>
                  <th> Datetime-in </th>
                  <th> Datetime-out </th>
                  <th> Datetime-out </th>
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
<?php
   $swal_arr = $this->session->flashdata('swal_arr');
   if(!empty($swal_arr)) {
     echo "<script>
       swal({
         title: '".$swal_arr['title']."',
         text: '".$swal_arr['text']."',
         type: '".$swal_arr['type']."',
         allowOutsideClick: false,
         customClass: 'swal-wide',
         confirmButtonClass: 'btn-success',
         confirmButtonText: 'Confirm',
         onOpen: () => swal.getConfirmButton().focus()
       })
     </script>";
   }
 ?>
<script type="text/javascript">
  $(document).ready(function(){
      var table = $('#client_logs_table').DataTable({
          responsive: true,
          paging: true,
          language: {
            "infoFiltered": "",
          },
          "serverSide": true,
          "order": [[ 1, "desc"]],
          "ajax": "<?php echo base_url(); ?>Logs/Serverside",
          "columns": [
            { "data": "trans_token","searchable": true},
            { "data": 1,"searchable": true,"visible": false},
            { "data": 2,"searchable": true,"visible": false},
            { "data": "cl_full_name","searchable": true,"visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                    data = '<a href="#" data-toggle="collapse" data-target="#more_details_'+row[1]+'">'+row['cl_full_name']+'</a>';
                    data +='<div id="more_details_'+row[1]+'" class="collapse">'+row['cl_contact_no']+'<br>'+row['cl_address'];
                    data +='<hr><label style="font-weight:bold;font-size:13pt;">COMPANY PRESENTED</label><br>'+row['cl_company_name']+'<br>';
                    if(row['cl_emb_id'] != 'Not in the list of company'){
                      data += 'Position.:&nbsp;<b>'+row['cl_comp_pos']+'</b><br>Contant No.:&nbsp;<b>'+row['contact_no']+'</b><br>Email Address:&nbsp;'+row['email']+'<br>Address:&nbsp;<b>'+row['province_name']+'</b>';
                    }
                    if(row['cl_emb_id'] == 'Not in the list of company'){
                      // data += row['company_contact']+'<br>'+row['company_email']+'<br>'+row['company_address'];
                      data += 'Position.:&nbsp;<b>'+row['cl_comp_pos']+'</b><br>Contant No.:&nbsp;<b>'+row['company_contact']+'</b><br>Email Address:&nbsp;'+row['company_email']+'<br>Address:&nbsp;<b>'+row['company_address']+'</b>';
                    }

                    data +='<hr><label style="font-weight:bold;font-size:13pt;">SAFETY AND HEALTH</label><br>Have you originated from, transfer from or transit from any location abroad, in the past 90 days?&nbsp;<b>'+row['cl_frdobtn']+'</b>';
                    if(row['cl_frdobtn'] == 'Yes'){
                      data += '<br>Origin:&nbsp;<b>'+row['cl_forigin']+'</b><br>Date of travel:&nbsp;<b>'+row['cl_fdtoftravel']+'</b><br>Date of arrival:&nbsp;<b>'+row['cl_fdtofarrival']+'</b>';
                    }
                    data += '<br><br>Have travelled from a local City and Municipality aside from the address of this office?&nbsp;<b>'+row['cl_srdobtn']+'</b>';
                    if(row['cl_srdobtn'] == 'Yes'){
                      data += '<br>Exact address of origin:&nbsp;<b>'+row['cl_saddress']+'</b>';
                    }
                    data +='<hr><label style="font-weight:bold;font-size:13pt;">OTHER INFORMATION</label><br>'+row['cl_other_info']+'<br></div>';
                  return data;
                }
            },
            { "data": "cl_company_name","searchable": true, "visible":false},
            { "data": "cl_address","searchable": true, "visible":false},
            { "data": "cl_contact_no","searchable": true, "visible":false},
            { "data": "cl_purpose","searchable": true},
            { "data": "cl_other_info","searchable": true, "visible":false},
            { "data": "cl_datetimein","searchable": true},
            { "data": "cl_datetimeout","searchable": true, "visible":false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                    if(row['cl_datetimeout'] != ''){
                      data = row['cl_datetimeout'];
                    }else{
                      data = '<button class="btn btn-danger btn-sm" style="width: 150px;" data-toggle="modal" data-target="#clog_timeout" onclick=timeoutlog("'+row[2]+'")>Time out</button>';
                    }

                  return data;
                }
            },
            {
              "data": null,
                "render": function(data, type, row, meta){
                    data = '<div class="dropdown"><button class="btn btn-info btn-sm dropdown-toggle" onclick=vwattchmnt("'+row[1]+'"); type="button" data-toggle="dropdown">View Attachments<span class="caret"></span></button><ul class="dropdown-menu action"><div id="vwattchmnt_body_'+row[1]+'"></div></ul></div>';

                  return data;
                }
            },
          ]
      });
    });
</script>
