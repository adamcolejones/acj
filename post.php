<?php
	require "header.php";
?>
	<div id="defaultBody">
		<?php 
			// this gets home.php?user=???
			if (isset($_GET["post"])) {
				$postID = $_GET["post"];
				$sqlUrlUser = "SELECT userID, proPic FROM users WHERE uniqueID = ?";
				$stmtUrlUser = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmtUrlUser, $sqlUrlUser)) {
					echo "error";
				}
				else {
					mysqli_stmt_bind_param($stmtUrlUser, "s", $uniqueID);
					mysqli_stmt_execute($stmtUrlUser);
					$resultUrlUser = mysqli_stmt_get_result($stmtUrlUser);
					// After getting user information, start displaying content
					while ($rowUrlUser = mysqli_fetch_assoc($resultUrlUser)) {
						$urlID = $rowUrlUser['userID'];
						$urlProPic = $rowUrlUser['proPic'];
						echo "
							<div id='homeContainer'>
								<div id='homeBanner'>
									<p>Test</p>
								</div>
						";
						homePosts($conn);
						echo '
							</div>
						';
					}
				}
			}
		?>
	</div>
<?php
	require 'footer.php';
?>