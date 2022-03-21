<?php

$servername = "localhost"; 			//localhost = localhost 	|| bluehost = 162.241.252.218
$dBUsername = "root"; 				//localhost = root     		|| bluehost = adamcol3_adamcj or adamcol3_test
$dBPassword = "3321fcbg6hk4";  		//localhost = 3321fcbg6hk4  || bluehost = {G~zP0Ihg*gW
$dBName = "acj"; 					//localhost = acj    		|| bluehost = adamcol3_acj1

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}
