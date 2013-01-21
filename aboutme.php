<?php
include_once('controller/pageController.php');
$pageController=new PageController(1);
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
				<div class="sponsorListHolder subContainer">
					<?php echo $pageController->printAboutMe(); ?>
					<div class="clear"></div>
				</div>
				<?php 
				/// INTEGRATION OF COMMENT SYSTEM
				echo $pageController->printComment();
				/// INTEGRATION OF COMMENT SYSTEM
				?>
			</div>
		</div>
		<div class="clear"></div>
	<?php 
		echo $pageController->printFooter();
		echo $pageController->javascriptPrintComment();
	?>
	<script type="text/javascript" src="<?php echo Minify_getUri('about_js') ?>"></script>
	</body>
</html>