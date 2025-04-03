<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection
include("../includes/helpers.php");                     // Helper Functions

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <?php include("../includes/head-contents.php"); ?>
</head>
<body>

    <?php include("navbar.php"); ?>
    <?php include("../includes/messages.php"); ?>

    <div class="container mt-1 mb-5">
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col-8">
                        <h3 class="fw-bold my-0">Products</h3>
                    </div>
                    <div class="col-4 text-end">
                        <a href="product-create.php" class="btn btn-outline-danger">Add Product</a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive crud-table">
                <?php 
                // Sql query to get all records
                $sql = "SELECT p.*, c.name AS category FROM products p 
                        INNER JOIN categories c ON c.id = p.category_id 
                        ORDER BY created_at DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0) { ?>
                <table class="table table-striped">
                    <tr class="sticky-header">
                        <th>#</th>
                        <th>Image</th> 
                        <th>Name</th> 
                        <th>Category</th> 
                        <th>Price</th> 
                        <th>Stock</th> 
                        <th>Available</th> 
                        <th>Description</th> 
                        <th>Created</th>
                        <th>Action</th> 
                    </tr>
                    <?php $i = 1; while($product = $result->fetch_assoc()) { ?>
                        <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <img src="<?php echo !empty($product['image']) ? '../uploads/' . $product['image'] : '../images/placeholder.png'; ?>" class="shadow rounded">
                        </td>
                        <td><?php echo $product['name'] ?></td>
                        <td><?php echo $product['category'] ?></td>
                        <td><?php echo $product['price'] ?></td>
                        <td><?php echo $product['stock'] ?></td>
                        <td><?php echo ($product['is_available'] == 1) ? "Yes" : "No" ?></td>
                        <td>
                            <?php 
                                $description = $product['description'];
                                echo strlen($description) > 70 ? substr($description, 0, 70) . '...' : $description;
                            ?>
                        </td>
                        <td><?php echo timestampToCustomHumanReadable(strtotime($product['created_at'])) ?></td>
                        <td class="action-column">
                            <a href="product-view.php?id=<?php echo $product['id'] ?>" class="btn btn-warning btn-sm" title="View"><i class="fa fa-eye"></i></a>
                            <a href="product-update.php?id=<?php echo $product['id'] ?>" class="btn btn-success btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                            <form action="product-delete.php" method="POST" class="d-inline-block">
                                <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-trash btn-sm" title="Delete" onclick="return confirm('Are you sure you want to remove this record?');"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?> 
                </table>
                <?php } else { ?>
                    <span class="fw-bold">No record found!</span>
                <?php } ?>    
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>