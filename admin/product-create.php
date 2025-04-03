<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/helpers.php");                     // Helper Functions
include("../includes/db-connection.php");               // Database connection


if(isset($_POST['create']))
{
    // Form inputs
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $available = $_POST['available'];
    $description = $_POST['description'];
    $imageName = NULL;

    // Data validation
    if (empty($name) || empty($category) || empty($price) || empty($stock) || !isset($available) || empty($description)) 
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
                header("location: product-create.php"); exit();
            }      
        }
        // Sql query to insert product record
        $sql = "INSERT INTO products (name, price, stock, is_available, description, image, category_id) VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiissi", $name, $price, $stock, $available, $description, $imageName, $category);
        if ($stmt->execute()) 
        {
            $_SESSION['success'] = "Product created successfully!";
            header("location: products.php"); exit();
        }
        else
        {
            $_SESSION['error'] = "Something went wrong!";
        }
    }
    // redirects to product-create page if something is not right.
    header("location: product-create.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="product-create.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Add Product</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="../images/placeholder.png" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                                <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="name" required>
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
                                                <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 my-2">
                                        <label>Price</label>
                                        <input type="number" step="0.01" class="form-control" name="price" required>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <label>Stock</label>
                                        <input type="number" class="form-control" name="stock" required>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <label>Available</label><br>
                                        
                                        <input type="radio" id="available0" name="available" value="1" checked class="btn-check" required>
                                        <label for="available0" class="btn btn-outline-secondary">Yes</label>

                                        <input type="radio" id="available1" name="available" value="0" class="btn-check" required>
                                        <label for="available1" class="btn btn-outline-secondary">No</label>
                                    </div>
                                    <div class="col-12 my-2">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="col-12 my-2">
                                        <input type="submit" class="btn btn-lg btn-danger w-100" name="create" value="Add">
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