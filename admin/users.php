<?php 

include("../includes/init-session.php");                // Start Session
include("../includes/check-if-not-admin.php");          // Check if user is not admin
include("../includes/db-connection.php");               // Database connection
include("../includes/helpers.php");                     // Helper Functions

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users</title>
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
                        <h3 class="fw-bold my-0">Users</h3>
                    </div>
                    <div class="col-4 text-end">
                        <a href="user-create.php" class="btn btn-outline-danger">Add User</a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive crud-table">
                <?php 
                // Sql query to get all users
                $sql = "SELECT * FROM users WHERE role = 'u' ORDER BY created_at DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0) { ?>
                <table class="table table-striped">
                    <tr class="sticky-header">
                        <th>#</th>
                        <th>Image</th> 
                        <th>Username</th> 
                        <th>Email</th> 
                        <th>Created</th>
                        <th>Action</th> 
                    </tr>
                    <?php $i = 1; while($user = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <img src="<?php echo !empty($user['image']) ? '../uploads/' . $user['image'] : '../images/placeholder.png'; ?>" class="shadow rounded">
                        </td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo timestampToCustomHumanReadable(strtotime($user['created_at'])) ?></td>
                        <td class="action-column">
                            <a href="user-view.php?id=<?php echo $user['id'] ?>" class="btn btn-warning btn-sm" title="View"><i class="fa fa-eye"></i></a>
                            <a href="user-update.php?id=<?php echo $user['id'] ?>" class="btn btn-success btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                            <form action="user-delete.php" method="POST" class="d-inline-block">
                                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
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