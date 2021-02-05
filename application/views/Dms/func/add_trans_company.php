
  <div class="row">
			<div class="col-md-12 table-responsive" style="zoom:95%">
				<table id="select_company_table" class="table table-hover table-striped" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>no</th>
							<th>token</th>
							<th>EMB ID</th>
							<th>Company Name</th>
							<th>Establishment Name</th>
							<th>Location</th>
							<th>Project Type</th>
							<th style="width: 50px !important">Action</th>
						</tr>
						<tr>
							<th>no</th>
							<th>token</th>
							<th>EMB ID</th>
							<th>Company Name</th>
							<th>Establishment Name</th>
							<th >Location</th>
							<th>Project Type</th>
							<th style="width: 50px !important; display: none"></th>
						</tr>
					</thead>
				</table>
			</div>
  </div>


<div hidden id="region_selection">
	<select id="region_slctd" class="form-control" name="region_slct" >
    <option value="" selected>-all region-</option>
		<?php
			foreach ($region as $key => $value) {
				if($value['rgnnum'] == $user_region) {
          echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
        }
        else {
          echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
        }
			}
		?>
	</select>
</div>

  		<script>

  			$(document).ready(function() {
  					var tableData = {
  						'region': $('#region_slctd').val(),
  					};
            // Setup - add a text input to each footer cell
            $('#select_company_table thead tr:eq(1) th').each( function (i) {
                var title = $('#example thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
            } );

  			    var table = $('#select_company_table').DataTable({
  							dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-3'<'type'>><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-5'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                orderCellsTop: true,
                fixedHeader: true,
                lengthMenu: [ [5, 10, 25], [5, 10, 25] ],
  							order: [[2, "desc"]],
  							language: {
  						    "infoFiltered": "",
  						  },
  			        serverSide: true,
  			        processing: true,
  			        responsive: true,
                autoWidth: true,
  							// scrollY: true,
          			scrollX: true,
                // fixedColumns: {
                //     leftColumns: 4,
                //     // rightColumns: 1
                // },
  			        ajax: {
  			            "url": "<?php echo base_url('Dms/Datatables/add_trans_company'); ?>",
  			            "type": 'POST',
  									"data": function ( d ) {
  			                   		return  $.extend(d, tableData);
  											 		},
  			        },
  			        columns: [
  								{ "data": "cnt", "searchable": false, "visible": false},
  								{ "data": "token", "searchable": false, "visible": false },
  								{ "data": "emb_id"},
  								{ "data": "company_name" },
  								{ "data": "establishment_name" },
  								{ "data": "location"},
  								{ "data": "project_name"},
  								{
  									"sortable": false,
  									"render": function(data, type, row, meta) {
  										data = "<button type='button' id='selectbtn' class='btn btn-success btn-sm waves-effect waves-light' data-dismiss='modal' >Select</button>&nbsp;";
  										return data;
  									}
  								}
  			        ],
  			    });

            // Apply the search
            $( table.table().container() ).on( 'keyup', 'thead input', function () {
                table
                  .column( $(this).data('index') )
                  .search( this.value )
                  .draw();
            } );

  				$("div.type").html($('#region_selection').html());

          $('#region_slctd').change(function() {
            tableData.region = $('#region_slctd').val();
  					table.draw();
  				} );

			    $("div.filter").on( 'click', '#filterbtn', function () {
						Dms.filter_transaction();
  				} );

			    $('#select_company_table tbody').on( 'click', '#selectbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							$('form[id="trans_form"] input[name="company"]').val(data['token']);
							$('form[id="trans_form"] textarea[id="company_display"]').html('['+data['emb_id']+']- '+data['company_name']);

  				} );

  			} );

  		</script>
