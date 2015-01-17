<?php
include_once('controller/pageController.php');
$pageController=new PageController(3);
$pageController->initMovie();
echo $pageController->printHeader();
$firstMovie=$pageController->getFirstMovie();
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
			<div id="mainContainer" class="movieContainer">
				<h2><?php echo $pageController->printH2(); ?></h2>
				<div id="movie">
					<!-- SEARCH -->
					<?php $pageController->buildSearchBox('movie'); ?>
					<!-- SEARCH -->
					<div class="clear"></div>
					<div id="movieHeader">
						<div class="wrap">
							<div id="slide-holder">
								<div class="slide-runner" id="firstMovie-<?php echo $firstMovie['tmdbId'] ?>">
									<div id="slide-controls">
										<p id="slide-client" class="text"><strong>Movie: </strong><span><?php echo $firstMovie['movie_name'].'|'.$firstMovie['tagline'];?></span></p>
										<p id="slide-desc" class="text"></p>
										<div class="left" id="movieDescriptionContainer">
											<div class="left movieMainSlideshow">
												<?php
												$images=$firstMovie['images'];
												if(sizeof($images)>1)
												{
													shuffle($images);
												}
												foreach($images as $image)
												{
												?>
													<img src="<?php echo $image['url'] ?>" alt="<?php echo $firstMovie['movie_name'];?>" height="<?php echo $image['height'];?>" width="<?php echo $image['width'];?>" title="<?php echo $firstMovie['movie_name'];?>"/>
												<?php
												}
												?>
											</div>
											<div class="right">
												<?php
												$display="style='display:none'";
												if(!$firstMovie['movie_name'])
												{
													$nameDisplay=$display;
												}
												if(!$firstMovie['language'])
												{
													$languageDisplay=$display;
												}
												if(!$firstMovie['overview'])
												{
													$overviewDisplay=$display;
												}
												if(!$firstMovie['release'])
												{
													$releaseDisplay=$display;
												}
												if($firstMovie['rating']==0 || !$firstMovie['rating'])
												{
													$rating="Not Yet Rated";
												}
												else
												{
													$rating=$firstMovie['rating'].'/10';
												}
												echo '<div '.$nameDisplay.'><div class="left descriptionType">Name :</div><div class="left descriptionContent" id="movieName">'.$firstMovie['movie_name'].'</div></div>';
												echo '<div '.$languageDisplay.'><div class="left descriptionType">Language :</div><div class="left descriptionContent" id="movieLanguage">'.$firstMovie['language'].'</div></div>';
												echo '<div '.$overviewDisplay.'><div class="left descriptionType">Overview :</div><div class="left descriptionContent" id="movieOverview">'.$firstMovie['overview'].'</div></div>';
												echo '<div><div class="left descriptionType">Rating :</div><div class="left descriptionContent" id="movieRating">'.$rating.'</div></div>';
												echo '<div '.$releaseDisplay.'><div class="left descriptionType">Release :</div><div class="left descriptionContent" id="movieRelease">'.$firstMovie['release'].'</div>';
												echo '<div class="clear"></div>';
												echo '<div class="links">';
													if(!$firstMovie['trailer'])
													{
														$trailerDisplay=$display;
													}
													if(!$firstMovie['homepage'])
													{
														$homepageDisplay=$display;
													}
													if($firstMovie['status']>=0)
													{
														$movieReleaseDisplay=$display;
													}
													echo '<div class="left linksLeft">';
													echo '<div '.$movieReleaseDisplay.'><i class="iconsSprite target left"></i><span class="link blue" id="newMovie">To Be Released</span></div>';
													echo '<div '.$trailerDisplay.'><i class="iconsSprite video left"></i><a class="link" id="movieTrailerLink" title="View '.$firstMovie['movie_name'].' Trailer" href ="'.$firstMovie['trailer'].'">View Trailer</a></div>';
													echo '<div '.$homepageDisplay.'><i class="iconsSprite world left"></i><a class="link" id="movieOriginalLink" title="View '.$firstMovie['movie_name'].' Website" target="_blank" href ="'.$firstMovie['homepage'].'">View Movie Website</a></div>';
													echo '</div>';
													echo '<div class="movieLike left"><fb:like href="http://www.pavanratnakar.com/movie/'.$firstMovie['tmdbId'].'" send="true" layout="button_count" width="400" show_faces="true" colorscheme="dark" font="lucida grande"></fb:like></div>';
												echo '</div>';
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="ps_slider" class="ps_slider left">
					<div id="ps_albums" class="movie">
						<a class="prev iconsSprite disabled"></a>
						<a class="next iconsSprite disabled"></a>
						<?php
						$movies=$pageController->getMovies();
						for($i=0;$i<sizeof($movies);$i++)
						{
						?>
							<div class="ps_album" id="tmdb-<?php echo $movies[$i]['tmdbId'];?>" style="opacity:0;">
								<div class="movieSlideshow">
									<?php
									$j=0;
									$thumbnails=$movies[$i]['images'];
									shuffle($thumbnails);
									?>
									<img src="<?php echo $thumbnails[0]['url'] ?>" alt="<?php echo $movies[$i]['movie_name'];?>" height="<?php echo $thumbnails[0]['height'];?>" width="<?php echo $thumbnails[0]['width'];?>" title="<?php echo $movies[$i]['movie_name'];?>"/>
								</div>
								<div class="ps_desc">
									<h3><?php echo $movies[$i]['movie_name'];?></h3>
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
	<script type="text/javascript" src="<?php echo Minify_getUri('movie_js') ?>&debug=true"></script>
	</body>
</html>