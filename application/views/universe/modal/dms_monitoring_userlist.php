
  <div class="row" >
			<div class="col-md-12 table-responsive" style="zoom:95%">
				<table id="dmsMonitoringUserlistTable" class="table table-hover table-striped" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>IIS No.</th>
							<th>Subject</th>
							<th>Trans. Type</th>
							<th>Status</th>
							<th>Date Forwarded</th>
						</tr>
					</thead>
				</table>
			</div>
  </div>
<?php
  // echo $token;
?>
  <script>
  	$(document).ready(function() {
  	    var table = $('#dmsMonitoringUserlistTable').DataTable({
          lengthMenu: [10, 15, 20],
						pageLength: 10,
  					order: [[0, "desc"]],
  					language: {
  				    "infoFiltered": "",
  				  },
  	        serverSide: true,
  	        processing: true,
  	        responsive: true,
  	        ajax: {
  	            "url": "<?php echo base_url('Universe/Data_Tables/inbox_monitoring_userlist'); ?>",
  	            "type": 'POST',
  							"data": { token: "<?=$token?>" },
  	        },
  	        columns: [
  						{ "data": "token" },
  						{ "data": "subject" },
  						{ "data": "type_description" },
  						{ "data": "status_description" },
  						{ "data": "date_out" },
  	        ],
  	    });
  	} );
  </script>
