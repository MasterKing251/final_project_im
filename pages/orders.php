<?php include '../db/db_conn.php';
include "../auth/auth.check.php";
$pdo = pdo_init();

if (isset($_POST['order'])) {
    $quantity = $_POST['quantity'];
    $id = $_POST['prod_id'];
    
    try {
        $query = $pdo->prepare("INSERT INTO `orders`( `product_id`, `quantity`) VALUES (:id,:quantity)");
        
        $query->bindParam(":id", $id);
        $query->bindParam(":quantity", $quantity);
        
        $result = $query->execute();
        
        if ($result) {
            header("Location: payment.php");
        }
    } catch (PDOException $e) {
        $error = "Errors: {$e->getMessage()}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Order</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="../css/style_products.css" />

        <script>
        $(document).ready(function() {
            $("div#prod").click(function() {
                $.prodName = $(this).find('h5#prod_name').html();
                $.prodPrice = $(this).find('h5#prod_price').html();
                $.prodId = $(this).find('h5#prod_id').html();
                $.prodPrice = $.prodPrice.replace("$ ", "");
                $('#myModal').modal('show');
                $('input#product').val($.prodName);
                $('input#price').val($.prodPrice);
                $('input#prod_id').val($.prodId);
            });
        });
        </script>
        <style>
        body {
            background: rgb(31, 252, 129);
            background: linear-gradient(30deg,
                    rgba(31, 252, 129, 1) 0%,
                    rgba(20, 115, 207, 1) 100%);
            background-size: cover;
            background-attachment: fixed;
        }

        </style>
    </head>

    <body>

        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Product</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <span><b> Name: </b></span><input type="text" id="product" name="product" readonly
                                style="border: 0"><br>
                            <span><b> Price: </b> </span><input type="text" id="price" name="price" readonly
                                style="border: 0">
                            <input hidden type="text" id="prod_id" name="prod_id" readonly style="border: 0">
                            <input type="text" name="quantity" id="quantity" placeholder="Quantity" required>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                            <input type="submit" name="order" id="order" value="Order" class="btn btn-primary " />
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <?php
        $page_title = "Products";
        include "assets/navbar.php" ?>
        <br />
        <div class="container availProd">
            <div class="display-4">Menu</div>
            <br />
            <div class="container coffeeContent">

                <?php
$query = $pdo->prepare("SELECT * FROM products WHERE id");
$query->execute(array());
$list = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($list as $bd) { ?>


                <div class="card" style="width: 18rem" id="prod">

                    <img class="mage" src="../img/<?php echo $bd->file; ?>" alt="" height="200" class="card-img-top">
                    <div class="card-body">
                        <h5 name="prod_id" id="prod_id" hidden><?php echo $bd->id; ?>
                        </h5>
                        <h5 class="card-title" name="<?php echo $bd->name; ?>" id="prod_name"><?php echo $bd->name; ?>
                        </h5>

                        <h5 class="card-title" id="prod_price">P <?php echo number_format($bd->price, 2); ?>
                        </h5>
                        <p class="card-text">
                            <?php echo $bd->description; ?>
                        </p>
                    </div>
                </div>

                <?php }
?>
            </div>
            </br></br>
        </div>
        </br>

    </body>

</html>
