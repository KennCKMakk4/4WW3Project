<?php

	// trying to log out of the session now
	session_start();

	session_unset(); // unset all variables
	
	// session_destroy();

	header("Location: signin.php");
?>