<?php
include_once ('functions.php');
include_once ("../plugins/phpmailer/class.phpmailer.php");
class MailClass {
	public function sendMailFunction($name,$email,$subject,$message) {
		$function=new Functions();
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$msg=
		'Name:	'.$name.'<br />
		Email:	'.$email.'<br />
		IP:	'.$userip.'<br /><br />
		Message:<br /><br />
		'.nl2br($message).'
		';
		$mail = new PHPMailer(true);
		try {
			// $mail->IsSMTP();
			// $mail->Host = 'smtp.gmail.com';
			// $mail->Port = 465;
			// $mail->SMTPSecure = 'tls';   //or try 'ssl' 
			// $mail->SMTPAuth = TRUE;
			// $mail->Username = 'pavanratnakar@gmail.com';  // Change this to your gmail adress
			// $mail->Password = 'pepsykutty';  // Change this to your gmail password
			// $mail->From = 'pavanratnakar@gmail.com';  // This HAVE TO be your gmail adress
			$mail->FromName = 'Pavan Ratnakar Applications'; // This is the from name in the email, you can put anything you like here
			$mail->AddAddress('pavanratnakar@gmail.com');
			$mail->Subject = "A new ".mb_strtolower($subject)." from ".$name." | Contact form feedback";
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->MsgHTML($msg);
			$status=$mail->Send();
		} catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}
		if (!$status) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
?>