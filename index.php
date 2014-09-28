<?php
include_once('controller/pageController.php');
$pageController=new PageController(0);
echo $pageController->printHeader();
?>
	</head>
	<body>
		<!-- Panel -->
		<div id="toppanel">
			<?php echo $pageController->printPanel(); ?>
		</div>
		<!--panel -->
		<!-- wrapper -->
		<div id="wrapper">
			<?php echo $pageController->printNavigation(); ?>
			<div id="main">
				<div id="mainContainer">
					<h2>LATEST UPDATES</h2>
					<div id="gallery">
						<div id="galleryHeader">
							<div class="wrap">
								<div id="slide-holder">
									<div id="slide-runner">
										<?php $pageController->getHomePageSlider(); ?>
										<div id="slide-controls">
											<p id="slide-client" class="text"><strong>Pavan Ratnakar: </strong><span></span></p>
											<p id="slide-desc" class="text"></p>
										</div>
									</div>
									<div id="slide-nav"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<!-- wrapper -->
		<div class="clear"></div>
		<?php echo $pageController->printFooter(); ?>
		<script type="text/javascript" src="<?php echo Minify_getUri('homepage_js') ?>"></script>
	</body>
</html>