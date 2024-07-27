<?php 

/* -------------------------------------------------------------------------- */
/*                                 Logout File                                */
/* -------------------------------------------------------------------------- */

    include("init-session.php");                // Start session
    session_unset();                            // Unset all session variables
    session_destroy();                          // Destroy the session
    header("location: ../base/login.php"); exit();      // Redirect to the login page
?>