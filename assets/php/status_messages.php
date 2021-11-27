<?php
session_start();
$_SESSION['status_message'] = "Please log in to submit objects";

// Connection
// Successful sign-in, registration
$_SESSION['status_message'] = "";
// Errors connecting to server
$_SESSION['status_message'] = "Failed to connect to server";
$_SESSION['status_message'] = "Failed to connect to database";


// Sign-in/Registration
$_SESSION['status_message'] = "Empty username received";
$_SESSION['status_message'] = "Empty password received";
// Registration
$_SESSION['status_message'] = "Empty fname received";
$_SESSION['status_message'] = "Empty lname received";
$_SESSION['status_message'] = "Empty email received";
$_SESSION['status_message'] = "Empty DOB received";

// insert query failed - existing username or email
$_SESSION['status_message'] = "Already Existing Username or Email";

// Sign-in
// query return 0 results
$_SESSION['status_message'] = "Invalid username or password";
// query failed to send
$_SESSION['status_message'] = "Could not query database";


?>