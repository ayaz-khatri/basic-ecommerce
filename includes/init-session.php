<?php
/* -------------------------------------------------------------------------- */
/*                          Code to start the session                         */
/* -------------------------------------------------------------------------- */


try 
{
    // Check if a session has not already been started
    if (session_status() == PHP_SESSION_NONE) 
    {
        // Start a new session
        session_start(); 
    }
} 
catch (Exception $e) 
{
    // Output an error message if an exception occurs during session start
    echo "An error occurred while starting the session: " . $e->getMessage(); exit();
}
?>
