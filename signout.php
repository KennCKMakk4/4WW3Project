<?php

	// trying to log out of the session now
	session_start();

	unset($_SESSION['fullname']);
	unset($_SESSION['valid']);
	unset($_SESSION['status_message']);

	// session_unset(); // unset all variables
	session_destroy();

	header("Location: signin.php");
?>