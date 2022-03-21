<?php
	require 'header.php';
?>
	<div id="defaultBody">
		<div id="signUpBody">
			<form action="includes/signup.inc.php" method="post">
				<label for="firstName">First Name</label>
				<input type="text" name="firstName" placeholder="First Name">
				<br>
				<label for="lastName">Last Name</label>
				<input type="text" name="lastName" placeholder="Last Name">
				<br>
				<label for="email">Email</label>
				<input type="text" name="email" placeholder="Email">
				<br>
				<label for="userName">User Name</label>
				<input type="text" name="userName" placeholder="User Name">
				<br>
				<label for="password">New Password</label>
				<input type="password" name="password" placeholder="New Password">
				<br>
				<label for="pwd-repeat">Repeat Password</label>
				<input type="password" name="pwd-repeat" placeholder="Repeat password">
				<br>
				<?php
					echo "<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>";
					echo '<input type="hidden" name="uniqueID" value="'.uniqid(random_int(1, 9999), TRUE).'">';
				?>
				<input type="submit" name="signup-submit"></input>
			</form>
		</div>
	</div>
<?php
	require 'footer.php';
?>