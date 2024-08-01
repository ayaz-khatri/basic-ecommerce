<?php
/* -------------------------------------------------------------------------- */
/*                       Error / Success alert messages                       */
/* -------------------------------------------------------------------------- */
?>

<div class="container my-3">
    <?php
    // Check if there is an error message stored in the session
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            <?php
            echo $_SESSION['error'];        // output the message
            unset($_SESSION['error']);      // Clear the message from the session
            ?>
        </div>
    <?php } ?>

    <?php
    // Check if there is a success message stored in the session
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            <?php
            echo $_SESSION['success'];      // output the message
            unset($_SESSION['success']);    // Clear the message from the session
            ?>
        </div>
    <?php } ?>
</div>