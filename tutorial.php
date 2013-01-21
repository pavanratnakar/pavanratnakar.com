<?php
include_once('controller/pageController.php');
$pageController=new PageController(12);
$pageController->initTutorial();
echo $pageController->printHeader();
$tutorial=$pageController->getTutorial();
$tutorials=$pageController->getTutorials();
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
			<div id="mainContainer" class="tutorialContainer">
				<h2><?php echo $pageController->printH2(); ?></h2>
				<div class="subContainer">
					<div class="siteCommonContainer left">
						<div class="right subnavigation">
						</div>
						<div class="left siteCommonInnterContainer ">
							<div id="tutorialContainer">
								<?php
								if(!$tutorial->getMainPage())
								{
									require_once('tutorials/'.$pageController->getTutorialQuery().'/'.$pageController->getSubTutorialQuery().'.php'); 
								}
								else
								{
								?>
									<h2>
										Welcome to my tutorial sections. I will try updating tutorials on regular basis.
									</h2>
									<div id="treeMenu">
										<div class="treeContainer left">
											<?php
											for($i=0;$i<sizeof($tutorials);$i++)
											{
												if ($i % 2 == 0)
												{
													$tutorial->printNode($tutorials,$i);
												}
											}
											?>
										</div>
										<div class="left treeContainer treeContainer2">
											<?php
											for($i=0;$i<sizeof($tutorials);$i++)
											{
												if ($i % 2 != 0)
												{
													$tutorial->printNode($tutorials,$i);
												}
											}
											?>
										</div>
									</div>
								<?php
								}
								?>
							</div>
						</div>
					</div>
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
	<script type="text/javascript" src="<?php echo Minify_getUri('tutorial_js') ?>"></script>
	</body>
</html>