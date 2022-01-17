<?php include '../db/db_conn.php';
include "../auth/auth.check.php";

$pdo = pdo_init();

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sales</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://kit.fontawesome.com/a0261d47fa.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/styles_sales.css">

    </head>
    <?php $page_title = "Sales";
include "assets/navbar.php"?>

    <body>
        <?php
        $user=$_SESSION['user'];
        if ($user) {
            try {
                //join query
                $query = $pdo->prepare("SELECT a.name, b.quantity,a.price  from orders b,products a where a.id=b.product_id");
                $query->execute(array());
                $list = $query->fetchAll(PDO::FETCH_OBJ);

                $query1 = $pdo->prepare("SELECT * FROM user_info WHERE user_id=".$user->user_id);
                $query1->execute(array());
                $accounts = $query1->fetchAll(PDO::FETCH_OBJ);
                $account = $accounts[0];
                //subqueries
                $query2 = $pdo->prepare("SELECT prod1, MAX(total_num)Total FROM ( SELECT a.product_id as prod1, SUM(a.total) AS total_num FROM payment a GROUP BY a.product_id ) as sums ,payment a, products b ");
                $query2->execute(array());
                $mostPops = $query2->fetchAll(PDO::FETCH_OBJ);
                $mostPop = $mostPops[0];
                //join query
                $query3 = $pdo->prepare("SELECT name,product_id,SUM(a.total) AS total_num FROM payment a, products b where a.product_id=b.id GROUP by product_id");
                $query3->execute(array());
                $prodSums = $query3->fetchAll(PDO::FETCH_OBJ);
                $query4 = $pdo->prepare("SELECT name FROM  products  where id=".$mostPop->prod1);
                $query4->execute(array());
                $prodNames = $query4->fetchAll(PDO::FETCH_OBJ);
                $prodName = $prodNames[0];
            } catch (PDOException $e) {
                $error = "Errors: {$e->getMessage()} ";
            }
        }
        if ($account->user_type == "ADMIN" || $account->user_type == "CASHIER") { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-4  text-center">Product with highest sales</h1>
                    <table class="table table-lg">
                        <thead>
                            <tr class="text-center">
                                <th>Product</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hov">
                                <td> <?php echo  $prodName->name; ?>
                                </td>
                                <td> <?php echo $mostPop->Total; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h1 class="display-4 text-center">Sales per Product</h1>

                    <table class="table table-lg">
                        <thead>
                            <tr class="text-center">
                                <th>Product Summary</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prodSums as $prodSum) { ?>
                            <tr class="hov">
                                <td> <?php echo $prodSum->name; ?>
                                </td>
                                <td> <?php echo $prodSum->total_num; ?>
                                </td>
                            </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
        <div class="container">

        </div>
        <div class="container">
            <h1 class="display-4  text-center">Orders</h1>
            <table id="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

    foreach ($list as $bd) { ?>
                    <tr class="hov">
                        <td id="descrName"><?php echo $bd->name; ?>
                        </td>
                        <td id="descr"><span> </span><?php echo $bd->quantity; ?>
                        </td>
                        <td id="descr"><span> </span><?php echo $bd->price* $bd->quantity; ?>
                        </td>
                    </tr><?php }
    ?>
                </tbody>


            </table>

        </div>
        <?php
        } else { ?>
        <div style="color:white;" class="container display-4 text-center">Access Denied</div>

        <?php }?>


    </body>

</html>
