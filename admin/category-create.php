<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/helpers.php");                     // Helper Functions

if(isset($_POST['create']))
{
    include("../includes/db-connection.php");           // Database connection

    // Form inputs
    $name = $_POST['name'];
    $description = $_POST['description'];
    $imageName = NULL;

    // Data validation
    if (empty($name) || empty($description)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    else
    {
        // Sql query to check if category exists in catogories table
        $sql = "SELECT * FROM categories WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
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
                    header("location: category-create.php"); exit();
                }      
            }
            // Sql query to insert category record
            $sql = "INSERT INTO categories (name, description, image) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $description, $imageName);
            if ($stmt->execute()) 
            {
                $_SESSION['success'] = "Category created successfully!";
                header("location: categories.php"); exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong!";
            }
        }
    }
    // redirects to category-create page if something is not right.
    header("location: category-create.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Category</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="category-create.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Add Category</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="../images/placeholder.png" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                                <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="my-3">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="my-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="my-3">
                                    <input type="submit" class="btn btn-lg btn-danger w-100" name="create" value="Add">
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