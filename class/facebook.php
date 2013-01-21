<?php
define("FACEBOOK_PROFILE", 'https://graph.facebook.com/100000417819011/feed?access_token=100184653364726|9d425cf7e3b58642307619f7.0-100000417819011|_u1WWUYcazYSQLrsEsBNiUgFacc');
define("FACEBOOK_NUMBER", 40);
define("FACEBOOK_STATUS",3);
include_once('db.php');
include_once ('functions.php');
class Facebook
{
	private $app_id='100184653364726';
	private $app_secret='58faf0b31b72c3a727fa04de1b53b553';
	private $my_url='http://www.pavanratnakar.com';
	public function __construct()
	{
		$db=new DB();
		/*
		session_start();
		$code = $_REQUEST["code"];
		if(empty($code)) 
		{
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=". $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state=". $_SESSION['state'];
			echo("<script> top.location.href='" . $dialog_url . "'</script>");
		}
		if($_REQUEST['state'] == $_SESSION['state']) 
		{
			$token_url = "https://graph.facebook.com/oauth/access_token?". "client_id=" . $this->app_id . "&redirect_uri=" . urlencode($this->my_url). "&client_secret=" . $this->app_secret . "&code=" . $code;
			$response = file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);
			//$graph_url = "https://graph.facebook.com/me?access_token=". $params['access_token'];
			echo $params['access_token'];
		}
		*/
	}
	/* INSERT FACEBOOK FUNCTION */
	public function insertFacebookWall($page,$limit,$date)
	{
		$result=null;
		$size=0;
		$result = json_decode(file_get_contents(''.$page.'&limit='.$limit.'&since='.urlencode($date).''));
		$size=sizeof($result->data);
		if($size>0)
		{
			$this->insertFacebookWallSQL($result);
		}
		return $size;
	}
	/* INSERT FACEBOOK FUNCTION */
	/* INSERT FACEBOOK SQL FUNCTION */
	public function insertFacebookWallSQL($result)
	{
		$function=new Functions();
		for ($x = 0;$x <sizeof($result->data);$x++) 
		{
			$message==null;
			$message=$result->data[$x]->message;
			$message = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $message);
			//$message=$function->checkValues($message);
			mysql_query("INSERT INTO facebook_wall (id,message,picture,link,name,caption,icon,type,created_time,updated_time)
			VALUES(
				'".$result->data[$x]->id."',
				'".$message."',
				'".$result->data[$x]->picture."',
				'".$result->data[$x]->link."',
				'".$result->data[$x]->name."',
				'".$result->data[$x]->caption."',
				'".$result->data[$x]->icon."',
				'".$result->data[$x]->type."',
				'".$result->data[$x]->created_time."',
				'".$result->data[$x]->updated_time."')");
		}
	}
	/* INSERT FACEBOOK SQL FUNCTION */
	/* GET FACEBOOK WALL ARRAY */
	public function wallArray($posts)
	{
		$function = new Functions();
		for ($x = 0, $numposts = mysql_num_rows($posts); $x < $numposts; $x++) 
		{
			$post = mysql_fetch_assoc($posts);
			$id=explode('_',$post["id"]);
			$profile_id=$id[0];
			$component_id=$id[1];
			$post_array[$x] = array(
			"id" => $post["p_id"], 
			"profile_id" => $profile_id,
			"component_id" => $component_id, 		
			"message" => utf8_encode($post["message"]),
			"picture" => $post["picture"], 
			"link" => $post["link"],
			"name" => $post["name"],
			"caption" => $post["caption"],
			"icon" => $post["icon"],
			"type" => $post["type"],
			"pubDate" => $function->waveTime($post["created_time"]),
			"updated_time" => $post["updated_time"]
			);	
		}
		return $post_array;
	}
	/* GET FACEBOOK WALL ARRAY */
	/* GET FACBOOK WALL */
	public function getFaceWall($size=0)
	{
		$totalWall = mysql_query("SELECT * from facebook_wall where type='status' order by created_time desc limit ".FACEBOOK_STATUS."");
		$wall_array = array(
			"size" => $size, 
			"maximum" => FACEBOOK_STATUS,
			"wallArray" => $this->wallArray($totalWall)
		);
		return $wall_array;
	}
	/* GET FACBOOK WALL */
	public function facebookWallPost()
	{
		$lastWall = mysql_query("SELECT * from facebook_wall order by created_time desc limit 1");
		if(mysql_num_rows($lastWall)>0)
		{
			$lastWallArray = mysql_fetch_assoc($lastWall);
			$size=$this->insertFacebookWall(FACEBOOK_PROFILE,FACEBOOK_NUMBER,$lastWallArray['created_time']);
		}
		else
		{
			$size=$this->insertFacebookWall(FACEBOOK_PROFILE,FACEBOOK_NUMBER,'');
		}
		return $this->getFaceWall($size);
	}
	/* GET FACEBOOK WALL ARRAY */
	/* DISPLAY WALLPOST */
	public function displayWallpost()
	{
		$result=$this->getFaceWall();
		for ($x = 0;$x <sizeof($result[wallArray]);$x++) 
		{
			echo '<li class="post">
					<div class="postContainer">
						<p class="message">'.($result[wallArray][$x]['message']).'</p>
					</div>
					<div class="postTime">'.$result[wallArray][$x]['pubDate'].'</div>
					<div class="clear"></div>
						';
			if($x!=(sizeof($result[wallArray])-1))
				echo '<div class="divider"></div>';
			echo '</li>';
		}
	}
	/* DISPLAY WALLPOST */
}
?>