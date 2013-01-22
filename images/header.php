<?php
ob_start();
session_name('pavanLogin');
// Starting the session
session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();
error_reporting(E_ALL^E_NOTICE);
require_once('class/user.php');
require_once('class/functions.php');
$user=new User();
$function=new Functions();
if(isset($_REQUEST['logoff']))
{
	$user->logoutUser();
	header('Location: '.$function->curPageURL()) ;
	exit;
}
require_once('min/utils.php');
require_once('class/facebook.php');
require_once('class/tweet.php');
require_once('class/comment.php');
require_once('class/meta.php');
/// META FOR TUTORIALS
if(isset($tutorialQuery) && isset($subTutorialQuery))
{
	$meta=new Meta(
		"Pavan Ratnakar :::: ".$pageDetails[$pageNumber]['title']." ::: ".$tutorials['name'].' :: '.$tutorials['subtutorials']['name'],
		"article",
		$tutorials['subtutorials']['description'],
		$pageDetails[$pageNumber]['keywords'].', '.$tutorials['subtutorials']['keyword'],
		'http://www.pavanratnakar.com/tutorial/'.$tutorials['id'].'/'.$tutorials['subtutorials']['id'].''
	);
}
/// META FOR TUTORIALS
/// META FOR GADGETS
else if($gadgets AND $_REQUEST['gadgetid'])
{
	$meta=new Meta(
		"Pavan Ratnakar :: ".$pageDetails[$pageNumber]['title']." : ".$gadgets[0]['title'],
		"product",
		$gadgets[0]['description'],
		$pageDetails[$pageNumber]['keywords'].', '.$gadgets[0]['title'],
		"http://www.pavanratnakar.com/gadget/".$gadgets[0]['id']."",
		'http://www.pavanratnakar.com/images/gadgets/gadget'.$gadgets[0]['id'].'.png'
	);
}
/// META FOR GADGETS
/// META FOR MOVIES
else if($movies AND $_REQUEST['movieid'])
{
	$meta=new Meta(
		"Pavan Ratnakar :: ".$pageDetails[$pageNumber]['title']." : ".$firstMovie['movie_name'],
		"article",
		$firstMovie['overview'],
		$pageDetails[$pageNumber]['keywords'].', '.$firstMovie['movie_name'],
		"http://www.pavanratnakar.com/movie/".$firstMovie['tmdbId']."",
		$firstMovie['images'][0]['url']
	);
}
/// META FOR MOVIES
/// META FOR OTHER PAGES
else
{
	$meta=new Meta(
		"Pavan Ratnakar :: ".$pageDetails[$pageNumber]['title'],
		"website",
		$pageDetails[$pageNumber]['description'],
		$pageDetails[$pageNumber]['keywords'],
		"http://www.pavanratnakar.com/".$pageDetails[$pageNumber]['link']
	);
}
/// META FOR OTHER PAGES
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
		<meta name="keywords" content="<?php echo $meta->getKeywords();?>" />
		<meta name="description" content="<?php echo $meta->getDescription();?>" />
		<meta name="author" content="Pavan Ratnakar" />
		<meta name="robots" content="index, follow" />
		<meta name="googlebot" content="index, follow" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta property="og:title" content="<?php echo $meta->getTitle();?>" />
		<meta property="og:type" content="<?php echo $meta->getType();?>" />
		<meta property="og:image" content="<?php echo $meta->getImage();?>" />
		<meta property="og:description" content="<?php echo $meta->getDescription();?>" />
		<meta property="og:site_name" content="Pavan Ratnakar Applications" />
		<meta property="og:url" content="<?php echo $meta->getMetaURL();?>"/>
		<meta property="fb:admins" content="100000417819011" />
		<title><?php echo $meta->getTitle();?></title>
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo Minify_getUri('main_css') ?>"/>
	</head>