<?php
/*
	Forms that control:
		-Login
		-Registration
		-Confirmation
*/
echo'
<form class="form-horizontal" action="login_parse.php" method="post">
	<fieldset>
	<legend>Please Log in to Access the Site</legend>
	<div class="form-group">
		<label class="col-md-4 control-label" for="username">Username</label>  
		<div class="col-md-4">
		<input id="username" name="username" type="text" placeholder="" class="form-control input-md" required="">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="passwordinput">Password</label>
		<div class="col-md-4">
		<input id="password" name="password" type="password" placeholder="" class="form-control input-md" required="">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="login"></label>
		<div class="col-md-4">
		<input type="submit" id="login" name="login" class="btn btn-primary" value="Login" />
		</div>
	</div>
	</fieldset>
	<p style="text-align: center;">Don\'t have a login?	<i class="glyphicon glyphicon-question-sign"></i></p>
</form>
<form class="form-horizontal" action="reg_parse.php" method="post">
	<fieldset>
	<legend>Register Here</legend>
	<div class="form-group">
		<label class="col-md-4 control-label" for="username"> Desired Username</label>  
		<div class="col-md-4">
		<input id="regusername" name="regusername" type="text" placeholder="" class="form-control input-md" required="">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="passwordinput">Desired Password</label>
		<div class="col-md-4">
		<input id="regpassword" name="regpassword" type="password" placeholder="" class="form-control input-md" required="">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="email">Email Address</label>  
		<div class="col-md-4">
		<input id="regemail" name="regemail" type="text" placeholder="" class="form-control input-md" required="">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="register"></label>
		<div class="col-md-4">
		<input type="submit" id="register" name="register" class="btn btn-primary" value="Register" />
		</div>
	</div>
	</fieldset>
	<p style="text-align: center;">An email with a confirmation code will be sent to you <i class="glyphicon glyphicon-send"></i></p>
</form>
<form class="form-horizontal" action="confirmation_parse.php" method="post">
	<fieldset>
	<legend>Have a Confirmation Code?</legend>
	<div class="form-group">
		<label class="col-md-4 control-label" for="username"> Confirmation Code</label>  
		<div class="col-md-4">
		<input id="code" name="code" type="text" placeholder="" class="form-control input-md" required="">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="confirm"></label>
		<div class="col-md-4">
		<input type="submit" id="confirm" name="confirm" class="btn btn-primary" value="Enter" />
		</div>
	</div>
	</fieldset>
	<p style="text-align: center;">Welcome to GAFFS!	<i class="glyphicon glyphicon-heart"></i></p>
</form>';
?>
