<div id="fb-root"></div><div id="panel">	<div class="panelContent">		<div id="panelUpdates" class="left leftContainer">			<h2>Welcome to Pavan Ratnakar Website</h2>			Thank you for visiting my website. Please feel free to reach me out for any clarifications.			<h3>Upcoming updates to the website.</h3>			<ul>				<li>Facebook, Yahoo &amp; Google Login.</li>				<li>Movie Section.</li>				<li>Picassa + Facebook + Flickr Gallery Integration.</li>			</ul>			<h3>Last updates added to the website.</h3>			<ul>				<li>Data migrations is complete.</li>				<li>Changed to friendly URL's.</li>				<li>Added 404 page.</li>			</ul>		</div>		<?php		if(!$_SESSION['uid'] OR !$cookie)		{		?>		<div id="panelLogin" class="left leftContainer">			<form id="loginForm" method="post" action="">				<h2>Member Login</h2>				<div id="loginStatus"></div>				<div class="clear"></div>				<label for="loginEmail" class="grey">Email:</label>				<input type="text" size="23" value="" id="loginEmail" name="email" class="field"/>				<label for="loginPassword" class="grey">Password:</label>				<input type="password" size="23" id="loginPassword" name="password" class="field"/>				<label class="radio">					<input type="checkbox" value="1" checked="checked" id="rememberMe" name="rememberMe"> &nbsp;Remember me				</label>				<div class="clear"></div>				<input type="submit" class="bt_login" value="Login" name="submit"/>			</form>			<div>				<h2>Login using below accounts</h2>				<fb:login-button show-faces="true" width="200" max-rows="1"></fb:login-button>			</div>		</div>		<div id="panelRegister" class="left leftContainer">			<form method="post" id="registerForm" action="" enctype="multipart/form-data">				<h2>Not a member yet? Sign Up!</h2>				<div id="registerStatus"></div>				<div class="clear"></div>				<label for="registerFirstname" class="grey">First Name:</label>				<input type="text" size="23" value="" id="registerFirstname" name="firstname" class="field"/>				<label for="registerLastname" class="grey">Last Name:</label>				<input type="text" size="23" id="registerLastname" name="lastname" class="field"/>				<label for="text" class="grey">Email:</label>				<input type="text" size="23" value="" id="registerEmail" name="email" class="field"/>				<label for="registerPassword" class="grey">Password:</label>				<input type="password" size="23" value="" id="registerPassword" name="password" class="field"/>				<div class="password-meter right">					<div class="password-meter-message">Password Stength Meter</div>					<div class="password-meter-bg">						<div class="password-meter-bar"></div>					</div>				</div>				<label for="sexSelect" class="grey">I am:</label>				<select name="sexSelect" id="sexSelect">					<option value="">Select Sex</option>					<option value="1">Male</option>					<option value="2">Female</option>				</select>				<label for="registerBirthDate" class="grey">Birthday:</label>				<input type="text" size="23" value="" id="registerBirthDate" name="registerBirthDate" class="field"/>				<div class="clear"></div>				<input type="submit" class="bt_register" value="Sign Up" name="submit"/>			</form>		</div>		<?php		}		else		{		?>		<div id="panelLogin" class="left leftContainer">			<?php			if($cookie)			{			?>				Welcome <?= $user->name ?>				<fb:login-button show-faces="true" width="200" max-rows="5"></fb:login-button>			<?php			}			else			{			?>			<h2>Profile</h2>			<a href="passwordreset">Change Your Password</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<a href="profile">Edit you profile</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<a href="?logoff">Log off</a>			<h3>Personal Details</h3> 			<?php 			echo $user->getDetails($_SESSION['uid']);				}			?>		</div>		<div id="panelRegister" class="left leftContainer">			<h2>Statistics</h2>			<h3>Login statistics</h3> 			<?php echo $user->loginStatistics($_SESSION['uid']);?>			<h3>Comment statistics</h3>			<?php echo $user->commentStatistics($_SESSION['uid']);?>		</div>		<?php		}		?>	</div></div><!-- The tab on top -->	<div class="tab">	<ul class="login">		<li class="left">&nbsp;</li>		<li>Hello <?php echo $_SESSION['uid'] ? $user->fullName($_SESSION['uid']) : 'Guest';?>!</li>		<li class="sep ">|</li>		<li id="toggle ">			<a id="open" class="open iconsSprite <?php echo $_SESSION['uid'] ? '' : 'login';?>" href="javascript:void(0);"><?php echo $_SESSION['uid'] ? 'View Your Profile' : 'Log In | Register';?></a>			<a id="close" style="display: none;" class="close iconsSprite" href="javascript:void(0);">Close Panel</a>					</li>		<li class="right">&nbsp;</li>	</ul> </div> <!-- / top -->