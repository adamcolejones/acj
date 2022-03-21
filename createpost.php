<?php
	require "header.php";
?>
	
<div id="defaultBody">
	<script>
		$(document).ready(function(e) {
			//Variables
			// this code generates a form with text fields.  Also gives user the remove feature
			// add [] around the name to create an array of different name values
			var textHtml = '<div><input type="TEXT" name="text[]" id="text"> <a href="#" id="remove">x</a></div><p />';

			var maxRows = 10;
			var x = 0;


			//Add rows to the form
			$("#addText").click(function(e) {
				if(x < maxRows) {
					$("#newPost").append(textHtml);
					x++;
				}
				// alert();	// gives aleart message when clicked
			});
			$("#addImage").click(function(e) {
				$("#newPost").append("<p>Image");
				// alert();	// gives aleart message when clicked
				// getimagesize() to make sure the upload is a picture
			});

			//Remove rows from the form
			$("#newPost").on('click' ,'#remove' ,function(e) {
				$(this).parent('div').remove();
				x--;
			});	

		});
	</script>

	<?php
		if (isset($_SESSION['userID'])) {
			// This echo is for the create new post box
			echo '
				<form enctype="multipart/form-data" method="POST" action"'.post($conn).'">		
					<div id="newPost">		
						<input type="hidden" name="date" value="'.date('Y-m-d H:i:s').'">
						
					</div>	
					<div id="newPostSubmit">
						<a href="#" id="addText">Text</a>
						<a href="#" id="addImage">Image</a>	
						<p/>		
						<button type="submit" name="postSubmit">Post</button>
					</div>	
				</form>
			';
		}
		else {
			echo '
				<div id="newPost">
					<p>You must be signed in to post!</p>
				</div>
			';
		}
	?>
	
</div> 
	