<?php session_start(); ?>
<html>
<head>
	<title>Contact Us</title>
	<script src="scripts.js"></script>
</head>
<body>
<?php
	include("gafflib.php");
	if (isset($_SESSION['uid'])){
		$results = mysqli_query($mysqli, "SELECT * from users WHERE id='".$_SESSION['uid']."'");
		$row = mysqli_fetch_assoc($results);
		$user_email = $row['email'];
		$username = $row['username'];
		echo("
			<form id='contact_gaffs' name='contact_gaffs' method='post' onsubmit='return validate_gaffs()' action='contact_gaffs_parse.php'>
				<input id='username' name='username' type='hidden' value='".$username."' />
				<input id='email' name='email' type='hidden' value='".$user_email."' />
				<label>Title of Query: </label>
					<input id='title' name='title' type='text' maxlength='150' />
					<br><br>
				<label>Category: </label>
					<select name='category' id='category'>
						<option value='default' disabled selected>Select a category</option>
						<option value='password_reset'>Passwod Reset</option>
						<option value='tech_help'>Technical Help</option>
						<option value='bug_report'>Report a Bug</option>
						<option value='misc'>Miscellaneous</option>
					</select>
					<br><br>
				<label>Message: </label>
					<input id='message' name='message' type='text' maxlength='500' size='25' />
					<br><br>
				<input type='reset' value='Reset' onlick='reset_contact()'><br><br>
				<input type='submit' id='submit' name='submit' value='Send Message' />
				
				
		");
	}
	else {
		echo("<p>You must be logged in to use this function</p>");
	}
?>
</body>
</html>
