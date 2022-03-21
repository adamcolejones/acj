<?php
	// this function will return all public posts from all public users
	function allPosts($conn) {
		echo '<div id="postBoxContainer">';
		$allPostSQL = "SELECT * FROM posts WHERE sectionID = 1 ORDER BY contentID DESC";
		$allPostRESULT = mysqli_query($conn, $allPostSQL);
		while ($allPostROW = mysqli_fetch_assoc($allPostRESULT)) {
			$userID = $allPostROW['userID'];
			$userSQL = "SELECT userName FROM users WHERE userID = ?";
			$userSTMT = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($userSTMT, $userSQL)) {
				echo 'error1';
			}
			else {
				mysqli_stmt_bind_param($userSTMT, "i", $userID);
				mysqli_stmt_execute($userSTMT);
				$userRESULT = mysqli_stmt_get_result($userSTMT);
				while ($userROW = mysqli_fetch_assoc($userRESULT)) {
					$userName = $userROW['userName'];
					$date = $allPostROW['date'];
					$text = $allPostROW['text'];
					echo '
						<a href="bible.php"> 
							<div id="postBox">
								<div id="postBoxUserName">'.$userName.'</div>
								<div id="postBoxDate">'.$date.'</div>
								<div id="postBoxBody">'.$text.'</div>
							</div>
						</a>
					';
				}
			}
		}
		echo '</div>'; // This is for postBoxContainer
	}

	// this function will show all of a user's own posts on their own homepage
	function homePosts($conn) {
		$uniqueID = $_GET['user'];
		$userSQL = "SELECT userID, userName FROM users WHERE uniqueID = ?";
		$userSTMT = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($userSTMT, $userSQL)) {
			echo 'error1';
		}
		else {
			mysqli_stmt_bind_param($userSTMT, "s", $uniqueID);
			mysqli_stmt_execute($userSTMT);
			$userRESULT = mysqli_stmt_get_result($userSTMT);
			while ($userROW = mysqli_fetch_assoc($userRESULT)) {
				$userID = $userROW['userID'];
				$userName = $userROW['userName'];
				$homePostSQL = "SELECT * FROM posts WHERE userID = ? ORDER BY date DESC";
				$homePostSTMT = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($homePostSTMT, $homePostSQL)) {
					echo 'error2';
				}
				else {
					mysqli_stmt_bind_param($homePostSTMT, "i", $userID);
					mysqli_stmt_execute($homePostSTMT);
					$homePostRESULT = mysqli_stmt_get_result($homePostSTMT);
					while ($homePostROW = mysqli_fetch_assoc($homePostRESULT)) {
						$date = $homePostROW['date'];
						$text = $homePostROW['text'];
						//  a href needs to be changed to match the post link
						echo '
							<a href="bible.php"> 
								<div id="postBox">
									<div id="postBoxUserName">'.$userName.'</div>
									<div id="postBoxDate">'.$date.'</div>
									<div id="postBoxBody">'.$text.'</div>
								</div>
							</a>
						';
					}
				}
			}
		}
	}

	function post($conn) {
		if (isset($_POST['postSubmit'])) {
			$userID = $_SESSION['userID'];
			$date = $_POST['date'];
			$text = $_POST['text'];
			$sectionID = 1;

			// make a random value for $postID and then see if it exists in the DB
			$postIDLength = 10;
			$postIDString = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$postIDDuplicate = true;
			while ($postIDDuplicate = true) {
				$postID = substr(str_shuffle($postIDString), 0, $postIDLength); //shuffle String, start with 0, 10 characters long
				$postIDSQL = "SELECT postID FROM posts WHERE postID = ?";
				$postIDStmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($postIDStmt, $postIDSQL)) {
					header("Location: ../createpost.php?error1");
					exit();
				}
				else {
					mysqli_stmt_bind_param($postIDStmt, "s", $postID);
					mysqli_stmt_execute($postIDStmt);
					$postIDResult = mysqli_stmt_get_result($postIDStmt);
					$postIDResultCheck = mysqli_num_rows($postIDResult);
					if ($postIDResultCheck <= 0) {
						$postIDDuplicate = false;
						break;
					}
					else {
						// repeat until you have a unique ID
					}
				}				
			}
			
			$postSQL = "INSERT INTO posts (userID, postID, sectionID, date, text) VALUES (?, ?, ?, ?, ?)";
			$postSTMT = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($postSTMT, $postSQL)) {
				echo 'Error2';
			}
			else {
				mysqli_stmt_bind_param($postSTMT, "isiss", $userID, $postID, $sectionID, $date, $text);
				mysqli_stmt_execute($postSTMT);
			}
			header('Location: home.php?user='.$_SESSION['uniqueID'].'');
      		exit();
		}
	}
