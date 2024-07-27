<?php 

/* -------------------------------------------------------------------------- */
/*                     Check if user is already logged-in                     */
/* -------------------------------------------------------------------------- */

	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
	{
		if($_SESSION['userRole'] == 'a')
		{
            // if user role is admin then redirect to admin home page
			header("location: admin/index.php"); exit();
		}
		else
		{
            // if user role is not admin then redirect to site's home page
			header("location: index.php"); exit();
		}
	}

?>