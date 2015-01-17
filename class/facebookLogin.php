<?php
define('YOUR_APP_ID', '100184653364726');
define('YOUR_APP_SECRET', '58faf0b31b72c3a727fa04de1b53b553');
include_once('db.php');
include_once ('functions.php');
class FacebookLogin
{
	public function __construct()
	{
		$db=new DB();
	}
	function get_facebook_token($app_id, $app_secret)
	{
		$args = array();
		parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
		ksort($args);
		$payload = '';
		foreach ($args as $key => $value)
		{
			if ($key != 'sig')
			{
				$payload .= $key . '=' . $value;
			}
		}
		if (md5($payload . $app_secret) != $args['sig']) 
		{
			return null;
		}
		return $args;
	}
	public function checkUser($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT uid FROM ".USER_TABLE." WHERE uid='$uid' AND auth_type='1'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function addUser($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		if($uid)
		{
			$sql=mysql_query("SELECT * FROM ".ACTIVE_USERS_TABLE." WHERE uid='".$uid."' AND logoff_time='0000-00-00 00:00:00' AND DATEDIFF(now(),login_time)<1 order by uid desc limit 1");
			$row = mysql_fetch_assoc($sql);
			if(mysql_num_rows($sql)!=1)
			{
				$result=mysql_query("INSERT INTO ".ACTIVE_USERS_TABLE."(uid,login_time,userip) VALUES ('$uid',now(),'$userip')");
			}
			if($this->checkUser($uid))
			{
				$result=mysql_query("INSERT INTO ".USER_TABLE."(uid,auth_type) VALUES ('$uid' ,'1')");
				return $result;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
}