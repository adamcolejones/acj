<?php
	require 'header.php';

	echo '
		<div id="defaultBody">
			
	';
	if (isset($_SESSION['userID'])) { 
		// if user is signed in, show them posts based on who they are following
		allPosts($conn);
	}
	else {
		allPosts($conn);
	}	
?>
			
		
	</div> <!--defaultBody-->
<?php
	require 'footer.php';
?>