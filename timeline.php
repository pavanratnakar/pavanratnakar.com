<?php
include_once('controller/pageController.php');
$pageController=new PageController(4);
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
				<div id="timelineLimiter" class="subContainer"> <!-- Hides the overflowing timelineScroll div -->
					<div id="timelineScroll"> <!-- Contains the timeline and expands to fit -->
					<?php
					// We first select all the events from the database ordered by date:
					$timeline=$pageController->initTimeLine();
					$dates = $timeline->showTimeLine();
					$scrollPoints = '';
					$i=0;
					foreach($dates as $year=>$array)
					{
						// Loop through the years:
						echo '
						<div class="event">
							<div class="eventHeading">'.$year.'</div>
							<ul class="eventList">
							';
						foreach($array as $event)
						{
							// Loop through the events in the current year:
							echo '<li class="'.$event['type'].'">
							<span class="iconsSprite" title="'.ucfirst($event['type']).'"></span>
							'.htmlspecialchars($event['title']).'
							<div class="content">
								<div class="body">'.nl2br($event['body']).'</div>
								<div class="title">'.htmlspecialchars($event['title']).'</div>
								<div class="date">'.date("F j, Y",strtotime($event['date_event'])).'</div>
							</div>
							</li>';
						}
						echo '</ul></div>';
						// Generate a list of years for the time line scroll bar:
						$scrollPoints.='<div class="scrollPoints">'.$year.'</div>';
					}
					?>
					<div class="clear"></div>
					</div>
					<div id="scroll"> <!-- The year time line -->
						<div id="centered"> <!-- Sized by jQuery to fit all the years -->
							<div id="highlight"></div> <!-- The light blue highlight shown behind the years -->
							<?php echo $scrollPoints ?> <!-- This PHP variable holds the years that have events -->
							<div class="clear"></div>
						</div>
					</div>
					<div id="slider1"> <!-- The slider container -->
						<div id="bar"> <!-- The bar that can be dragged -->
							<div id="barLeft"></div>  <!-- Left arrow of the bar -->
							<div id="barRight"></div>  <!-- Right arrow, both are styled with CSS -->
					  </div>
					</div>
				</div>
				<div id="ps_overlay" class="ps_overlay" style="display:none;"></div>
				<a id="ps_close" class="ps_close" style="display:none;"></a>
                <div id="ps_ad" class="ps_ad" style="display:none;"></div>
				<?php 
				/// INTEGRATION OF COMMENT SYSTEM
				echo $pageController->printComment();
				/// INTEGRATION OF COMMENT SYSTEM
				?>
			</div>
		</div>
	<?php 
		echo $pageController->printFooter();
		echo $pageController->javascriptPrintComment();
	?>
	<script type="text/javascript" src="<?php echo Minify_getUri('pavan_timeline_js') ?>"></script>
	</body>
</html>