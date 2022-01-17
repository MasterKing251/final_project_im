<?php
$page_title = "Edit Account";
include "../auth/no.auth.check.php";
include "../includes/header.php";
include "assets/navbar.php";


if (!isset($_GET['user_id'])) {
    $_SESSION['status']=[
        'class' => 'danger',
        'message' => 'Edit page must accept an ID'
    ];
    header('Location: accounts.php');
} else {
    try {
        $pdo = pdo_init();
        $accounts = $pdo->query("SELECT * FROM user_info WHERE user_id={$_GET['user_id']}")->fetchAll(PDO::FETCH_OBJ);
    
        if (count($accounts) ==0) {
            $_SESSION['status'] = [
                    'class' => 'danger',
                    'message' => 'ID supplied in editing is not valid.'
                ];
            header('Location: accounts.php');
        }
    
        $account = $accounts[0];
        $user = $_SESSION['user'];
        if ($account->user_id != $account->user_id && $account->user_id != 1) {
            $_SESSION['status'] = [
                    'class' => 'danger',
                    'message' => 'You cannot edit this Account'
                ];
            header('Location: pages/accounts.php');
        }
    } catch (PDOException $e) {
        $error = "Errors: {$e->getMessage()}";
    }
}
if (isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_num = $_POST['contact_num'];

    try {
        ob_start();
        $query = $pdo->prepare("UPDATE user_info SET first_name=:first_name, middle_name=:middle_name, last_name=:last_name, contact_num=:contact_num WHERE user_info.user_id=".$account->user_id);
    
        $user = $_SESSION['user'];
        $query->bindParam(":first_name", $first_name);
        $query->bindParam(":middle_name", $middle_name);
        $query->bindParam(":last_name", $last_name);
        $query->bindParam(":contact_num", $contact_num);
        if ($query->execute()) {
            $status = [
                    'class' => 'success',
                    'message' => 'The account is updated successfully'
                ];
            $_SESSION['status'] = $status; ?>
<script>
window.location.href = 'accounts.php';
</script>
<?php
        }
    } catch (PDOException $e) {
        $error = "Errors: {$e->getMessage()}";
    }
} ?>
<div class="container col-5">
    <h1 class="display-4">Update Account</h1>
    <br>
    <?php if (isset($error)) {?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php }?>
    <form action="<?php echo $_SERVER['PHP_SELF'].'?user_id='.$_GET["user_id"]; ?>" method="POST">

        <input type="hidden" name="user_id" value="<?php echo $account->user_id; ?>" />
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name"
                value="<?php echo $account->first_name; ?>" required />
            <label for="middle_name">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name"
                value="<?php echo $account->middle_name; ?>" required />
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name"
                value="<?php echo $account->last_name; ?>" required />
            <label for="contact_num">Contact Number</label>

            <input type="text" name="contact_num" id="contact_num" class="form-control" placeholder="Contact Number"
                value="<?php echo $account->contact_num; ?>" required />
        </div>

        <button name="update" type="submit" class="btn edit">Save</button>
        <a href="accounts.php" type="submit" class="btn del">Cancel</a>
    </form>
</div>

</body>

</html>
