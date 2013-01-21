<?php
include_once('controller/pageController.php');
$pageController=new PageController(5);
$galleries=$pageController->initGallery();
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
				<div id="ps_slider" class="ps_slider">
					<div id="ps_albums" class="gallery">
					<a class="prev iconsSprite disabled"></a>
					<a class="next iconsSprite disabled"></a>
						<?php
						for($i=0;$i<sizeof($galleries);$i++)
						{
						?>
							<div class="ps_album" id="album<?php echo $galleries[$i]['id'];?>" style="opacity:0;">
								<img src="http://www.pavanratnakar.com/albums/album<?php echo strtolower($galleries[$i]['id']);?>/thumb/thumb.jpg" alt="<?php echo $galleries[$i]['title'];;?>" title="<?php echo $galleries[$i]['title'];?>"/>
								<div class="ps_desc">
									<h3><?php echo $galleries[$i]['title'];?></h3>
									<span><?php echo $galleries[$i]['description'];?></span>
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
	<script type="text/javascript" src="<?php echo Minify_getUri('gallery_js') ?>"></script>
    </body>
</html>