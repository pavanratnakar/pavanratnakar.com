<?php
class PageController {
    private $pageNumber;
    private $pageDetails;
    private $meta;
    private $user;
    private $utils;
    private $comments;
    private $commentId;
    private $gadgetId;
    private $movieId;
    private $movies;
    private $firstMovie;
    private $galleryId;
    private $suggestion;
    private $suggestions;
    private $tutorial;
    private $tutorials;
    private $tutorialQuery;
    private $subTutorialQuery;
    public function __construct($pageNumber) {       
        if (file_exists('config/config.php')) {
            $path='';
        } else {
            $path='../';
        }
        include_once (''.$path.'class/user.php');
        $this->user=new User();
        if ($pageNumber != -1) {
            include_once (''.$path.'config/config.php');
            include_once (''.$path.'class/functions.php');
            include_once (''.$path.'class/page.php');
            include_once (''.$path.'class/meta.php');
            include_once (''.$path.'min/utils.php');
            ob_start();
            session_name(Config::$session_name);
            session_set_cookie_params(Config::$session_expiry);
            session_start();
            error_reporting(E_ALL^E_NOTICE);
            $this->utils=new Functions();
            $this->checkLogout();
            $page=new Page();
            $this->pageNumber=$pageNumber;
            $this->pageDetails=$page->getPageDetails();
            $this->meta=$this->getMeta();
        }
    }
    /* GETTERS AND SETTERS */
    public function setPageNumber($pageNumber) {
        $this->pageNumber=$pageNumber;
    }
    public function getPageNumber() {
        return $this->pageNumber;
    }
    public function setPageDetails($pageDetails) {
        $this->pageDetails=$pageDetails;
    }
    public function getPageDetails() {
        return $this->pageDetails;
    }
    public function setUser($user) {
        $this->user=$user;
    }
    public function getUser() {
        return $this->user;
    }
    public function setUtils($utils) {
        $this->utils=$utils;
    }
    public function getUtils($utils) {
        return $this->utils;
    }
    public function setComments($comments) {
        $this->comments=$comments;
    }
    public function getComments() {
        return $this->comments;
    }
    public function setCommentId($commentId) {
        $this->commentId=$commentId;
    }
    public function getCommentId() {
        return $this->commentId;
    }
    public function setGadgetId($gadgetId) {
        $this->gadgetId=$gadgetId;
    }
    public function getGadgetId() {
        return $this->gadgetId;
    }
    public function setMovieId($movieId) {
        $this->movieId=$movieId;
    }
    public function getMovieId() {
        return $this->movieId;
    }
    public function setFirstMovie($firstMovie) {
        $this->firstMovie=$firstMovie;
    }
    public function getFirstMovie() {
        return $this->firstMovie;
    }
    public function setMovies($movies) {
        $this->movies=$movies;
    }
    public function getMovies() {
        return $this->movies;
    }
    public function setGalleryId($galleryId) {
        $this->galleryId=$galleryId;
    }
    public function getGalleryId() {
        return $this->galleryId;
    }
    public function setSuggestion($suggestion) {
        $this->suggestion=$suggestion;
    }
    public function getSuggestion() {
        return $this->suggestion;
    }
    public function setSuggestions($suggestions) {
        $this->suggestions=$suggestions;
    }
    public function getSuggestions() {
        return $this->suggestions;
    }
    public function setTutorial($tutorial) {
        $this->tutorial=$tutorial;
    }
    public function getTutorial() {
        return $this->tutorial;
    }
    public function setTutorials($tutorials) {
        $this->tutorials=$tutorials;
    }
    public function getTutorials() {
        return $this->tutorials;
    }
    public function setTutorialQuery($tutorialQuery) {
        $this->tutorialQuery=$tutorialQuery;
    }
    public function getTutorialQuery() {
        return $this->tutorialQuery;
    }
    public function setSubTutorialQuery($subTutorialQuery) {
        $this->subTutorialQuery=$subTutorialQuery;
    }
    public function getSubTutorialQuery() {
        return $this->subTutorialQuery;
    }   
    /* GETTERS AND SETTERS */
    /* HEADER */
    public function getMeta(){
        $meta=new Meta(
            "Pavan Ratnakar :: ".$this->pageDetails[$this->pageNumber]['title'],
            "website",
            $this->pageDetails[$this->pageNumber]['description'],
            $this->pageDetails[$this->pageNumber]['keywords'],
            "http://www.pavanratnakar.com/".$this->pageDetails[$this->pageNumber]['link']
            );
        return $meta;
    }
    public function printHeader() {
        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
        <meta name="keywords" content="'.$this->meta->getKeywords().'" />
        <meta name="description" content="'.$this->meta->getDescription().'" />
        <meta name="author" content="Pavan Ratnakar" />
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta property="og:title" content="'.$this->meta->getTitle().'" />
        <meta property="og:type" content="'.$this->meta->getType().'" />
        <meta property="og:image" content="'.$this->meta->getImage().'" />
        <meta property="og:description" content="'.$this->meta->getDescription().'" />
        <meta property="og:site_name" content="Pavan Ratnakar Applications" />
        <meta property="og:url" content="'.$this->meta->getMetaURL().'"/>
        <meta property="fb:admins" content="100000417819011" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@pavanratnakar" />
        <meta name="twitter:creator" content="@pavanratnakar" />
        <meta name="twitter:title" content="'.$this->meta->getTitle().'" />
        <meta name="twitter:description" content="'.$this->meta->getDescription().'" />
        <meta name="twitter:image:src" content="'.$this->meta->getImage().'" />
        <meta itemprop="name" content="'.$this->meta->getTitle().'" />
        <meta itemprop="description" content="'.$this->meta->getDescription().'" />
        <meta itemprop="image" content="'.$this->meta->getImage().'" />
        <title>'.$this->meta->getTitle().'</title>
        <link type="text/css" rel="stylesheet" media="all" href="'.Minify_getUri('main_css').'"/>';
    }
    /* HEADER */
    /* PANEL */
    public function printPanel() {
        $userid=$this->user->getCurrenUserId();
        $panel_name=($userid) ? 'View Your Profile' : 'Log In | Register';
        $class_name=($userid) ? '' : 'login';
        return '<div id="panel"></div>
        <!-- The tab on top -->
        <div class="tab">
        <ul class="login">      
        <li class="left">&nbsp;</li>        
        <li id="greetingUser">Hello '.$this->user->getTabUserName().'</li>      
        <li class="sep ">|</li>     
        <li id="toggle ">           
        <a id="open" class="open iconsSprite '.$class_name.'" href="javascript:void(0);">'.$panel_name.'</a>            
        <a id="close" style="display: none;" class="close iconsSprite" href="javascript:void(0);">Close Panel</a>                   
        </li>       
        <li class="right">&nbsp;</li>   
        </ul> 
        </div> 
        <!-- / top -->';
    }   
    /* PANEL */
    public function printPanelContent() {
        $check=$this->user->checkLoginType();
        $userid=$this->user->getCurrenUserId();
        $returnString='
        <div class="panelContent clearfix">
        <div id="panelUpdates" class="left leftContainer">
        <h2>Welcome to Pavan Ratnakar Website</h2>
        Thank you for visiting my website. Please feel free to reach me out for any clarifications.
        <h3>Upcoming updates to the website.</h3>
        <ul>
        <li>Picassa + Facebook + Flickr Gallery Integration.</li>
        <li>User Profile Details.</li>
        </ul>
        <h3>Last updates added to the website.</h3>
        <ul>
        <li>Movie Section.</li>
        <li>Facebook Login integration is complete.</li>
        <li>Changed to friendly URL\'s.</li>
        </ul>
        </div>';
        if ($check==FALSE) {
            $returnString.='<div id="panelLogin" class="left leftContainer">
            <form id="loginForm" method="post" action="" class="clearfix">
            <h2>Member Login</h2>
            <div id="loginStatus"></div>
            <div class="clear"></div>
            <label for="loginEmail" class="grey">Email:</label>
            <input type="text" size="23" value="" id="loginEmail" name="email" class="field"/>
            <label for="loginPassword" class="grey">Password:</label>
            <input type="password" size="23" id="loginPassword" name="password" class="field"/>
            <label class="radio">
            <input type="checkbox" value="1" checked="checked" id="rememberMe" name="rememberMe"> &nbsp;Remember me
            </label>
            <div class="clear"></div>
            <input type="submit" class="bt_login" value="Login" name="submit"/>
            </form>
            <div class="clear"></div>
            <!--<div>
            <h2>Login using below accounts</h2>
            <div id="otherLoginContainer">
            <fb:login-button show-faces="true" width="280" max-rows="1"></fb:login-button>
            </div>
            </div>
            -->
            </div>
            <div id="panelRegister" class="left leftContainer">
            <form method="post" id="registerForm" action="" class="clearfix" enctype="multipart/form-data">
            <h2>Not a member yet? Sign Up!</h2>
            <div id="registerStatus"></div>
            <div class="clear"></div>
            <label for="registerFirstname" class="grey">First Name:</label>
            <input type="text" size="23" value="" id="registerFirstname" name="firstname" class="field"/>
            <label for="registerLastname" class="grey">Last Name:</label>
            <input type="text" size="23" id="registerLastname" name="lastname" class="field"/>
            <label for="text" class="grey">Email:</label>
            <input type="text" size="23" value="" id="registerEmail" name="email" class="field"/>
            <label for="registerPassword" class="grey">Password:</label>
            <input type="password" size="23" value="" id="registerPassword" name="password" class="field"/>
            <div class="password-meter right">
            <div class="password-meter-message">Password Stength Meter</div>
            <div class="password-meter-bg">
            <div class="password-meter-bar"></div>
            </div>
            </div>
            <label for="sexSelect" class="grey">I am:</label>
            <select name="sexSelect" id="sexSelect">
            <option value="">Select Sex</option>
            <option value="1">Male</option>
            <option value="2">Female</option>
            </select>
            <label for="registerBirthDate" class="grey">Birthday:</label>
            <input type="text" size="23" value="" id="registerBirthDate" name="registerBirthDate" class="field"/>
            <div class="clear"></div>
            <input type="submit" class="bt_register" value="Sign Up" name="submit"/>
            </form>
            </div>';
        } else {
            $returnString.='<div id="panelLogin" class="left leftContainer">
            <h2>Profile</h2>';
            if ($check==1) { 
                $returnString.='<a href="passwordreset">Change Your Password</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<a href="profile">Edit you profile</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<a id="normalLogout" href="javascript:void(0);">Log off</a>';
            }
            if ($check==2) {
                $returnString.='<a target="_blank" href="https://www.facebook.com/profile.php?'.$userid.'">View your Facebook profile</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<a id="facebookLogout" href="javascript:void(0);">Log off</a>';
            }
            $returnString.='<h3>Personal Details</h3>';
            $returnString.=$this->user->getDetails($userid);
            $returnString.='</div>
            <div id="panelRegister" class="left leftContainer">
            <h2>Statistics</h2>
            <h3>Login statistics</h3>';
            $returnString.=$this->user->loginStatistics($userid);
            $returnString.='<h3>Comment statistics</h3>';
            $returnString.=$this->user->commentStatistics($userid);
            if ($check==2) {
                    //echo '<fb:login-button show-faces="true" width="280" max-rows="1"></fb:login-button>';
            }
            $returnString.='</div>';
        }
        $returnString.='</div>';
        return $returnString;
    }
    /* NAVIGATION */
    public function printNavigation() {
        $return_string='<div id="header">
        <h1>PAVAN RATNAKAR <sup>2D</sup></h1>
        <div id="navigation" class="left">
        <ul class="menuUL" id="navgiationMenu">
        <!-- The class names that are assigned to the links correspond to name of the shape that is shown on hover: -->';
        for ($i=0;$i<sizeof($this->pageDetails);$i++) {
            if ($i==$this->pageNumber) {
                $class="current";
                $liclass="current_page_item";
            } else {
                $class="";
                $liclass="";
            }
            if ($i==(sizeof($this->pageDetails)-1)) {
                $class.=" last";
            }
            if ($this->pageDetails[$i]['menu']!="") {
                $return_string.="<li class='".$liclass."'><a class='".$class."' href='http://www.pavanratnakar.com/".$this->pageDetails[$i]['link']."'>".$this->pageDetails[$i]['menu']."</a></li>";
            }
        }
        $return_string.='        </ul>
        </div>
        <div class="clear"></div>
        </div>';
        return $return_string;
    }   
    /* NAVIGATION */
    /* H2 TAGS */
    public function printH2() {
        return $this->pageDetails[$this->pageNumber]['name'];
    }
    /* H2 TAGS */
    /* CHECK LOGOUT */
    public function checkLogout() {
        if (isset($_REQUEST['logoff'])) {
            $this->user->logoutUser();
            header('Location: '.$this->utils->curPageURL()) ;
            exit;
        }
    }
    /* CHECK LOGOUT */
    /* COMMENT */
    public function initComment($commentId=null) {
        include_once ('class/comment.php');
        if ($commentId) {
            $this->commentId=$this->pageDetails[$this->pageNumber]['chat'].'|'.$commentId;;
        } else {
            $this->commentId=$this->pageDetails[$this->pageNumber]['chat'];
        }
        $this->comments=new Comment($this->commentId);
    }
    public function printComment() {
        return $this->comments->printComment($this->commentId);
    }
    public function javascriptPrintComment() {
        return $this->comments->javascriptPrint();
    }
    /* COMMENT */
    /* FOOTER */
    public function googleAd($adSlot,$adWidth,$adHeight) {
        return '<script type="text/javascript">
        <!--
        google_ad_client = "'.Config::$googleAdId.'";
        /* single line */
        google_ad_slot = "'.$adSlot.'";
        google_ad_width = '.$adWidth.';
        google_ad_height = '.$adHeight.';
            //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
    }
    public function shareThisContainer() {
        return '<div class="subfooter" id="shareThisContainer">
        <div class="footer-content left">
        <span id="share_this_google" class="st_plusone_button" st_url="'.$this->meta->getMetaURL().'"></span>
        <span id="share_this_facebook" class="st_fblike_hcount"  st_url="'.$this->meta->getMetaURL().'"></span>         
        </div>
        <div class="footer-content right">
        <span id="share_this_sharethis" class="st_sharethis_large" st_url="'.$this->meta->getMetaURL().'" displayText="ShareThis"></span>
        </div>
        <div class="right header">
        <h3>Share This</h3>
        </div>
        <div class="clear"></div>
        </div>';
    }
    public function socialContainer() {
        return '<div class="socialContainer">
        <div class="footer-content col-option3 left">
        <div class="footer-column recentComments">
        <h4>Latest Comments</h4>    
        <ul id="recentComments" class="socialColumn">
        <li>Loading...</li>
        </ul>
        </div>
        <div class="footer-column lastestfacebookPost">
        <h4>Latest Facebook Feed</h4>
        <ul id="facebookPosts" class="socialColumn">
        <li>Loading...</li>
        </ul>
        </div>
        <div class="footer-column latesttweets">
        <h4>Latest Tweets</h4>  
        <ul id="tweets" class="socialColumn">
        <li>Loading...</li>
        </ul>
        </div>
        </div>
        <div class="clear"></div>
        </div>';
    }
    public function subFooter() {
        return 
        '<div class="subfooter">
        <div class="left" id="contactInfo">
        <h4>Contact Info</h4>
        <ul class="contact-widget contactInfo left">
        <li class="tel left"><i class="iconsSprite left"></i><div class="contantContainer">+(91) 9742272426</div></li>
        <li class="email left"><i class="iconsSprite left"></i><div class="contantContainer"><a href="mailto:pavanratnakar@gmail.com">pavanratnakar@gmail.com</a></div></li>
        </ul>
        </div>
        <div class="right">
        <a target="_blank" class="socialIcon" href="http://twitter.com/pavanratnakar"><i class="socialSprite left" id="twitterIcon"></i></a>
        <a target="_blank" class="socialIcon" href="http://www.facebook.com/profile.php?id=100000417819011"><i class="socialSprite left" id="facebookIcon"></i></a>
        <a target="_blank" class="socialIcon" href="http://www.flickr.com/photos/pavanratnakar/"><i class="socialSprite left" id="flickrIcon"></i></a>
        <a target="_blank" class="socialIcon" href="https://profiles.google.com/pavanratnakar"><i class="socialSprite left" id="googleIcon"></i></a>
        <a target="_blank" class="socialIcon" href="http://www.linkedin.com/pub/pavan-ratnakar/17/46b/694"><i class="socialSprite left" id="inIcon"></i></a>
        <a target="_blank" class="socialIcon" href="http://www.orkut.co.in/Main#Profile?uid=14173517175091902205&pcy=3&t=0"><i class="socialSprite left" id="orkutIcon"></i></a>
        <a target="_blank" class="socialIcon" href="https://picasaweb.google.com/pavanratnakar"><i class="socialSprite left" id="picassaIcon"></i></a>
        <!--
        <a target="_blank" class="socialIcon" href=""><i class="socialSprite left" id="yahooIcon"></i></a>
        <a target="_blank" class="socialIcon" href=""><i class="socialSprite left" id="yahooBuzz"></i></a>
        -->
        </div>
        <div class="clear"></div>
        </div>';
    }
    public function signature() {
        return  '<p class="signature">'.date('Y').' Pavan Ratnakar - Applications &nbsp;&nbsp;&middot;&nbsp;&nbsp; All my applications are dedicated to Pepsy Ratnakar</p>';
    }
    public function bottomScript() {
        return
        '<div id="fb-root"></div>
        <script type="text/javascript" src="'.Minify_getUri("main_js").'"></script>
        <!-- Internet Explorer HTML5 enabling script: -->
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->';
    }
    public function printFooter() {
        $return_string='<div id="footerWrapper"><!-- Start big footer --><div id="big-footer">'.$this->shareThisContainer().$this->socialContainer().$this->subFooter().$this->signature().'</div><!-- End big footer --></div>';
        $return_string.='<div align="center">'.$this->googleAd('0772185248','728','90').'</div>'.$this->bottomScript();
        return $return_string;
    }
    /* FOOTER */
    /* HOME PAGE */
    public function getHomePageSlider() {
        include_once ('class/slider.php');
        $slider=new Slider();
    }
    /* HOME PAGE */
    /* ABOUT ME */
    public function printAboutMe() {
        include_once ('class/about.php');
        $about=new About();
        $this->initComment();
        return $about->printAboutMe();
    }
    /* ABOUT ME */
    /* GADGETS */
    public function initGadget() {
        include_once ('class/gadget.php');
        $gadget=new Gadget();
        if (isset($_REQUEST['gadgetid'])) {
            $this->gadgetId=$_REQUEST['gadgetid'];
            $this->commentId=$this->gadgetId;
        } else {
            $this->gadgetId=null;
            $this->commentId=null;
        }
        $this->initComment($this->commentId);
        $gadgets=$gadget->getPageSpecificGadgets($this->gadgetId);
        if (isset($_REQUEST['gadgetid'])) {
            $this->meta=new Meta(
                "Pavan Ratnakar :: ".$this->pageDetails[$this->pageNumber]['title']." : ".$gadgets[0]['title'],
                "product",
                $gadgets[0]['description'],
                $pageDetails[$pageNumber]['keywords'].', '.$gadgets[0]['title'],
                "http://www.pavanratnakar.com/gadget/".$gadgets[0]['id']."",
                'http://www.pavanratnakar.com/images/gadgets/gadget'.$gadgets[0]['id'].'.png'
                );
        }
        return $gadgets;
    }
    /* GADGETS */
    /* MOVIES */
    public function initMovie() {
        include_once ('class/movie.php');
        $movie=new Movie();
        if (isset($_REQUEST['movieid'])) {
            $this->movieId=$_REQUEST['movieid'];
            $commentId=$this->movieId;
        } else {
            $this->movieId=null;
            $commentId=null;
        }
        $this->initComment($commentId);
        $this->movies=$movie->getPageSpecificMovies($this->movieId);
        $this->firstMovie=$movie->getMovieDetails($this->movies[0]['tmdbId']);
        if (isset($_REQUEST['movieid'])) {
            $this->meta=new Meta(
                "Pavan Ratnakar :: ".$this->pageDetails[$this->pageNumber]['title']." : ".$this->firstMovie['movie_name'],
                "article",
                $this->firstMovie['overview'],
                $this->pageDetails[$this->pageNumber]['keywords'].', '.$this->firstMovie['movie_name'],
                "http://www.pavanratnakar.com/movie/".$this->firstMovie['tmdbId']."",
                $this->firstMovie['images'][0]['url']
                );
        }
    }
    /* MOVIES */
    /* SEARCH */
    public function buildSearchBox($type) {
        include_once ('class/search.php');
        $search=new Search($type);
        $search->buildSearchBox();
    }
    /* SEARCH */
    /* TIMELINE */
    public function initTimeLine() {
        require_once ('class/timeline.php');
        $timeline=new Timeline();
        $this->initComment();
        return $timeline;
    }
    /* TIMELINE */
    /* PROFILE */
    public function initProfile() {
        $this->utils->checkSecuredPage();
    }
    /* PROFILE */
    /* GALLERY */
    public function initGallery() {
        include_once ('class/gallery.php');
        $gallery=new Gallery();
        if (isset($_REQUEST['galleryid'])) {
            $this->galleryId=$_REQUEST['galleryid'];
            $commentId=$this->galleryId;
        } else {
            $this->galleryId=null;
            $commentId=null;
        }
        $this->initComment($commentId);
        $galleries=$gallery->getPageSpecificGalleries($this->galleryId);
        if (isset($_REQUEST['galleryid'])) {
            $this->meta=new Meta(
                "Pavan Ratnakar :: ".$this->pageDetails[$this->pageNumber]['title']." : ".ucwords(strtolower($galleries[0]['title'])),
                "album",
                $galleries[0]['description'],
                $this->pageDetails[$this->pageNumber]['keywords'].', '.ucwords(strtolower($galleries[0]['title'])),
                "http://www.pavanratnakar.com/gallery/".$galleries[0]['id']."",
                'http://www.pavanratnakar.com/albums/album'.strtolower($galleries[0]['id']).'/thumb/thumb.jpg'
                );
        }
        return $galleries;
    }
    /* GALLERY */
    /* CONTACT ME */
    public function initContact() {
        include_once ('class/suggestion.php');
        $suggestion=new Suggestion();
        $this->suggestions=$suggestion->showAllSuggestion();
    }
    /* CONTACT ME */
    /* TUTORIAL */
    public function initTutorial() {
        include_once ('class/tutorial.php');
        $this->tutorial=new Tutorial();
        if (isset($_GET['tutorialid']) && isset($_GET['subtutorialid'])) {
            $this->tutorials=$this->tutorial->getTutorials($this->utils->checkValues($_GET['tutorialid']),$this->utils->checkValues($_GET['subtutorialid']));
            $this->tutorialQuery=$this->tutorials['query'];
            $this->subTutorialQuery=$this->tutorials['subtutorials']['query'];
            $this->tutorial->setMainPage(FALSE);
            $commentId=$this->tutorials['id'].'|'.$this->tutorials['subtutorials']['id'];
            $this->meta=new Meta(
                "Pavan Ratnakar :::: ".$this->pageDetails[$this->pageNumber]['title']." ::: ".$this->tutorials['name'].' :: '.$this->tutorials['subtutorials']['name'],
                "article",
                $this->tutorials['subtutorials']['description'],
                $this->pageDetails[$this->pageNumber]['keywords'].', '.$this->tutorials['subtutorials']['keyword'],
                'http://www.pavanratnakar.com/tutorial/'.$this->tutorials['id'].'/'.$this->tutorials['subtutorials']['id'].''
                );
        } else {   
            $this->tutorial->setMainPage(TRUE);
            $this->tutorials=$this->tutorial->getTutorials();
            $commentId=null;
        }
        $this->initComment($commentId);
    }
    /* TUTORIAL */
    /* SITE MAP */
    public function initSiteMap() {
        $url_name='';
        $return_string='';
        include_once ('class/movie.php');
        include_once ('class/gadget.php');
        include_once ('class/gallery.php');
        include_once ('class/tutorial.php');
        foreach ($this->pageDetails as $page) {
            if ($page['menu']!="") {
                $url_name=ucwords(strtolower($page['name']));
                $return_string.= '<li><a href="http://www.pavanratnakar.com/'.$page['link'].'" title="'.$url_name.'">'.$url_name.'</a></li>';
                if ($page['id'] == 2) {
                    $gadget=new Gadget();
                    $gadget_array=$gadget->getAllGadgets();
                    $return_string.= '<ul>';
                    foreach($gadget_array as $gadget) {
                        $return_string.= '<li><a href="http://www.pavanratnakar.com/gadget/'.$gadget['id'].'" title="'.$gadget['title'].'">'.$gadget['title'].'</a></li>';
                    }
                    $return_string.= '</ul>';
                }
                if ($page['id'] == 3) {
                    $movie=new Movie();
                    $movie_array=$movie->getAllMovies(0);
                    $return_string.= '<ul>';
                    foreach($movie_array as $movie) {
                        $return_string.= '<li><a href="http://www.pavanratnakar.com/movie/'.$movie['tmdbId'].'" title="'.$movie['movie_name'].'">'.$movie['movie_name'].'</a></li>';
                    }
                    $return_string.= '</ul>';
                }
                if ($page['id'] == 5) {
                    $gallery=new Gallery();
                    $gallery_array=$gallery->getAllGalleries();
                    $return_string.= '<ul>';
                    foreach($gallery_array as $gallery) {
                        $gallery_title=ucwords(strtolower($gallery['title']));
                        $return_string.= '<li><a href="http://www.pavanratnakar.com/gallery/'.$gallery['id'].'" title="'.$gallery_title.'">'.$gallery_title.'</a></li>';
                    }
                    $return_string.= '</ul>';
                }
                if ($page['id'] == 6) {
                    $return_string.= '<ul>';
                    $return_string.= '<li><a href="http://www.pavanratnakar.com/resumedocs/Pavan_Ratnakar.pdf" target="_blank" title="Download PDF Version">Download PDF Version</a></li>';
                    $return_string.= '<li><a href="http://www.pavanratnakar.com/resumedocs/Pavan_Ratnakar.doc" title="Download Word/Doc Version">Download Word/Doc Version</a></li>';
                    $return_string.= '</ul>';
                }
                if ($page['id'] == 12) {
                    $tutorial=new Tutorial();
                    $tutorials=$tutorial->getTutorials();
                    $return_string.= '<ul>';
                    foreach($tutorials as $tutorial) {
                        $return_string.= '<li><a href="javascript:void(0);" title="'.$tutorial['name'].'">'.$tutorial['name'].'</a></li>';
                        if (sizeof($tutorial['subtutorials']) > 0) {
                            $return_string.= '<ul>';
                            foreach($tutorial['subtutorials'] as $subtutorial) {
                                if ($subtutorial->id == 0) {
                                    $link="javascript:void(0);";
                                    $name='To be updated.';
                                } else {
                                    $link="http://www.pavanratnakar.com/tutorial/".$tutorial['id']."/".$subtutorial->id;
                                    $name=$subtutorial->name;
                                }
                                $return_string.= '<li><a href="'.$link.'" title="'.$name.'">'.$name.'</a></li>';
                            }
                            $return_string.= '</ul>';
                        }
                    }
                    $return_string.= '</ul>';
                }
            }
        }
        return $return_string;
    }
    /* SITE MAP */
    /* HACKS */
    public function initHacks() {
        $this->initComment($this->commentId);
    }
    /* HACKS */
}
?>