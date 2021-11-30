<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ranger's Watch - Registration</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Author: K. Mak, the sign up page for the application Ranger's Watch.">
		
		<!-- load specific style for this page, then apply global style (header, footer, button) -->
		<link rel="stylesheet" href="assets/css/global_style.css">
		<link rel="stylesheet" href="assets/css/forms.css">
		
		<!-- access icons from Google -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
        <!-- bootstrap plugin
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
		-->

		<script type="text/javascript" src="assets/js/registration.js"></script>
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
			else
				include 'include/header.inc'; 
		?>
		
		<div class="main_body">
			<div class="title"><h1 id="objTitle">Register a New Account</h1></div>
			
			<!-- start of form to register -->
			<!-- same class as submission form-->
			<form class="form_submission" onsubmit="return validate(this)" method="post" action="assets/php/action_register.php">
				
				<!-- first name, last name, in-line -->
				<div class="container-row">
					<!-- dividing into two equal divs-->
					<div class="container-row-50">
						<label class="text_bar left-rounded bg-green">First Name*</label>
						<input class="input_box right-rounded" type="text" name="input_fname" placeholder="Enter your first legal name">
					</div>
					<div class="container-row-50">
						<label class="text_bar left-rounded bg-green">Last Name*</label>
						<input class="input_box right-rounded" type="text" name="input_lname" placeholder="Enter your last legal name">
					</div>
				</div>

				<!-- username -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Username*</label>
					<input class="input_box right-rounded" type="text" name="input_username" placeholder="Enter your username">
				</div>
				
				<!-- email -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">E-mail*</label>
					<input class="input_box right-rounded" type="text" name="input_email" placeholder="Enter your email">
				</div>
				<!-- note: change type="text" back to type="email" later for double validation instead of just .js-->

				<!-- passwords-->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Password*</label>
					<input class="input_box right-rounded" type="password" name="input_password" placeholder="Enter your password. We recommend using a strong one with multiple symbols">
				</div>

				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Confirm Password*</label>
					<input class="input_box right-rounded" type="password" name="input_password_confirm" placeholder="Type in your chosen password again">
				</div>

				<!-- asking dob with date field -->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Date of Birth</label>
					<input class="input_box right-rounded" type="date" name="input_dob">
				</div>

				<!-- last section asking for any experience, newsletters, and terms and conditions -->
				<div class="container-row">

					<!-- asking previous archery experience with radio -->
					<div class="container-radio">
						<label class="text_bar left-rounded bg-green">Have you done archery before?</label>
						<div class="container-radio-section">
							<div class="container-radio-row">
								<input class="radio-button" type="radio" id="radio1" name="input_experience" value="0">
								<label class="radio-label" for="radio1">Never</label><br>
							</div>
							<div class="container-radio-row">
								<input class="radio-button" type="radio" id="radio2" name="input_experience" value="1">
								<label class="radio-label" for="radio2">Once or twice</label><br>
							</div>
							<div class="container-radio-row">
								<input class="radio-button" type="radio" id="radio3" name="input_experience" value="2">
								<label class="radio-label" for="radio3">Some</label><br>
							</div>
							<div class="container-radio-row">
								<input class="radio-button" type="radio" id="radio4" name="input_experience" value="3">
								<label class="radio-label" for="radio4">Trained</label><br>
							</div>
							<div class="container-radio-row">
								<input class="radio-button" type="radio" id="radio5" name="input_experience" value="4">
								<label class="radio-label" for="radio5">Experienced</label><br>
							</div>
						</div>
					</div>

					<!-- div for checkboxes, ask if they want to accept notifications-->
					<div class="container-row-50">
						<div class="container-checkbox">
							<div class="container-checkbox-row">
								<input class="checkbox-button" type="checkbox" id="cb-notification1" name="input_noti1" value="1">
								<label class="checkbox-label" for="cb-notification1">Would you like to receive notifications of neaby centres?</label>
							</div>
							<div class="container-checkbox-row">
								<input class="checkbox-button" type="checkbox" id="cb-notification2" name="input_noti2" value="1">
								<label class="checkbox-label" for="cb-notification2">Would you like to receive notifications of updates?</label>
							</div>
						</div>
						
					</div>
				</div>

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

				<!-- submit button -->
				<div class="container-row">
					<input type="submit" value="Submit" class="form_button">
					<!-- old version used for linking to another html page
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