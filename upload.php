<?php 
/*
	Form that allows users to upload posts
*/
session_start(); ?>
<head>
<title>Upload a Post</title>
</head>
<?php
	include "top.html";
	if (isset($_SESSION['uid'])){ //if logged in show form
		include "profile_wrapper.php";
		echo '
			<h3><i class="glyphicon glyphicon-cloud"></i> Upload: </h3> 
			<hr>
			<form class="form-horizontal" action="upload_parse.php" method="post" enctype="multipart/form-data">
				<fieldset>
					<div class="form-group">
						<label class="col-md-4 control-label" for="title">Title</label>  
						<div class="col-md-4">
							<input id="title" name="title" type="text" placeholder="insert title here..." class="form-control input-md" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="location">Location</label>  
							<div class="col-md-4">
								<input id="location" name="location" type="text" placeholder="insert location here" class="form-control input-md" required="">
							</div>
					</div>
					<div class="form-group">
					  <label class="col-md-4 control-label" for="type">Type</label>
					  <div class="col-md-4">
						<select id="type" name="type" class="form-control">
						  <option value="apartment">apartment</option>
						  <option value="house">house</option>
						  <option value="studio">studio</option>
						  <option value="digs">digs</option>
						</select>
					  </div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="price">Price per Month</label>  
						<div class="col-md-4">
							<input id="price" name="price" type="number" min="0" max="9999" step="1" placeholder="insert price here" class="form-control input-md" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="leaselength">Length of Lease (months) </label>  
						<div class="col-md-4">
							<input id="leaselength" name="leaselength" type="number" min="0" max="99" step="1" placeholder="insert length here" class="form-control input-md" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="bedrooms">Number of Bedrooms</label>  
						<div class="col-md-4">
							<input id="bedrooms" name="bedrooms" type="number" min="0" max="9" step="1" placeholder="insert number here" class="form-control input-md" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="bathrooms">Number of Bathrooms</label>  
						<div class="col-md-4">
							<input id="bathrooms" name="bathrooms" type="number" min="0" max="9" step="1" placeholder="insert number here" class="form-control input-md" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="walkdistance">Walking Distance from College (minutes)</label>  
						<div class="col-md-4">
							<input id="walkdistance" name="walkdistance" type="number" min="0" max="99" step="5" placeholder="insert minutes here" class="form-control input-md" required=""> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="furnished">Furnished?</label>
							<div class="col-md-4"> 
								<label class="radio-inline" for="furnished-0">
									<input type="radio" name="furnished" id="furnished-0" value="no">
									no
								</label> 
								<label class="radio-inline" for="furnished-1">
									<input type="radio" name="furnished" id="furnished-1" value="yes">
									yes
								</label>
							</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="imageupload">Upload Image</label>
						<div class="col-md-4">
							<input id="imageupload" name="imageupload" class="input-file" type="file" required="">
							<span class="help-block">thumbnail will be 600 x 400<br>Max file size is 500kb</span>  
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="keywords">Keywords</label>
						<div class="col-md-4">                     
							<textarea class="form-control" id="keywords" name="keywords" placeholder="words like \'wifi\' and \'television\'"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="description">Description</label>
						<div class="col-md-4">                     
							<textarea class="form-control" id="description" name="description" placeholder="write your description here..."></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="upload"></label>
						<div class="col-md-4">
							<input id="upload" name="upload" class="btn btn-primary" type="submit" value="Upload Post" />
						</div>
					</div>
				</fieldset>
			</form>
		</div>';
	}
	else include "access.php"; //show login screen
	include "bottom.html";
?>




