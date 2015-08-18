<?php 
	/*
		For Contacting Gaffs
	*/
	session_start();?>
<head>
	<title>Contact Gaffs</title>
</head>
<?php 
	include "top.html";
	if (isset($_SESSION['uid'])){ //if logged in
		$user = $_SESSION['uid']; //get user id
		//show form
		echo '
			<head><script src="js/scripts.js"></script></head>
			<form class="form-horizontal" id="contactgaffs" name="contactgaffs" action="contact_gaffs_parse.php" method="post" onSubmit="return validate_gaffs_contact_form()">
				<fieldset>
					<legend>Have a question?</legend>
					<div class="form-group">
						<label class="col-md-4 control-label" for="title">Query Title</label>  
						<div class="col-md-4">
							<input id="title" name="title" type="text" placeholder="enter title here..." class="form-control input-md" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="category">Question Category</label>
						<div class="col-md-4">
							<select id="category" name="category" class="form-control">
								<option disabled selected>Choose a Category </option>
								<option value="reset">Password Reset</option>
								<option value="tech_help">Technical Help</option>
								<option value="bug">Report a Bug</option>
								<option value="misc">Miscellaneous</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="message">Message</label>
						<div class="col-md-4">                     
							<textarea class="form-control" id="message" name="message" placeholder="enter message here..." required=""></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="contact"></label>
						<div class="col-md-4 text-center">
							<input id="contact" name="contact" class="btn btn-primary" value="Contact Us" type="submit" />
						</div>
					</div>
					<input type="hidden" value="'.$user.'" name="uid" id="uid" />
				</fieldset>
			</form>
		';}
	else include "access.php"; //show login screen
include "bottom.html";
?>
