<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ranger's Watch - Registration</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Author: K. Mak, the sign-in page of Ranger's Watch.">
		
		<!-- load specific style for this page, then apply global style (header, footer, button) -->
		<link rel="stylesheet" href="assets/css/global_style.css">
		<link rel="stylesheet" href="assets/css/forms.css">
		
		<!-- access icons from Google -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
        <!-- bootstrap plugin
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
		-->
		<script type="text/javascript" src="assets/js/signin.js"></script>
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
			<div class="title"><h1 id="objTitle">Sign In</h1></div>
			
			<!-- start of form for signing in -->
			<form class="form_signin"  onsubmit="return validate(this)" method="post" action="assets/php/action_signin.php"> 

				<!-- username login-->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Username*</label>
					<input class="input_box right-rounded" type="text" name="input_username" required placeholder="Enter your username">
				</div>

				<!-- password-->
				<div class="container-row">
					<label class="text_bar left-rounded bg-green">Password*</label>
					<input class="input_box right-rounded" type="password" name="input_password" required placeholder="Enter your password">
				</div>

				<!-- rendering error message to screen -->
				<?php 
					if (isset($_SESSION['status_message']))
						if (!empty($_SESSION['status_message'])) {
							echo "<div class='container-row'>
									<p class='error_message'> Error: " . $_SESSION['status_message'] . "</p>
									</div>";
							// reset message so when you change screens and come back, msg doesn't appear again
							$_SESSION['status_message'] = "";
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