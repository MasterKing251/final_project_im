<?php
$page_title = "View Account";
include "../auth/no.auth.check.php";
include "../includes/header.php";
include "assets/navbar.php";


if (!isset($_GET['user_id'])) {
    $_SESSION['status']=[
        'class' => 'danger',
        'message' => 'View page must accept an ID'
    ];
    header('Location: accounts.php');
}
    try {
        $pdo = pdo_init();
        $accounts = $pdo->query("SELECT * FROM user_info WHERE user_info.user_id={$_GET['user_id']}")->fetchAll(PDO::FETCH_OBJ);
        $admin = $pdo->query('SELECT * from admin_info where user_id='.$user->user_id)->fetchAll((PDO::FETCH_OBJ));

        if (count($accounts) ==0) {
            $_SESSION['status'] = [
                'class' => 'danger',
                'message' => 'The ID supplied in viewing the feedback is not valid'
            ];
            header('Location: feedbacks.php');
        }
        $account = $accounts[0];
    } catch (PDOException $e) {
        $error = "Errors: {$e->getMessage()}";
    }
?>
<div class="container-fluid">

    <?php if (isset($error)) {?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php }?>

    <div class="container">
        <h1 class="display-4">First Name: <?php echo $account->first_name; ?>
        </h1>
        <h1 class="display-4">Middle Name: <?php echo $account->middle_name; ?>
        </h1>
        <h1 class="display-4">Last Name: <?php echo $account->last_name; ?>
        </h1>
        <h1 class="display-4">Contact Number: <?php echo $account->contact_num; ?>
        </h1>
        <h1 class="display-4">Birthdate: <?php echo $account->birth_day; ?>
        </h1>
        <h1 class="display-4">Account Type: <?php echo $account->user_type; ?>
        </h1>

        <hr class="mb-1">
        <div class="all-btn">
            <?php
                if (count($admin) == 0) { ?>
            <a href="accounts.edit.php?user_id=<?php echo $account->user_id; ?>"
                class="btn btn-primary btn-lg disabled">Edit</a>
            <a href="accounts.delete.php?user_id=<?php echo $account->user_id; ?>"
                class=" btn btn-danger btn-lg disabled">Delete</a>
            <?php
                } else { ?>

            <a href="accounts.edit.php?user_id=<?php echo $account->user_id; ?>" class="btn edit btn-lg">Edit</a>
            <a href="accounts.delete.php?user_id=<?php echo $account->user_id; ?>" class="btn del btn-lg">Delete</a>
            <?php
                }
            ?>
            <a href="accounts.php" class="btn view btn-lg">Back</a>
        </div>


    </div>
