<?php 

include("../includes/init-session.php");                  // Start Session
include("../includes/check-if-not-loggedin.php");         // Check if user is not loggedin

if(isset($_POST['changePassword']))
{
    include("../includes/db-connection.php");           // Database connection

    // Form inputs
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Data validation
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/"; 
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    else if($newPassword != $confirmPassword)
    {
        // Check if password and confirm password do not match
        $_SESSION['error'] = "Passwords do not match!";
    }
    else if(!preg_match($pattern, $newPassword))
    {
        // check the password pattern
        $_SESSION['error'] = "Password must contain at least one number, one uppercase, one lowercase letter, and at least 8 or more characters!";
    }
    else
    {
        //Sql query to check if email exists in users table
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['userId']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!password_verify($oldPassword, $user['password'])) 
        {
            $_SESSION['error'] = "Password does not match with our records!";
        }
        else
        {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);               // Password Encryption
            // Sql query to update user's password
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashedPassword, $_SESSION['userId']);
            if ($stmt->execute()) 
            {
                $_SESSION['success'] = "Password updated successfully!";
                header("location: change-password.php"); exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong!";
            }
        }
    }
    // redirects to change-password page if something is not right.
    header("location: change-password.php"); exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="change-password.php" method="POST">
                        <h3 class="fw-bold text-center">Change Password</h3>
                        <hr>
                        <div class="my-3">
                            <label>Old Password</label>
                            <input type="text" class="form-control" name="oldPassword" required>
                        </div>
                        <div class="my-3">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="newPassword"  title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                        </div>
                        <div class="my-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirmPassword" required>
                        </div>
                        <div class="my-3">
                            <input type="submit" class="btn btn-danger w-100" name="changePassword" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>