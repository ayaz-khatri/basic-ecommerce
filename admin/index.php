<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>

    <div class="container my-5 dashboard-icons">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 my-2">
                <a href="index.php">
                    <div class="box text-center">
                        <img src="../images/dashboard.png">
                        <button class="btn btn-danger w-100 my-3">Dashboard</button>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 my-2">
                <a href="users.php">
                    <div class="box text-center">
                        <img src="../images/users.png">
                        <button class="btn btn-danger w-100 my-3">Users</button>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 my-2">
                <a href="categories.php">
                    <div class="box text-center">
                        <img src="../images/categories.png">
                        <button class="btn btn-danger w-100 my-3">Categories</button>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 my-2">
                <a href="products.php">
                    <div class="box text-center">
                        <img src="../images/products.png">
                        <button class="btn btn-danger w-100 my-3">Products</button>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>