<h2>Session Management Using PHP : Cookie-based Sessions</h2>
<hr><br/>
<div>
<?php
	include_once('class/functions.php');
	$function=new Functions();
	$typeKeyword=$function->checkValues($_GET['type']);
	$subject=$function->checkValues($_GET['tutorial']);
	$function->tutorialLike($typeKeyword,$subject);
?>
</div>
<div class="clear"></div><br/>
<h3>What's in a session?</h3>
<p>
A session means the duration spent by a Web user from the time logged in to the time logged out-during this time the user can view protected content. Protected content means the information that is not open to everyone. The beauty of a session is that it keeps the login credentials of users until they log out, even if they move from one Web page to another, in the same Web service, of course.
</p><br/>
<p>
From the point of view of a server-side programmer, the server verifies the user name and password obtained from the client and permits the client to create a session if the data is valid. On successful verification of login credentials, a session ID is created for the user, which should either be stored on the server or the client. Once the login information is stored, all subsequent pages identify the user and provide the requested information.
</p><br/>
<h3>Few methods of session management?</h3>
<ol>
	<li>Cookie Based Session</li>
	<li>Database Driven Session</li>
</ol><br/>
<h3>Advantages of Cookie Based Session</h3>
<p>Cookie-based strategy is simple.</p><br/>
<h3>Disadvantages of Cookie Based Session</h3>
<ol>
	<li>People might peep into the client machine, find the cookie and misuse the name-value pair to cheat the server, disguising themselves as authentic users.</li>
	<li>The second pitfall in cookie-based sessions is that a conservative user may block all incoming cookies. When the server sends a session cookie, it assumes that the client would store it. But, the client might reject the cookie for security reasons and thus hamper the formation of a session.</li>
</ol><br/>
<h3>Implementation : Table Schema</h3>
<ol>
	<li>I have taken the schema of the general User table that one would require.</li>
	<li>Creating object of this class creates connection.</li>
</ol><br/>
<pre class="brush: php;">
CREATE TABLE `users` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
);
insert  into `users`(`uid`,`password`,`email`) values (17,'827ccb0eea8a706c4c34a16891f84e7b','pavanratnakar@gmail.com');
</pre>
<h3>Implementation : Db Class</h3>
<table border="0">
	<tbody>
		<tr>
			<th colspan="2">Table 1: Datebase Connection Functions</th>
		</tr>
		<tr>
			<td><strong>Function</strong></td>
			<td><strong>Purpose</strong></td>
		</tr>
		<tr>
			<td><code>mysql_pconnect()</code></td>
			<td>establishes a persistent connection. You only need to call it once for the session. That's the beauty of it. It will hold open a connection to the db that you can use over and over again simply by calling the resource ID whenever you need to interact with the db.</td>
		</tr>
		<tr>
			<td><code>mysql_connect()</code></td>
			<td>establishes a connection for the duration of the script that access the db. Once the script has finished executing it closes the connection. The only time you need to close the connection manually is if you jump out of the script for any reason.</td>
		</tr>
	</tbody>
</table><br/>
<ol>
	<li>The constructor establishes connection with database server using <i>mysql_connect</i> function.</li>
	<li>Creating object of this class creates connection.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
define("DB_SERVER","localhost");
define("DB_USERNAME","root");
define("DB_PASSWORD","");
define("DB_DATABASE","test");
define("USER_TABLE","users");
class DB
{
	private $connection;
	function __construct()
	{
		$connection=mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD) or die("We are facing some technical issue.Please try later on.");
		mysql_select_db(DB_DATABASE,$connection) or die("We are facing some technical issue.Please try later on.");
	}
}
?>';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : Functions Class</h3>
<table border="0">
	<tbody>
		<tr>
			<th colspan="2">Table 2: PHP Functions</th>
		</tr>
		<tr>
			<td><strong>Function</strong></td>
			<td><strong>Purpose</strong></td>
		</tr>
		<tr>
			<td><code>nl2br()</code></td>
			<td>Inserts HTML line breaks before all newlines in a string.</td>
		</tr>
		<tr>
			<td><code>trim()</code></td>
			<td>Strip whitespace (or other characters) from the beginning and end of a string.</td>
		</tr>
		<tr>
			<td><code>stripslashes()</code></td>
			<td>Un-quotes a quoted string.</td>
		</tr>
		<tr>
			<td><code>strtr()</code></td>
			<td>Translate characters or replace substrings.</td>
		</tr>
		<tr>
			<td><code>strip_tags()</code></td>
			<td>Strip HTML and PHP tags from a string.</td>
		</tr>
		<tr>
			<td><code>mysql_real_escape_string()</code></td>
			<td>Escapes special characters in a string for use in an SQL statement.</td>
		</tr>
	</tbody>
</table><br/>
<ol>
	<li>I use <i>Functions</i> class to have common functions defined. <i>Functions</i> class has currently two methods which are meant for security purpose.</li>
	<li><i>checkValues</i> method is used to check any string for <i>CROSS-SIDE Scripting</i>.</li>
	<li><i>dbCheckValues</i> method is used to check any string for <i>SQL injection</i>. This method should be used after <i>mysql_connect</i> method.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
class Functions
{
	public function __construct()
	{

	}
	public function checkValues($value)
	{
		$value= nl2br($value);
		$value = trim($value);
		if (get_magic_quotes_gpc()) 
		{
			$value = stripslashes($value);
		}
		$value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
		$value = strip_tags($value,"<br>");
		return $value;
	}
	public function dbCheckValues($value)
	{
		$value = mysql_real_escape_string($value);
		return $value;
	}
}
?>';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : User Class</h3>
<table border="0">
	<tbody>
		<tr>
			<th colspan="2">Table 3: mysql Functions</th>
		</tr>
		<tr>
			<td><strong>Function</strong></td>
			<td><strong>Purpose</strong></td>
		</tr>
		<tr>
			<td><code>mysql_query()</code></td>
			<td>Send a MySQL query.</td>
		</tr>
		<tr>
			<td><code>mysql_fetch_assoc()</code></td>
			<td>Fetch a result row as an associative array.</td>
		</tr>
		<tr>
			<td><code>mysql_num_rows()</code></td>
			<td>Get number of rows in result.</td>
		</tr>
	</tbody>
</table><br/>
<ol>
	<li>The constructor creates database object.</li>
	<li><i>checkUser</i> method checks if the given email id and password are available in the <i>USER</i> table.</li>
	<li><i>dbCheckValues</i> method is used to check for <i>SQL injection</i>. Each parameter of the function should go through this function to prevent possiblity of <i>SQL injection</i>.</li>
	<li>If user is available in database, return an array with true flag and userid.</li>
	<li>If user is not available return false flag with null user id.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
include_once("db.php");
include_once("functions.php");
class User
{
	public function __construct()
	{
		$db=new DB();
	}
	function checkUser($email,$password)
	{
		$function=new Functions();
		$userArray=array();
		$status=FALSE;
		$userid=NULL;
		$email=$function->dbCheckValues($email);
		$password=$function->dbCheckValues(md5($password));
		$sql=mysql_query("SELECT uid FROM ".USER_TABLE." WHERE email=\'$email\' and password=\'$password\'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1)
		{
			$status=TRUE;
			$uid=$row["uid"];
		}
		else
		{
			$status=FALSE;
			$uid=NULL;
		}
		$userArray= array(
			"status" => $status,
			"uid" => $uid
			);
		return $userArray;
	}
}
?>';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : Error Class</h3>
<ol>
	<li>Contains method for printing the error.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
class Error
{
	public function errorDisplay($subject,$errors)
	{
		$errorString = "<p class=\"error\">".$subject." Error</p>";
		$errorString .= "<ul>";
		foreach($errors as $error)
		{
			$errorString .= "<li class=\"error\">$error</li>";
		}
		$errorString .= "</ul>";
		return $errorString;
	}
}
?>';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : User Controller</h3>
<p>
	PHP provides a cookie-based implementation for session management. The $_SESSION array is used for storing session data. PHP automatically generates a session ID and sends a session cookie containing this session ID to the client machine. The PHP functions for session management are listed in Table 1
</p><br/>
<table border="0">
	<tbody>
		<tr>
			<th colspan="2">Table 4: Session Management Functions</th>
		</tr>
		<tr>
			<td><strong>Function</strong></td>
			<td><strong>Purpose</strong></td>
		</tr>
		<tr>
			<td><code>session_set_cookie_params()</code></td>
			<td>Set the session cookie parameters.</td>
		</tr>
		<tr>
			<td><code>session_name ()</code></td>
			<td>Get and/or set the current session name.</td>
		</tr>
		<tr>
			<td><code>session_start()</code></td>
			<td>Initialises a session. If the session was not already started, it sends the session cookie to the client machine. If the session was already started, it loads the <code>$_SESSION</code> global variable with whatever values it was previously initialised with.</td>
		</tr>
		<tr>
			<td><code>isset()</code></td>
			<td>Determine if a variable is set and is not NULL.</td>
		</tr>
		<tr>
			<td><code>session_destroy()</code></td>
			<td>Destroys the session. The variable <code>$_SESSION</code> is cleared and the session cookie on the client is killed.</td>
		</tr>
	</tbody>
</table><br/>
<ol>
	<li>Contains all methods related to user. This is the file which handles session in my case.</li>
	<li>Used <i>session_name</i> to set a session name. This is not mandatory.</li>
	<li>Used <i>session_set_cookie_params</i> to set session expiry time.</li>
	<li><i>session_start</i> function should be called before you assign or read any session values. Functionality of the function is explained in the table above.</li>
	<li><i>loginUser</i> method is used to check if the User is a valid user. To check for valid user, I call the user class method <i>checkUser</i> which returns either TRUE or FALSE value based on SELECT query. Parameters which are passed to <i>loginUser</i> are checked for <i>CROSS-SIDE scripting</i> using <i>checkValues</i> method defined in <i>Functions</i> class. If the user is valid, create a SESSION with key as <i>uid</i> and value as <i>SQL SELECT userid</i>.</li>
	<li><i>getUserId</i> method is used to check if the SESSION is alive of not. If it is alive it returns TRUE, if not FALSE.</li>
	<li><i>logoutUser</i> destroys the session for the given user. <i>session_destroy</i> functionality is explained in the table above.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
session_name("pavanTutorialLogin");
// Starting the session
session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();
include_once("class/functions.php");
include_once("class/user.php");
class UserController
{
	public function loginUser($email,$password)
	{
		$function=new Functions();
		$email=$function->checkValues($_POST["email"]);
		$password=$function->checkValues($_POST["password"]);
		$user=new User();
		$userData=$user->checkUser($email,$password);
		if($userData["status"])
		{
			$_SESSION["uid"]=$userData["uid"];
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	
	}
	public function getUserId()
	{
		if(isset($_SESSION["uid"]))
		{
			return $_SESSION["uid"];
		}
		else
		{
			return FALSE;
		}
	}
	public function logoutUser()
	{
		if(isset($_SESSION["uid"]))
		{
			$_SESSION = array();
			session_destroy();
		}
	}
}
?>';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : Index Page</h3>
<ol>
	<li>Create object of userController Class. Call the method <i>getUserId</i> to check if the user is logged in.</li>
	<li>If the user is logged in, display logout link. Will explain the logout functionality at the end.</li>
	<li>Login Form has email and password as input fields. I am not performing any client side validation here. Will host another tutorial with client side validation using jQuery. Submission of the form, sends the form data as POST variables along with HTTP header to <i>process.php</i> page.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php 
include_once("controller/userController.php");
$userController=new UserController();
?>
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<?php
		if($userController->getUserId())
		{
			echo "You have successfully logged in and your user id is ".$userController->getUserId();
			echo "<br/><a href=\"logout.php\">Click here if you want to logout</a>";
		}
		else
		{
			echo $errorString; 
		?>
		<form method="post" action="process.php">
			<table border="0">
				<tr>
					<td><label for="email">Email:</label></td>
					<td><input type="text" id="email" name="email" maxlength="50" /></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" id="password" name="password" /></td>
				</tr>
			</table>
			<input name="submit" type="submit" value="Log in" />
		</form>
		<?php
		}
		?>
	</body>
</html>';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : Process Page</h3>
<table border="0">
	<tbody>
		<tr>
			<th colspan="2">Table 5: php Functions</th>
		</tr>
		<tr>
			<td><strong>Function</strong></td>
			<td><strong>Purpose</strong></td>
		</tr>
		<tr>
			<td><code>in_array()</code></td>
			<td>Checks if a value exists in an array.</td>
		</tr>
	</tbody>
</table><br/>
<ol>
	<li>Check if the form has been submitted.</li>
	<li>I have created an array to permit only the fields that I want to accept so that one can't send whatever they want to the form.</li>
	<li>All POST variable are checked for their size. If any POST variable is null, <i>errors</i> array would be pushed with the error message. All the POST variable are stored as normal variable with the same name.</li>
	<li>If <i>errors</i> array is not null, print the errors and show the form once again.</li>
	<li>If form has been submitted with no validation errors, call <i>loginUser</i> method part of <i>userController</i> object.</li>
	<li>If the response is FALSE, display the error and show the form once again.</li>
	<li>If the response is TRUE, redirect to index page.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
// process.php
/*
 *  Specify the field names that are in the form. This is meant
 *  for security so that someone can\'t send whatever they want
 *  to the form.
 */
include_once("controller/userController.php");
include_once("class/error.php");
if($_POST["submit"])
{
	$error=new Error();
	$userController=new UserController();
	$allowedFields = array(
		"email",
		"password"
	);
	// Specify the field names that you want to require...
	$requiredFields = array(
		"email",
		"password"
	);
	// Loop through the $_POST array, which comes from the form...
	$errors = array();
	foreach($_POST AS $key => $value)
	{
		// first need to make sure this is an allowed field
		if(in_array($key, $allowedFields))
		{
			$$key = $value;
			// is this a required field?
			if(in_array($key, $requiredFields) && $value == "")
			{
				$errors[] = "The field $key is required.";
			}
		}
	}
	// were there any errors?
	if(count($errors) > 0)
	{
		$errorString=$error->errorDisplay("Form",$errors);
		// display the previous form
		include_once("index.php");
	}
	else
	{
		if($userController->loginUser($email,$password))
		{
			header("Location: index.php");
		}
		else
		{
			$errors[]="Wrong Id or Password";
			$errorString=$error->errorDisplay("Form",$errors);
			include_once("index.php");
		}
	}
}
else
{
	header("Location: index.php");
}
';
echo htmlentities($content);
?>
</pre>
<h3>Implementation : Logout</h3>
<ol>
	<li>On page call, create object of <i>userController</i> and call <i>logoutUser</i> method which will destroy the SESSION and then redirect to Index page.</li>
</ol><br/>
<pre class="brush: php;">
<?php 
$content='<?php
// logout.php
/*
 *  Logout the user
 */
include_once("controller/userController.php");
$userController=new UserController();
$userController->logoutUser();
header("Location: index.php");
?>';
echo htmlentities($content);
?>
</pre>
<p>
I have tried keeping it as simple as possible. Please post your comments/feedback below. 
</p><br/>
<hr><br/>
<div>
<?php
	$function->tutorialLike($typeKeyword,$subject);
?>
</div>
<div class="clear"></div><br/>