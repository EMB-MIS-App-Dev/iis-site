<iframe src="https://en.wikipedia.org/wiki/User_experience"> </iframe>

<?php
	echo $appli_id;
?>

		<div class="container-fluid">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_new_confirmation"> <i class="fas fa-plus"></i> Apply for PCO Accreditation </button>
      <br><br>
			<div class="row">
				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"> PCO Accreditation </h6>
						</div>
						<!-- Card Body -->
						<div class="card-body">

							<div class="table-responsive">
								<table id="pco_application_table" class="table table-bordered table-striped table-hover" style="width: 100%" cellspacing="0">
									<thead align="center">
										<tr>
											<th>appli_id</th>
											<th>user_id</th>
											<th style="width: 15%">appli_token</th>
											<th>step_id</th>
											<th>step</th>
											<th>stat_id</th>
											<th>status</th>
											<th>remarks</th>
											<th>action</th>
											<th>date_submitted</th>
											<th>button</th>
										</tr>
									</thead>
								</table>
							</div>

						</div>
						<!-- Card Body -->
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document).ready( function () {
		var table = $('#pco_application_table').DataTable({
			dom: "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-1'<'col_filter'>><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
	    order: [[0, "desc"]],
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
  		// pageLength: -1,
			language: {
				infoFiltered: "",
				processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
			},
			deferRender: true,
			paging: true,
			serverSide: true,
			processing: true,
			responsive: true,
			ajax: {
					"url": "<?php echo base_url('Pco/Datatables/application'); ?>",
					"type": 'POST',
					"data": { 'csrf_token_name': '<?php echo $this->security->get_csrf_hash(); ?>', 'user_id': '<?=$user_id?>' },
			},
			columns: [
	      { data: "appli_id", render: $.fn.dataTable.render.text() },
				{ data: "user_id", "visible": false, "searchable": false },
	      { data: "appli_token",
	        "render": function(data, type, row, meta) {
	            if(data != 0) {
	              return data;
	            }
	            else {
	              return data = ' -draft-';
	            }
	        }
	      },
				{ data: "step", render: $.fn.dataTable.render.text() },
	      { data: null,
	        "render": function(data, type, row, meta) {
						if(type === 'display' || type === "filter"){
		          switch(row['step'])
		          {
		            case '1': data = 'Step 1: Basic Information'; break;
		            case '2': data = 'Step 2: Company Details'; break;
		            case '3': data = 'Step 3: Educational Attainment'; break;
		            case '4': data = 'Step 4: Work Experience'; break;
		            case '5': data = 'Step 5: Trainings/Seminars Attended'; break;
		            case '6': data = 'Step 6: Other Requirements'; break;
		            case '7': data = 'For Finalization/Submission'; break;
		            case '8': data = 'For EMB 7 Evaluation'; break;
		            case '9': data = 'To Edit / Update'; break;
		            case '10': data = 'For Payment'; break;
		            case '11': data = 'Lacking PCO Training'; break;
		            case '11': data = 'Approved / For Certification'; break;
		            case '12': data = 'Re-Open'; break;
		            case '13': data = 'Disapproved'; break;
		            case '14': data = 'Closed/Deleted'; break;
		            case '15': data = 'For Claiming'; break;
		            case '16': data = 'Draft Application'; break;
		            case '17': data = 'Claimed'; break;
		            default: data = ' '; break;
		          }
	   				}
	          return data;
	        }
	      },
	      { data: "stat_id", render: $.fn.dataTable.render.text() },
	      { data: "status", "visible": false, "searchable": false },
	      { data: "action", render: $.fn.dataTable.render.text() },
	      { data: "remarks", render: $.fn.dataTable.render.text() },
	      { data: "date_submitted", render: $.fn.dataTable.render.text() },
	      {
          "sortable": false,
          "render": function(data, type, row, meta) {
						if(row['step'] == 10)
						{
							data = " <button type='button' id='payment' class='btn btn-primary btn-sm waves-effect waves-light' title='For Payment'><i class='fas fa-money-bill-wave'></i></button>&nbsp;";

							data += "<a href='"+'<?=base_url('pco/application/')?>'+row['appli_id']+'/'+row['step']+'/orderofpayment'+"' target='_blank'> <button type='button' id='payment' class='btn btn-warning btn-sm' title='For Payment'><i class='fas fa-money-bill-wave'></i></button></a>&nbsp;";
						}
						else if(row['step'] == 9)
						{
							data = "<a href='letter.php' target='_blank'> <button type='button' id='endorse' class='btn btn-primary btn-sm waves-effect waves-light' title='Endorsement Letter'><i class='fas fa-star'></i></button></a>&nbsp;";
						}
						else {
              data = "<button type='button' id='update' class='btn btn-warning btn-sm waves-effect waves-light' title='Update'><i class='far fa-edit'></i></button>&nbsp;";
						}
						return data;
          }
	      }
	    ]
	  });

		$("div.search_bar").html('<input class="search_fld form-control form-control-sm" id="search_bar" />');
		$("div.search_btn").html('<button id="search_btn" class="search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button> <i id="search_spinner" class="fas fa-spinner fa-pulse" ></i>');

		$("#search_btn").on('click', function () {
		  table.search($("#search_bar").val()).draw();
			$('#search_spinner').show();
		});

		// $('#search_btn').on('click', function () {
		//   table.column(4).search($('#search_bar').val()).draw();
		// });

		table.on( 'draw', function () {
		  console.log( 'Redraw occurred at: '+new Date().getTime() );
			// $(".search_fld").prop('disabled', true);
			$('#search_spinner').hide();
		} );

    // EDIT: Capture enter press as well
    $("#searchNameField").keypress(function(e) {
        // You can use $(this) here, since this once again refers to your text input
        if(e.which === 13) {
            e.preventDefault(); // Prevent form submit
            oTable.search($(this).val()).draw();
        }
    });

	  $('#pco_application_table tbody').on( 'click', '#update', function () {
	    var data = table.row( $(this).parents('tr') ).data();
			window.location.href = "<?=base_url()?>"+'pco/application/'+data['appli_id']+'/'+data['step'];
	  });

	  $('#pco_application_table tbody').on( 'click', '#payment', function () {
	    var data = table.row( $(this).parents('tr') ).data();
			window.location.href = "<?=base_url()?>"+'pco/application/'+data['appli_id']+'/'+data['step'];
	  });


	});
</script>
