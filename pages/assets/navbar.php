<?php
$user=$_SESSION['user'];

$username;

if (isset($user->user_admin)) {
    $username=$user->user_admin;
} elseif (isset($user->user_emp)) {
    $username=$user->user_emp ;
} elseif (isset($user->user_cash)) {
    $username=$user->user_cash ;
}

?>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img class="image-fluid icon"
                    <?php if ($page_title == "OOZ-Dashboard") { ?> src="img/icons8_java_100px_1.png" alt=" Icon">
                <?php } else { ?>
                src="../img/icons8_java_100px_1.png" alt="OOZ Icon"> <?php } ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            <?php if ($page_title == "OOZ-Dashboard") { ?>href="index.php">
                            <?php
                        } else {?>
                            href="../index.php"> <?php
                        } ?> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            <?php if ($page_title == "OOZ-Dashboard") { ?>href="pages/orders.php">
                            <?php
                        } else {?>
                            href="orders.php"> <?php
                        } ?> Order
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            <?php if ($page_title == "OOZ-Dashboard") { ?>href="pages/accounts.php">
                            <?php
                        } else {?>
                            href="accounts.php"> <?php
                        } ?> Accounts
                        </a>
                    </li>

                    <?php
                        if ($user->user_id) {
                            ;
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            <?php if ($page_title == "OOZ-Dashboard") { ?>href="pages/products.php">
                            <?php
                        } else {?>
                            href="products.php"> <?php
                        } ?> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            <?php if ($page_title == "OOZ-Dashboard") { ?>href="pages/sales.php">
                            <?php
                        } else {?>
                            href="sales.php"> <?php
                        } ?> Sales
                        </a>
                    </li>

                    <li class="nav-item dropdown">

                        <a style="text-transform:uppercase;" class=" nav-link dropdown-toggle active" href="#"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $username ;?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <li>
                                <a class="dropdown-item " aria-current="page"
                                    <?php if ($page_title == "OOZ-Dashboard") { ?> href="pages/logout.php">
                                    <?php
                        } else {?>
                                    href="logout.php"> <?php
                        } ?> Log out
                                </a>

                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
