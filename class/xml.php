<?php
include_once('db.php');
include_once ('functions.php');
class XML
{
	public function __construct()
	{

	}
	public function readXML($fileName)
	{
		$pos = strpos($fileName,'/xml/');
		if($pos)
		{
			$xmlstr = file_get_contents($fileName);
		}
		else
		{
			$xmlstr = file_get_contents('xml/'.$fileName);
		}
		$page = new SimpleXMLElement($xmlstr);
		return $page;
	}
}
?>