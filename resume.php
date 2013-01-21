<?php
include_once('controller/pageController.php');
$pageController=new PageController(6);
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
					<div id="resumeContainer" class="siteCommonContainer left">
						<div class="right subnavigation">
							<a href="javascript:void(0);" class="expand open eventHeading" id="openResume">Expand All</a>
							&nbsp;&nbsp;&middot;&nbsp;&nbsp;
							<a title="Pavan Ratnakar :: Front End Web Developer Resume : Printer friendly version" href="resumePrint" class="resumebox cboxElement eventHeading">Printer Friendly Version</a>
							&nbsp;&nbsp;&middot;&nbsp;&nbsp;
							<a title="Pavan Ratnakar :: Front End Web Developer Resume : Download PDF Version" target="_blank" class="eventHeading" href="resumedocs/Pavan_Ratnakar.pdf">Download PDF Version</a>
							&nbsp;&nbsp;&middot;&nbsp;&nbsp;
							<a title="Pavan Ratnakar :: Front End Web Developer Resume : Download Word/Doc Version" class="eventHeading" href="resumedocs/Pavan_Ratnakar.doc">Download Word/Doc Version</a>
						</div>
						<div class="left siteCommonInnterContainer ">
							<?php include_once('include/resumeBody.php'); ?>
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
	<script type="text/javascript" src="<?php echo Minify_getUri('resume_js') ?>"></script>
    </body>
</html>