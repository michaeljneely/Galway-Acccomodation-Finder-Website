<?php
	/*
		For parsing the 'contact poster' form on each post page
			-Sends message to poster
			-Send copy of message to sender
	*/
	include "gafflib.php";
	$uid = $_POST["id"];
	$from = $_POST["senderemail"];
	$msg = $_POST["message"];
	$category = $_POST["category"];
	$results = mysqli_query($mysqli, "SELECT * from users where id='".$uid."'");
	$row = mysqli_fetch_assoc($results);
	$to = $row['email'];
	$subject = "Someone is Interested in Your Gaffs Post";
	$content = "A Gaffs user has sent you a message. \r\nInterest: ".$category."\r\nMessage: ".$msg."\r\nFrom: ".$from."\r\nThank you, \r\nTeam Gaffs ";
	mail($to, $subject, $content);
	$user_subject = "A Copy of Your Message to a Gaffs Poster";
	mail($from,$user_subject,$content);
	include "top.html";
	echo'<head><script src="js/scripts.js"></script></head>';
	successDisplay("thank you for your interest","a copy of your message has been sent to your email"," the home page ");
	//redirect
	header("refresh:10;url=index.shtml");
	include "bottom.html";
?>
