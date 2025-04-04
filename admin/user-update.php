<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection
include("../includes/helpers.php");                     // Helper Functions

if(isset($_POST['update']))
{
    // Form inputs
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $imageName = $_POST['image'];
    $oldImage = $imageName;

    // Data validation
    if (empty($id) || empty($username) || empty($email)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        // Check the email format
        $_SESSION['error'] = "Use correct email format!";
    } 
    else
    {
        // SQL query to check if email exists in users table but exclude current user
        $sql = "SELECT * FROM users WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($user)
        {
            $_SESSION['error'] = "Email already exists!";
        }
        else
        {
            if (!empty($_FILES['img']['name'])) 
            {
                // Uploads image to server
                $imageName = uploadImage($_FILES['img'], "../uploads/", $entityName = "user"); 
                if($imageName == NULL)
                {
                    header("location: user-update.php?id=$id"); exit();
                }      
                unlink("../uploads/".$oldImage);
            }
            // Sql query to update user record
            $sql = "UPDATE users SET username = ?, email = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $email, $imageName, $id);
            if ($stmt->execute()) 
            {
                $_SESSION['success'] = "User updated successfully!";
                header("location: users.php"); exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong!";
            }
        }
    }
    // redirects to user-create page if something is not right.
    header("location: user-update.php?id=$id"); exit();
}

// Validate and sanitize input
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))  
{
    // Ensure the ID is an integer
    $userId = (int) $_GET['id'];

    // SQL statement to get user record
    $sql = "SELECT * FROM users WHERE id = ? AND role = 'u'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0)
    {
        $_SESSION["error"] = "User not found!";
        header("location: users.php"); exit();      // redirects if record not found
    }
    $user = $result->fetch_assoc();
}
else
{
    // Set error message
    $_SESSION["error"] = "Invalid user ID!";
    header("location: users.php"); exit();      // redirects if Invalid Id
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User - <?php echo $user['username'] ?></title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="user-update.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Edit User</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo !empty($user['image']) ? '../uploads/' . $user['image'] : '../images/placeholder.png'; ?>" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                                <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="my-3">
                                    <label>Username</label>
                                    <input type="hidden" class="form-control" name="id" required value="<?php echo $user['id'] ?>">
                                    <input type="hidden" class="form-control" name="image" value="<?php echo $user['image'] ?>" required>
                                    <input type="text" class="form-control" name="username" required value="<?php echo $user['username'] ?>">
                                </div>
                                <div class="my-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required value="<?php echo $user['email'] ?>">
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