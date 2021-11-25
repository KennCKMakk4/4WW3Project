<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ranger's Watch - Registration</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Author: K. Mak, the search page of the application Ranger's Watch.">
		
		<!-- load specific style for this page, then apply global style (header, footer, button) -->
		<link rel="stylesheet" href="assets/css/global_style.css">
		<link rel="stylesheet" href="assets/css/forms.css">
		
		<!-- access icons from Google -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
		<!-- form validation for search.php -->
		<script type="text/javascript" src="assets/js/search.js"></script>

        <!-- bootstrap plugin
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
		-->
    </head>


    <body>
		
		<?php include 'header.inc' ?>
		
		<div class="main_body">
			<div class="title"><h1 id="objTitle">Search</h1></div>
			
			<!-- creating form - no action yet -->
			<form class="form_search" name="searchForm" onsubmit="return validate(this)">

				<!-- search bar - by name-->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">By name</label>
					<input class="input_box right-rounded" type="text" name="input_search_name" placeholder="Search for nearby archery centers by name">
				</div>
				
				<div class="container-row justify_left ">
					<!-- button to auto fill in geolocation-->
					<div class="form_button smaller_margin" name="btn_getLocation" onclick="getLocation()">
						<i class="material-icons">search</i>
						<p class="form_button_text">Use My Location</p>
					</div>
				</div>
				<!-- search bar - by location-->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">By location</label>
					<input class="input_box right-rounded" type="text" name="input_search_loc" placeholder="Search for nearby archery centers by a location.">
				</div>
				<!-- selection options, by rating -->
				<div class="container-row">
					<label class="text_bar_long left-rounded bg-green">With Minimum Rating:</label>
					<select class="input_box right-rounded" name="minrating">
						<option value="minRate5">5</option>
						<option value="minRate4">4</option>
						<option value="minRate3">3</option>
						<option value="minRate2">2</option>
						<option value="minRate1">1</option>
					</select>
				</div>



				<!-- submit button -->
				<div class="container-row">
					<!-- Input 'submit' for form validation 
					-->
					<input class="form_button " type="submit" value="Submit" class="form_button">

					<!-- Move to results.php (temporarily) so that we can move things along -->
					<a href="results.php">
						<div class="form_button">
							<i class="material-icons">search</i>
							<p class="form_button_text">Search (Move to results.php)</p>
						</div>
					</a> 
					<!-- same thing here ; we're using a regular div instead of button so that we can move along to the results page
						<button class="form_button">
							<i class="material-icons">search</i>
							<p class="form_button_text">Search</p>
						</button>
					-->
				</div>
			</form>
		</div>
		
        <?php include 'footer.inc' ?>
    </body>
</html>