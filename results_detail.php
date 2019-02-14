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
    
    // get the value from results.php
    $videoid = $_POST['videoid'];
    
    // do the query and print out the texts
    $query = "SELECT * FROM p2records where videoid=".$videoid;
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_array($result)){
		echo "<b>". $row['title'] . "</b><br>";
		echo "<br>";
		echo "<b>Genre: </b>" . $row['genre'] ."<br>";
		echo "<b>Keywords: </b>" . $row['keywords'] ."<br>";
		echo "<b>Duration: </b>" . $row['duration'] ."<br>";
		echo "<b>Color: </b>" . $row['color'] ."<br>";
		echo "<b>Sound: </b>" . $row['sound'] ."<br>";
		echo "<b>Sponsor: </b>" . $row['sponsorname'] ."<br>";
	}
	
	// close the db
	mysql_close($db);
	
?>