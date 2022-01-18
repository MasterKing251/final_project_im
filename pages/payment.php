<?php
$page_title = "Pay Order";
 include '../db/db_conn.php';
include "../auth/auth.check.php";
$pdo = pdo_init();



?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php $page_title; ?>
        </title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <link rel="stylesheet" href="../css/style_payment.css" />
        <link rel="stylesheet" href="../css/navbar.css" />

    </head>

    <body>
        <?php
        
        include "assets/navbar.php";
        
        try {
            $lastOrders=$pdo->query("SELECT order_id, product_id FROM orders  ORDER BY order_id DESC  LIMIT 1 ")->fetchAll(PDO::FETCH_OBJ);
            $lastOrder=$lastOrders[0];
            //join query
            $queries = $pdo->query("SELECT a.name,a.price,b.quantity FROM products a,orders b where a.id=".$lastOrder->product_id." and b.order_id=".$lastOrder->order_id)->fetchAll(PDO::FETCH_OBJ);
            $query=$queries[0];
        } catch (PDOException $e) {
            $error = "Errors: {$e->getMessage()}";
        }
        
        ?>
        <br />

        <div class="container col-8 ">
            <div class="title text-center">Payment</div>
            <span class="details">Product Ordered: <?php echo $query->name; ?></span><br>
            <span class="details">Product Quantity: <?php echo $query->quantity; ?></span><br>
            <span class="details">Product Price: P <?php echo $query->price; ?></span><br>
            <span class="details">Total: P <?php echo $query->price * $query->quantity; ?></span><br>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <div class="user-details">
                    <div class="input-inbox">
                        <span class="details">Amount</span>
                        <input name="amount" type="amount" placeholder="Pesos" required>
                    </div>
                </div>
                <button id="pay" name="pay" type="submit" class="btn-color btn  " data-toggle="modal"
                    data-target="#modal1">Pay</button>
    </body>
    <?php
if (isset($_POST['pay'])) {
            $amount = $_POST['amount'];
            //add amount to the customer and create new datas
            $query1 = $pdo->prepare("INSERT INTO customer(amount) VALUES(:amount)");
            $query1->bindParam(":amount", $amount);
            //select latest added customer
            $queries2 = $pdo->query("SELECT cust_id FROM customer  ORDER BY cust_id DESC  LIMIT 1 ")->fetchAll(PDO::FETCH_OBJ);
            $queries = $queries2[0];

            if ($query1->execute()) {
                //calculate the total amount
                $total = $query->price * $query->quantity;
                //add data to the payment table
                $query3 = $pdo->prepare("INSERT INTO `payment`(`cust_id`, `order_id`,`product_id` ,`total`) VALUES (:cust_id,:order_id,:product_id,:total)");
                $query3->bindParam(":cust_id", $queries->cust_id);
                $query3->bindParam(":order_id", $lastOrder->order_id);
                $query3->bindParam(":product_id", $lastOrder->product_id);
                $query3->bindParam(":total", $total);
                $query3->execute();
        
                if ($query3) { ?>
    <script>
    alert("Order created")
    location.replace("orders.php");
    </script>
    <?php
                }
            }
        }?>

</html>
