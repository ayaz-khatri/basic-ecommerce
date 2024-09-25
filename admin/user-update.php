<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection

if(isset($_POST['update']))
{
    // Form inputs
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

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
            // Sql query to update user record
            $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $username, $email, $id);
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
            <div class="col-md-6">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="user-update.php" method="POST">
                        <h3 class="fw-bold text-center">Edit User</h3>
                        <hr>
                        <div class="my-3">
                            <label>Username</label>
                            <input type="hidden" class="form-control" name="id" required value="<?php echo $user['id'] ?>">
                            <input type="text" class="form-control" name="username" required value="<?php echo $user['username'] ?>">
                        </div>
                        <div class="my-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required value="<?php echo $user['email'] ?>">
                        </div>
                        <div class="my-3">
                            <input type="submit" class="btn btn-lg btn-danger w-100" name="update" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>