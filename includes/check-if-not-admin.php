<?php 

/* -------------------------------------------------------------------------- */
/*                    Check if logged in user is not admin                    */
/* -------------------------------------------------------------------------- */
	
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
	{
        if($_SESSION['userRole'] != 'a')
        {
            // if user's role is not admin then redirect to login page
            header("location: ../base/login.php"); exit();
        }
	}
    else
    {
        // if user is not logged in then redirect to login page
        header("location: ../base/login.php"); exit();
    }	

?>