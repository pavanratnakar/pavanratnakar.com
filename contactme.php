<?php
include_once('controller/pageController.php');
$pageController=new PageController(7);
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
				<div class="subContainer">
					<div id="featureSuggestContainer" class="left siteCommonContainer">
					<h3 class="eventHeading">Feature Suggestions</h3>
						<div class="siteCommonInnterContainer left">
							<?php
								$pageController->initContact();
								echo $pageController->getSuggestions();
								$userid=$pageController->getUser()->getCurrenUserId();
							?>
							<form id="suggest" action="" method="post">
								<p>
									<input type="text" id="suggestionText" class="rounded" maxlength="255" />
									<input type="submit" value="Submit" id="submitSuggestion" />
								</p>
							</form>
						</div>
					</div>
					<div id="contactFormContainer" class="right siteCommonContainer">
					<h3 class="eventHeading">Contact Me</h3>
						<div class="siteCommonInnterContainer right">
							<form id="contactForm" method="post" action="">
								<div id="contactStatus"></div>
								<div class="clear"></div>
								<label for="contantName" class="grey">Name:</label>
								<input type="text" size="23" id="contantName" name="name" class="field" value="<?php echo $pageController->getUser()->formFullName($userid)?>"/>
								<label for="contactEmail" class="grey">Email:</label>
								<input type="text" size="23" id="contactEmail" name="email" class="field" value="<?php echo $pageController->getUser()->getEmail($userid)?>"/>
								<label for="contactSubject" class="grey">Subject:</label>
								<select name="subject" id="contactSubject">
									<option value="" selected="selected"> - Choose -</option>
									<option value="Question">Question</option>
									<option value="Business proposal">Business proposal</option>
									<option value="Advertisement">Advertising</option>
									<option value="Complaint">Complaint</option>
								</select>
								<label for="contactMessage" class="grey">Message:</label>
								<textarea type="text" size="23" value="" id="contactMessage" name="message" class="field"></textarea>
								<div id="QapTcha"></div>
								<div id="contactButtons">
									<input type="submit" class="bt_contact contactSubmit" value="Submit" name="submit"/>
									<input class="bt_contact cancel" type="submit" value="Cancel"/>
								</div>
							</form>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	<?php 
		echo $pageController->printFooter();
	?>
	<script type="text/javascript" src="<?php echo Minify_getUri('suggest_js') ?>"></script>
    </body>
</html>