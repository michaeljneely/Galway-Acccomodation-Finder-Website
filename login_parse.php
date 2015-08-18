<?php
	/*
		For processing user login
	*/

session_start();
include "gafflib.php";
include "top.html";

if (isset($_POST['username'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$results = mysqli_query($mysqli,"SELECT * FROM users WHERE username='".$username."' AND password='".$password."' LIMIT 1");
	$row = mysqli_fetch_assoc($results);
	if ($results && mysqli_num_rows($results) == 1 && $row['entry'] == 1) //if correct info and allowed entry
	{
		//set session
		$_SESSION['uid'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		//to profile page
		header("location: profile.php");
	}
	else { //display error
		echo'<head><script src="js/scripts.js"></script></head>';
		errorDisplay("Error!","Invalid login information"," the home page ");
		//redirect
		header('refresh:10;url=index.shtml');
	}
	include "bottom.html";
}
?>
