<?php
$page_title = "Register";
include "../auth/no.auth.check.php";
include "../includes/header.php";



if (isset($_POST["submit"])) {
    if ($_POST["password"] != $_POST["confirm_password"]) {
        $errors = "Password in not equal to Confirm Password";
    } else {
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthdate = $_POST["birthdate"];
        $number = $_POST["number"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user_type = $_POST["user_type"];
        
        $userTypeDB;
        $userNameDB;
        if ($user_type == "ADMIN") {
            $userTypeDB = "admin_info";
            $userNameDB = "user_admin";
        } elseif ($user_type == "EMPLOYEE") {
            $userTypeDB = "emp_info";
            $userNameDB = "user_emp";
        } else {
            $userTypeDB = "cash_info";
            $userNameDB = "user_cash";
        }

        try {
            $pdo = pdo_init();
            //insert query
            $query = $pdo->prepare('INSERT into user_info(`first_name`, `last_name`, `middle_name`, `contact_num`, `birth_day`, `user_type`) VALUES(:first_name, :last_name,:middle_name,:number,:birthdate,:user_type)');

            $query->bindParam(":first_name", $first_name);
            $query->bindParam(":last_name", $last_name);
            $query->bindParam(":middle_name", $middle_name);
            $query->bindParam(":number", $number);
            $query->bindParam(":birthdate", $birthdate);
            $query->bindParam(":user_type", $user_type);
           
            $query->execute();
            if ($query) {
                try {
                    $query2 = $pdo->query("SELECT * FROM user_info WHERE user_id=(SELECT max(user_id) FROM user_info)")->fetchAll(PDO::FETCH_COLUMN, 0);
                    $id;
                    foreach ($query2 as $queries) {
                        $id = (int)$queries;
                    }
                    try {
                        $query3 = $pdo->prepare("INSERT into ".$userTypeDB."(`user_id`, `".$userNameDB."`, `password`) VALUES (:user_id,:user_name, :password)");

                        $query3->bindParam(":user_id", $id);
                        $query3->bindParam(":user_name", $username);
                        $query3->bindParam(":password", $password);
                        $query3->execute();
                        if ($query3) {
                            header("Location: login.php");
                        }
                    } catch (PDOException $e) {
                        $errors = $e->getMessage();
                    }
                } catch (PDOException $e) {
                    $errors = $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            $errors = $e->getMessage();
        }
    }
}?>

<?php if (isset($errors)) {?>
<div class="alert alert-danger">
    <?php echo $errors; ?>
</div>
<?php }?>
<div class="container col-8 ">
    <div class="title text-center">Registration Form</div>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <div class="user-details">
            <div class="input-inbox">
                <span class="details">First Name</span>
                <input name="first_name" type="text" placeholder="Enter Your First Name" required>
            </div>
            <div class="input-inbox">
                <span class="details">Middle Name</span>
                <input name="middle_name" type="text" placeholder="Enter Your Last Name">
            </div>
            <div class="input-inbox">
                <span class="details">Last Name</span>
                <input name="last_name" type="text" placeholder="Enter Your Last Name" required>
            </div>
            <div class="input-inbox">
                <span class="details">Birthday</span>
                <input name="birthdate" type="date"" required>
            </div>
            <div class=" input-inbox">
                <span class="details">Phone Number</span>
                <input name="number" type="text" placeholder="Enter Your Number" required>
            </div>
            <div class="input-inbox">
                <span class="details">Username</span>
                <input name="username" type="text" placeholder="Enter Your Username" required>
            </div>
            <div class="input-inbox">
                <span class="details">Password</span>
                <input name="password" type="password" placeholder="Enter Your Password" required>
            </div>
            <div class="input-inbox">
                <span class="details">Confirm Password</span>
                <input name="confirm_password" type="password" placeholder="Confirm Password" required>
            </div>
            <div class="input-inbox">
                <span class="details">Type of Employee</span>
                <select required class="dropdown" id="typeEmp" name="user_type" value="<?php if (isset($_GET['typeEmp'])) {
    echo($_GET['typeEmp']);
} ?>">
                    <option value="" disabled selected hidden class="dropdownTransparent"> Type of
                        Employee
                    </option>
                    <option value="ADMIN" name="typeEmp">Admin</option>
                    <option value="EMPLOYEE" name="typeEmp">Employee</option>
                    <option value="CASHIER" name="typeEmp">Cashier</option>
                </select>
            </div>
            <button id="register" name="submit" type="submit" class="btn-color btn  " data-toggle="modal"
                data-target="#modal1">Register</button>
            <div class="text-center signup "> <a href="login.php">Log in Here!</a>
            </div>
        </div>

    </form>
</div>

</body>



</html>
