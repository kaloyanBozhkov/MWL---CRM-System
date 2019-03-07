<?php 
	$title = "";
	$btnid = "";
	$classBgColor = "";
	if(isset($_SESSION['loginSection']) && $_SESSION['loginSection'] == "admin"){
		$title = "ADMIN LOGIN";
		$btnid = "btnlgn";
		$classBgColor = "pinkBg";
	}else{
		header('Location: index.php');
	}
?>
	
	<div class="limiter <?php echo $classBgColor; ?>">
		<div class="container-login100 wrapScape">
			<div class="wrap-login100 p-t-50 p-b-90">
				<div class="login100-form validate-form flex-sb flex-w">
					<span class="login100-form-title p-b-51">
						<?php echo $title ?>
					</span>

					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						<input class="input100" type="text" name="username" id="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember username
							</label>
						</div>
					</div>
					<div class="flex-sb-m w-full p-t-3 p-b-24">
					<div class="container-login100-form-btn m-t-17">
						<button id='<?php echo $btnid; ?>' class="login100-form-btn">
							Login
						</button>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/templates/loginForm/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/templates/loginForm/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/templates/loginForm/js/main.js"></script>
