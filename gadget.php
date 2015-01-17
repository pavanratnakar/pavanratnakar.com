<?php
include_once('controller/pageController.php');
$pageController=new PageController(2);
$gadgets=$pageController->initGadget();
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
			<div id="mainContainer" class="gadgetContainer">
				<h2><?php echo $pageController->printH2(); ?></h2>
				<div id="ps_slider" class="ps_slider left">
					<div id="ps_albums" class="gadget">
						<a class="prev iconsSprite disabled"></a>
						<a class="next iconsSprite disabled"></a>
						<?php
						for($i=0;$i<sizeof($gadgets);$i++)
						{
						?>
							<div class="ps_album" id="gadget<?php echo $gadgets[$i]['id'];?>" style="opacity:0;">
                                <a class="trailer_video" title="Video" style="display:none;"><?php echo $gadgets[$i]['video'];?></a>
								<img src="http://www.pavanratnakar.com/images/gadgets/gadget<?php echo $gadgets[$i]['id'];?>.png" alt="<?php echo $gadgets[$i]['title'];?>" title="<?php echo $gadgets[$i]['title'];?>"/>
								<div class="ps_desc">
									<h3><?php echo $gadgets[$i]['title'];?></h3>
									<span><?php echo $gadgets[$i]['description'];?></span>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
				<div id="ps_overlay" class="ps_overlay" style="display:none;"></div>
				<a id="ps_close" class="ps_close" style="display:none;"></a>
				<div id="ps_container" class="ps_container" style="display:none;">
					<a id="ps_next_photo" class="ps_next_photo" style="display:none;"></a>
				</div>
                <div id="ps_ad" class="ps_ad" style="display:none;"></div>
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
	<script type="text/javascript" src="<?php echo Minify_getUri('gadget_js') ?>"></script>
	</body>
</html>