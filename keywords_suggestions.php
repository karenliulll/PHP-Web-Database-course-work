<?php
	// login to the db
    $h = 'pearl.ils.unc.edu';
    $u = 'webdb_lct';
    $p = 'jZT7Wtqj8';
    $dbname = 'webdb_lct';
    $db = mysqli_connect($h,$u,$p,$dbname);
    
    // error message
    if (mysqli_connect_errno()) {
		echo "Problem connecting: " . mysqli_connect_error();
		exit();
    }
    
    // get the value from search form
	$search = $_REQUEST['search'];
	
	// do the query to match the keywords starting with the search term
	if ($search == "") {
		$query = null;
	} else {	
    	$query = "SELECT * FROM keywords WHERE words LIKE '" . $search . "%' LIMIT 10";
    }
    // print out the right keywords
    $result = mysqli_query($db, $query);
    	while ($row = mysqli_fetch_array($result)){
    	echo $row['words'];
    	echo "<br>";
    	}
    
    // close the db
    mysql_close($db);
    
?>