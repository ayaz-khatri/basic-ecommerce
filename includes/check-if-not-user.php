<?php 

/* -------------------------------------------------------------------------- */
/*                    Check if logged in user is not user                    */
/* -------------------------------------------------------------------------- */
	
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
	{
        if($_SESSION['userRole'] != 'u')
        {
            // if user's role is not user then redirect to login page
            header("location: ../base/login.php"); exit();
        }
	}
    else
    {
        // if user is not logged in then redirect to login page
        header("location: ../base/login.php"); exit();
    }	

?>