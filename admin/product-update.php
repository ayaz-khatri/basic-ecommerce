<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection
include("../includes/helpers.php");                     // Helper Functions

if(isset($_POST['update']))
{
    // Form inputs
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $available = $_POST['available'];
    $description = $_POST['description'];
    $imageName = $_POST['image'];
    $oldImage = $imageName;

    if (empty($id) || empty($name) || empty($category) || empty($price) || empty($stock) || !isset($available) || empty($description)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    elseif (!is_numeric($price) || $price < 0) {
        $_SESSION['error'] = "Please enter a positive number for price!";
    } 
    elseif (!is_numeric($stock) || $stock < 0) {
        $_SESSION['error'] = "Please enter a positive number for stock!";
    }
    else
    {
        if (!empty($_FILES['img']['name'])) 
        {
            // Uploads image to server
            $imageName = uploadImage($_FILES['img'], "../uploads/", $entityName = "product"); 
            if($imageName == NULL)
            {
                header("location: product-update.php?id=$id"); exit();
            }      
            unlink("../uploads/".$oldImage);
        }
        // Sql query to update product record
        $sql = "UPDATE products SET name = ?, category_id = ?, price = ?, stock = ?, is_available = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiissi", $name, $category, $price, $stock, $available, $description, $imageName, $id);
        if ($stmt->execute()) 
        {
            $_SESSION['success'] = "Product updated successfully!";
            header("location: products.php"); exit();
        }
        else
        {
            $_SESSION['error'] = "Something went wrong!";
        }
    }
    // redirects to product-create page if something is not right.
    header("location: product-update.php?id=$id"); exit();
}

// Validate and sanitize input
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $productId = (int) $_GET['id'];

    // SQL statement to get product record
    $sql = "SELECT * FROM products WHERE id = ?";
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
    // Set error message
    $_SESSION["error"] = "Invalid product ID!";
    header("location: products.php"); exit();         // redirects if Invalid Id
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product - <?php echo $product['name'] ?></title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="product-update.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Update Product</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo !empty($product['image']) ? '../uploads/' . $product['image'] : '../images/placeholder.png'; ?>" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                                <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <label>Product Name</label>
                                        <input type="hidden" class="form-control" name="id" value="<?php echo $product['id'] ?>" required>
                                        <input type="hidden" class="form-control" name="image" value="<?php echo $product['image'] ?>" required>
                                        <input type="text" class="form-control" name="name" value="<?php echo $product['name'] ?>" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label>Category</label>
                                        <select name="category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <?php 
                                                $sql = "SELECT * FROM categories"; 
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while($category = $result->fetch_assoc()){
                                            ?>
                                                <option value="<?php echo $category['id'] ?>" <?php echo ($category['id'] == $product['category_id'] ? "selected" : "") ?>><?php echo $category['name'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 my-2">
                                        <label>Price</label>
                                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $product['price'] ?>" required>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <label>Stock</label>
                                        <input type="number" class="form-control" name="stock" value="<?php echo $product['stock'] ?>" required>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <label>Available</label><br>
                                        
                                        <input type="radio" id="available0" name="available" value="1" class="btn-check" <?php echo ($product['is_available'] == 1) ? "checked" : "" ?> required>
                                        <label for="available0" class="btn btn-outline-secondary">Yes</label>

                                        <input type="radio" id="available1" name="available" value="0" class="btn-check" <?php echo ($product['is_available'] == 0) ? "checked" : "" ?> required>
                                        <label for="available1" class="btn btn-outline-secondary">No</label>
                                    </div>
                                    <div class="col-12 my-2">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3" required><?php echo $product['description'] ?></textarea>
                                    </div>
                                    <div class="col-12 my-2">
                                        <input type="submit" class="btn btn-lg btn-danger w-100" name="update" value="Update">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    <script src="../js/preview-image.js"></script>
    
</body>
</html>