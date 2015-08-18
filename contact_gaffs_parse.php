<?php
	/*
		Parses 'Contact Gaffs' and:
			-Sends email to Gaffs
			-Send copy to user
	*/
	session_start();
	include "gafflib.php";
	include "top.html";
	if (isset($_SESSION['uid'])) //if logged in
		{
		/*
			Get User information
		*/
		$uid = $_POST['uid'];
		$results = mysqli_query($mysqli, "SELECT * from users where id='".$uid."'");
		$row = mysqli_fetch_assoc($results);
		$from = $row['email'];
		$username = $row['username'];
		/*
			Get posted information
		*/
		$message = $_POST['message'];
		$title = $_POST['title'];
		$category = $_POST['category'];
		
		/*
			Send Mail
		*/
		$subject = "Message from Gaffs User $username";
		$content = "A Gaffs user has sent you a message. \r\ntitle: ".$title."\n\r".$category."\n\rmessage:".$message."\r\nreply: ".$from;
		mail("teamgaffswebservices@gmail.com", $subject, $content);
		$user_subject = "A copy of your message to Gaffs";
		$user_message = "\r\ntitle: ".$title."\r\ncategory: ".$category."\r\nmessage: ".$message."\r\nPlease allow 1-2 business days for a reply. \r\nThank you,\r\nTeam Gaffs ";
		mail($from,$user_subject,$user_message);
		/*
			Display Success
		*/
		echo'<head><script src="js/scripts.js"></script></head>';
		successDisplay("Thanks for the message!","A copy has been sent to your registered email"," your profile page ");
		//redirect
		header('refresh:10;url=profile.php');
		
	}
	else include "access.php"; //display login screen
	include "bottom.html";
?>
