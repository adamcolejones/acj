<?php

if(isset($_POST['login-submit'])) {
	
	require 'dbh.inc.php';

	$mailuid = $_POST['mailuid'];
	$password = $_POST['password'];

	if (empty($mailuid) || empty($password)) {
		header("Location: ../index.php?error1");
		exit();
	}
	else {
		$sql = "SELECT userID, uniqueID, userName, password FROM users WHERE email=?;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../index.php?error2");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "s", $mailuid);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)) {
				$pwdCheck = password_verify($password, $row['password']);
				if ($pwdCheck == false) {
					header("Location: ../index.php?error3");
					exit();
				}
				else if ($pwdCheck == true) {
					session_start();
					$_SESSION['userID'] = $row['userID'];
					$_SESSION['userName'] = $row['userName'];
					$_SESSION['uniqueID'] = $row['uniqueID'];

					header("Location: ../home.php?user=".$_SESSION['uniqueID']."");  //get the url of the current page and send them there instead
					exit();
				}
				else {
					header("Location: ../index.php?error4");
					exit();
				}
			}
			else {
				header("Location: ../index.php?error5");
				exit();
			}
		}
	}
}
else {
	header("Location: ../index.php");
	exit();
}