<?php
include_once ('db.php');
include_once ('functions.php');
if(file_exists('cfg/config.cfg.php'))
{
   include_once('cfg/config.cfg.php');
}
else
{
   include_once('../cfg/config.cfg.php');
}
class Search
{
	private $classname;
	public function __construct($type)
	{
		$this->classname=$type;
	}
	public function buildSearchBox()
	{
		echo '<div class="search right"><div class="ui-widget"><label for="'.$this->classname.'Search">Search '.$this->classname.': </label><input id="'.$this->classname.'Search" /></div></div>';
	}
}
?>