<?php

	$con = mysqli_connect('localhost', 'root', 'root', 'newunityaccess'); 

	//check that connection happened

	if(mysqli_connect()_errno()){
		echo "1"; //error code #1 = connection failed
		exit(); 
	}

	$username = $_POST["name"]; 
	$password = $_POST["password"]; 

	//check if name exists
	$namecheckquery = "SELECT username FROM players WHERE username ='" . $username . "';"; 

	$namecheck = mysqli_query($con, $namecheckquery) or die("2: Name check query failed"); //error #2 = name check query failed

	if(mysqli_num_rows($namecheck) > 0 ) {
		echo "3: Name already exists" //error code #3 = name exists cannot register 
		exit(); 
	}

	//add user to the table 
	$salt = "\$5\$rounds=5000\$" . "steamedhams" . $username . "\$"; 
	$hash = crypt($password, $salt); 
	$insertuserquery = "INSERT INTO player (username, hash, salt) VALUES ('" . $username . "', '" . $hash . "', '" . $salt . "');"; 
	mysqli_query($con, $insertuserquery) or die("4: Insert player query failed"); //error #4 = insert player query failed

	echo("0"); 


?>