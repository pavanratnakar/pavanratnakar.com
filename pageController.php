<?php
class PageController
{
    private $pageNumber;
    private $pageDetails;
    private $meta;
    private $user;
    private $utils;
    public function __construct($pageNumber)
    {
        if(file_exists('config/config.php'))
        {
            $path='';
        }
        else
        {
            $path='../';
        }
        if($pageNumber!=-1)
        {
            include_once (''.$path.'config/config.php');
            include_once (''.$path.'class/functions.php');
            include_once (''.$path.'class/page.php');
            include_once (''.$path.'class/meta.php');
            include_once (''.$path.'../min/utils.php');
            ob_start();
            error_reporting(E_ALL^E_NOTICE);
            $this->utils=new Functions();
            $page=new Page();
            $this->pageNumber=$pageNumber;
            $this->pageDetails=$page->getPageDetails();
            $this->meta=$this->getMeta();
        }
    }
    /* GETTERS AND SETTERS */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber=$pageNumber;
    }
    public function getPageNumber()
    {
        return $this->pageNumber;
    }
    public function setPageDetails($pageDetails)
    {
        $this->pageDetails=$pageDetails;
    }
    public function getPageDetails()
    {
        return $this->pageDetails;
    }
    public function setUtils($utils)
    {
        $this->utils=$utils;
    }
    public function getUtils($utils)
    {
        return $this->utils;
    }

    /* GETTERS AND SETTERS */
    /* HEADER */
    public function getMeta()
    {
        $meta=new Meta(
            "Pavan Ratnakar :: ".$this->pageDetails[$this->pageNumber]['title'],
            "website",
            $this->pageDetails[$this->pageNumber]['description'],
            $this->pageDetails[$this->pageNumber]['keywords'],
            "http://www.pavanratnakar.com/".$this->pageDetails[$this->pageNumber]['link']
        );
        return $meta;
    }
    public function printHeader($name)
    {
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
                <title>'.$this->meta->getTitle().'</title>
                <link type="text/css" rel="stylesheet" media="all" href="'.Minify_getUri($name).'"/>';
    }
    /* HEADER */
    /* PANEL */
    /* H2 TAGS */
    public function printH2()
    {
        return $this->pageDetails[$this->pageNumber]['name'];
    }
    /* H2 TAGS */

    /* COMMENT */
    public function initFacebookComment()
    {
        return '<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=210274865661234";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, \'script\', \'facebook-jssdk\'));</script>';
    }
    /* COMMENT */
    /* FOOTER */
    public function googleAd($adSlot,$adWidth,$adHeight)
    {
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
    public function shareThisContainer()
    {
        return '<div class="subfooter" id="shareThisContainer">
            <div class="footer-content left">
                <span id="share_this_google" class="st_plusone_button" st_url="'.$this->meta->getMetaURL().'"></span>
                <span id="share_this_facebook" class="st_fblike_hcount"  st_url="'.$this->meta->getMetaURL().'"></span>
            </div>
            <div class="footer-content right">
                <span id="share_this_sharethis" class="st_sharethis_large" st_url="'.$this->meta->getMetaURL().'" displayText="ShareThis"></span>
            </div>
            <div class="right header">
                <h4>Share This</h4>
            </div>
            <div class="clear"></div>
        </div>';
    }
    public function subFooter()
    {
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
    public function signature()
    {
        return 	'<p class="signature">'.date('Y').' Pavan Ratnakar - Applications &nbsp;&nbsp;&middot;&nbsp;&nbsp; All my applications are dedicated to Pepsy Ratnakar</p>';
    }
    public function printFacebookCommentSection()
    {
        return  '<div class="fb-comments" data-href="'.$this->meta->getMetaURL().'" data-num-posts="10" data-width="860" data-colorscheme="dark"></div>';
    }
    public function printFooter($name,$downloadpath)
    {
        $return_string= '<div id="footerWrapper"><!-- Start small footer --><div id="small-footer"><div class="subfooter socialContainer">'.$this->demoInfo().$this->downloadTheScript($downloadpath).'</div></div><!-- Start big footer --><div id="big-footer"><div id="facebookCommentContainer" class="subfooter"><h3 class="title">Comments Section</h3>'.$this->printFacebookCommentSection().'</div>'.$this->shareThisContainer().$this->subFooter().$this->signature().'</div><!-- End big footer --></div>';
        $return_string.='<div align="center">'.$this->googleAd('0772185248','728','90').'</div>';
        return $return_string;
    }
    /* FOOTER */
    public function downloadTheScript($path){
        $return_string = '<h3>Download section</h3>';
        if($path){
            $return_string .= '<h4><a href="http://www.pavanratnakar.com/demo/downloads/'.$path.'">Download the script</a></h4>';
        } else {
            $return_string .= '<h4 class="warning">Script with be available for download soon!</h4>';
        }
        return  $return_string;
    }
    public function demoInfo(){
        return '<h3>Demo Info</h3><ul>'.$this->pageDetails[$this->pageNumber]['content'].'</ul>';
    }
}
?>