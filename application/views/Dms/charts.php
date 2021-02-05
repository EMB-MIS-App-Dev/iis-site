		<style type="text/css">
		  #chart-container {
		    width: 640px;
		    height: auto;
		  }
		</style>
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file"></i> DRAFT TRANSACTIONS</h6>

							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a>

						</div>


						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div id="chart-container">
							      <canvas id="mycanvas"></canvas>
							    </div>
								</div>

							</div>
						<!-- Card Body -->

					</div>

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
					confirmButtonText: 'Orayts',
					onOpen: () => swal.getConfirmButton().focus()
				})
	    </script>";
		}
	?>
		<script>
		$(document).ready(function(){
			$.ajax({
				url: "<?php echo base_url('Dms/data/charts'); ?>",
				method: "POST",
				dataType: "json",
				success: function(data) {
					// console.log(data);

					var ctx = $("#mycanvas");

					var input = [
						{"y":4,"x":"2017-01-01"},
           	{"y":0,"x":"2017-01-02"},
           	{"y":9,"x":"2017-01-03"},
           	{"y":0,"x":"2017-01-04"},
           	{"y":14,"x":"2017-01-05"}
					];

					var barGraph = new Chart(ctx, {
						type: 'line',
						data: {
					    datasets: [{
					      "data": data,
						    label: ["test"]
					    }]
					  },
						backgroundColor:'rgba(255, 99, 132, 0.2)',
			      borderColor: 'rgba(255,99,132,1)',
			      borderWidth: 1,
				    options: {
				        scales: {
				            xAxes: [{
				                type: 'time',
				                time: {
				                    unit: 'day'
				                }
				            }]
				        }
				    }
					});
				},
				error: function(data) {
					console.log(data);
				}
			});
			});
		</script>
