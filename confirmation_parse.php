<?php
	/*
		For confirming user accounts
	*/
	session_start();
	include "gafflib.php";
	include "top.html";
	
	//update db
	$confirm_code = $_POST['code'];
	$results = mysqli_query($mysqli, "UPDATE users SET entry='1' WHERE confirmation='".$confirm_code."'");
	
	//check to make sure successful update
	$check = mysqli_query($mysqli, "SELECT * FROM users WHERE confirmation='".$confirm_code."'");
	$entry = mysqli_fetch_assoc($check)['entry'];
	
	//if successful
	if ($entry)
	{
		echo'<head><script src="js/scripts.js"></script></head>';
		successDisplay("You have been successfully confirmed", "Welcome to Gaffs!"," the home page ");
		//redirect
		header('refresh:10;url=index.shtml');
	}
	// if not
	else
	{
		echo'<head><script src="js/scripts.js"></script></head>';
		errorDisplay("Error!", "Confirmation Code Unsuccessful"," the home page ");
		header('refresh:10;url=index.shtml');
	}
include "bottom.html";
?>
