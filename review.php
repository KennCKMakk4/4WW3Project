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
		<link rel="stylesheet" href="assets/css/review.css">
		
        <!-- bootstrap plugin
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
		-->

		<script type="text/javascript" src="assets/js/review.js"></script>
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
				$_SESSION['status_message'] = "Please log in to review locations";
				include 'include/header.inc'; 
				header("Location: signin.php");
			}

			// checks if form sent valid data
			function isValidEntry($input) {
				return (isset($input) && !empty($input));
			} 
			
			function errorReceived($msg) {
				$_SESSION['status_message'] = $msg;
			}

			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				// get values from form, and check if they are valid
				$sqlFilters = "";

				// building query string from search_name and search_loc
				if (isValidEntry($_GET['id'])) {
					$location_id = $_GET['id'];
				} else {
					errorReceived("No Object ID in Request");
				}

				// connecting to db
				try {
					require "dbconn.php";
					$tblName = "locations";
					$sql_read = "SELECT `name` FROM " . $tblName . " WHERE `id`=?;";
					$result = $conn->prepare($sql_read);
					$result->bindValue(1, $location_id);
					$result->execute();

					$location_name = "";
					if ($result->rowCount() > 0) {
						$row = $result->fetch();
						$location_name = $row["name"];
						$_SESSION['status_message'] = "";
					} else {
						errorReceived("No results obtained with object ID " . $location_id);
					}
				} catch (PDOException $e) {
					$error = $e->errorInfo[2];
					errorReceived($error);
				}
			}
		?>
		
		<div class="main_body">
			<div class="title"><h1 id="objTitle">Reviewing</h1></div>
			
			<!-- start of form to register -->
			<form class="form_submission" onmousedown="handleClick(event)" onsubmit="return validate(this)" method="post" action="assets/php/action_review.php">
				
				<?php 
					echo "<input type='hidden' name='location_id' id='location_id' value='" . $location_id . "'>";
					echo "<input type='hidden' name='username' id='username' value='" . $_SESSION['username'] . "'>";
				?>
				<!-- signed in as -->
				<div class="container-row">
					<h2> Currently Signed In As:<br> <?php echo $_SESSION['fullname'] ?> </h2>
				</div>
				<!-- who are you reviewing -->
				<div class="container-row">
					<h2> Currently Reviewing: <br> <?php echo $location_name ?> </h2>
				</div>


				<?php if (!empty($location_name)) { ?>
					<h2 class="lessMargin">Rating</h2>
					<div class="container-row container-row-star margin_bot_25">
							<div class="ratings_star" id="ratingsbar" onmousemove="handleHover(event)" >
								<i id="star1" class='material-icons ratings_star_obj' onmousemove="handleHover(event)" >star_border</i>
								<i id="star2" class='material-icons ratings_star_obj' onmousemove="handleHover(event)" >star_border</i>
								<i id="star3" class='material-icons ratings_star_obj' onmousemove="handleHover(event)" >star_border</i>
								<i id="star4" class='material-icons ratings_star_obj' onmousemove="handleHover(event)" >star_border</i>
								<i id="star5" class='material-icons ratings_star_obj' onmousemove="handleHover(event)" >star_border</i>
							</div>
						<input type="hidden" name="currentRating" required id="currentRating" value='-1'>
					</div>


					<!-- a brief description about this place -->
					<div class="container-row">
						<label class="text_bar left-rounded bg-green">Comments</label>
						<textarea class="input_box right-rounded height_200" name="input_about" placeholder="Write down what you think about this place (500chars max)"></textarea>
					</div>


					<!-- submit button -->
					<div class="container-row">
						<input type="submit" value="Submit" class="form_button">
					</div>
				<?php } ?>

				<!-- rendering error message to screen -->
				<?php 
					if (isset($_SESSION['status_message'])){
						if (!empty($_SESSION['status_message'])) {
							echo "<div class='container-row'>
									<p class='error_message'> Error: " . $_SESSION['status_message'] . "</p>
									</div>";
						}
					}
				?>

			</form>
		</div>
		
        <?php include 'include/footer.inc' ?>
    </body>
</html>