<?php
include '../db/db_conn.php';
include "../auth/auth.check.php";
$pdo = pdo_init();

if (isset($_POST['delete'])) {
    $ooz_id = $_POST['ooz_id'];
    $imgfile =  $_POST['oldfile'];
    $imgfile =  str_replace(" ", "", $imgfile);
    ;


    $delete = $pdo->prepare('DELETE FROM products WHERE id=:id');
    $delete->bindParam(":id", $ooz_id);
    $ok = $delete->execute();

    unlink("uploads/" . $imgfile);
    echo "<meta http-equiv='refresh' content='0'>";
}



if (isset($_POST['add'])) {
    $ooz_id = $_POST['ooz_id'];
    $ooz_name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $price = str_replace(",", "", $price);
    

    $upload_dir = "uploads/";
    $maxSize    = 10000000;
    $type       = $_FILES["file"]["type"];
    $name       = $_FILES["file"]["name"];
    $tmp_name       = $_FILES["file"]["tmp_name"];
    $fileExtension = explode(".", $name);
    $fileExtension = end($fileExtension);

    $newName = uniqid() . "." . $fileExtension;
    $filePath = $upload_dir . $newName;
    if (empty($name)) {
        echo "Please Select a Image File";
    } elseif ($_FILES["file"]["size"] > $maxSize) {
        echo "Please select max size = 2MB";
    } elseif ($type == "image/jpeg" || $type == "image/png") {
        move_uploaded_file($tmp_name, $filePath);

        $add = $pdo->prepare("INSERT INTO `products`(`id`, `file`, `name`, `description`, `price`)
        VALUES (:id,:file,:name,:desc,:price)");
        $add->bindParam(":id", $ooz_id);
        $add->bindParam(":file", $newName);
        $add->bindParam(":name", $ooz_name);
        $add->bindParam(":desc", $desc);
        $add->bindParam(":price", $price);
        //    echo '<script>alert('.$newName.'); </script>';

        $ok = $add->execute();
       
        // if ($ok) {
        //     echo "Saved to Database";
        // } else {
        //     echo "No saved";
        // }
        echo "<meta http-equiv='refresh' content='0'>";
    }
}





?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>products</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://kit.fontawesome.com/a0261d47fa.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        $(document).ready(function() {
            $("#table tr").click(function() {
                $(this).addClass('selected').siblings().removeClass('selected');
                $.id = $(this).find('td#id').html();
                $.descrName = $(this).find('td#descrName').html();
                $.file = $(this).find('td#file').html();
                $.desc = $(this).find('td#descr').html();
                $.price = $(this).find('td#price').html();

                $.img = $(this).find('td#file').html();;
                $.file = $.file.replace("<img class=\"mage\" src=\"uploads/", "");
                $.file = $.file.replace("\" alt=\"\" width=\"150\">", "");

                $('input#tfile').val($.file);
                $('input#tid').val($.id);
                $('input#tname').val($.descrName);
                $('input#tdesc').val($.desc);
                $('input#tprice').val($.price);




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

        table {
            margin: 1%;
            width: 98%;
            background-color: #663300;
            color: white;
            font-family: arial, sans-serif;
            border-collapse: collapse;

        }

        .selected {
            background-color: rgba(255, 255, 255, 0.2);

        }

        td,
        th {

            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        input[type="checkbox"] {
            transform: scale(0.5, 0.5);

            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .fileUploadInput {
            display: grid;
            grid-gap: 10px;
            position: relative;
            z-index: 1;
            margin-right: 100px;
        }


        .fileUploadInput input {
            position: relative;
            z-index: 1;


            height: 40px;
            border: 1px solid #323262;
            background-color: rgba(0, 0, 0, 0);
            border-radius: 3px;
            font-family: arial, sans-serif;
            font-size: 10pt;
            user-select: none;
            cursor: pointer;
            font-weight: regular;
        }

        .fileUploadInput input[type="file"] {
            padding: 0 gap(m);
        }

        .fileUploadInput input[type="file"]::-webkit-file-upload-button {
            visibility: hidden;
            margin-left: -5px;
            padding: 0;
            height: 40px;
            width: 0;
        }

        .fileUploadInput button {
            position: absolute;
            right: 0;
            bottom: 0;

            width: 40px;
            height: 40px;
            line-height: 0;
            user-select: none;
            color: white;
            background-color: #323262;
            border-radius: 0 3px 3px 0;
            border: none;
            font-family: arial, sans-serif;
            font-size: 1rem;
            font-weight: 800;
        }

        .fileUploadInput button svg {
            width: auto;
            height: 50%;
        }



        @-moz-document url-prefix() {
            .fileUploadInput button {
                display: none
            }
        }

        </style>
    </head>
    <?php $page_title = "products";
    include "assets/navbar.php";
?>

    <body>
        <?php
    $query1 = $pdo->prepare("SELECT * FROM user_info WHERE user_id=".$user->user_id);
    $query1->execute(array());
    $accounts = $query1->fetchAll(PDO::FETCH_OBJ);
    
    $account = $accounts[0];
    if ($account->user_type == "ADMIN" || $account->user_type == "DELIVERY") {
        ?>
        <form method="POST" enctype="multipart/form-data">



            <table>

                <tr>


                    <th style="display:none">ID</th>
                    <th>

                        <div class="row" style="height: 40px;">
                            <div class="col-sm-2" style="margin-top:9px ;">
                                File
                            </div>

                            <div class="col-sm-2">
                                <div class="" style="margin-top: 4px;">
                                    <label for="imgs">
                                        <span class="btn btn-primary"
                                            style="width:130px;height:30px;padding:0%;font-size:13pt;">choose
                                            file</span>
                                        <input title="" type="file" name="file" id="imgs" style="display: none" />
                                    </label>
                                </div>
                            </div>
                        </div>

                    </th>


                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>


                </tr>

                <tr>
                    <td style="display:none">

                        <input type="text" name="ooz_id" id="tid" readonly />
                    </td>
                    <td>
                        <input title="" type="text" id="tfile" name="oldfile" />

                    </td>
                    <td>
                        <input type="text" name="name" id="tname" />
                    </td>
                    <td>
                        <input type="text" name="desc" id="tdesc" />
                    </td>
                    <td style="width: 200px;">

                        <input type="text" name="price" id="tprice" />
                    </td>



                </tr>

            </table>
            <center>
                <div class="btn-group btn-group-sm w-75" style="margin:10px">

                    <input type="submit" name="add" id="insert" value="ADD" class="btn btn-dark "
                        style="width: 100%;" />
                    <input type="submit" name="update" id="update" value="UPDATE" class="btn btn-secondary "
                        style="width: 100%;" />
                    <input type="submit" name="delete" id="delete" value="DELETE" class="btn btn-danger "
                        style="width: 100%;" />
                </div>
                </div>
            </center>
        </form>
        <?php

if (isset($_POST['update'])) {
    $ooz_id = $_POST['ooz_id'];
    $ooz_name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $price = str_replace(",", "", $price);
    $upload_dir = "uploads/";
    $maxSize    = 2000000;
    $type       = $_FILES["file"]["type"];
    $name       = $_FILES["file"]["name"];
    $tmp_name       = $_FILES["file"]["tmp_name"];
    $fileExtension = explode(".", $name);
    $fileExtension = end($fileExtension);
    $newName = '';
    if ($_FILES['file']['size'] == 0) {
        $newName =  $_POST['oldfile'];
        $newName =  str_replace(" ", "", $newName);
        ;
    } else {
        $newName = uniqid() . "." . $fileExtension;

        $filePath = $upload_dir . $newName;
        move_uploaded_file($tmp_name, $filePath);
        $imgName = $pdo->prepare("SELECT  `file` FROM `products` WHERE name=:name ");

        $imgName->bindParam(":name", $ooz_name);
        $ok = $imgName->execute();
        $name = $imgName->fetchColumn();

        unlink("uploads/" . $name);
    }
    $update = $pdo->prepare("UPDATE products SET id=:id,file=:file,name=:name,description=:desc,price=:price WHERE id=:id");
    $update->bindParam(":id", $ooz_id);
    $update->bindParam(":file", $newName);
    $update->bindParam(":name", $ooz_name);
    $update->bindParam(":desc", $desc);
    $update->bindParam(":price", $price);

    $ok = $update->execute();
    echo "<meta http-equiv='refresh' content='0'>";
} ?>
        <table id="table">
            <tr>

                <th style="display:none">ID&emsp;</th>
                <th>Coffee</th>

                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>

            <?php
$query = $pdo->prepare("SELECT * FROM products WHERE id");
        $query->execute(array());
        $list = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($list as $bd) { ?>
            <tr>
                <td id="id" style="display:none"><?php echo $bd->id; ?>
                </td>
                <td id="file"> <img class="mage" src="uploads/<?php echo $bd->file; ?>" alt="" width="150"></td>
                <td id="descrName"><?php echo $bd->name; ?>
                </td>
                <td id="descr"><?php echo $bd->description; ?>
                </td>
                <td id="price"><?php echo number_format($bd->price, 2); ?>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?php
    } else {?>
        <div style="color: white;" class="text-center container display-4">Only employees can access this page</div>
        <?php } ?>
    </body>
    <script>
    $(document).ready(function() {
        $('#imgs').change(function() {
            $val = $(this).val();
            $val = $val.replace(/^.*[\\\/]/, '');
            $('input#tfile').val($val);

        });
    });
    </script>

</html>
