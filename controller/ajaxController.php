<?php
class AjaxController {
    private $comment;
    private $utils;
    private $movie;
    private $gallery;
    private $pageController;
    private $facebook;
    private $tweet;
    public function __construct($ref) {
        include_once('../config/config.php');
        include_once('../class/comment.php');
        include_once('../class/movie.php');
        include_once('../class/gallery.php');
        include_once('../class/functions.php');
        include_once('../class/facebook.php');
        include_once('../class/tweet.php');
        include_once('pageController.php');
        $this->comment=new Comment();
        $this->utils=new Functions();
        $this->movie=new Movie();
        $this->gallery=new Gallery();
        $this->facebook=new Facebook();
        $this->tweet=new Tweet();
        $ref=$this->utils->checkValues($ref);
        $this->pageController=new PageController(-1);
        $this->$ref();
    }
    /* GETTERS AND SETTERS */
    public function getComment() {
        return $this->comment;
    }
    public function setComment($comment) {
        $this->comment=$comment;
    }
    public function getUtils() {
        return $this->utils;
    }
    public function setUtils($utils) {
        $this->utils=$utils;
    }
    public function getMovie() {
        return $this->movie;
    }
    public function setMovie($movie) {
        $this->movie=$movie;
    }
    public function getGallery() {
        return $this->gallery;
    }
    public function setGallery($gallery) {
        $this->gallery=$gallery;
    }
    public function getPageController() {
        return $this->pageController;
    }
    public function setPageController($pageController) {
        $this->pageController=$pageController;
    }
    public function getTweet() {
        return $this->tweet;
    }
    public function setTweet($tweet) {
        $this->tweet=$tweet;
    }
    public function getFacebook() {
        return $this->facebook;
    }
    public function setFacebook($facebook) {
        $this->facebook=$facebook;
    }
    /* GETTERS AND SETTERS */
    
    public function nextMovie() {
        $movieIds=$this->utils->checkValues($_REQUEST['movieIds']);
        $nextMovieArray= array(
            "status" => TRUE,
            "movieArray" => $this->movie->getNextMovie($movieIds)
            );
        $response = json_encode($nextMovieArray);
        echo $response;
        unset($response);
    }
    public function movieChange() {
        $tmdbId=$this->utils->checkValues($_REQUEST['tmdbId']);
        $waveId=$this->utils->checkValues($_REQUEST['waveId']);
        $waveId=explode('|',$waveId);
        $movieDetailsArray= array(
            "status" => TRUE,
            "movieArray" => $this->movie->getMovieDetails($tmdbId),
            "commentArray" => $this->comment->printComment($waveId[0].'|'.$tmdbId),
            "printCommentArray" => $this->comment->javascriptPrint()
            );
        $response = $_GET["jsoncallback"] . "(" .json_encode($movieDetailsArray). ")";
        echo $response;
        unset($response);
    }
    public function gadgetChange() {
        $gadgetId=$this->utils->checkValues($_REQUEST['gadgetId']);
        $waveId=$this->utils->checkValues($_REQUEST['waveId']);
        $waveId=explode('|',$waveId);
        $gadgetDetailsArray= array(
            "status" => TRUE,
            "commentArray" => $this->comment->printComment($waveId[0].'|'.$gadgetId),
            "printCommentArray" => $this->comment->javascriptPrint()
            );
        $response = $_GET["jsoncallback"] . "(" .json_encode($gadgetDetailsArray). ")";
        echo $response;
        unset($response);
    }
    public function galleryChange() {
        $albumId=$this->utils->checkValues($_REQUEST['albumId']);
        $waveId=$this->utils->checkValues($_REQUEST['waveId']);
        $galleryArray= array(
            "status" => TRUE,
            "commentArray" => $this->comment->printComment($waveId[0].'|'.$albumId),
            "printCommentArray" => $this->comment->javascriptPrint(),
            "files" => $this->gallery->showGallery($this->utils->checkValues($_REQUEST['album_name']))
            );
        $response = $_GET["jsoncallback"] . "(" . json_encode($galleryArray) . ")";
        echo $response;
        unset($response);
    }
    public function resetPanel() {
        echo $this->pageController->printPanel();
    }
    public function getPanelContent() {
        echo $this->pageController->printPanelContent();
    }
    public function footerSocial() {
        $social_array = array(
            "facebook_wall" => $this->facebook->facebookWallPost(),
            "twiteer_tweets" => $this->tweet->tweetArray($this->tweet->getFeed('twitter',Config::$twitter_profile,'*',Config::$twitter_status)),
            "comment" => $this->comment->commentArray($this->comment->getLastComments())
            );
        $response = $_GET["jsoncallback"] . "(" .json_encode($social_array). ")";
        echo $response;
        unset($response);
    }
    public function movieSearch() {
        $movieArray= array(
            "status" => TRUE,
            "movieArray" => $this->movie->getAllMoviesByMovieName($this->utils->checkValues($_REQUEST['searchId']))
            );
        $response = $_GET["jsoncallback"] . "(" .json_encode($movieArray). ")";
        echo $response;
        unset($response);
    }
}
$ajaxController=new AjaxController($_REQUEST['ref']);
?>