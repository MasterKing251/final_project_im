<?php include '../db/db_conn.php';
include "../auth/auth.check.php";
$pdo = pdo_init();

if (isset($_POST['submit'])) {
    $products = $_POST['products'];
    $quantity = $_POST['quantity'];
    var_dump($products);
    // $add = $pdo->prepare("INSERT INTO `sales`(`name`, `price`)
    // VALUES (:name,:price)");
    // $add->bindParam(":name", $pname);
    // $add->bindParam(":price", $price);
    foreach ($products as $product) {
        echo $product;
    }

    // $ok = $add->execute();
    // echo "<meta http-equiv='refresh' content='0'>";
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Order</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <link rel="stylesheet" href="../css/style_order.css" />


        <style>
        body {
            background-image: url(../img/bg_coffee_login.png);
            background-size: cover;
            background-attachment: fixed;
        }

        .del {
            color: white;
            background: #261007;
            border: none;
        }

        .del:hover {
            background: #692307;
            color: #db6f30;
        }

        </style>
    </head>

    <body>



        <?php
        $page_title = "Products";
        include "assets/navbar.php" ?>
        <br />
        <div class="container availProd">
            <div class="title">
                <div class="display-4 text-center">Order Product</div>
                <h2><a href="#" class="btn btn-warning btn-lg">Order</a></h2>
            </div>


            <br />
            <div class="container ">

                <?php
$query = $pdo->prepare("SELECT * FROM inventory WHERE id");
$query->execute(array());
$products = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($products as $product) { ?>

                <div class="form-check">
                    <input style="margin:10px;width: 25px;height:25px" class="form-check-input" type="checkbox"
                        value="<?php echo $product->id; ?>" id="<?php echo $product->id; ?>">
                    <label class="form-check-label" for="<?php echo $product->id; ?>">
                        <h2 hidden><?php echo $product->id; ?>
                        </h2>
                        <h2>
                            P <?php echo number_format($product->price, 2); ?>
                        </h2>
                        <h2><?php echo $product->name; ?>
                        </h2>
                        <form action=""><input class="quantity" type="text" placeholder="#" required></form>

                    </label>

                    <hr>

                </div>
                <?php }
?>

            </div>
        </div>
        </div>
    </body>

</html>
