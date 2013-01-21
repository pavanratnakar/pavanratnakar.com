<?php
header("HTTP/1.0 404 Not Found");
include_once('controller/pageController.php');
$pageController=new PageController(11);
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
			<div id="main">
				<div id="mainContainer">
					<h2><?php echo $pageController->printH2(); ?></h2>
					<div class="subContainer">
						<div class="siteCommonContainer left">
							<div class="left siteCommonInnterContainer ">
								<h3 id="notFound"> Sorry! Could not find what you were looking for.</h3>
								<div id="rocket"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<?php echo $pageController->printFooter();?>
		<script type="text/javascript" src="<?php echo Minify_getUri('404_js') ?>"></script>
	</body>
</html>