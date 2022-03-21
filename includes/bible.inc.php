<?php
	
	function getChapter($conn) {
		// check the url for book first
		$bookValid = False;
		if (isset($_GET["book"])) {
			$book = $_GET["book"];
			$bookSQL = "SELECT * FROM bible WHERE book = ?";
			$bookSTMT = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($bookSTMT, $bookSQL)) {
				echo 'error 1';
			}
			else {
				mysqli_stmt_bind_param($bookSTMT, "s", $book);
				mysqli_stmt_execute($bookSTMT);
				$bookRESULT = mysqli_stmt_get_result($bookSTMT);
				$bookRESULTCHECK = mysqli_num_rows($bookRESULT);
				if ($bookRESULTCHECK <= 0) {
					$bookValid = False;
				}
				else {
					$bookValid = True;
				}
			}
		}
		// if there is no book, or book is invalid ask user for a book
		if (!$bookValid) {
			echo '
				<a href="bible.php?book=Genesis">Genesis</a>
				<a href="bible.php?book=Exodus">Exodus</a>
				<a href="bible.php?book=Leviticus">Leviticus</a>
				<a href="bible.php?book=Numbers">Numbers</a>
				<a href="bible.php?book=Deuteronomy">Deuteronomy</a>
				<a href="bible.php?book=Joshua">Joshua</a>
				<a href="bible.php?book=Judges">Judges</a>
				<a href="bible.php?book=Ruth">Ruth</a>
				<a href="bible.php?book=1 Samuel">1 Samuel</a>
				<a href="bible.php?book=2 Samuel">2 Samuel</a>
				<a href="bible.php?book=1 Kings">1 Kings</a>
				<a href="bible.php?book=2 Kings">2 Kings</a>
				<a href="bible.php?book=1 Chronicles">1 Chronicles</a>
				<a href="bible.php?book=2 Chronicles">2 Chronicles</a>
				<a href="bible.php?book=Ezra">Ezra</a>
				<a href="bible.php?book=Nehemiah">Nehemiah</a>
				<a href="bible.php?book=Esther">Esther</a>
				<a href="bible.php?book=Job">Job</a>
				<a href="bible.php?book=Psalm">Psalm</a>
				<a href="bible.php?book=Proverbs">Proverbs</a>
				<a href="bible.php?book=Ecclesiastes">Ecclesiastes</a>
				<a href="bible.php?book=Song of Solomon">Song of Solomon</a>
				
				<a href="bible.php?book=Isaiah">Isaiah</a>
				<a href="bible.php?book=Jeremiah">Jeremiah</a>
				<a href="bible.php?book=Lamentations">Lamentations</a>
				<a href="bible.php?book=Ezekiel">Ezekiel</a>
				<a href="bible.php?book=Daniel">Daniel</a>
				<a href="bible.php?book=Hosea">Hosea</a>
				<a href="bible.php?book=Joel">Joel</a>
				<a href="bible.php?book=Amos">Amos</a>
				<a href="bible.php?book=Obadiah">Obadiah</a>
				<a href="bible.php?book=Jonah">Jonah</a>
				<a href="bible.php?book=Micah">Micah</a>
				<a href="bible.php?book=Nahum">Nahum</a>
				<a href="bible.php?book=Habakkuk">Habakkuk</a>
				<a href="bible.php?book=Zephaniah">Zephaniah</a>
				<a href="bible.php?book=Haggai">Haggai</a>
				<a href="bible.php?book=Zechariah">Zechariah</a>
				<a href="bible.php?book=Malachi">Malachi</a>

			';
		}
		// once book is decided, ask for chapter
		// check for chapter or invalid chapter
		// load passage, ask user if they want to compare somewhere on the page
	}

	


?>