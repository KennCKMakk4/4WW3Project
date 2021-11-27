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
		?>
		
		<div class="main_body">
		
			<!-- title section of main body -->
			<div class="title">
				<h1 id="objTitle">Showing results near: 'hamilton, ON'</h1>
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
						<tr>
							<td><a href="object.php">Hamilton Archery Centre</a></td>
							<td>3.5 stars<br>254 reviews</td>
							<td>148 Parkdale Avenue North <br>
								Lower Level <br>
								Hamilton, Ontario <br>
								L8H 5X2</td>
						</tr>
						<tr>
							<td><a href="object.php">Evolve Archery Canada</a></td>
							<td>4.6 stars<br>53 reviews</td>
							<td>375 Wettlaufer Terrace<br>
								Milton, ON <br>
								L9T 7N4</td>
						</tr>
						<tr>
							<td><a href="object.php">Silver Swords Armories</a></td>
							<td>4.4 stars<br>95 reviews</td>
							<td>180 Burnhamthorpe Road E<br>
								Oakville, ON <br>
								L6H 7B5</td>
						</tr>
						<tr>
							<td><a href="object.php">Badenoch Archery</a></td>
							<td>4.6 stars<br>11 reviews</td>
							<td>15 Badenoch Street<br>
								Morriston, ON <br>
								N0B 2C0</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
        <?php include 'include/footer.inc' ?>
    </body>
</html>