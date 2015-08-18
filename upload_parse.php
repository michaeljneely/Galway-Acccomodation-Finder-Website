<?php 
/*
	For parsing upload form
		-insert entry in db
		-store image
		-create and store thumbnail
		-generate post page
*/

session_start();
include "gafflib.php";
include "top.html";
if (isset($_SESSION['uid'])) { //if logged in

	/*
		Variables
	*/
	$user = $_SESSION['uid'];
	$post_title = $_POST['title'];
	$description = $_POST['description'];
	$location = $_POST['location'];
	$type = $_POST['type'];
	$price = $_POST['price'];
	$leaselength = $_POST['leaselength'];
	$bedrooms = $_POST['bedrooms'];
	$bathrooms = $_POST['bathrooms'];
	$walkingdistance = $_POST['walkdistance'];
	$furnished = $_POST['furnished'];
	$keywords = $_POST['keywords'];
	$target_dir = "images/";
	$target_file = $target_dir . basename($_FILES["imageupload"]["name"]);
	$name = $_FILES["imageupload"]["name"];
	$tmp = $_FILES["imageupload"]["tmp_name"];
	$size = $_FILES["imageupload"]["size"];
	if(imageUpload($target_file,$tmp,$size)) //if image successfully uploaded
	{
			makeThumbnails($target_file, $_FILES["imageupload"]["name"]); //make thumbnail
			$target_thumbfile = "thumbs/".$_FILES["imageupload"]["name"].""; //get thumbnail path
			$insert = mysqli_query($mysqli,"INSERT INTO posts (title, description, imagepath, thumbpath, location, 
			bedrooms, price, owner, type, bathrooms, furnished, lease_length, walkingdistance, keywords)
			VALUES ('".$post_title."','".$description."','".$target_file."','".$target_thumbfile."','".$location."',
			'".$bedrooms."','".$price."','".$user."','".$type."','".$bathrooms."','".$furnished."','".$leaselength."',
			'".$walkingdistance."','".$keywords."')");
			mysqli_close($mysqli); //update and close db
			//variables to pass to function createPostPage
			$data = [
				"post_title" => $post_title,
				"post_description" => $description,
				"bedrooms" => $bedrooms,
				"bathrooms" => $bathrooms,
				"leaselength" => $leaselength,
				"furnished" => $furnished,
				"keywords" => $keywords,
				"location" => $location,
				"type" => $type,
				"price" => $price,
				"walkingdistance" => $walkingdistance,
				"imagepath" => "../$target_file",
			]; 
			createPostPage($data,$target_file,$user); //make page
			//display success
			echo'<script src="js/scripts.js"></script>';
			successDisplay("Your Post Has Been Successfully Uploaded","check it out on your profile!"," your profile page ");
			//redirect
			header('refresh:10;url=profile.php');
	}
//no need for else statement -- imageUpload function provides errors
}
else include "access.php"; //else display login page
include "bottom.html";
?>




