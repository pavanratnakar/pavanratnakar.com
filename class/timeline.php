<?php
include_once('db.php');
include_once ('functions.php');
class Timeline
{
	public function __construct()
	{
		$db=new DB();
	}
	public function showTimeLine()
	{
		$dates = array();
		$sql = mysql_query("SELECT * FROM ".TIMELINE_TABLE." ORDER BY date_event ASC");
		while($row=mysql_fetch_assoc($sql))
		{
			// Store the events in an array, grouped by years:
			$dates[date('Y',strtotime($row['date_event']))][] = $row;
		}
		return $dates;
	}
}
?>