<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection

// Validate and sanitize input
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $userId = (int) $_POST['id'];

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user['image'] != NULL)
    {
        unlink("../uploads/".$user['image']);
    }

    // SQL statement to delete
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    // Set success message
    $_SESSION["success"] = "User deleted successfully!";
}
else
{
    // Set error message
    $_SESSION["error"] = "Invalid user ID!";
}

// Redirect to users page
header("location: users.php"); exit();
?>