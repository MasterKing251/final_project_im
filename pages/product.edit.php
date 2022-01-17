 <?php
include '../db/db_conn.php';
include "../auth/auth.check.php";
$pdo = pdo_init();

try {
    $id = $_GET['id'];

    $pdo = pdo_init();

    $records = $pdo->query("SELECT * from products WHERE id = '$id'")->fetchAll(PDO::FETCH_OBJ);
    $records = $records[0];
} catch (PDOException $e) {
    echo "ERROR: {$e->getMessage()}";
}


if (isset($_POST['Save'])) {
    $uploadstatus = true;
    if (empty($_POST['Name']) || empty($_POST['Date']) || empty($_POST['Supplier']) || empty($_POST['Quantity']) || empty($_POST['price']) || empty($_POST['desc'])) {
        $_SESSION['stat'] = [
                'class' => 'danger',
                'message' => "All field must not be empty."
            ];
        $uploadstatus = false;
    }

    if ($uploadstatus) {
        try {
            $Pid = $records->id;
            $PName = $_POST['Name'];
            $PDate = $_POST['Date'];
            $PSupp = $_POST['Supplier'];
            $PQuant = $_POST['Quantity'];
            $price = $_POST['price'];
            $desc= $_POST['desc'];
            $pdo = pdo_init();

            $stmt = $pdo->prepare("UPDATE `products` SET `name`=:Name,`description`=:desc,`price`=:price,`date`=:Date,`supplier`=:Supp,`quantity`=:Quant WHERE id=".$Pid);
            $stmt->bindParam(":Name", $PName);
            $stmt->bindParam(":Date", $PDate);
            $stmt->bindParam(":Supp", $PSupp);
            $stmt->bindParam(":Quant", $PQuant);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":desc", $desc);

            $stmt->execute();
            if ($stmt) {
                $_SESSION['stat'] = [
                    'class' => 'success',
                    'message' => "Update Successfully!"
                ];
                header("Location: products.php");
            }
        } catch (PDOException $e) {
            echo "ERROR: {$e->getMessage()}";
        }
    }
}

 ?>
 <!DOCTYPE html>
 <html>

     <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" href="assets/bootstrap/bootstrap.css">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
             integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
             crossorigin="anonymous" />
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
             integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
             crossorigin="anonymous">
         </script>
         <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
         <script src="https://kit.fontawesome.com/a0261d47fa.js" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
         <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
             integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
             crossorigin="anonymous">
         </script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
             integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
             crossorigin="anonymous">
         </script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
             integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
             crossorigin="anonymous">
         </script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <title>Edit Products</title>
         <link rel="stylesheet" href="../css/edit.product.style.css">

     </head>

     <body>
         <div class="container">
             <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id'];?>">
                 <input type="hidden" name="id" value="<?php echo $records->id; ?>">
                 <div class="card w-50 align-items-center mx-auto my-5">
                     <h3 class="card-title">Edit Products</h3>
                     <div class="card-body">
                         <div class="row ">
                             <div class="form-group mt-2">
                                 <label for="Name">Product Name</label>
                                 <input required type="text" id="Name" name="Name" placeholder="Product Name"
                                     class="form-control" value="<?php echo $records->name; ?>">
                             </div>

                             <div class="form-group mt-2">
                                 <label for="Date">Product Date</label>
                                 <input type="Date" id="Date" name="Date" placeholder="Date" class="form-control"
                                     value="<?php echo $records->date; ?>">
                             </div>


                             <div class="form-group mt-2">
                                 <label for="Supplier">Product Supplier</label>
                                 <input required type="text" id="Supplier" name="Supplier"
                                     placeholder="Product Supplier" class="form-control"
                                     value="<?php echo $records->supplier; ?>">
                             </div>
                             <div class="form-group mt-2">
                                 <label for="Quantity">Product Quantity</label>
                                 <input required type="text" id="Quantity" name="Quantity"
                                     placeholder="Product Quantity" class="form-control"
                                     value="<?php echo $records->quantity; ?>">
                             </div>
                             <div class="form-group mt-2">
                                 <label for="price">Price</label>
                                 <input required type="text" id="price" name="price" placeholder="Product Price"
                                     class="form-control" value="<?php echo $records->price; ?>">
                             </div>
                             <div class="form-group mt-2">
                                 <label for="desc">Product Description"</label>
                                 <input required type="text" id="desc" name="desc" placeholder="Product Description"
                                     class="form-control" value="<?php echo $records->description; ?>">
                             </div>
                         </div>
                         <div class="mt-3 d-flex justify-content-end">
                             <a href="products.php" class="btn btn-secondary mx-2">Cancel</a>
                             <input type="submit" name="Save" class="btn btn-primary" value="Save">

                         </div>
                     </div>
                 </div>
             </form>
         </div>

     </body>

 </html>
