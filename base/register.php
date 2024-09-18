<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-loggedin-user.php");         // Check if user is already loggedin

if(isset($_POST['register']))
{
    include("../includes/db-connection.php");           // Database connection

    // Form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

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
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);               // Password Encryption
            // Sql query to insert user record
            $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashedPassword);
            if ($stmt->execute()) 
            {
                $_SESSION['success'] = "User created successfully!";
                header("location: login.php"); exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong!";
            }
        }
    }
    // redirects to register page if something is not right.
    header("location: register.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="register.php" method="POST">
                        <h3 class="fw-bold text-center">Register</h3>
                        <hr>
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
                            <input type="submit" class="btn btn-danger w-100" name="register" value="Register">
                        </div>
                        <div class="my-3 text-center">
                            <span>Already have an account?</span>
                            <a href="login.php" class="btn btn-link text-danger">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>