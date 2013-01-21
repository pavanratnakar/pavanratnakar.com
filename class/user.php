<?php
include_once('db.php');
include_once ('functions.php');
include_once ('facebookLogin.php');
session_name('pavanLogin');
// Starting the session
session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();
class User
{
	public function __construct()
	{
		$db=new DB();
	}
	public function registerUser($firstname,$lastname,$password,$email,$sexselect,$birthDate)
	{
		$function=new Functions();
		$firstname=$function->dbCheckValues($firstname);
		$lastname=$function->dbCheckValues($lastname);
		$password=$function->dbCheckValues(md5($password));
		$email=$function->dbCheckValues($email);
		$sexselect=$function->dbCheckValues($sexselect);
		$birthDate = $function->date_php2sql($function->dbCheckValues($birthDate));
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$sql=mysql_query("SELECT uid FROM ".USER_TABLE." WHERE email='$email'");
		if(mysql_num_rows($sql)==0)
		{
			$result=mysql_query("INSERT INTO ".USER_TABLE."(firstname,lastname,password,email,sexSelect,birthdate,ip,registertime) VALUES('$firstname','$lastname','$password','$email','$sexselect','$birthDate','$userip',now())");
			return $result;
		}
		else
		{
			return FALSE;
		}
	}
	public function changePassword($oldPassword,$newPassword,$uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$oldPassword=$function->dbCheckValues(md5($oldPassword));
		$newPassword=$function->dbCheckValues(md5($newPassword));
		$result=mysql_query("UPDATE ".USER_TABLE." SET password='".$newPassword."' WHERE uid='".$uid."' and password='".$oldPassword."'");
		return mysql_affected_rows();
	}
	public function loginUser($email,$password,$rememberMe)
	{
		$function=new Functions();
		$email=$function->dbCheckValues($email);
		$password=$function->dbCheckValues(md5($password));
		$sql=mysql_query("SELECT uid FROM ".USER_TABLE." WHERE email='$email' and password='$password'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			$_SESSION['uid'] = $row['uid'];
			$_SESSION['rememberMe'] =$rememberMe;
			// Store some data in the session
			setcookie('pavanRemember',$rememberMe);
			$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
			$result=mysql_query("INSERT INTO ".ACTIVE_USERS_TABLE."(uid,login_time,userip) VALUES ('".$row['uid']."',now(),'$userip')");
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function loginStatistics($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT * FROM ".ACTIVE_USERS_TABLE." WHERE uid='$uid' ORDER BY id DESC LIMIT 4");
		$content="<ul>";
		for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
		{
			$row = mysql_fetch_assoc($sql);
			$content.="<li>";
			$content.="Logged in on ";
			$content.="<span class='blue'>".$function->waveTime($row['login_time'])."</span>";
			$content.=" using ";
			$content.="<span class='blue'>".long2ip($row['userip'])."</span>";
			$content.="</li>";
		}
		$content.="</ul>";
		return $content;
	}
	public function commentStatistics($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT count(*) as commentCount FROM wave_comments WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		$content ="<ul><li><span class='blue'>".$row['commentCount']."</span> comments have been posted by you so far.</li></ul>";
		return $content;
	}
	public function fullName($uid)
	{
		$check=$this->checkLoginType();
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT firstname,lastname,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			if($row['auth_type']==0)
			{
				return $row['firstname']." ".$row['lastname'];
			}
			else if(($row['auth_type']==1))
			{
				return '<fb:name uid="'.$uid.'" linked="false" useyou="false">Facebook User</fb:name>';
			}
		}
		else
		{
			return FALSE;
		}
	}
	/// FUNCTION FOR CONTACT ME FORM. TO GET RAW FULL NAME INSTEAD OF FB METHOD
	public function formFullName($uid)
	{
		$check=$this->checkLoginType();
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT firstname,lastname,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			if($row['auth_type']==0)
			{
				return $row['firstname']." ".$row['lastname'];
			}
			else if(($row['auth_type']==1))
			{
				$facebookLogin=new FacebookLogin();
				$token = $facebookLogin->get_facebook_token(YOUR_APP_ID, YOUR_APP_SECRET);
				$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .$token['access_token']));
				return $user->name;
			}
		}
		else
		{
			return FALSE;
		}
	}
	public function getEmail($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT email,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			if($row['auth_type']==0)
			{
				return $row['email'];
			}
			else if(($row['auth_type']==1))
			{
				$facebookLogin=new FacebookLogin();
				$token = $facebookLogin->get_facebook_token(YOUR_APP_ID, YOUR_APP_SECRET);
				$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .$token['access_token']));
				return $user->email;
			}
		}
		else
		{
			return FALSE;
		}
	}
	public function getFirstName($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT firstname,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			if($row['auth_type']==0)
			{
				return $row['firstname'];
			}
			else if(($row['auth_type']==1))
			{
				return '<fb:name uid="'.$uid.'" firstnameonly="true" linked="false" useyou="false">Facebook User</fb:name>';
			}
		}
		else
		{
			return FALSE;
		}
	}
	public function getLastName($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT lastname,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			if($row['auth_type']==0)
			{
				return $row['lastname'];
			}
			else if(($row['auth_type']==1))
			{
				return '<fb:name uid="'.$uid.'" lastnameonly="true" linked="false" useyou="false">Facebook User</fb:name>';
			}
		}
		else
		{
			return FALSE;
		}
	}
	public function getBirthDate($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT birthdate FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			return $row['birthdate'];
		}
		else
		{
			return FALSE;
		}
	}
	public function updateEmail($uid,$email)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$email=$function->dbCheckValues($email);
		$result=mysql_query("UPDATE ".USER_TABLE." SET email='".$email."' WHERE uid='".$uid."'");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function updateFirstName($uid,$firstname)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$firstname=$function->dbCheckValues($firstname);
		$result=mysql_query("UPDATE ".USER_TABLE." SET firstname='".$firstname."' WHERE uid='".$uid."'");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function updateLastName($uid,$lastname)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$lastname=$function->dbCheckValues($lastname);
		$result=mysql_query("UPDATE ".USER_TABLE." SET lastname='".$lastname."' WHERE uid='".$uid."'");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function getProfilePic($uid)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$sql=mysql_query("SELECT profilepic,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			if($row['auth_type']==0)
			{
				$title=$this->fullName($arr['uid']);
				$imgpath='<img src="http://www.pavanratnakar.com/images/profilePic/small/'.$row['profilepic'].'" title="'.$title.'" alt="'.$title.'" />';
			}
			else
			{
				$imgpath='<fb:profile-pic uid="'.$uid.'" facebook-logo="true" size="square" linked="true"></fb:profile-pic>';
			}
			return $imgpath;
		}
		else
		{
			return FALSE;
		}
	}
	public function getDetails($uid)
	{
		$function=new Functions();
		$check=$this->checkLoginType();
		$uid=$function->dbCheckValues($uid);
		$content=$this->getProfilePic($uid);
		$content.='<div id="personalDetails">';
		$content.='<span class="label left">FirstName</span>: '.$this->getFirstName($uid);
		$content.='<br/><span class="label left">LastName</span>: '.$this->getLastName($uid);
		$content.='<br/><span class="label left">Email</span>: '.$this->getEmail($uid);
		if($check!=2)
		{
			$content.='<br/><span class="label left">BirthDate</span>: '.$this->getBirthDate($uid);
		}
		$content.='</div>';
		return $content;
	}
	public function logoutUser()
	{
		$userid=$this->getCurrenUserId();
		$result=mysql_query("UPDATE ".ACTIVE_USERS_TABLE." SET logoff_time = NOW() WHERE uid='".$userid."' AND logoff_time='0000-00-00 00:00:00'");
		$check=$this->checkLoginType();
		if($check==1)
		{
			$_SESSION = array();
			session_destroy();
		}
	}
	public function checkLoginType()
	{
		$facebookLogin=new FacebookLogin();
		$token = $facebookLogin->get_facebook_token(YOUR_APP_ID, YOUR_APP_SECRET);
		if($_SESSION['uid'])
		{	
			return 1;
		}
		else if($token)
		{
			return 2;
		}
		else
		{
			return FALSE;
		}
	}
	public function getTabUserName()
	{
		$check=$this->checkLoginType();
		if($check==1)
		{
			return $this->fullName($_SESSION['uid']);
		}
		else if($check==2)
		{
			$facebookLogin=new FacebookLogin();
			$token = $facebookLogin->get_facebook_token(YOUR_APP_ID, YOUR_APP_SECRET);
			$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .$token['access_token']));
			return $this->fullName($user->id);
		}
		else
		{
			return 'Guest';
		}
	}
	public function getCurrentUserProfilePic($uid)
	{		
		$check=$this->checkLoginType();
		if($check==1)
		{
			$sql=mysql_query("SELECT profilepic,auth_type FROM ".USER_TABLE." WHERE uid='$uid'");
			$row = mysql_fetch_assoc($sql);
			if(mysql_num_rows($sql)==1)
			{
				if($row['auth_type']==0)
				{
					return $row['profilepic'];
				}
				else
				{
					return FALSE;
				}
			}
		}
		else if($check==2)
		{
			return FALSE;
		}
	}
	public function getCurrenUserId()
	{
		$check=$this->checkLoginType();
		if($check==1)
		{
			$userid=$_SESSION['uid'];
		}
		else if($check==2)
		{
			$facebookLogin=new FacebookLogin();
			$token = $facebookLogin->get_facebook_token(YOUR_APP_ID, YOUR_APP_SECRET);
			$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .$token['access_token']));
			$userid=$user->id;
		}
		else
		{
			$userid=FALSE;
		}
		return $userid;
	}
}
?>