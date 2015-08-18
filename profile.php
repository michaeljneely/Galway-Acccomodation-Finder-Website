<?php 
/*
	For displaying account home page
*/
session_start();?>
<head>
	<title>My Profile</title>
	<link href="css/3-col-portfolio.css" rel="stylesheet">
</head>
<?php
include "top.html";
include "gafflib.php";
if (isset($_SESSION['uid'])) { //if logged in
	$id = $_SESSION['uid']; ///get id
	$results=mysqli_query($mysqli, "SELECT * from posts WHERE owner='".$id."'"); //find posts by owner
	include "profile_wrapper.php"; //include side bar
	echo'
		<h3><i class="glyphicon glyphicon-th-large"></i> My Posts</h3><hr>
	';
	printTiles($results); //print out results
}
else include "access.php"; //show login screen
include "bottom.html";
?>
