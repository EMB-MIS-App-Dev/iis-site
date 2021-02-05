<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <div class="container-fluid">
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
          <!-- </div> -->
          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SMR RECORDS</h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="smr_submitted_list">
                      <thead>
                        <tr>
                        <th>Emb id</th>
                        <th>Establishment</th>
                        <th>No. SMR submitted</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td colspan="7" class="dataTables_empty">Loading data from server</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>

          <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Footer -->

    </div>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#smr_submitted_list').DataTable({
        responsive: true,
        paging: true,
        "serverSide": true,
        "order": [[ 0, "facility_id" ]],
        "ajax": "<?php echo base_url(); ?>Smr/records/smr_records",
        "columns": [
          { "data": "emb_id","searchable": true},
          {
            "data": null,
              "render": function(data, type, row, meta){
                data = "<a class='btn btn-info btn-sm' href='#'>"+row['company_name']+"</a>";
                return data;
              }
          },
          { "data": "smr_num_submitted","searchable": true},
        ]
    });
  });
</script>
