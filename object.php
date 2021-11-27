<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ranger's Watch - Hamilton Archery Centre</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Author: K. Mak, displays in detail an archery range or shop from the website of Ranger's Watch">
		
		<!-- load specific style for this page, then apply global style (header, footer, button) -->
		<link rel="stylesheet" href="assets/css/global_style.css">
		<link rel="stylesheet" href="assets/css/object.css">
		
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
		<script type="text/javascript" src="assets/js/object.js"></script>
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
				<h1 id="objTitle">Hamilton Archery Centre</h1>
			</div>

			<!-- 'splash screen', first section of object, shows important details-->
			<div class="objSplash">
				<!-- map of obj -->
				<div class="img_container">
					<img class="img_object" alt="image of hamilton archery centre" src="assets/img/img_hamiltonarcherycentre.jpg">
				</div>

				<!-- ratings section of obj -->
				<div class="ratings_section">
					<div class="ratings_bar">
						<h3 class="rating"> User Rating: </h3>
						<div class="ratings_star">
							<i class="material-icons">star</i>
							<i class="material-icons">star</i>
							<i class="material-icons">star</i>
							<i class="material-icons">star_half</i>
							<i class="material-icons">star_border</i>
						</div>
					</div>
					<div class="ratings_num">
						<p> 3.5 average ratings out of 254 reviewers </p>
					</div>
				</div>

			</div>
			
			<!-- Description: -->
			<div class="main_section">
				<h2>About</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
					eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut 
					enim ad minim veniam, quis nostrud exercitation ullamco laboris 
					nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor 
					in reprehenderit in voluptate velit esse cillum dolore eu fugiat 
					nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
					sunt in culpa qui officia deserunt mollit anim id est laborum.
				</p>
				<h3>Contact:</h3>
				<p>(905) 979-4811 <br>hamiltonarcherycentre@gmail.com</p>
			</div>
			
			<!-- Location -->
			<div class="main_section">
				<h2>Location</h2>

				<!-- sorting elements - map and address on left, video on right-->
				<div class="container-row">
					<!-- map and address -->
					<div class="obj_add_map">
						<!-- address -->
						<h3> Address </h3>
						<p>
							148 Parkdale Avenue North <br>
							Lower Level <br>
							Hamilton, Ontario <br>
							L8H 5X2
						</p>
						<!-- map -->
						<div class="img_container">
							<!-- <img class="img_object" alt="map of hamilton archery centre" src="assets/img/map_hamiltonarcherycentre.png"> -->
							<div class="map_object" id="mymap"></div>
						</div>
					</div>
					
					<!-- video -->
					<div class="obj_vid_container">
						<video class="obj_video" controls autoplay muted>
							<source src="assets/media/sample.webm" type="video/webm">
							Sample Video could not be loaded
						</video>
					</div>
				</div>
				<h3>Hours Open:</h3>
				<p>Currently closed for renovations.</p>
			</div>
			
			<!-- reviews -->
			<div class="main_section">
				<h2>Reviews</h2>
				<div class="review-section">
					<div class="ratings_bar">
						<h4 class="rating"> Random Bloke: </h4>
						<div class="ratings_star">
							<i class="material-icons">star</i>
							<i class="material-icons">star</i>
							<i class="material-icons">star</i>
							<i class="material-icons">star_half</i>
							<i class="material-icons">star_border</i>
						</div>
					</div>
					<p>
						A pretty good place to go for archery whether or not you have had experience. 
						They offer lessons as well as walk-in session for all users. Lots of space outdoors as well to look around.
						Highly recommend with archers of all experience.
					</p>
				</div>

				
				<div class="review-section">
					<div class="ratings_bar">
						<h4 class="rating"> NotABot: </h4>
						<div class="ratings_star">
							<i class="material-icons">star</i>
							<i class="material-icons">star</i>
							<i class="material-icons">star</i>
							<i class="material-icons">star_half</i>
							<i class="material-icons">star_border</i>
						</div>
					</div>
					<p>
						It's aight.
					</p>
				</div>
			</div>
		</div>
		
        <?php include 'include/footer.inc' ?>
    </body>
</html>