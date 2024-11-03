<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/helpers.php");                     // Helper Functions

if(isset($_POST['create']))
{
    include("../includes/db-connection.php");           // Database connection

    // Form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $imageName = NULL;

    // Data validation
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/"; 
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    else if($password != $confirmPassword)
    {
        // Check if password and confirm password do not match
        $_SESSION['error'] = "Passwords do not match!";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        // Check the email format
        $_SESSION['error'] = "Use correct email format!";
    } 
    else if(!preg_match($pattern, $password))
    {
        // check the password pattern
        $_SESSION['error'] = "Password must contain at least one number, one uppercase, one lowercase letter, and at least 8 or more characters!";
    }
    else
    {
        // Sql query to check if email exists in users table
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
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
                    header("location: user-create.php"); exit();
                }      
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);               // Password Encryption
            // Sql query to insert user record
            $sql = "INSERT INTO users (username, email, password, image) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $imageName);
            if ($stmt->execute()) 
            {
                $_SESSION['success'] = "User created successfully!";
                header("location: users.php"); exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong!";
            }
        }
    }
    // redirects to user-create page if something is not right.
    header("location: user-create.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add User</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="user-create.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Add User</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                            <img src="../images/placeholder.png" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                            <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="my-3">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="my-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="my-3">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password"  title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                </div>
                                <div class="my-3">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="confirmPassword" required>
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