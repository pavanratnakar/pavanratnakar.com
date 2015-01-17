<?php
	require_once('min/utils.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"	
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Resume (Print Version) :: Pavan Ratnakar</title>
	<meta name="keywords" content="printable resume, web developer resume, php developer resume, printer friendly resume" />
	<meta name="description" content="Printable version of Pavan Ratnakar's PHP | UI Web Developer Resume" />
	<meta name="author" content="Pavan Ratnakar" />
	<meta name="robots" content="index, follow" />
	<meta name="googlebot" content="index, follow" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo Minify_getUri('resume_print_css') ?>">
</head>
<body id="resume">
	<div id="resumePopup">			
		<img src="images/icons/print.png" class="print" width="25" height="25" border="0" alt="printer friendly" style="margin-right:5px;"/> 
		<a href="javascript:printWindow()">Print this page</a>
		<?php require_once('include/resumeBody.php'); ?>
	</div>
	<?php echo '<!-- created: '.date('l jS \of F Y h:i:s A').' -->';?>
	<script type="text/javascript">
	function printWindow()
	{
	   bV = parseInt(navigator.appVersion)
	   if (bV >= 4) window.print()
	}
	</script>
	<!-- GOOGLE ANALYTICS CODE -->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-22528464-1']);
	  _gaq.push(['_setDomainName', '.pavanratnakar.com']);
	  _gaq.push(['_trackPageview']);
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
	<!-- END OF ANALYTICS CODE -->	
</body>
</html>