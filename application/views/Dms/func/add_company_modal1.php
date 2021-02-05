
  <div class="row" >
			<div class="col-md-12 table-responsive" style="zoom:95%">
				<table id="select_company_table" class="table table-hover table-striped" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>no</th>
							<th>token</th>
							<th>EMB ID</th>
							<th>Company Name</th>
							<th>Establishment Name</th>
							<th>House No.</th>
							<th>Street</th>
							<th>Barangay</th>
							<th>City</th>
							<th>Province</th>
							<th>Project Type</th>
							<th style="width: 50px !important">Action</th>
						</tr>
						<tr>
							<th>no</th>
							<th>token</th>
							<th>EMB ID</th>
							<th>Company Name</th>
							<th>Establishment Name</th>
							<th>House No.</th>
							<th>Street</th>
							<th>Barangay</th>
							<th>City</th>
							<th>Province</th>
							<th>Project Type</th>
							<th style="width: 50px !important; display: none"></th>
						</tr>
					</thead>
				</table>
			</div>
  </div>

<div hidden id="region_selection">
	<select class="addcomp_region_slctd form-control" name="region_slct" >
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
  						'region': $('.addcomp_region_slctd').val(),
  					};
            // Setup - add a text input to each footer cell
            $('#select_company_table thead tr:eq(1) th').each( function (i) {
                var title = $('#example thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
            } );

  			    var table = $('#select_company_table').DataTable({
  							dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-3'<'type'>><'col-sm-12 col-md-1'<'refresh'>><'col-sm-12 col-md-6'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                orderCellsTop: true,
                fixedHeader: true,
                lengthMenu: [ [5, 10, 15], [5, 10, 15] ],
  							order: [[3, "desc"]],
  							language: {
  						    "infoFiltered": "",
  						  },
  			        serverSide: true,
  			        processing: true,
  			        responsive: true,
                autoWidth: true,
  							// scrollY: true,
          			scrollX: true,
                fixedColumns: {
                    // leftColumns: 4,
                    rightColumns: 1
                },
  			        ajax: {
  			            "url": "<?php echo base_url('Dms/Data_Tables/add_company'); ?>",
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
  								{ "data": "house_no" },
  								{ "data": "street" },
  								{ "data": "barangay_name" },
  								{ "data": "city_name" },
  								{ "data": "province_name" },
  								{ "data": "project_name"},
  								{
  									"sortable": false,
  									"render": function(data, type, row, meta) {
  										data = "<button type='button' class='selectbtn btn btn-success btn-sm waves-effect waves-light' data-dismiss='modal' >Select</button>&nbsp;";
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

  				$("div.refresh").html('<a id="addcomp_refresh"><i class="fas fa-sync"></i></a>');

          $('.addcomp_region_slctd').change(function() {
            tableData.region = $('.addcomp_region_slctd').val();
  					table.draw();
  				} );

			    $("a#addcomp_refresh").click( function () {
						table.draw();
  				} );

			    $('#select_company_table tbody').on( 'click', '.selectbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
              var form_div = $('form div#company-selection-group');
              var address = data['house_no']+' '+data['street']+' '+data['barangay_name']+' '+data['city_name']+' '+data['province_name'];

							form_div.find('input[name="company"]').val(data['token']);
							form_div.find('input#company_embid').val(data['emb_id']);
							form_div.find('textarea#company_name').html(data['company_name']);
							form_div.find('textarea#establishment_name').html(data['establishment_name']);
							form_div.find('textarea#company_address').html(address.trim().toUpperCase());
							form_div.find('textarea#project_type').html(data['project_fullname']);
  				} );

  			} );

  		</script>
