<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection

// Validate and sanitize input
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $categoryId = (int) $_POST['id'];
    
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if($category['image'] != NULL)
    {
        unlink("../uploads/".$category['image']);
    }

    // SQL statement to delete
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    
    // Set success message
    $_SESSION["success"] = "Category deleted successfully!";
}
else
{
    // Set error message
    $_SESSION["error"] = "Invalid Category ID!";
}

// Redirect to users page
header("location: categories.php"); exit();
?>