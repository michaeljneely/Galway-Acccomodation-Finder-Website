<head>
	<title>Quick Search Results</title>
	<link href="css/3-col-portfolio.css" rel="stylesheet">
</head>
<?php
	/*
		Returns Results of Quick Search Form
	*/
	include "gafflib.php";
	include "top.html";
	/*
		Data
	*/
	$bedrooms = $_POST["bedrooms"];
	$max_price = $_POST["max_price"];
	$walking_distance = $_POST["walkingdistance"];
	/*
		Beginning of Query
	*/
	$query = "SELECT * FROM posts WHERE ";
	//if a space is needed in query construction
	$space_needed = 0;	
	/*
		Building the Query
			-Need checks for defaults (value = 0)
				-if default, ignore field (don't add to query)
			-Need checks for spaces
	*/
	//Check Bedrooms
		if ($bedrooms != 0)
		{
			if ($bedrooms <= 4) $query .= "(bedrooms = '".$bedrooms."')";
			if ($bedrooms > 4) $query .= "(bedrooms >= 5)";
			$space_needed = 1;
		}
	//Check Price
		if ($max_price != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			if($max_price <= 1500) $query .= "(price BETWEEN 0 AND '".$max_price."')";
			else if ($max_price > 1500) $query .= "(price >= 1500)";
			$space_needed = 1;
		}
	//Check Walking Distance
		if ($walking_distance != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			if($walking_distance <= 20) $query .= "(walkingdistance BETWEEN 0 AND '".$walking_distance."')";
			else if ($walking_distance > 20) $query .= "(walkingdistance >= 20)";
			$space_needed = 1;
		}
	//If at very end, nothing selected
		if ($space_needed == 0)
		{
			$query = "SELECT * FROM posts";
		}
	$results = mysqli_query($mysqli, $query);
	/*
		If no results, print error message
	*/
	if (!$results || mysqli_num_rows($results) == 0)
	{
		echo'<head><script src="js/scripts.js"></script></head>';
		errorDisplay("No posts with those parameters found","Try again!","the home page");
		header('refresh:10;url=index.shtml');
	}
	/*
		Otherwise, display results
	*/
	else
	{
		printTiles($results);
	}
	include "bottom.html";
?>
