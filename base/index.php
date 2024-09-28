<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="px-4 py-5 m-0 text-center hero">
        <img class="img img-fluid" src="../images/logo256x256.png" alt="Logo" width="100">
        <h1 class="display-5 fw-bold my-3"><?php echo WEBSITE_NAME; ?></h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit veniam voluptas molestiae, cupiditate incidunt laborum aut eveniet similique consequatur blanditiis eius totam consequuntur, possimus quis voluptatibus nostrum delectus sapiente quae.
            </p>
            <a href="about.php" class="btn btn-danger btn-lg px-5">About Us</a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 col-lg-4 my-2">
                <div class="box product">
                    <img src="../images/placeholder.png" class="img img-fluid mb-4 rounded shadow mx-auto d-block">
                    <h3 class="fw-bold">Product 1</h3>
                    <hr>
                    <p>
                        <?php
                            $para = "Lorem ipsum dolor sit amet consectetur, adipisicing elit.Lorem ipsum dolor sit amet consectetur, adipisicing elit.Lorem ipsum dolor sit amet consectetur, adipisicing elit.Lorem ipsum dolor sit amet consectetur, adipisicing elit.Lorem ipsum dolor sit amet consectetur, adipisicing elit.Lorem ipsum dolor sit amet consectetur, adipisicing elit."; 
                            echo substr_replace($para, "...", 70); 
                        ?>
                    </p>
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-danger" title="View">View Details</a>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="btn btn-outline-danger" title="Add to cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" class="btn btn-outline-danger" title="Like"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 my-2">
                <div class="box product">
                    <img src="../images/placeholder.png" class="img img-fluid mb-4 rounded shadow mx-auto d-block">
                    <h3 class="fw-bold">Product 2</h3>
                    <hr>
                    <p><?php echo substr_replace($para, "...", 70); ?></p>
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-danger" title="View">View Details</a>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="btn btn-outline-danger" title="Add to cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" class="btn btn-outline-danger" title="Like"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 my-2">
                <div class="box product">
                    <img src="../images/placeholder.png" class="img img-fluid mb-4 rounded shadow mx-auto d-block">
                    <h3 class="fw-bold">Product 3</h3>
                    <hr>
                    <p><?php echo substr_replace($para, "...", 70); ?></p>
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-danger" title="View">View Details</a>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="btn btn-outline-danger" title="Add to cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" class="btn btn-outline-danger" title="Like"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>