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
    $description = $_POST['description'];
    $imageName = $_POST['image'];
    $oldImage = $imageName;

    if (empty($id) || empty($name) || empty($description)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    else
    {
        // SQL query to check if category exists in categories table but exclude current category
        $sql = "SELECT * FROM categories WHERE name = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();

        if($category)
        {
            $_SESSION['error'] = "Category already exists!";
        }
        else
        {
            if (!empty($_FILES['img']['name'])) 
            {
                // Uploads image to server
                $imageName = uploadImage($_FILES['img'], "../uploads/", $entityName = "category"); 
                if($imageName == NULL)
                {
                    header("location: category-update.php?id=$id"); exit();
                }      
                unlink("../uploads/".$oldImage);
            }
            // Sql query to update category record
            $sql = "UPDATE categories SET name = ?, description = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $description, $imageName, $id);
            if ($stmt->execute()) 
            {
                $_SESSION['success'] = "Category updated successfully!";
                header("location: categories.php"); exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong!";
            }
        }
    }
    // redirects to category-create page if something is not right.
    header("location: category-update.php?id=$id"); exit();
}

// Validate and sanitize input
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $categoryId = (int) $_GET['id'];

    // SQL statement to get category record
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
    // Set error message
    $_SESSION["error"] = "Invalid Category ID!";
    header("location: categories.php"); exit();         // redirects if Invalid Id
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Category - <?php echo $category['name'] ?></title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="category-update.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Update Category</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo !empty($category['image']) ? '../uploads/' . $category['image'] : '../images/placeholder.png'; ?>" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                                <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="my-3">
                                    <label>Category Name</label>
                                    <input type="hidden" class="form-control" name="id" value="<?php echo $category['id'] ?>" required>
                                    <input type="hidden" class="form-control" name="image" value="<?php echo $category['image'] ?>" required>
                                    <input type="text" class="form-control" name="name" value="<?php echo $category['name'] ?>" required>
                                </div>
                                <div class="my-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5" required><?php echo $category['description'] ?></textarea>
                                </div>
                                <div class="my-3">
                                    <input type="submit" class="btn btn-lg btn-danger w-100" name="update" value="Update">
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