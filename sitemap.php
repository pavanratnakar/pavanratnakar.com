<?php
include_once('controller/pageController.php');
$pageController=new PageController(13);
echo $pageController->printHeader();
?>
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
					<div id="sitemapContainer" class="siteCommonContainer left">
						<div class="siteCommonInnterContainer left"> 
						<ul>
							<?php echo $pageController->initSitemap(); ?>
						</ul>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	<?php 
		echo $pageController->printFooter(); 
	?>
	<script type="text/javascript" src="<?php echo Minify_getUri('tutorial_js') ?>"></script>
	</body>
</html>