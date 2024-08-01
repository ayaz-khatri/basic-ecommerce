<?php 

/* -------------------------------------------------------------------------- */
/*                       Check if user is not logged in                       */
/* -------------------------------------------------------------------------- */

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
	{
        // redirect to login page if not logged in
		header("location: ../base/login.php"); exit();
	}

?>
