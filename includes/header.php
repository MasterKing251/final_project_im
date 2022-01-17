<?php
if ($page_title==("OOZ-Dashboard")) {
    include "db/db_conn.php";
} else {
    include "../db/db_conn.php";
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page_title; ?>
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://kit.fontawesome.com/a0261d47fa.js" crossorigin="anonymous"></script>
        <?php if ($page_title == "OOZ-Dashboard") { ?>
        <link rel="stylesheet" href="css/style.css">
        <?php } ?>
        <?php if ($page_title == "Login Page") { ?>
        <link rel="stylesheet" href="../css/login.css">
        <?php } ?>
        <?php if ($page_title == "Register") { ?>
        <link rel="stylesheet" href="../css/register.css">
        <?php } ?>


        <?php if ($page_title == "Accounts") { ?>
        <link rel="stylesheet" href="../css/accounts.css">
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>
        <?php if ($page_title == "Order") { ?>
        <link rel="stylesheet" href="../css/style_order.css">
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>
        <?php if ($page_title == "Pay Order") { ?>
        <link rel="stylesheet" href="../css/style_order.css">
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>
        <?php if ($page_title == "View Account") { ?>
        <link rel="stylesheet" href="../css/viewAccount.css">
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>
        <?php if ($page_title == "Edit Account") { ?>
        <link rel="stylesheet" href="../css/viewAccount.css">
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>
        <link rel="stylesheet" href="css/navbar.css">
        <?php
         ?>
        <?php if ($page_title == "Sales") { ?>
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>
        <?php if ($page_title == "Products") { ?>
        <link rel="stylesheet" href="../css/navbar.css">
        <?php } ?>





    </head>

    <body>
