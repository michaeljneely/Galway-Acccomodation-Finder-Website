<?php
/*
	For changing of account details
*/
session_start();
include "gafflib.php";
include "top.html";

if (isset($_SESSION['uid'])) { //if logged in
	/*
		Variables
	*/
	$id = $_SESSION['uid'];
	$newusername = $_POST['newusername'];
	$newpassword = $_POST['newpassword'];
	$newemail = $_POST['newemail'];
	$query = "UPDATE users SET "; //beginning of sql statement
	$okay = 1; //okay to change details
	$commas = 0; //for inserting commas into sql statement
	$errors = ""; //string to contain errors
	
	if($newusername != ""){ //if username isnt blank check for clashes
		$check_username = mysqli_query($mysqli, "SELECT * FROM users WHERE username='".$newusername."'");
		$results_username = mysqli_num_rows($check_username);
		if ($results_username != 0) //if clash
		{
			$errors .= "Username already taken<br>";
			$okay = 0;
		}
		else  //add to query
		{
			$query .= "username='".$newusername."'";
			$commas = 1;
		}
	}
	if($newpassword != "")//if password isnt blank, update password
	{ 
		if ($commas == 1){ //if previous value in sql statement
			$query .= ", password='".$newpassword."'"; //add query with comma
		}
		else{
			$query .= "password='".$newpassword."'"; //add regular query
			$commas = 1;
		}
	}
	if($newemail != "") //if email isnt blank check for clashes
	{
		$check_email = mysqli_query($mysqli, "SELECT * FROM users WHERE email='".$newemail."'");
		$results_email = mysqli_num_rows($check_email);
		if ($results_email != 0) //if clash
		{
			$errors .= "Email already taken<br>";
			$okay = 0;
		}
		else
		{
			if ($commas == 1){ //if previous value in sql statement
				$query .= ", email='".$newemail."'";//add query with comma
			}
			else{
				$query .= "email='".$newemail."'"; //add regular query
			}
		}
	}
	$query .= " WHERE id='".$id."'"; //finish statement
	/*
		If: no errors
	*/
	if ($okay)
	{
		$results = mysqli_query($mysqli, $query); //update db
		header("location: details.php"); //refresh
	}
	/*
		Else: Show Errors
	*/
	else {
		echo"<head><script src='js/scripts.js'></script></head>";
		errorDisplay("Looks like there were errors! Try again!",$errors,"your details page "); //display errors
		//redirect
		header('refresh:10;url=details.php');
	}
}
else include "access.php"; //display login screen
include "bottom.html";
?>
