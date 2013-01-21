<?php
include_once('controller/pageController.php');
$pageController=new PageController(8);
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
					<div id="updatePicContainer" class="left siteCommonContainer ">
						<h3 class="eventHeading">Profile Pic</h3>
						<div align="center" id="profilePicContainer">
							<?php echo $pageController->getUser()->getProfilePic($_SESSION['uid']).'"';?>
						</div>
						<div id="photoUpload_container"></div>
					</div>
					<div id="updateBasicInformation" class="right siteCommonContainer">
						<h3 class="eventHeading">Basic Information</h3>
						<label for="updateEmail" style="width:80px;color: #DDDDDD;" class="left grey">Email Id :</label>
						<p id="updateEmail" style="color: #DDDDDD;"  class="editableText left"><?php echo $pageController->getUser()->getEmail($_SESSION['uid']);?></p>
						<div class="clear"></div>
						<label for="updateFirstName"  style="width:80px;color: #DDDDDD;" class="left grey">First Name :</label>
						<p id="updateFirstName" style="color: #DDDDDD;" class="editableText left"><?php echo $pageController->getUser()->getFirstName($_SESSION['uid']);?></p>
						<div class="clear"></div>
						<label for="updateLastName"  style="width:80px;color: #DDDDDD;" class="left grey">Last Name :</label>
						<p id="updateLastName" style="color: #DDDDDD;" class="editableText left"><?php echo $pageController->getUser()->getLastName($_SESSION['uid']);?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	<?php 
		echo $pageController->printFooter();
	?>
	<script type="text/javascript" src="<?php echo Minify_getUri('profile_js') ?>"></script>
	</body>
</html>