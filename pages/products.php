<?php
include '../db/db_conn.php';
include "../auth/auth.check.php";
$pdo = pdo_init();

try {
    $records = $pdo->query("SELECT id, name, date, supplier, quantity from products ORDER BY id ASC")->fetchAll(PDO::FETCH_OBJ);

    if (count($records) > 0) {
        $_SESSION['data'] = $records[0];
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST['Add'])) {
    $uploadstatus = true;
    if (empty($_POST['Name']) || empty($_POST['Date']) || empty($_POST['Supplier']) || empty($_POST['Quantity'])|| empty($_POST['price'])) {
        $_SESSION['stat'] = [
                    'class' => 'danger',
                    'message' => "All field must not be empty."
                ];
        $uploadstatus = false;
    }
    if ($uploadstatus) {
        try {
            $PName = $_POST['Name'];
            $PDate = $_POST['Date'];
            $PSupplier = $_POST['Supplier'];
            $PQuantity = $_POST['Quantity'];
            $price = $_POST['price'];
            $desc=$_POST['desc'];
        
            $conn = pdo_init();
            $stmt = $conn->prepare("INSERT INTO `products`(`name`,`date`, `description`, `price`,  `supplier`, `quantity`) VALUES (:PName,:PDate,:desc,:price,:PSupplier,:PQuantity)");
            $stmt->bindParam(":PName", $PName);
            $stmt->bindParam(":PDate", $PDate);
            $stmt->bindParam(":PSupplier", $PSupplier);
            $stmt->bindParam(":PQuantity", $PQuantity);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":desc", $desc);
            $result = $stmt->execute();
                
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            if (count($data) > 0) {
                $_SESSION['data'] = $data[0];
            }
            if ($result) {
                $_SESSION['stat'] = [
                    'class' => 'success',
                    'message' => "Update Successfully!"
                ];
            }
            header("Location: products.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    echo "<meta http-equiv='refresh' content='0'>";
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
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://kit.fontawesome.com/a0261d47fa.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var search = $("#search").val();
                $.post("function.php", {
                    function: search
                }, function(data, status) {
                    $("#data").html(data);
                });
            });
        });
        </script>
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/style_products.css">
        <title><?php $page_title; ?>
        </title>
    </head>

    <?php $page_title = "Products";
   include "assets/navbar.php";
?>

    <body>
        <?php   $query1 = $pdo->prepare("SELECT * FROM user_info WHERE user_id=".$user->user_id);
                $query1->execute(array());
                $accounts = $query1->fetchAll(PDO::FETCH_OBJ);
                $account = $accounts[0];
                
                if ($account->user_type == "ADMIN" || $account->user_type == "EMPLOYEE") { ?>
        <div class="container">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="modal fade" id="AddProducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="Name">Product Name</label>
                                        <input required type="text" id="Name" name="Name" placeholder="Product Name"
                                            class="form-control">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="price">Product Price</label>
                                        <input required type="text" id="price" name="price" placeholder="Product Price"
                                            class="form-control">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="Date">Product Date</label>
                                        <input required type="Date" id="Date" name="Date" placeholder="Date"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="Supplier">Product Supplier</label>
                                        <input required type="text" id="Supplier" name="Supplier"
                                            placeholder="Product Supplier" class="form-control">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="Quantity">Product Quantity</label>
                                        <input required type="text" id="Quantity" name="Quantity"
                                            placeholder="Product Quantity" class="form-control">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="desc">Description</label>
                                        <input required type="text" id="desc" name="desc" placeholder="Description"
                                            class="form-control">
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="" style="margin-top: 4px;">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="Add" class="btn btn-primary" value="Add">

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="content1">
                <h4 class="text-center display-4 ">Products</h4>
                <div class="w-50 mb-2">

                </div>

                <div class="w-100 d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-primary  btn-lg px-5 py-2 my-2 mx-4" data-toggle="modal"
                            data-target="#AddProducts"
                            style="font-size: 15px; text-transform: uppercase; font-weight: 600;">
                            Add Products
                        </button>
                    </div>
                    <?php if (isset($_SESSION['stat'])) {?>
                    <div class="alert alert-<?php echo $_SESSION['stat']['class']?> mb-0" role="error">
                        <?php echo $_SESSION['stat']['message']; ?>
                    </div>
                    <?php } unset($_SESSION['stat']); ?>
                    <form action="function.php" method="POST">
                        <div class="input-group my-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='bx bx-search-alt-2 py-1'></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search" id="search">
                        </div>
                    </form>
                </div>

                <hr>
                <?php if (count($records) > 0) {?>
                <table class="text-center table table-striped table-bordered  table-sm">
                    <thead>
                        <tr>
                            <th>
                                id
                            </th>
                            <th>
                                Product Name
                            </th>
                            <th>
                                Product Date
                            </th>
                            <th>
                                Product Supplier
                            </th>
                            <th>
                                Product Quantity
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="data">
                        <?php foreach ($records as $record) { ?>
                        <tr>
                            <td>
                                <?php echo $record->id; ?>
                            </td>
                            <td>
                                <?php echo $record->name; ?>
                            </td>
                            <td>
                                <?php echo $record->date; ?>
                            </td>
                            <td>
                                <?php echo $record->supplier; ?>
                            </td>
                            <td>
                                <?php echo $record->quantity; ?>
                            </td>
                            <td class="text-center">
                                <div class="flex">
                                    <a href="product.edit.php?id=<?php echo $record->id;?>"
                                        class="btn edit btn-md ">Edit</a>
                                    <a href="product.delete.php?id=<?php echo $record->id;?>"
                                        class="btn del btn-md mx-1">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <p class="text-center mt-5" style="font-size: 25px;">No Records</p>
                <?php }?>
            </div>

        </div>
        <?php } else {?>
        <div style="color:white;" class="container display-4 text-center">Access Denied</div>
        <?php } ?>
    </body>

</html>
