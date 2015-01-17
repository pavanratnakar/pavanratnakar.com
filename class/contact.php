<?php
include_once ('functions.php');
include_once ('mailClass.php');
session_start();
class Contact
{
	public function __construct()
	{
		/*$db=new DB();*/
	}
	public function contactMe($name,$email,$subject,$message)
	{
		$function=new Functions();
		$mail=new MailClass();
		$status=$mail->sendMailFunction($name,$email,$subject,$message);
		if($status)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
?>