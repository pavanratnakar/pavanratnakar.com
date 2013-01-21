<?php
include_once('controller/pageController.php');
$pageController=new PageController(9);
$pageController->initProfile();
echo $pageController->printHeader();
?>
	</head>
	<body>
		<!-- Panel -->
		<div id="toppanel">
			<?php echo $pageController->printPanel(); ?>
		</div>
		<!--panel -->
		<div id="wrapper">
			<?php echo $pageController->printNavigation(); ?>
			<div id="mainContainer">
				<h2><?php echo $pageController->printH2(); ?></h2>
				<div class="subContainer">
					<div id="changePassword" class="left siteCommonContainer">
						<h3 class="eventHeading">Change Password</h3>
						<form id="passwordResetForm" method="post" action="">
							<div id="passwordResetStatus"></div>
							<div class="clear"></div>
							<label for="oldPassword" class="grey">Old Password:</label>
							<input type="password" size="23" id="oldPassword" name="oldPassword" class="field" value=""/>
							<div class="clear"></div>
							<label for="reoldPassword" class="grey">Re-type your old Passoword:</label>
							<input type="password" size="23" id="reoldPassword" name="reoldPassword" class="field" value=""/>
							<div class="clear"></div>
							<label for="newPassword" class="grey">New Password:</label>
							<input type="password" size="23" id="newPassword" name="newPassword" class="field" value=""/>
							<div class="password-meter right">
								<div class="password-meter-message">Password Stength Meter</div>
								<div class="password-meter-bg">
									<div class="password-meter-bar"></div>
								</div>
							</div>
							<div class="clear"></div>
							<div id="contactButtons">
								<input type="submit" class="bt_contact contactSubmit" value="Submit" name="submit"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	<?php 
		echo $pageController->printFooter();
	?>
	<script type="text/javascript" src="<?php echo Minify_getUri('resetPassword_js') ?>"></script>
	</body>
</html>