<?php
include_once('controller/pageController.php');
$pageController=new PageController(10);
echo $pageController->printHeader();
?>
	</head>
	<body>
		<div id="wrapper">
			<?php echo $pageController->printNavigation(); ?>
			<div id="mainContainer">
				<h2><?php echo $pageController->printH2(); ?></h2>
				<div class="subContainer">
					<div id="compatiblity" class="siteCommonContainer left">
						<div class="left siteCommonInnterContainer ">
							<h3>SORRY - YOU CANNOT VIEW THE SITE DUE TO BROWSER COMPATIBILITY ISSUE</h3>
							The web has evolved in the last ten years, from simple text pages to rich, interactive applications including video and voice. Unfortunately, very old browsers cannot run many of these new features effectively. My site currently does not support your browser. I encourage you to update your browsers as soon as possible. Also, I will surely try rolling out updates in future which would support your browser. 
							When it comes to Modern browsers, there are many choices:
							<br/><br/>
							<a href="http://www.microsoft.com/windows/Internet-explorer/default.aspx">Microsoft Internet Explorer 8.0+</a>
							<br/>
							<a href="http://www.mozilla.com/en-US/firefox/firefox.html">Mozilla Firefox 3.0+</a>
							<br/>
							<a href="http://www.google.com/chrome?brand=CHFV">Google Chrome 4.0+</a>
							<br/>
							<a href="http://www.apple.com/safari/">Safari 3.0+</a>
							<br/><br/>
							Many other companies have already stopped supporting older browsers like Internet Explorer 6.0 as well as browsers that are not supported by their own manufacturers.
							Please take the time to switch your browser to the most up-to-date browsers available.
							<br/><br/>Please feel free to mail me at <a href="mailto:pavanratnakar@gmail.com">pavanratnakar@gmail.com</a> for more information.
							<h3>THANK YOU!</h3>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<script type="text/javascript" src="<?php echo Minify_getUri('compatibility_js') ?>"></script>
    </body>
</html>