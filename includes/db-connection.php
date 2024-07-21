<?php 

/* -------------------------------------------------------------------------- */
/*                             Database Connection                            */
/* -------------------------------------------------------------------------- */


// Define constants for database connection parameters
define('DB_SERVER', 'localhost');       // Server name
define('DB_USERNAME', 'root');          // Database username
define('DB_PASSWORD', '');              // Database password (empty for no password)
define('DB_NAME', 'basic_ecommerce');   // Database name

try 
{
    // Create a new mysqli object with error handling enabled
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
} 
catch (Exception $e) 
{
    // Handle the exception and display the error message
    echo "ERROR: " . $e->getMessage(); exit();
}

?>