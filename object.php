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
			} else {
				include 'include/header.inc'; 
			}


			// checks if form sent valid data
			function isValidEntry($input) {
				return (isset($input) && !empty($input));
			} 
			
			function errorReceived($msg) {
				$_SESSION['status_message'] = $msg;
			}

			// renders stars showing the avgrating given
			function renderStarRatings($avgratings) {
				$starrating = $avgratings;
				for ($loopi = 0; $loopi < 5; $loopi++) {
					if ($starrating >= 1) {
						echo "<i class='material-icons'>star</i>";
					} else if ($starrating >= 0.5) {
						echo "<i class='material-icons'>star_half</i>";
					} else {
						echo "<i class='material-icons'>star_border</i>";
					}
					$starrating -= 1; 
				}
			}
			
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				// get values from form, and check if they are valid
				$sqlFilters = "";

				// building query string from search_name and search_loc
				if (isValidEntry($_GET['id'])) {
					$location_id = $_GET['id'];
					// $sqlFilters = " WHERE (`name` LIKE '%" . $input_name . "%')";
				} else {
					// you must have an id in order to request an object to render
					errorReceived("No Object ID in Request");
				}

				// connecting to db
				try {
					require "dbconn.php";
					$tblName = "locations";
					$sql_read = "SELECT * FROM " . $tblName . " WHERE (`id`=:location_id);";
					$result = $conn->prepare($sql_read);
					$result->bindValue(':location_id', $location_id);

					$location_name = "";
					$location_about = "";
					$location_phone = "";
					$location_email = "";
					$location_address = "";
					$location_lat = "";
					$location_long = "";
					$location_img = "";
					$location_video = "";

					if ($result->execute()) {
						if ($result->rowCount() > 0) {
							$row = $result->fetch();
							$location_name = $row["name"];
							$location_about = $row["about"];
							$location_phone =  $row["phone"];;
							$location_email =  $row["email"];;
							$location_address =  $row["address"];;
							$location_lat =  $row["latitude"];;
							$location_long =  $row["longitude"];;
							$location_img =  $row["image"];;
							$location_video =  $row["video"];;
						} else {
							errorReceived("No results obtained with object ID " . $location_id);
						}
					}		

					$val_ratings = 0;
					$num_ratings = 0;
					// getting total number of reviews, and average rating values
					$sql_getratings = "SELECT `location_id`, COUNT(`value`) AS `total`, AVG(`value`) AS `avg` FROM ratings WHERE `location_id`=:location_id;";
					$result2 = $conn->prepare($sql_getratings);
					$result2->bindValue(':location_id', $location_id);
					if ($result2->execute()) {
						if ($result2->rowCount() > 0) {
							$row1 = $result2->fetch();
							$num_ratings = $row1['total'];
							if ($num_ratings > 0) $val_ratings = round($row1['avg'], 2);
						}
					}
					echo "<input type='hidden' id='latlongtoken' value='" . $location_lat . ", " . $location_long . ", " . $location_name . "'>"; 

				} catch (PDOException $e) {
					$error = $e->errorInfo[2];
					errorReceived($error);
				}

				require 'bktconn.php';
				try {
					// checking for img, then replace it with url to object from bucket
					if (!empty($location_img)) {
						$fileDownload = $s3Client->getCommand('GetObject', [
							'Bucket' => $bktName, 'Key' => $location_img
						]);
						$request = $s3Client->createPresignedRequest($fileDownload, '+5 minutes');
						$presignedUrl = (string)$request->getUri();
						$location_img = $presignedUrl; 	// storing url to img
					}

					if (!empty($location_video)) {
						$fileDownload = $s3Client->getCommand('GetObject', [
							'Bucket' => $bktName, 'Key' => $location_video
						]);
						$request = $s3Client->createPresignedRequest($fileDownload, '+5 minutes');
						$presignedUrl = (string)$request->getUri();
						$location_video = $presignedUrl; 	// storing url to img
					}
				} catch (S3Exception $e) {
					errorReceived("Could not gather media data from bucket: " . $e->getMessage());
				}
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
						$_SESSION['status_message'] = "";
					}
				}
			?>

			<!-- title section of main body -->
			<div class="title">
				<h1 id="objTitle"> <?php echo $location_name ?></h1>
			</div>

			<!-- 'splash screen', first section of object, shows important details-->
			<div class="objSplash">
				<!-- map of obj -->
				<div class="img_container">
					<img class="img_object" 
					alt="image of <?php echo $location_name?>" 
					src="<?php echo $location_img ?>">
				</div>

				<!-- ratings section of obj -->
				<div class="ratings_section">
					<div class="ratings_bar">
						<h3 class="rating"> User Rating: </h3>
						<div class="ratings_star">
							<?php  // rendering stars to represent ratings
								renderStarRatings($val_ratings);
							?>
						</div>
					</div>
					<div class="ratings_num">
						<p> <?php echo $val_ratings; ?> average ratings out of <?php echo $num_ratings; ?> reviewers </p>
					</div>
				</div>

			</div>
			
			<!-- Description: -->
			<div class="main_section">
				<h2>About</h2>
				<p><?php echo $location_about ?></p>
				<h3>Contact:</h3>
				<p><?php echo $location_phone . "<br>" . $location_email ?></p>
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
						<p><?php echo $location_address ?></p>
						<!-- map -->
						<div class="img_container">
							<div class="map_object" id="mymap"></div>
						</div>
					</div>
					
					<!-- video -->
					<?php 
					if (!empty($location_video)) { ?>
					<div class="obj_vid_container">
						<video class="obj_video" controls autoplay muted>
								<source src="<?php echo $location_video ?>" type="video/webm">
								Sample Video could not be loaded
							</video>
					</div>
					<?php } ?>
				</div>
				<!-- <h3>Hours Open:</h3>
				<p>Currently closed for renovations.</p> -->
			</div>
			
			<!-- reviews -->
			<div class="main_section">
				<h2>Reviews</h2>


				<?php
					$val_ratings = 0;
					$num_ratings = 0;
					// getting total number of reviews, and average rating values
					$sql_getratings = "SELECT * FROM ratings WHERE `location_id`=:location_id ORDER BY `created` DESC;";
					$result3 = $conn->prepare($sql_getratings);
					$result3->bindValue(':location_id', $location_id);
					$result3->execute();
					if ($result3->rowCount() <= 0) {
						echo "No reviews for this location at the moment. Be the <a href=review.php?id=". $location_id .">first</a> to do so!";
					} else {
						echo "Want to submit a review for this place? Click <a href=review.php?id=". $location_id .">here!</a><br><br>";
						while($row = $result3->fetch()) { ?>
							<div class="review-section">
								<div class="ratings_bar">
									<h4 class="rating"> <?php echo $row['username']?>: </h4>
									<div class="ratings_star">
										<?php renderStarRatings($row['value']); ?>
									</div>
								</div>
								<?php echo "\t\t\t" . $row['created']; ?>
								<p><?php echo $row['comment']?> </p>
							</div>
						<?php }
					}
				?>
			</div>
		</div>
		
        <?php include 'include/footer.inc' ?>
    </body>
</html>