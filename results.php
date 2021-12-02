<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ranger's Watch - Hamilton Archery Centre</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Author: K. Mak, the results page after a search request on the application Ranger's Watch.">
		
		<!-- load specific style for this page, then apply global style (header, footer, button) -->
		<link rel="stylesheet" href="assets/css/global_style.css">
		<link rel="stylesheet" href="assets/css/results.css">
		
		<!-- access icons from Google -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
        <!-- bootstrap plugin
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
		-->
		<link rel="stylesheet"
			href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" 
			integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" 
			crossorigin=""/>
		<script 
			src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
			integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" 
			crossorigin="">
		</script>
			
		<!-- form validation for search.php -->
		<script type="text/javascript" src="assets/js/results.js"></script>
    </head>


    <body onload="initialize()">
		<?php 
			session_start();
			$session_valid = false;
			if (isset($_SESSION['valid'])) {
				if(!empty($_SESSION['valid']) && ($_SESSION['valid']))
					$session_valid = $_SESSION['valid'];
			}
			
			if ($session_valid) {
				include 'include/headersession.inc'; 
			} else
				include 'include/header.inc'; 
			
				
			// checks if form sent valid data
			function isValidEntry($input) {
				return (isset($input) && !empty($input));
			} 
			
			function errorReceived($msg) {
				$_SESSION['status_message'] = $msg;
			}

			// Multiple filters: by Name, by LatLong, by Ratings,
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				// get values from form, and check if they are valid
				$sqlFilters = "";
				// building query string from search_name and search_loc
				if (isValidEntry($_GET['input_search_name'])) {
					$input_name = $_GET['input_search_name'];
					$sqlFilters = " WHERE (`name` LIKE :input_name)";
				}


				if (isValidEntry($_GET['input_search_loc'])) {
					$latlong = explode(",", $_GET['input_search_loc']);
					$latlongpresent = 1;
					$lat = trim($latlong[0]);
					$long = trim($latlong[1]);

					// storing data for js to pull later; this is horrible and we should replace it at some point
					echo "<input type='hidden' id='latlongtoken' value='" . $lat . ", " . $long . "'>";
				}
				
				// separate from the locations table, we will adjust in query later by linking it
				$input_minrating = 0;
				if (isValidEntry($_GET['minrating'])) {
					$input_minrating = $_GET['minrating'];
				}

				// connecting to db

				try {
					require "dbconn.php";
					// SELECT (col1, col2) FROM table WHERE ...
					$tblName = "locations";
					$sql_read = "SELECT * FROM " . $tblName . $sqlFilters . ";";
					$result = $conn->prepare($sql_read);
					if (!empty($input_name))
						$result->bindValue(':input_name', "%{$input_name}%");
					if ($result->execute()) {
						if ($result->rowCount() > 0) {
							$_SESSION['status_message'] = "";
						} else {
							errorReceived("There were no results matching your search settings");
						}
					}
					// setting up query to pull ratings for a location ID; values binded later
					$sql_getratings = "SELECT `location_id`, COUNT(`value`) AS `total`, AVG(`value`) AS `avg` FROM ratings WHERE `location_id`=:location_id;";
					$resultID = $conn->prepare($sql_getratings);
				} catch (PDOException $e) {
					$error = $e->errorInfo[2];
					errorReceived($error);
				}

				// TODO: edit the search query to now watch for latlong
			}
		?>
		
		<div class="main_body">

			<!-- rendering error message to screen -->
			<?php 
				if (isset($_SESSION['status_message'])){
					if (!empty($_SESSION['status_message'])) {
						echo "<div class='container-row'>
								<p class='error_message'> Error: " . $_SESSION['status_message'] . "</p>
								</div>";
						// reset message so when you change screens and come back, msg doesn't appear again
					}
				}
			?>
		
			<!-- title section of main body -->
			<div class="title">
				<h1 id="objTitle">Showing results <?php 
						$searchtext = "";
						if (isValidEntry($_GET['input_search_name'])) $searchtext = $searchtext . " containing '" . $_GET['input_search_name'] . "'";
						if (isValidEntry($_GET['input_search_loc'])) $searchtext = $searchtext . " near '" . $_GET['input_search_loc'] . "'";
						if ($input_minrating > 0) $searchtext = $searchtext . " with minimum rating '" . $input_minrating . "'";
						echo $searchtext;
						?> </h1>
			</div>

			<!-- larger splash scection of page; contains only the map of all locations atm-->
			<div class="objSplash">
				<!-- div for map, then the img -->
				<div class="img_map_container">
					<!-- <img class="img_object" alt="image of google map results of search" src="assets/img/map_results.png"> -->
					<div class="map_object" id="mymap"></div>
				</div>
			</div>
			
			<!-- Next section: -->
			<div class="main_section">
				<!-- table of results-->
				<table class="results_table">
					<thead>
						<tr>
							<th>Center</th>
							<th>Reviews</th>
							<th>Address</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							// interleaving php data
						$dataForJS = "";
						if ($result->rowCount() > 0) {
							while ($row  = $result->fetch()) { 
								$location_name = $row['name'];
								$location_id = $row['id'];

								$val_ratings = 0;
								$num_ratings = 0;
								// reusing query from b4, just passing new location id
								$resultID->bindValue(':location_id', $location_id);
								if ($resultID->execute()) {
									if ($resultID->rowCount() > 0) {
										$row1 = $resultID->fetch();
										$num_ratings = $row1['total'];
										if ($num_ratings > 0) $val_ratings = round($row1['avg'], 2);
									}
								}

								// Filter out minimum ratings
								if ($val_ratings < $input_minrating) {
									// skip to next loop without rendering
									continue;
								}
								// appending the data
								if (!empty($dataForJS)) $dataForJS = $dataForJS . ", ";
								$dataForJS = $dataForJS . $row['latitude'] . ", " . $row['longitude'] . ", " . $row['name'] . ", " . $row['id'];
						?>
							<tr>
								<td><?php echo "<a href='object.php?id=" . $location_id . "'>" . $location_name . "</a>";  ?></td>
								<td><?php echo "Rating: " . ($val_ratings == 0 ? "None" : $val_ratings) . "<br>" . $num_ratings . " reviews"; ?></td>
								<td><?php echo $row['address']; ?></td>
							</tr>
							<?php 
							}
						}
						// done print rows
						
						// storing data for js to pull later; this is horrible and we should replace it at some point
						echo "<input type='hidden' id='locationtoken' value='" . $dataForJS . "'>";
						?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- <?php include 'include/sampleresults.inc' ?> -->
		
        <?php include 'include/footer.inc' ?>
    </body>
</html>