<?php
include_once ('../class/user.php');
include_once ('../class/comment.php');
include_once ('../class/gallery.php');
include_once ('../class/suggestion.php');
include_once ('../class/functions.php');
include_once ('../class/contact.php');
include_once ('../class/facebook.php');
include_once ('../class/tweet.php');
include_once ('../class/buzz.php');
include_once ('../class/facebookLogin.php');
include_once ('../class/movie.php');
$function=new Functions();
$type=$function->checkValues($_REQUEST['ref']);
if($type=='register')
{
	$user=new User();
	if(!$_POST['firstname'] || !$_POST['password'] || !$_POST['email'] || !$_POST['sexSelect'] || !$_POST['birthDate'])
	{
		$err[] = 'All the fields must be filled in!';
		$status=FALSE;
	}
	else if($function->checkSize($_POST['firstname'],2,32))
	{
		$err[]='Firstname must be between 2 and 32 characters!';
		$status=FALSE;
	}
	else if(!$function->checkEmail($_POST['email']))
	{
		$err[]='Please enter a valid email address';
		$status=FALSE;
	}
	else if($function->checkSize($_POST['password'],5,32))
	{
		$err[]='Your password must be at least 5 characters long';
		$status=FALSE;
	}
	$register=$user->registerUser(
	$function->checkValues($_POST['firstname']),
	$function->checkValues($_POST['lastname']),
	$function->checkValues($_POST['password']),
	$function->checkValues($_POST['email']),
	$function->checkValues($_POST['sexSelect']),
	$function->checkValues($_POST['birthDate'])
	);
	if($register)
	{
		$err[] = "Thank You! You have sucessfully Registered.<br/>Please login now.";
		$status=TRUE;
	}
	else
	{
		$err[] = "This username is already taken!";
		$status=FALSE;
	}
	$registerUser= array(
		"status" => $status,
		"message" => $err
		);
	$response = $_POST["jsoncallback"] . "(" . json_encode($registerUser) . ")";
	echo $response;
	unset($response);
}
else if($type=='login')
{
	$user=new User();
	if(!$_POST['email'] || !$_POST['password'])
	{
		$err[] = 'All the fields must be filled in!';
		$status=FALSE;
	}
	else if(!$function->checkEmail($_POST['email']))
	{
		$err[]='Please enter a valid email address';
		$status=FALSE;
	}
	else if($function->checkSize($_POST['password'],5,32))
	{
		$err[]='Your password must be at least 5 characters long';
		$status=FALSE;
	}
	else
	{
		$login=$user->loginUser(
			$function->checkValues($_POST['email']),
			$function->checkValues($_POST['password']),
			$function->checkValues((int)$_POST['rememberMe'])
		);
		if($login)
		{
			$err[] = "Logged In successfully!";
			$status=TRUE;
		}
		else
		{
			$err[] = "Wrong email and/or password!";
			$status=FALSE;
		}
	}
	$loginUser= array(
		"status" => $status,
		"message" => $err
		);
	$response = $_POST["jsoncallback"] . "(" . json_encode($loginUser) . ")";
	echo $response;
	
	unset($response);
}
else if($type=='getName')
{
	$user=new User();
	$userArray= array(
		"name" => $user->fullName($_SESSION['uid'])
		);
	$response = $_POST["jsoncallback"] . "(" . json_encode($userArray) . ")";
	echo $response;
	unset($response);
}
else if($type=='passwordReset')
{
	$user=new User();
	if(($user->changePassword($function->checkValues($_POST['oldPassword']),$function->checkValues($_POST['newPassword']),$_SESSION['uid']))==1)
	{
		$status=TRUE;
		$err[] = "Password Reset Successfully!. You have been logged off.";
		$user->logoutUser();
	}
	else
	{
		$status=FALSE;
		$err[] = "Password could not be reset. Please ensure your old password is correct!";
	}
	$passwordResetArray= array(
		"status" => $status,
		"message" => $err
		);
	$response = $_POST["jsoncallback"] . "(" . json_encode($passwordResetArray) . ")";
	echo $response;
	unset($response);
}
else if($type=='addComment')
{
	$comment=new Comment();
	$addComment=$comment->addComment(
		$function->checkValues($_POST['comment']),
		$function->checkValues($_POST['addon']),
		$function->checkValues($_POST['parent']),
		$function->checkValues($_POST['category'])
	);
	if($addComment)
	{
		$comment= array(
			"status" => TRUE,
			"message" => "Comment entered succesfully",
			"commentArray"=>$addComment
		);
	}
	else
	{
		$comment= array(
			"status" => FALSE,
			"message" => "Comment not entered",
			"commentArray"=>$addComment
		);
	}
	$response = $_POST["jsoncallback"] . "(" . json_encode($comment) . ")";
	echo $response;
	unset($response);
}
else if($type=='deleteComment')
{
	$comment=new Comment();
	$deleteComment=$comment->deleteComment($function->checkValues($_POST['id']));
	if($deleteComment)
	{
		$comment= array(
			"status" => TRUE,
			"message" => "Comment deleted succesfully"
		);
	}
	else
	{
		$comment= array(
			"status" => FALSE,
			"message" => "Comment could not be deleted"
		);
	}
	$response = $_POST["jsoncallback"] . "(" . json_encode($comment) . ")";
	echo $response;
	unset($response);
}
else if($type=='addSuggestion')
{
	$suggestion=new Suggestion();
	if(mb_strlen($_POST['content'],'utf-8')<3)
	{
		exit;
	}
	$suggestionArray=$suggestion->addSuggestion($function->checkValues($_POST['content']));
	$response = $_POST["jsoncallback"] . "(" . json_encode($suggestionArray) . ")";
	echo $response;
	unset($response);
}
else if($type=='addSuggestionVote')
{
	$suggestion=new Suggestion();
	$vote = $function->checkValues((int)$_POST['vote']);
	$id = $function->checkValues((int)$_POST['id']);
	if($vote != -1 && $vote != 1){
		exit;
	}
	$suggestionVote=$suggestion->addSuggestionVote($vote,$id);
	if($suggestionVote)
	{
		$comment= array(
			"status" => TRUE,
			"message" => "Successfully registered the Vote"
		);
	}
	$response = $_POST["jsoncallback"] . "(" . json_encode($suggestionVote) . ")";
	echo $response;
	unset($response);
}
else if($type=='contact')
{
	$contact=new Contact();
	if(!$_POST['name'] || !$_POST['email'] || !$_POST['subject'] || !$_POST['message'])
	{
		$err[] = 'All the fields must be filled in!';
		$status=FALSE;
	}
	else if($function->checkSize($_POST['name'],2,32))
	{
		$err[]='Name must be between 2 and 32 characters!';
		$status=FALSE;
	}
	else if($function->checkSize($_POST['message'],2,200))
	{
		$err[]='Message must be between 2 and 200 characters!';
		$status=FALSE;
	}
	else if(!$function->checkEmail($_POST['email']))
	{
		$err[]='Please enter a valid email address';
		$status=FALSE;
	}
	else
	{
		$name=$function->checkValues($_POST['name']);
		$email=$function->checkValues($_POST['email']);
		$subject=$function->checkValues($_POST['subject']);
		$message=$function->checkValues($_POST['message']);
		$mailStatus=$contact->contactMe($name,$email,$subject,$message);
		if($mailStatus)
		{
			$err[] = "Thank You!<br/><br/>I will get back to you as and when possible.";
			$status=TRUE;
		}
		else
		{
			$err[] = "Mail not sent!";
			$status=FALSE;
		}
	}
	$contact= array(
		"status" => $status,
		"message" => $err
	);
	$response = $_POST["jsoncallback"] . "(" . json_encode($contact) . ")";
	echo $response;
	unset($response);
}
else if($type=='updateProfile')
{
	$functionType=$function->checkValues($_POST['type']);
	$newValue=$function->checkValues($_POST['newValue']);
	$user=new User();
	$user->$functionType($_SESSION['uid'],$newValue);
}
else if($type=='facebookcheck')
{
	$facebookLogin=new FacebookLogin();
	$cookie = $facebookLogin->get_facebook_token('100184653364726','58faf0b31b72c3a727fa04de1b53b553');
	$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .$cookie['access_token']));
	$userid=$user->id;
	if($userid)
	{
		if($facebookLogin->addUser($userid))
		{
			$status=TRUE;
			$message="USER ADDED";
		}
		else
		{
			$status=FALSE;
			$message="USER IS ALREADY PRESENT IN DATABASE";
		}
	}
	else
	{
		$status=FALSE;
		$message="USER IS NOT LOGGED INTO FACEBOOK";
	}
	$facebookLoginArray = array(
		"status" => $status,
		"message" => $message
	);
	$response = $_GET["jsoncallback"] . "(" .json_encode($facebookLoginArray). ")";
	echo $response;
}
else if($type=='logout')
{
	$user=new User();
	$user->logoutUser();
	$logoutArray = array(
		"status" => TRUE,
		"message" => "Logged Out"
	);
	$response = $_GET["jsoncallback"] . "(" .json_encode($logoutArray). ")";
	echo $response;
}
?>