<?php
	require 'header.php';
	echo '
		<div id="defaultBody">
	';
		if (isset($_SESSION['userID'])) {
			if (isset($_GET['user'])) {
				$userID = $_SESSION['userID'];
				$userSQL = "SELECT userName FROM users WHERE userID=?";
				$userSTMT = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($userSTMT, $userSQL)) {
					echo 'error 1';
				}
				else {
					mysqli_stmt_bind_param($userSTMT, "s", $userID);
					mysqli_stmt_execute($userSTMT);
					$userRESULT = mysqli_stmt_get_result($userSTMT);
					while ($userROW = mysqli_fetch_assoc($userRESULT)) {
						$userName = $userROW['userName'];
						if ($userName == $_GET['user']) {
							echo '
								<div id="newWorkOut">
									<p>Post your workout here!</p>
								</div>
							';
						}
						else {
							// kick user back to either their workout page or an error page
							echo 'You must be logged in as this user to post workouts!';
						}
					}
				}
			}
			else {
				echo 'You need to be logged in as the user to see this page';
			}
		}
		else {
			echo '
				<div id="newWorkOut">
					<p>You must be signed in to post!</p>
				</div>
			';
		}
	// this ends the defaultBody div id
	echo '
		</div> 
	'; 