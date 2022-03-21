<?php
	require 'header.php';
	require "includes/bible.inc.php";
?>
	<div id="defaultBody">
		<div id="bibleBox">
			<?php 
				
				
				getChapter($conn);



			?>
		</div>
	</div>
<?php
	require 'footer.php';
?>