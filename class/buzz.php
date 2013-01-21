<?php
include_once ('functions.php');
class Buzz
{
	public function __construct()
	{

	}
	/* GET BUZZ ARRAY */
	public function buzzArray($result)
	{
		$function=new Functions();
		$resultArray=$result->query->results->entry;
		for ($x = 0;$x <sizeof($resultArray);$x++) 
		{
			$tweet_array[$x] = array(
			"id" => end(explode('/',$resultArray[$x]->id)),
			"content" => $resultArray[$x]->content,
			"title" => $resultArray[$x]->title,
			"link" => $resultArray[$x]->link,
			"origLink" => $resultArray[$x]->origLink,
			"pubDate" => $function->waveTime($resultArray[$x]->published)
			);	
		}
		return $tweet_array;
	}
	/* GET BUZZ ARRAY */
}
?>