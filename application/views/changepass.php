	<div class="limiter">
		<div class="container-login100">
			<div class="text-center w-full  p-b-22"> <!-- p-t-42 -->
					<span class="txt1" style="color:#ffffff;font-size:30px;font-weight:bold;">

					</span>
			</div>
			<form class="" action="<?php echo base_url(); ?>Index/cpass_user" method="post">
				<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30" style="">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-10">
						<span style="color:green;">ENVIRONMENTAL MANAGEMENT BUREAU</span>
					</span>
					<br />
					<p style="color:red; text-align: center">
						* Please enter your new password *<br />(minimum of 6 characters)
					</p> <br />

					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="password" name="npass" placeholder="New Password" minlength="6" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="password" name="cnpass" placeholder="Confirm New Password" minlength="6" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-25">
						<button type="submit" class="login100-form-btn">
							Confirm
						</button>
					</div>

					<div class="text-center w-full p-t-115">
						<span class="txt1">
							Already have an account?
						</span>

						<a class="txt1 bo1 hov1" href="<?php echo base_url(); ?>">
							Login
						</a>
					</div>
				</form>
			</div>
			</form
		</div>
	</div>
