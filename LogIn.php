<?php
	
	$con = mysqli_connect('localhost', 'root', 'root', 'newunityaccess'); 

	//check that connection happened

	if(mysqli_connect()_errno()){
		echo "1"; //error code #1 = connection failed
		exit(); 
	}

	$username = mysqli_real_escape_string($con, $_POST["name"]); //look through the string and check to avoid sql injection querying 
	$usernameclean = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH); 
	$password = $_POST["password"]; 

	//check if name exists
	$namecheckquery = "SELECT username, satl, hash, score FROM players WHERE usernameclean ='" . $username . "';"; 

	$namecheck = mysqli_query($con, $namecheckquery) or die("2: Name check query failed"); //error #2 = name check query failed

	if(mysqli_num_rows($namecheck) != 1 ){
		echo "5: Either no user with name or more than one"; //error code #5 = number of names matching != 1
		exit();  
	}


	//get login info from query 
	$existinginfo = mysqli_fetch_assoc($namecheck); 
	$salt = $existinginfo["salt"]; 
	$hash = $existinginfo["hash"]; 

	$loginhash = crypt($password, $salt ); 
	if(hash != $loginhash){
		echo "6: Incorrect password"; //error code #6 = password does not hash to match table 
		exit(); 
	}

	echo "0\t" . $existinginfo["score"]; 




?>