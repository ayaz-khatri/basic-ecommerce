<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection

// Validate and sanitize input
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $productId = (int) $_POST['id'];
    
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if($product['image'] != NULL)
    {
        unlink("../uploads/".$product['image']);
    }

    // SQL statement to delete
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    
    // Set success message
    $_SESSION["success"] = "Product deleted successfully!";
}
else
{
    // Set error message
    $_SESSION["error"] = "Invalid product ID!";
}

// Redirect to products page
header("location: products.php"); exit();
?>