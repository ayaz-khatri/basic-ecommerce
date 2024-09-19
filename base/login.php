<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-loggedin-user.php");         // Check if user is already loggedin

if(isset($_POST['login']))
{
    include("../includes/db-connection.php");           // Database connection

    // Form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Data validation
    if (empty($email) || empty($password)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
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
            if (password_verify($password, $user['password'])) 
            {
                // User's data is stored in SESSION variable if user is authenticated
                $_SESSION['loggedin'] = true;
                $_SESSION['userId'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['userEmail'] = $user['email'];
                $_SESSION['userRole'] = $user['role'];
                if($user['role'] == 'a')
                {
                    // redirected to admin home page if user's role is admin
                    header("location: ../admin/index.php"); exit();
                }
                else
                {
                    // redirected to site's home page if user's role is not admin
                    header("location: index.php"); exit();
                }
            }
            else
            {
                $_SESSION['error'] = "Password does not match with our records!";
            }
        }
        else
        {
            $_SESSION['error'] = "Email not found!";
        }
    }
    // redirects to login page if something is not right.
    header("location: login.php"); exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="login.php" method="POST">
                        <h3 class="fw-bold text-center">LOGIN</h3>
                        <hr>                        
                        <div class="my-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="my-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="my-3">
                            <input type="submit" class="btn btn-danger w-100" name="login" value="Login">
                        </div>
                        <div class="my-3 text-center">
                            <span>Don't have an account?</span>
                            <a href="register.php" class="btn btn-link text-danger">Register here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>