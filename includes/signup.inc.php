<?php 
	date_default_timezone_set('America/Chicago');
	if (isset($_POST['signup-submit'])) {
		require 'dbh.inc.php';
		
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		$passwordRepeat = $_POST['pwd-repeat'];
		$joined = $_POST['date'];

		// make a random value for $uniqueID and then see if it exists in the DB
		$uniqueIDLength = 10;
		$uniqueIDString = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$uniqueIDDuplicate = true;
		while ($uniqueIDDuplicate = true) {
			$uniqueID = substr(str_shuffle($uniqueIDString), 0, $uniqueIDLength); //shuffle String, start with 0, 10 characters long
			$uniqueIDSQL = "SELECT * FROM users WHERE uniqueID = ?";
			$uniqueIDStmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($uniqueIDStmt, $uniqueIDSQL)) {
				header("Location: ../signup.php?error1");
				exit();
			}
			else {
				mysqli_stmt_bind_param($uniqueIDStmt, "s", $uniqueID);
				mysqli_stmt_execute($uniqueIDStmt);
				$uniqueIDResult = mysqli_stmt_get_result($uniqueIDStmt);
				$uniqueIDResultCheck = mysqli_num_rows($uniqueIDResult);
				if ($uniqueIDResultCheck <= 0) {
					$uniqueIDDuplicate = false;
					break;
				}
				else {
					// repeat until you have a unique ID
				}
			}				
		}
		
		// Check empty fields
		if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordRepeat)) {
			header("Location: ../signup.php?error=empty_fields");
			exit();
		}
		// Verify real emails
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../signup.php?error=invalid_email");
			exit();
		}
		// Passwords must be identical	
		else if ($password != $passwordRepeat) {
			header("Location: ../signup.php?error=different_pws");
			exit();
		}
		// Verify unique email address
		else {
			$sqlEmailVerify = "SELECT email FROM users WHERE email=?";
			$stmtEmailVerify = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmtEmailVerify, $sqlEmailVerify)) {
				header("Location: ../signup.php?error1");
				exit();
			}
			else {
				mysqli_stmt_bind_param($stmtEmailVerify, "s", $email);
				mysqli_stmt_execute($stmtEmailVerify);
				$resultEmailVerify = mysqli_stmt_get_result($stmtEmailVerify);
				$resultCheckEmailVerify = mysqli_num_rows($resultEmailVerify);
				if ($resultCheckEmailVerify > 0) {
					header("Location: ../signup.php?error=email_exists");
					exit();
				}
				// Verify unique user name
				else {
					$sqlUserVerify = "SELECT userName FROM users WHERE userName=?";
					$stmtUserVerify = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmtUserVerify, $sqlUserVerify)) {
						header("Location: ../signup.php?error2");
						exit();
					}
					else {
						mysqli_stmt_bind_param($stmtUserVerify, "s", $userName);
						mysqli_stmt_execute($stmtUserVerify);
						$resultUserVerify = mysqli_stmt_get_result($stmtUserVerify);
						$resultCheckUserVerify = mysqli_num_rows($resultUserVerify);
						if ($resultCheckUserVerify > 0) {
							header("Location: ../signup.php?error=userName_exists");
							exit();
						}
						// Enter user input into the database
						else {
							$sqlUser = "INSERT INTO users (uniqueID, userName, firstName, lastName, email, password, joindate) VALUES (?, ?, ?, ?, ?, ?, ?)";
							$stmtUser = mysqli_stmt_init($conn);
							if (!mysqli_stmt_prepare($stmtUser, $sqlUser)) {
								header("Location: ../signup.php?error3");
								exit();
							}
							else {
								$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
								mysqli_stmt_bind_param($stmtUser, "sssssss", $uniqueID, $userName, $firstName, $lastName, $email, $hashedPassword, $joined);
								mysqli_stmt_execute($stmtUser);
								header("Location: ../index.php?signup=success");
								// here the user should be automatically sent to a login page for their new account
								exit();
							}
						}
					}
				}	
			}
		}
	}
	else {
		header("Location: ../signup.php");
		exit();
	}
?>