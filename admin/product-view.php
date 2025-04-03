<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection
include("../includes/helpers.php");                     // Helper Functions

// Validate and sanitize input
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $productId = (int) $_GET['id'];

    // SQL statement to get product record
    $sql = "SELECT p.*, c.name AS category FROM products p 
            INNER JOIN categories c ON c.id = p.category_id 
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0)
    {
        $_SESSION["error"] = "Product not found!";
        header("location: products.php"); exit();      // redirects if record not found
    }
    $product = $result->fetch_assoc();
}
else
{
    $_SESSION["error"] = "Invalid product ID!";
    header("location: products.php"); exit();          // redirects if invalid id
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $product['name'] ?></title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="<?php echo !empty($product['image']) ? '../uploads/' . $product['image'] : '../images/placeholder.png'; ?>" class="img img-fluid rounded shadow my-3">
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold"><?php echo $product['name'] ?></h3>
                            <hr>
                            <table class="table">
                                <tr>
                                    <td class="fw-bold text-secondary">Category</td>
                                    <td><?php echo $product['category'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Price</td>
                                    <td><?php echo $product['price'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Stock</td>
                                    <td><?php echo $product['stock'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Available</td>
                                    <td><?php echo ($product['is_available'] == 1) ? "Yes" : "No" ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Description</td>
                                    <td><?php echo $product['description'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Created At</td>
                                    <td>
                                        <div><?php echo timestampToCustomHumanReadable(strtotime($product['created_at'])) ?></div>
                                        <div class="text-secondary"><?php echo date("D, d F Y, h:i A", strtotime($product['created_at'])); ?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/footer.php"); ?>
</body>
</html>