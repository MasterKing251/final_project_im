<?php
$page_title = "Login Page";
include "../includes/header.php";
include "../auth/no.auth.check.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    

    try {
        $pdo = pdo_init();
        $query = $pdo->prepare("SELECT * from admin_info WHERE admin_info.user_admin=:username AND admin_info.password=:password");

        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();
        $admin = $query->fetchAll(PDO::FETCH_OBJ);
        
        $query = $pdo->prepare("SELECT * from emp_info WHERE emp_info.user_emp=:username AND emp_info.password=:password");

        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();
        $cashier = $query->fetchAll(PDO::FETCH_OBJ);
        
        $query = $pdo->prepare("SELECT * from cash_info WHERE cash_info.user_cash=:username AND cash_info.password=:password");

        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();
        $emp = $query->fetchAll(PDO::FETCH_OBJ);
        
        
        if ($admin) {
            $user = $admin[0];
            $_SESSION['user'] = $user;
            header("Location: ../index.php");
        }
        if ($cashier) {
            $user = $cashier[0];
            $_SESSION['user'] = $user;
            header("Location: ../index.php");
        }
        if ($emp) {
            $user = $emp[0];
            $_SESSION['user'] = $user;
            header("Location: ../index.php");
        } else {
            $errors = "Invalid Username or Password";
        }
    } catch (PDOException $e) {
        $errors = $e->getMessage();
    }
}
?>
<style>

</style>


<div class="body">
    <div class="center">

        <h1>Login</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="text_field">
                <input id="username" name="username" type="text" required placeholder="USERNAME" />

            </div>
            <div class="text_field">
                <input id="password" name="password" type="password" required placeholder="PASSWORD" />

            </div>
            <?php if (isset($errors)) {?>
            <div class="alert alert-danger">
                <?php echo $errors; ?>
            </div>
            <?php }?>
            <button name="login" type="submit" class="submit"> Login </button>

            <div class="signup">
                <a href="register.php">Register here!</a>
            </div>
        </form>
    </div>
</div>
