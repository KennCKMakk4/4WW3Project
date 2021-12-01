<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ranger's Watch - Submission</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Author: K. Mak, the submission page of Ranger's Watch. Used by users for creating new locations and submitting them to the database.">
		
		<!-- load specific style for this page, then apply global style (header, footer, button) -->
		<link rel="stylesheet" href="assets/css/global_style.css">
		<link rel="stylesheet" href="assets/css/forms.css">
		
		<!-- access icons from Google -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
        <!-- bootstrap plugin
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
		-->
		<script type="text/javascript" src="assets/js/submission.js"></script>
    </head>


    <body>
		<?php 
			session_start();
			$session_valid = false;
			if (isset($_SESSION['valid'])) {
				if(!empty($_SESSION['valid']) && ($_SESSION['valid']))
					$session_valid = $_SESSION['valid'];
			}
			
			if ($session_valid)
				include 'include/headersession.inc'; 
			else {
				include 'include/header.inc'; 

				$_SESSION['status_message'] = "Please log in to submit a location";
				header("Location: signin.php");
			}
			// We don't want people to be able to submit w/o logging in - we also want to track who submitted a place
			// We redirect them
		?>
		
		<div class="main_body">
			<div class="title"><h1 id="objTitle">Submit a New Location</h1></div>
			
			<!-- start of form - no action yet -->
			<form name="submissionForm" class="form_submission" enctype="multipart/form-data" method="post" action="assets/php/action_submit.php"> <!-- onsubmit="return validate(this)" Disabled for HTML5 Form Validation instead -->

				<!-- using container-row to have all elements in div to be in-line-->
				<!-- each row has a label and an input; label is class text_bar, inputs are class input_box-->
				<!-- allows for colouring of label, aesthetics -->

				<!-- Name of location -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Name*</label>
					<input class="input_box right-rounded" type="text" name="input_name" required placeholder="Enter name of the Archery Centre">
				</div>

				<!-- a brief description about this place -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">About*</label>
					<textarea class="input_box right-rounded height_200" name="input_about" required placeholder="Enter a brief description of this centre"></textarea>
				</div>

				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Phone</label>
					<input class="input_box right-rounded" type="tel" name="input_phone" placeholder="Phone Contact Information">
				</div>

				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Email</label>
					<input class="input_box right-rounded" type="email" name="input_email" placeholder="Email Contact Information">
				</div>

				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Address</label>
					<textarea class="input_box right-rounded height_100" name="input_address" placeholder="Enter the address of the centre"></textarea>
				</div>



				<div class="container-row justify_left ">
					<!-- button to auto fill in geolocation-->
					<div class="form_button smaller_margin" name="btn_getLocation" onclick="getLocation()">
						<i class="material-icons">search</i>
						<p class="form_button_text">Use My Location</p>
					</div>
				</div>
				
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Latitude*</label>
					<input class="input_box right-rounded" 
						type="text" 
						name="input_latitude" 
						required 
						pattern="^(\+|-)?(?:90(?:(?:\.0{1,9})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,9})?))$"
						placeholder="latitude">
				</div>
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Longitude*</label>
					<input class="input_box right-rounded" 
						type="text" 
						name="input_longitude" 
						required 
						pattern="^(\+|-)?(?:180(?:(?:\.0{1,9})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,9})?))$"
						placeholder="longitude">
				</div>
				<!-- image uploading -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Image*</label>
					<input class="input_box right-rounded file_upload" id="input_image" type="file" accept="image/*" name="input_image" required>
				</div>

				<!-- video uploading -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Video</label>
					<input class="input_box right-rounded file_upload" id="input_video" type="file" accept="video/*" name="input_video">
				</div>
			
				<!-- rendering error message to screen -->
				<?php 
					if (isset($_SESSION['status_message']))
						if (!empty($_SESSION['status_message'])) {
							echo "<div class='container-row'>
									<p class='error_message'> Error: " . $_SESSION['status_message'] . "</p>
									</div>";
						}
				?>

				<!-- submit button -->
				<div class="container-row">
					<input type="submit" value="Submit" class="form_button">
					<!--
					<a href="object.php">
						<button class="form_button">
							<i class="material-icons">done</i>
							<p class="form_button_text">Submit</p>
						</button>
					</a> 
					-->
				</div>
			</form>
		</div>
		
        <?php include 'include/footer.inc' ?>
    </body>
</html>