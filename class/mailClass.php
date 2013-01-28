<?php
include_once ('functions.php');
include_once ("../plugins/phpmailer/class.phpmailer.php");
class MailClass {
	public function __construct(){
		/*$db=new DB();*/
	}
	public function sendMailFunction($name,$email,$subject,$message){
		$function=new Functions();
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$msg=
		'Name:	'.$name.'<br />
		Email:	'.$email.'<br />
		IP:	'.$userip.'<br /><br />
		Message:<br /><br />
		'.nl2br($message).'
		';
		$mail = new PHPMailer();
		$mail->IsMail();
		//$mail->Host = 'ssl://smtp.gmail.com:465';
		//$mail->SMTPAuth = TRUE;
		//$mail->Username = 'pavanratnakar@gmail.com';  // Change this to your gmail adress
		//$mail->Password = '28pepsy1998';  // Change this to your gmail password
		$mail->From = 'pavanratnakar@gmail.com';  // This HAVE TO be your gmail adress
		$mail->FromName = 'Pavan Ratnakar Applications - Contact'; // This is the from name in the email, you can put anything you like here
		$mail->AddAddress('pavanratnakar@gmail.com');
		$mail->Subject = "A new ".mb_strtolower($subject)." from ".$name." | Contact form feedback";
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($msg);
		$status=$mail->Send();
		if (!$status) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
?>