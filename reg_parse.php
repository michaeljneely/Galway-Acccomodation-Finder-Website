<?php
	/*
		For processing registration of new user
	*/
	session_start();
	include "gafflib.php";
	include "top.html";
	/*
		Get register information
	*/
	$username = $_POST['regusername'];
	$password = $_POST['regpassword'];
	$email = $_POST['regemail'];
	
	//create confirmation code
	$random_hash = md5(uniqid(rand(), true));
	
	/*
		Check for username and email conflicts
	*/
	$sqli_username = mysqli_real_escape_string($mysqli,$username);
	$sqli_email = mysqli_real_escape_string($mysqli,$email);
	$username_repeat = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '".$sqli_username."'");
	$email_repeat = mysqli_query($mysqli, "SELECT * FROM users WHERE email = '".$sqli_email."'");
	$okay = 1;
	$errors = "";
	if (mysqli_num_rows($username_repeat) != 0)
	{
		$errors .= "Username already taken<br>";
		$okay = 0;
	}
	if (mysqli_num_rows($email_repeat) != 0)
	{
		$errors .= "Email already taken<br>";
		$okay = 0;
	}
	/*
		If no errors
	*/
	if ($okay)
	{
		mysqli_query($mysqli,"INSERT INTO users (username, password, email, confirmation) VALUES ('".$username."','".$password."','".$email."','".$random_hash."')"); //update table
		mysqli_close($mysqli);
		//send email
		$url = "danu6.it.nuigalway.ie/michaelneelytestsite/access.php";
		$subject = "Confirmation Code from Gaffs";
		$message = "Thank you for registering.\nYour registration details are as follows:\n\n" . "username: " . 
			$username . "\n\remail: " . $email . "\n\rConfirmation Code: " . $random_hash . "\n\nPlease Enter your code at: " . $url . "\nThanks,\n" . "The Gaffs Team";
		mail($email,$subject,$message);
		echo'<head><script src="js/scripts.js"></script></head>';
		successDisplay("You have successfuly registered!","Check your email for the confirmation code"," the home page ");
		//redirect
		header('refresh:10;url=index.shtml');
	}
	//If errors
	else
	{
		echo'<head><script src="js/scripts.js"></script></head>';
		errorDisplay("Error!",$errors," the home page ");
		header('refresh:10;url=index.shtml');
	}
include "bottom.html";
?>
