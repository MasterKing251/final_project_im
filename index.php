<?php
$page_title = "OOZ-Dashboard";

include "includes/header.php";
include "auth/auth.check.php";
include "pages/assets/navbar.php";

$user=$_SESSION['user'];
$accounts = [];
try {
    $pdo = pdo_init();
    $accounts = $pdo->query("SELECT * from user_info")->fetchAll((PDO::FETCH_OBJ));
    $products = $pdo->query("SELECT * from products")->fetchAll((PDO::FETCH_OBJ));
} catch (PDOException $e) {
    $error = "Errors: {$e->getMessage()} ";
}

?>

<body>
    <div class="content">
        <h1 class="text-center display-4">Dashboard</h1>
        <div class="tables ">

            <br>
            <div class="container">
                <h2 class="text-center">Accounts</h2>

                <table class="table table-bordered  table-lg">
                    <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>User Type</th>


                        </tr>
                    </thead>
                    <tbody class="table-body ">

                        <?php foreach ($accounts as $account) { ?>
                        <tr class="">
                            <td style="text-transform: uppercase;">
                                <?php echo $account->first_name." ".$account->middle_name." ". $account->last_name;?>
                            </td>
                            <td style="text-transform: uppercase;"><?php echo $account->user_type; ?>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <h2 class="text-center">Products</h2>

                <table class="table table-bordered  table-lg">
                    <thead>
                        <tr class="text-center">
                            <th>Product Name</th>
                            <th>Price</th>


                        </tr>
                    </thead>
                    <tbody class="table-body ">

                        <?php foreach ($products as $product) { ?>
                        <tr class="">
                            <td style="text-transform: uppercase;">
                                <?php echo $product->name;?>
                            </td>
                            <td style="text-transform: uppercase;"><?php echo $product->price; ?>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
