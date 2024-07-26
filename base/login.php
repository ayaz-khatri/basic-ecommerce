<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <?php include('../includes/head-contents.php'); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box">
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
                            <input type="submit" class="btn btn-danger w-100" name="submit" value="Login">
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