<body background="b2.jpg">
<div class="title"><h2>Open Video</h2></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<style>
	.title {
		position: absolute;
		left: 20%;
	}
	
    h2 {
        font-family: "Adobe Hebrew";
        color: darkred;
    }

	.searchBar {
		position: fixed;
		top: 10%;
	}
	
	.reset {
		position: fixed;
		top: 19%;
	}
	
	.suggestions {
		position: fixed;
		top: 25%;
		height: 320px;
		width: 200px;
		border-style: solid;
        border-color: black;
        padding: 5px;
        border-width: 2px;
	}
	
    .results {
        position: absolute;
        left: 20%;
        top: 10%;
        right: 27%;
        background-color: white;
        border-style: solid;
        border-color: black;
        padding: 10px;
        border-width: 3px;
    }
    
    .metadata {
    	position: fixed;
    	left: 75%;
    	top: 10%;
    	right: 10%;
    	height: 280px;
    	width: 230px;
    	border-style: solid;
        border-color: black;
        padding: 10px;
        border-width: 3px;
    }
    
</style>

<!-- create search box and button -->
<form class="searchBar" action="" method="get">
	<b>>Search here: </b>
	<br>
	<input class="t1" type="text" name="search" id="search" />
	<br>
	<input type="submit" value="Search" />
	<br>
</form> 

<!-- make the reset button -->
<form class="reset" action="results.php"><input type="submit" value="Back to the full list"></form>

<!-- create the suggestion section -->
<div class="suggestions">
    <p><b>Suggestions:</b></p>
    <div class="suggested_words">
    <script>
    	$(document).ready(function(){
    		// when typing the search words, get the suggestions
    		$(".t1").keyup(function(){
				s = document.getElementById("search").value,
				console.log(s),
    			$.post("keywords_suggestions.php",
    			{
    				// get the value from the search bar and pass it to the key_sug php
    				search: $(this).val()
    			},
    			// print out the data of suggestions
    			function(data, status) {
					$(".suggested_words").html(data);
				});
    		});
    	});
    </script>
    </div>
</div>

<!-- create the result-showing section -->
<div class="results">
<table border="0">
<tbody>

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
	$search = $_GET['search'];
	
	// format the input 
	$search = addslashes($search);
	
	echo "<b>Showing results for: " . $search . "</b><br>";
	echo "<br>";
	
	// do the query depending on whether there is search term or not
	if (isset($_GET['search'])) {
		$query = "SELECT * FROM p2records WHERE MATCH (title, description, keywords) AGAINST ('" . $search . "')";
	} else {
		$query = "SELECT * FROM p2records";
	}
	
    // do the query and print out the table
    $result = mysqli_query($db, $query);
    	while ($row = mysqli_fetch_array($result)){
	    	// print out the formatted table    	
	    	// $url = 'http://www.open-video.org/details.php?videoid=' . $row['videoid'];
// 	    	echo $url;
	    	echo "<tr class='result' videoid=".$row['videoid'].">";
	    	echo "<td><a href='http://www.open-video.org/details.php?videoid=" . $row['videoid'] . "'>" . "<img src=" . "http://www.open-video.org/surrogates/keyframes/" . $row['videoid'] . "/" . $row['keyframeurl'] . "></td>";
	    	echo "<td><b><a href='http://www.open-video.org/details.php?videoid=" . $row['videoid'] . "'>" . $row['title'] . "(" . $row['creationyear'] . ")</a></b><br>"; 
	    	echo substr($row['description'], 0, 200) . "<br></td>";
	    	echo "</tr>";
		}

    // close the db
    mysql_close($db);
?> 
</tbody>
</table>
</div>

<!-- create the details-showing section -->
<div class="metadata">
<h4>Mouse over the results to see more description</h4>
<script>
	$(document).ready(function(){
		// when mouse over the results, show the metadata
		$(".result").mouseenter(function() {
			$.post("results_detail.php", 
			{
				// get the videoid of current result
				videoid: $(this).attr('videoid')
			}, 
			// print out the metadata
			function(data, status) {
				$(".metadata").html(data);
			});
		});
		
		// when mouse out, remove the metadata
		$(".result").mouseout(function() {
			$(".metadata").html("<b>Mouse over the results to see more description</b>");
		});
	});
</script>
</div>
</body>

