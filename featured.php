<?php 
/*
	For displaying featured posts
*/
session_start();?>
<head>
	<title>Featured</title>
	<link href="css/3-col-portfolio.css" rel="stylesheet">
</head>
<?php
include "top.html";
include "gafflib.php";
?>
<div class="row">
	<div class="col-lg-12 text-center">
		<h1 class="page-header">Featured Properties</h1>
	</div>
</div>
<?php
	$results  = mysqli_query($mysqli, "SELECT * FROM posts WHERE featured='1'"); //get featured posts
	printTiles($results); //print out results
include "bottom.html";
?>
