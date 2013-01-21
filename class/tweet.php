<?php
define("TWITTER_PROFILE", 'http://twitter.com/statuses/user_timeline/140623230.rss');
define("TWITTER_STATUS",3);
include_once ('functions.php');
class Tweet
{
	public function __construct()
	{

	}
	public function getFeed($type,$profile,$selection,$size,$count=null)
	{
		/* Forming the query: */
		if($type=='facebook')
		{
			$facebookArray=explode('/',$profile);
			$facebookProfile=$facebookArray[0];
			$connection=$facebookArray[1];
			$query ='SELECT '.$selection.' FROM facebook.graph('.$count.') WHERE id=\''.$facebookProfile.'\' AND connection=\''.$connection.'\'';
		}
		else
		{
			$query ='SELECT '.$selection.' FROM feed WHERE url=\''.$profile.'\' LIMIT '.$size.'';
		}
		/* Forming the URL to YQL: */
		$url = "http://query.yahooapis.com/v1/public/yql?q=".urlencode($query)."&format=json";
		return json_decode(file_get_contents($url));
	}
	/* GET TWITTER ARRAY */
	function tweetArray($result)
	{
		$function=new Functions();
		$resultArray=$result->query->results->item;
		for ($x = 0;$x <sizeof($resultArray);$x++) 
		{
			$description==null;
			$description=$resultArray[$x]->description;
			$description = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $description);
			$description=$function->checkValues($description);
			$tweet_array[$x] = array(
			"id" => end(explode('/',$resultArray[$x]->link)),
			"description" => $description,
			"title" => $resultArray[$x]->title,
			"link" => $resultArray[$x]->link,
			"origLink" => $resultArray[$x]->origLink,
			"pubDate" => $function->waveTime($resultArray[$x]->pubDate)
			);	
		}
		return $tweet_array;
	}
	/* GET TWITTER ARRAY */
}
?>