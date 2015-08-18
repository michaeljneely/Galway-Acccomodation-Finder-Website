<head>
	<title>Search Results</title>
	<link href="css/3-col-portfolio.css" rel="stylesheet">
</head>
<?php
	/*
		Returns Results of Main Search Form
	*/
	include "gafflib.php";
	include "top.html";
	/*
		Data
	*/
	$walking_distance = $_POST["walkdistance"];
	$max_price = $_POST["price"];
	$lease_length = $_POST["lengthlease"];
	$min_bedrooms = $_POST["bedroom_min"];
	$max_bedrooms = $_POST["bedroom_max"];
	$min_bathrooms = $_POST["bathroom_min"];
	$max_bathrooms = $_POST["bathroom_max"];
	$furnished = $_POST["furnished"];
	$type = $_POST["type"];
	$keywords = $_POST["keywords"];
	$orderby = $_POST["orderby"];
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
			-Need to check what to sort by
	*/
	//Check Walking Distance
		if ($walking_distance != 0)
		{
			if($walking_distance <= 20) $query .= "(walkingdistance BETWEEN 0 AND '".$walking_distance."')";
			else if ($walking_distance > 20) $query .= "(walkingdistance >= 20)";
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
	//Check Lease Length
		if ($lease_length != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			if($lease_length <= 12) $query .= "(lease_length BETWEEN 0 AND '".$lease_length."')";
			else if ($lease_length > 12) $query .= "(lease_length >= 12)";
			$space_needed = 1;
		}
	//Check Bedrooms
		if ($min_bedrooms != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			if ($max_bedrooms == 0) $query .= "(bedrooms >= '".$min_bedrooms."')";
			else
			{
				if ($min_bedrooms == $max_bedrooms) $query .= "(bedrooms = '".$min_bedrooms."')";
				else $query .= "(bedrooms between '".$min_bedrooms."' AND '".$max_bedrooms."')";
			}
			$space_needed = 1;
		}
	//Check Bathrooms
		if ($min_bathrooms != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			if ($max_bathrooms == 0) $query .= "(bathrooms >= '".$min_bathrooms."')";
			else
			{
				if ($min_bathrooms == $max_bathrooms) $query .= "(bathrooms = '".$min_bathrooms."')";
				else $query .= "(bathrooms between '".$min_bathrooms."' AND '".$max_bathrooms."')";
			}
			$space_needed = 1;
		}
	//Check Furnished
		if (strcmp($furnished,"0") != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			$query .= "(furnished = '".$furnished."')";
			$space_needed = 1;
			
		}
	//Check Type
		if (strcmp($type,"0") != 0)
		{
			if($space_needed == 1) $query .= " AND ";
			$query .= "(type='".$type."')";
			$space_needed = 1;
		}
	//Check Keywords
		//get individual words
		$split_keywords = stringChopper($keywords);
		$length = count($split_keywords);
		if ($length != 0)
		{
			if ($space_needed == 1) $query .= " AND ";
			//add first keyword
			$query .= "(keywords LIKE '%".$split_keywords[0]."%')";
			//if more words
			if ($length > 1)
			{
				//loop through rest
				for ($i=1;$i<($length);$i++)
				{
					//skip if NULL
					if (!strcmp($split_keywords[$i],NULL)) continue;
					//add next keyword
					$query .= " AND (keywords LIKE '%".$split_keywords[$i]."%')";
				}
			}
			$space_needed = 1;
		}
	//If at very end, nothing selected
		if ($space_needed == 0)
		{
			$query = "SELECT * FROM posts";
		}
	//If Order required
		if ((strcmp($orderby, "0")) != 0)
		{
			$query .= " ORDER BY ".$orderby." ASC";
		}
	/*
		Finished Query and Results
	*/
	$results = mysqli_query($mysqli, $query);
	/*
		If no results, print error message
	*/
	if (!$results || mysqli_num_rows($results) == 0)
	{
		echo'<head><script src="js/scripts.js"></script></head>';
		errorDisplay("No posts with those parameters found","Try again!","the search page");
		header('refresh:10;url=search.shtml');
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
