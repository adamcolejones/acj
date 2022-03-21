<?php
	require 'header.php';

	echo '	
		<div id="defaultBody">
			<div id="userBox">	
	';
			$userBoxSQL = "SELECT uniqueID, privacy, firstName, lastName FROM users"; // get this info only
			$userBoxSTMT = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($userBoxSTMT, $userBoxSQL)) {
					echo "error";
			}
			else {
				mysqli_stmt_execute($userBoxSTMT);
				$userBoxRESULT = mysqli_stmt_get_result($userBoxSTMT);
				while ($userBoxROW = mysqli_fetch_assoc($userBoxRESULT)) {
					if ($userBoxROW['privacy'] == 'public') { // check if user account is private
						echo '
							<a href="home.php?user='.$userBoxROW['uniqueID'].'">'.$userBoxROW['firstName'].' '.$userBoxROW['lastName'].'</a>
						';
					}
				}
			}
	echo '
			</div>
		</div>
	';

	require 'footer.php';
?>