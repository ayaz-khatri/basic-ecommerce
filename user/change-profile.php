<?php 

include("../includes/init-session.php");                  // Start Session
include("../includes/check-if-not-user.php");             // Check if not user
include("../includes/db-connection.php");                 // Database connection
include("../includes/helpers.php");                       // Helper Functions

if(isset($_POST['update']))
{
    // Form inputs
    $id = (int) $_SESSION['userId'];
    $username = $_POST['username'];
    $imageName = $_POST['image'];
    $oldImage = $imageName;

    // Data validation
    if (empty($id) || empty($username)) 
    {
        $_SESSION['error'] = "Please fill all fields!";
    } 
    else
    {
        if (!empty($_FILES['img']['name'])) 
        {
            // Uploads image to server
            $imageName = uploadImage($_FILES['img'], "../uploads/", $entityName = "user"); 
            if($imageName == NULL)
            {
                header("location: change-profile.php"); exit();
            }      
            unlink("../uploads/".$oldImage);
        }
        // Sql query to update user record
        $sql = "UPDATE users SET username = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $imageName, $id);
        if ($stmt->execute()) 
        {
            $_SESSION['success'] = "Profile updated successfully!";
            header("location: change-profile.php"); exit();
        }
        else
        {
            $_SESSION['error'] = "Something went wrong!";
        }
    }
    
    // redirects to change-profile page if something is not right.
    header("location: change-profile.php"); exit();
}

// Ensure the ID is an integer
$userId = (int) $_SESSION['userId'];

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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Profile - <?php echo $user['username'] ?></title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="change-profile.php" method="POST" enctype="multipart/form-data">
                        <h3 class="fw-bold text-center">Change Profile</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo !empty($user['image']) ? '../uploads/' . $user['image'] : '../images/placeholder.png'; ?>" class="img img-fluid shadow rounded mt-3 entityImage" id="img">
                                <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control my-3" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="my-3">
                                    <label>Username</label>
                                    <input type="hidden" class="form-control" name="image" value="<?php echo $user['image'] ?>" required>
                                    <input type="text" class="form-control" name="username" required value="<?php echo $user['username'] ?>">
                                </div>
                                <div class="my-3">
                                    <label>Email</label>
                                    <input type="email" disabled class="form-control" name="email" required value="<?php echo $user['email'] ?>">
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