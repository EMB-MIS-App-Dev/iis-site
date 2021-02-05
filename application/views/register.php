	<style type="text/css">
		.set_error{
			color:red;
		}
	</style>
	<div class="limiter">
		<div class="container-login100">
			<div class="text-center w-full  p-b-22"> <!-- p-t-42 -->
					<span class="txt1" style="color:#ffffff;font-size:30px;font-weight:bold;">

					</span>
			</div>
			<!-- <form class="" action="<?php// echo base_url(); ?>Index/register_user" method="post"> -->
			 <?php echo form_open('Index/register'); ?>
				<div class="wrap-login100 p-l-50 p-r-50 p-t-50 p-b-30" style="">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-40">
						<span style="color:green;">ENVIRONMENTAL MANAGEMENT BUREAU</span><br>
						<span style="color:#000;font-size: 12pt;">(FOR GOV. EMPLOYEES ONLY)</span><br>
					</span>

					<div class="wrap-input100 validate-input m-b-16">
						<?php echo form_error('fname'); ?>
						<input class="input100" type="text" name="fname" placeholder="First name" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-user"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="text" name="mname" placeholder="Middle name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-user"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16">
						<?php echo form_error('sname'); ?>
						<input class="input100" type="text" name="sname" placeholder="Last name" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-user"></span>
						</span>

					</div>
					<div class="wrap-input100 validate-input m-b-16">
						<select class="input100" name="extension">
							<option value="">-</option>
							<?php foreach ($suffix as $key => $value) {?>
	                          <option value="<?php echo $value['snam']; ?>"><?php echo $value['snam']; ?></option>
	                        <?php } ?>
						</select>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-user"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16">
						<?php echo form_error('email'); ?>
						<input class="input100" type="text" name="email" placeholder="Email" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-envelope"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16">
						<?php echo form_error('region'); ?>
						<select class="input100" name="region" >
							<option value="">Office located</option>
							<?php foreach ($region as $key => $value) {?>
	                          <option value="<?php echo $value['rgnnum']; ?>"><?php echo $value['rgnnam']; ?></option>
	                        <?php } ?>
						</select>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-map-marker"></span>
						</span>

					</div>

					<div class="wrap-input100 validate-input m-b-16">
						<?php echo form_error('tregion'); ?>
						<select class="input100" name="tregion" >
							<option value="">Office</option>
							<?php foreach ($offices as $key => $value) {?>
	                          <option value="<?php echo $value['office_code']; ?>"><?php echo $value['office_name']; ?></option>
	                        <?php } ?>
						</select>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-map-marker"></span>
						</span>

					</div>

					<div class="container-login100-form-btn p-t-25">
						<button type="submit" class="login100-form-btn">
							Register
						</button>
					</div>

					<div class="text-center w-full p-t-15">
						<span class="txt1">
							Already have an account?
						</span>

						<a class="txt1 bo1 hov1" href="<?php echo base_url(); ?>">
							Login
						</a>
					</div>
				</form>
			</div>
		 </form>
		</div>
	</div>
