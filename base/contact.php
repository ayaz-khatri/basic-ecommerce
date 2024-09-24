<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box">
                    <?php include("../includes/messages.php"); ?>
                    <form action="#">
                        <h3 class="fw-bold text-center">Contact Us</h3>
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
                            <label>Your Message</label>
                            <textarea name="message" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="my-3">
                            <input type="submit" class="btn btn-danger w-100" name="contact" value="Submit">
                        </div>
                        <div class="my-3 box">
                            <div class="row text-center">
                                <div class="col">
                                    <a href="#" class="me-2 h3" data-bs-toggle="tooltip" title="Instagram">
                                        <i class="fa-brands fa-instagram" style="color: #E4405F;"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="me-2 h3" data-bs-toggle="tooltip" title="Facebook">
                                        <i class="fa-brands fa-facebook" style="color: #1877F2;"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="me-2 h3" data-bs-toggle="tooltip" title="Twitter">
                                        <i class="fa-brands fa-x-twitter" style="color: #000000;"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="me-2 h3" data-bs-toggle="tooltip" title="LinkedIn">
                                        <i class="fa-brands fa-linkedin-in" style="color: #0A66C2;"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="me-2 h3" data-bs-toggle="tooltip" title="YouTube">
                                        <i class="fa-brands fa-youtube" style="color: #FF0000;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>