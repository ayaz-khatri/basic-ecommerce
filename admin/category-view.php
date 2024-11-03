<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection
include("../includes/helpers.php");                     // Helper Functions

// Validate and sanitize input
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $categoryId = (int) $_GET['id'];

    // SQL statement to get user record
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0)
    {
        $_SESSION["error"] = "Category not found!";
        header("location: categories.php"); exit();      // redirects if record not found
    }
    $category = $result->fetch_assoc();
}
else
{
    $_SESSION["error"] = "Invalid Category ID!";
    header("location: categories.php"); exit();          // redirects if invalid id
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $category['name'] ?></title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="box">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="<?php echo !empty($category['image']) ? '../uploads/' . $category['image'] : '../images/placeholder.png'; ?>" class="img img-fluid rounded shadow my-3">
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold"><?php echo $category['name'] ?></h3>
                            <hr>
                            <table class="table">
                                <tr>
                                    <td class="fw-bold text-secondary">Description</td>
                                    <td><?php echo $category['description'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Created At</td>
                                    <td>
                                        <div><?php echo timestampToCustomHumanReadable(strtotime($category['created_at'])) ?></div>
                                        <div class="text-secondary"><?php echo date("D, d F Y, h:i A", strtotime($category['created_at'])); ?></div>
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