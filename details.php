<?php 
/*
	For changing account details
*/
session_start();?>
<head>
<title>My Profile</title>
</head>
<?php
include "gafflib.php";
include "top.html";
if (isset($_SESSION['uid'])) { //if logged in
	$results = mysqli_query($mysqli, "SELECT * from users where id='".$_SESSION['uid']."'"); //get user from db
	$row = mysqli_fetch_assoc($results);
	$username = $row['username'];
	$password = $row['password'];
	$email = $row['email'];
	/*
		Display
	*/
	include "profile_wrapper.php";
	echo '
		<h3><i class="glyphicon glyphicon-user"></i> My Details: </h3> 
		<table class="table text-left">
			<tbody>
			<tr>
				<td><p><u>Username:</u></p></td>
				<td><p>'.$username.'</p></td>
			</tr>
			<tr>
				<td><p><u>Password:</u></p></td>
				<td><p>'.$password.'</p></td>
			</tr>
			<tr>
				<td><p><u>Email Address:</u></p></td>
				<td><p>'.$email.'</p></td>
			</tr>
			</tbody>
		</table>
		<hr>
		<h3><i class="glyphicon glyphicon-pencil"></i> Change Details: </h3>
		<form class="form-horizontal" id="changedetails" name="changedetails" action="change_details.php" method="post">
			<fieldset>
				<div class="form-group">
					<label class="col-md-4 control-label" for="newusername"><p>New Username</p></label>  
					<div class="col-md-4">
						<input id="newusername" name="newusername" type="text" placeholder="new username here..." class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="newpassword"><p>New Password</p></label>  
					<div class="col-md-4">
						<input id="newpassword" name="newpassword" type="text" placeholder="new password here..." class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="newemail"><p>New Email</p></label>  
					<div class="col-md-4">
						<input id="newemail" name="newemail" type="text" placeholder="new email here.." class="form-control input-md"> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="changedetails"></label>
					<div class="col-md-4">
						<button id="changedetails" name="changedetails" class="btn btn-primary">Change Details</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	';}
else include "access.php"; //display login screen
include "bottom.html";
?>
