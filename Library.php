<?php
/*
	PHP Function Libaray.
	Author:  Michael Neely March-April 2015
	Copyright Michael Neely 2015 All Rights Reserved
	This software is the proprietary property of Michael Neely
	You may not distribute or disclose the source code, or use this documentation to reengineer the library.
	
	List of functions:
		-Make Thumbnails
		-Image Upload
		-Page Creation
		-Error Message
		-Success Message
		-Print Tiles
		-String Chopper
		-Contact Poster
*/


//
	//global SQL database connection variable
	$mysqli = mysqli_connect("x", "x", "x", "x");
//


//
	//Make 600px x 400px thumbnails and store to thumbs/...
	function makeThumbnails($img, $id)
	{
		$thumbnail_width = 600;
		$thumbnail_height = 400;
		$thumb_beforeword = "thumbs/"; //path for thumbnails
		$arr_image_details = getimagesize($img);// pass id to thumb name
		$original_width = $arr_image_details[0];
		$original_height = $arr_image_details[1];
		if ($original_width > $original_height) {
			$new_width = $thumbnail_width;
			$new_height = intval($original_height * $new_width / $original_width);
		} else {
			$new_height = $thumbnail_height;
			$new_width = intval($original_width * $new_height / $original_height);
		}
		$dest_x = intval(($thumbnail_width - $new_width) / 2);
		$dest_y = intval(($thumbnail_height - $new_height) / 2);
		if ($arr_image_details[2] == 1) {
			$imgt = "ImageGIF";
			$imgcreatefrom = "ImageCreateFromGIF";
		}
		if ($arr_image_details[2] == 2) {
			$imgt = "ImageJPEG";
			$imgcreatefrom = "ImageCreateFromJPEG";
		}
		if ($arr_image_details[2] == 3) {
			$imgt = "ImagePNG";
			$imgcreatefrom = "ImageCreateFromPNG";
		}
		if ($imgt) {
			$old_image = $imgcreatefrom($img);
			$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
			imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
			$imgt($new_image,"$thumb_beforeword" . "$id");
		}
	}
//

//
	//Upload Image to Server. (path: images/..)
	function imageUpload($target,$tmp,$size)
	{
		$upload_ok = 1; //bool for upload of image
		$errors = ""; //list of errors
		$imageFileType = pathinfo($target,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($tmp);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
			} else {
				$errors .= "-File is not an image.<br>";
				$upload_ok = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target)) {
			$errors .= "-Sorry, file already exists.<br>";
			$upload_ok = 0;
		}
		// Check file size (max: 500kb)
		if ($size > 1000000) {
			$errors .= "-Sorry, your file is too large.<br>";
			$upload_ok = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$errors .= "-Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
			$upload_ok = 0;
		}
		if ($upload_ok && move_uploaded_file($tmp, $target)) { //if successfully uploaded
			return 1; //successful termination
		}
		else { //if error
			$errors .= "-Sorry, there was an error uploading your file.<br>";
			echo "
			<head>
				<script src='js/scripts.js'></script>
			</head>
			<div class='address-bar' style='color: black;'>
					<br>
					<hr>
					<i class='glyphicon glyphicon-warning-sign'></i>
					<br>
					Looks like an error occurred:
					<br>
					<br>
					$errors
					<br>
					<br>
					Redirecting to your profile page in <span id='countdown'>10</span>
					<br>
					<hr>
					<br>
				</div>";
		header('refresh:10;url=profile.php'); //redirect to profile
			return 0; //unsuccessful termination
		}
	}
//

//
	//Create .shtml page for a post and store path in SQL db
function createPostPage($postdata,$path,$user)
{
	/*
		Variables
	*/
	$mysqli = mysqli_connect("x", "x", "x", "x");
	$posts_path = "posts/";
	$title = $postdata['post_title'];
	$description = $postdata['post_description'];
	$img = $postdata['imagepath'];
	$bedrooms = $postdata['bedrooms'];
	$bathrooms = $postdata['bathrooms'];
	$furnished = $postdata['furnished'];
	$leaselength = $postdata['leaselength'];
	$keywords = $postdata['keywords'];
	$location = $postdata['location'];
	$type = $postdata['type'];
	$price = $postdata['price'];
	$walkingdistance = $postdata['walkingdistance'];
	$query = mysqli_query($mysqli, "SELECT * from posts where title='".$title."'");
	$get_title = mysqli_fetch_assoc($query)["id"];
	$html_file_name = $get_title.".shtml";
	$file_path = $posts_path.$html_file_name;
	$fp = fopen($posts_path.$html_file_name, "w+");
	if ($furnished == 1) $isfurnished = "yes";
	if ($furnished == 0) $isfurnished = "no";
	
	/*
		Page Content
	*/
	$inserted_text = '
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="">
			<meta name="author" content="">
			
			<link rel="icon" type="image/ico" href="../images/myicon.ico">
			<!-- Bootstrap Core CSS -->
			<link href="../css/bootstrap.min.css" rel="stylesheet">
			<!-- Custom CSS -->
			<link href="../css/business-casual.css" rel="stylesheet">
			<!-- Fonts -->
			<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
			<link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

			<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
			<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
			<title>'.$title.'</title>
			<script src="../js/scripts.js"></script>
		</head>

		<body style="background-color: #66ccff;">
		
			<!-- Top -->
			
			<div class="navbar-collapse collapse">
			  <ul class="nav navbar-nav navbar-right">
				
				<li class="dropdown">
				  <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
					<i class="glyphicon glyphicon-home"></i> My Gaffs <span class="caret"></span></a>
				  <ul id="g-account-menu" class="dropdown-menu" role="menu">
					<li><a href="profile.php"><i class="glyphicon glyphicon-bookmark"></i> My Profile</a></li>
					<li><a href="logout_parse.php"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
				  </ul>
				</li>
			  </ul>
			</div>
			<div class="brand">GAFFS</div>
			<div class="address-bar">NUIG Accomodation Finder for Students</div>
			
			<!-- Navigation -->
			
			<nav class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li>
								<a href="../index.shtml">Home</a>
							</li>
							<li>
								<a href="../featured.php">Featured</a>
							</li>
							<li>
								<a href="../search.shtml">Search</a>
							</li>
							<li>
								<a href="../profile.php">My Profile</a>
							</li>
							<li>
								<a href="../contact.php">Contact</a>
							</li>
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</div>
				<!-- /.container -->
			</nav>

			<div class="container">

				<!-- Main Page -->
				<div class="row">
					<div class="box">
					
						<!-- Title -->
						
						<div class="row">
							<div class="col-lg-12 text-center">
								<h1 class="page-header"> '.$title.' </h1>
							</div>
						</div>
						
						<!-- Image -->
						
						<div class="col-lg-12 portfolio-item text-center">
							<img class="img-responsive" style="margin: 0 auto;" src='.$img.' alt="">
						</div>
						<div class="clearfix"></div>
						
						
						<!-- Details -->
						<br>
						<br>
						<hr>
						<div class="row text-center">
							<h3> Details </h3>
						</div>
						<hr>
						<div class="col-lg-12">
						
							<!-- Table -->
							
							<table class="table table-striped table-bordered table-hover">
								<tbody>
									<tr>
										<td>Location</td>
										<td>'.$location.'</td>
									</tr>
									<tr>
										<td>Type</td>
										<td>'.$type.'</td>
									</tr>
									<tr>
										<td>Walking Distance From College</td>
										<td>'.$walkingdistance.' minutes</td>
									</tr>
									<tr>
										<td>Price</td>
										<td>€'.$price.'/month</td>
									</tr>
									<tr>
										<td>Number of Bedrooms</td>
										<td>'.$bedrooms.' bedrooms</td>
									</tr>
									<tr>
										<td>Number of Bathrooms</td>
										<td>'.$bathrooms.' bathrooms</td>
									</tr>
									<tr>
										<td>Lease Length</td>
										<td>'.$leaselength.' months</td>
									</tr>
									<tr>
										<td>Furnished</td>
										<td>'.$isfurnished.'</td>
									</tr>
									<tr>
										<td>Keywords</td>
										<td>'.$keywords.'</td>
									</tr>
									<tr>
										<td>Description</td>
										<td>'.$description.'</td>
									</tr>
								</tbody>
							</table>
						<br>
						<br>
						<br>
							<div class="row text-center">
							<h3> Contact Poster </h3>
							</div>
						<hr>
						<br>
						
						<!-- Form -->
							<form class="form-horizontal text-center" action="../contact_poster.php" method="post" name="contactposter" id="contactposter" onSubmit="return validate_contact_poster()">
								<fieldset>
									<input type="hidden" value="'.$user.'" id="id" name="id"/>
									<div class="form-group">
										<label class="col-md-4 control-label" for="senderemail">Your Email</label>
										<div class="col-md-4">
											<input id="senderemail" name="senderemail" type="text" placeholder="insert email here..." class="form-control input-md" required="">
					
										</div>
									</div>
									<div class="form-group">
									  <label class="col-md-4 control-label" for="category">Your Interest</label>
									  <div class="col-md-4">
										<select id="category" name="category" class="form-control">
										  <option value="Question">Question</option>
										  <option value="Rent">Rent</option>
										</select>
									  </div>
									</div>
									<div class="form-group">
									  <label class="col-md-4 control-label" for="message">Your Message</label>
									  <div class="col-md-4">
										<textarea class="form-control" id="message" name="message"></textarea>
									  </div>
									</div>
									<div class="form-group">
									  <label class="col-md-4 control-label" for="submit"></label>
									  <div class="col-md-4">
										<button id="submit" name="submit" class="btn btn-primary">Send Message</button>
									  </div>
									</div>
								</fieldset>
							</form>
						</div> <! -- /col-lg-12 -->
					</div> <! -- /box -->
				</div> <!-- /row -->
			</div> <!-- /container -->
			<footer>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<p>Copyright &copy; NUIG Accomodation Finder for Students  2015</p>
						</div>
					</div>
				</div>
			</footer>
			<!-- jQuery -->
			<script src="../js/jquery.js"></script>
			<!-- Bootstrap Core JavaScript -->
			<script src="../js/bootstrap.min.js"></script>
		</body>
		</html>
	'; //end inserted text
	fwrite($fp, $inserted_text);  //write out
	fclose($fp);
	/*
		update db
	*/
	$mysqli = mysqli_connect("danu6.it.nuigalway.ie", "mydb1623nm", "my9gon", "mydb1623");
	$insert_image_path = mysqli_query($mysqli, "UPDATE posts SET path='".$file_path."' WHERE imagepath='".$path."'");
	mysqli_close($mysqli);
}
//

	//success message display
function successDisplay($title, $main, $redirect)
{
	echo "
		<div class='address-bar' style='color: black;'>
			<br>
			<hr>
			<i class='glyphicon glyphicon-heart'></i>
			<br>
			".$title."
			<br>
			<br>
			".$main."
			<br>
			<br>
			Redirecting to ".$redirect." in <span id='countdown'>10</span>
			<br>
			<hr>
			<br>
		</div>
	";
}
	//

//
	//error message display
function errorDisplay($title, $main, $redirect)
{
	echo"
		<div class='address-bar' style='color: black;'>
				<br>
				<hr>
				<i class='glyphicon glyphicon-warning-sign	'></i>
				<br>
				".$title."
				<br>
				<br>
				".$main."
				<br>
				<br>
				Redirecting to ".$redirect." in <span id='countdown'>10</span>
				<br>
				<hr>
				<br>
		</div>
	";
}
//

	//print out tiles of posts that include:
		//-title
		//-price
		//-number of bedrooms
		//-hyperlinks to posts' main page
	//
function printTiles($results)
{
	echo "<div class='row text-left'>";
	$count = 0; //for printing in rows of 3
	while ($row = mysqli_fetch_assoc($results)){ //while there are posts
		$temp_title = $row["title"];
		$temp_thumb_path = $row["thumbpath"];
		$temp_rooms = $row["bedrooms"];
		$temp_price = $row["price"];
		$temp_path = $row["path"];
		echo '
			<div class="col-md-4 portfolio-item">
				<a href="'.$temp_path.'">
					<img class="img-responsive" src="'.$temp_thumb_path.'"">
				</a>
				<h3>
					<a href="'.$temp_path.'"">'.$temp_title.'</a>
				</h3>
				<p>Price: '.$temp_price.' euro/month<br></br>Bedrooms: '.$temp_rooms.'</p>
			</div>
		'; //print a post with title, rooms, price, thumbnail. hyperlink to posts' main page
		$count = $count + 1;
		if ($count == 3){ //if row of 3 go to next row
			echo '</div><div class="row text-left">';
			$count = 0;
		}
	}
	echo '</div></div>'; //close posts box
}

function stringChopper($string)
{
	$pieces = preg_split("/[\s,]+/", $string);
	return $pieces;
}
	
function contactPoster($id,$details)
{
	$mysqli = mysqli_connect("x","x","x","x");
	$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id='".$id."'");
	$row = mysqli_fetch_assoc($result);
	$to = $row["email"];
	$subject = "Query from GAFFS user";
	$message = $details;
	mail($to,$subject,$message);
}
?>
