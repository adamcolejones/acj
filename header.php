<?php
	require 'includes/dbh.inc.php';
	require "includes/post.inc.php";
	session_start();
	date_default_timezone_set('America/Chicago');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>acj</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="headerContainer">
			<a href="index.php">ACJ</a>
		</div>
		<!-- Signin / signup is outside of the Header container for styling conflictions -->
		<?php 
			// If user is logged in, show the necessary user info
			if (isset($_SESSION['userID'])) {
				$sessionUserID = $_SESSION['userID'];
				echo '
					<div id="signOutUserName">
						<p>'.$_SESSION['userName'].'</p>
					</div>
					<div id="signOutLink">
						<a href="includes/signout.inc.php">Sign Out</a>
					</div>
					<div id="postLink">
						<a href="createpost.php">New Post</a>
					</div>					
				';
			}
			// If user is not logged in, prompt user to login or signup
			else {
				echo '
					<div id="signInHeader">
						<form action="includes/signin.inc.php" method="post">
							<input type="text" name="mailuid" placeholder="E-mail">
							<input type="password" name="password" placeholder="Password">
							<button type="Submit" name="login-submit">Login</button>
						</form>
					</div>
					<div id="signUp">
						<a href="signup.php">or Sign Up</a>
					</div>
				';
			}
		?>
		<div id="sideBar">
			<?php
				echo '
					<a href="bible.php">Bible</a>
				';	
				if (isset($_SESSION['uniqueID'])) {
					echo '
						<a href="home.php?user='.$_SESSION['uniqueID'].'">Home</a>
					';
				}
				else {
					echo '
						<a href="index.php">Home</a>
					';
				}
				echo '
					<a href="topics.php">Topics</a>
				';	
				echo '
					<a href="users.php">Users</a>
				';	
			?>		
		</div>