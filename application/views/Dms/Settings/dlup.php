<style>

</style>
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-edit"> </i>LOCATED UPLOAD</h6>

						</div>
						<?php echo form_open_multipart('dms/custom/test/debug/settings/dlup', array('id' => 'trans_form11')); ?>
						<!-- Card Body -->
							<div class="card-body">

										<div class="table-responsive">
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab"> <br />
															<span class="set_note">uploads/dms/-year-/-region-/-iisno-</span>
															<div>
																<input type="text" class="form-control" name="file_path" required/>
																<input type="file" class="form-control" name="file_attached" required/>
															</div>
														</div>
												</div>

												<div class="col-xl-12 mb-3">

												</div>

										</div>

							</div>
						<!-- Card Body -->
						<div class="card-footer">
							<div class=" float-right">
								<button type="submit" class="btn btn-success btn-icon-split" name="upload" ><span class="text"> <i class="fas fa-share-square"></i> UPLOAD</span></button> <br /><br />
							</div>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>

</div> <!-- Header Wrapper End -->
