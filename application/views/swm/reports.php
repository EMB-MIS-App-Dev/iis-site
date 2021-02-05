<link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://js.arcgis.com/4.16/esri/themes/light/main.css">

<style type="text/css">
  .table-outer th, td { white-space: nowrap; }
  .table-outer div.dataTables_wrapper {
      margin: 0 auto;
  }
  label#header-lgu-label {
      color: #FFF;
  }
  label.total_reports {
      float: right;
      margin: 6px 2px 0px 0px;
      color: #FFF;
      font-size: 8pt;
  }
  #::-webkit-scrollbar-track
  {
      -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
      background-color: #F2F2F2;
  }

  ::-webkit-scrollbar
  {
      width: 5px;
      height: 10px;
      background-color: #F2F2F2;
  }

  ::-webkit-scrollbar-thumb
  {
      background-color: #08507E;
      border: 1px solid #08507E;
  }

  .iisno{
    font-weight: bold;
    overflow: hidden !important;
  }

  .DTFC_LeftBodyLiner{
    overflow: hidden !important;
    font-weight: bold;
  }
  .DTFC_RightBodyLiner{
    overflow: hidden !important;
    font-weight: bold;
  }
</style>
<?php $rfilter = !empty($_GET['rfilter']) ? $_GET['rfilter'] : 'All'; ?>
<div class="container-fluid">
  <div class="row">
    <!-- DATATABLES Card -->
    <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #FFF;">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-book"></i> SWEET-ENMO REPORTS</h6>
            <div style="width: 40%;display: flex;">
              <select class="form-control" id="regionfilterselectize" style="width:50%;" onchange="filterswmall(this.value);">
                <option value="<?php echo $rfilter; ?>"><?php echo $rfilter; ?></option>
                <?php if($rfilter != 'All'){ ?>
                  <option value="All">All</option>
                <?php } ?>
                <?php for ($i=0; $i < sizeof($regions); $i++) { ?>
                  <option value="<?php echo $regions[$i]['rgnnum']; ?>"><?php echo $regions[$i]['rgnnum']; ?></option>
                }
                <?php } ?>
              </select>
              <a style="margin-left:5px;width:50%;font-size: 14px;height: 35px;" href="<?php echo base_url().'Swm/Sweet/Sweetmapall'; ?>" target="_blank" style="float:right; margin-right: 5px;font-size: 8pt;" class="btn btn-info btn-sm"><span class="fa fa-map-marker"></span>&nbsp;MAP VIEW</a>
            </div>
        </div>
        <div class="card-body" style="padding:0px;">
          <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
            <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
              <table id="inbox_sweet_report_signed" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                    <th style="min-width: 100px;"> IIS No. </th>
                    <th> IIS No. </th>
                    <th> Casehandler </th>
                    <th> Type of Report </th>
                    <th> Date Created </th>
                    <th> Subject </th>
                    <th> Date Patrolled </th>
                    <th> LGU Patrolled </th>
                    <th> Barangay </th>
                    <th> Violations Observed </th>
                    <th> Est. Area (sq. m.) </th>
                    <th> Type of Monitoring </th>
                    <th> Actions to be undertaken </th>
                    <th> Assigned </th>
                    <th> Status </th>
                    <th> Status </th>
                    <th> region </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#regionfilterselectize').selectize();
    var table = $('#inbox_sweet_report_signed').DataTable({
          responsive: true,
          paging: true,
          language: {
            "infoFiltered": "",
          },
          "serverSide": true,
          ajax: {
              "url": "<?php echo base_url(); ?>Swm/Sweet_serverside",
              "type": 'POST',
              "data": { regionfilter : '<?php echo $rfilter; ?>'},
          },
          "order": [[ 3, "asc", 4, "asc"]],
          "columnDefs": [
            { className:"iisno","targets":[1] },
          ],
          scrollX: true,
          fixedColumns:   {
              leftColumns: 2,
              rightColumns: 3
          },
          "order": [[ 19, "asc" ]],
          "lengthMenu": [ [50, 100, 500,-1], [50, 100, 500, "All"] ],
          "columns": [
            { "data": "feedback","visible": false},
            { "data": "feedback_seen","visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                    data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[1]+"&rn="+row[19]+"' target='_blank'><span class='fa fa-file'></span></a>";
                    data += "&nbsp;<a title='View Report History - Report No: "+row['report_number']+"' href='#' onclick=view_sw_history('"+row[1]+"'); class='btn btn-info btn-sm' data-toggle='modal' data-target='#view_sw_history'><span class='fa fa-clipboard'></span> History</a>";
                    // data += "&nbsp;<a href='#' onclick=swedit_report('"+row[1]+"'); data-toggle='modal' data-target='#edit_report' title='Edit Report' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></a>";
                    // data += "&nbsp;<a href='#' style='font-size:10pt!important;' id='sweet_process_btn'  data-toggle='modal' data-target='#process_sweetreport' title='Evaluate Report' class='btn btn-success btn-sm'><span class='fa fa-check'></span> Evaluate</a>";
                    data += "&nbsp;<a title='View Map Location' href='../Swm/Sweet/Sweetmap?token="+row[1]+"' target='_blank' class='btn btn-info btn-sm'><span class='fa fa-map-marker'></span></a>";
                    if((row['feedback_seen'] == '' || row['feedback_seen'] == null) && row['feedback'] > 0){
                      data += "&nbsp;<a href='#' onclick=lgufeedbackbtn('"+row[1]+"'); data-toggle='modal' data-target='#lgufeedbackmodal' title='LGU Feedbacks' class='btn btn-primary btn-sm'><span class='fa fa-envelope'></span><b>&nbsp;"+row['feedback']+"</b></a>";
                    }
                    return data;
                }
            },
            { "data": "trans_no","searchable": true},
            { "data": 1,"visible": false},
            { "data": "creator_name","searchable": true},
            { "data": "report_type","searchable": true},
            { "data": "date_created","searchable": true},
            { "data": "subject","searchable": true},
            { "data": "date_patrolled","searchable": true},
            { "data": "lgu_patrolled_name","searchable": true},
            { "data": "barangay_name","searchable": true},
            { "data": "violations_observed_desc","searchable": true},
            { "data": "total_land_area","searchable": true},
            { "data": "type_of_monitoring_desc","searchable": true},
            { "data": "actions_undertaken_desc","searchable": true},
            { "data": "assigned_name","searchable": true},
            { "data": 'status',"searchable": true,"visible":false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                    data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                  }else if(row['status'] == 'On-Process'){
                    data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                  }else{
                    data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                  }
                  return data;
                }
            },
            { "data": 'region',"searchable": true,"visible":false},
          ]

    });
  });
</script>
