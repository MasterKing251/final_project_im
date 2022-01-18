<?php
$page_title = "Accounts";
include "../auth/auth.check.php";
include "../includes/header.php";
include "assets/navbar.php";

$accounts = [];
$user = $_SESSION["user"];
try {
    $pdo = pdo_init();
    $accounts = $pdo->query('SELECT * from user_info')->fetchAll((PDO::FETCH_OBJ));
    $admin = $pdo->query('SELECT * from admin_info where user_id='.$user->user_id)->fetchAll((PDO::FETCH_OBJ));
} catch (PDOException $e) {
    $error = "Errors: {$e->getMessage()} ";
}

?>
<div class="content">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h1 style="text-transform: capitalize;" class="  fontSize display-4 ">
                    <div class="title text-center">Accounts</div>

                </h1>

                <hr class="mb-2">
                <?php if (count($accounts)> 0) { ?>
                <table class="table table-bordered  table-lg">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-body ">
                        <?php foreach ($accounts as $account) { ?>
                        <tr class="text-center">
                            <td style="text-transform:uppercase"><?php echo $account->user_id; ?>
                            </td>
                            <td style="text-transform: uppercase;"><?php echo $account->first_name; ?>
                            </td>
                            <td style="text-transform: uppercase;"><?php echo $account->middle_name; ?>
                            </td>
                            <td style="text-transform: uppercase;"><?php echo $account->last_name; ?>
                            </td>
                            <td style="text-transform: uppercase;"><?php echo $account->user_type; ?>
                            </td>
                            <td class="text-center">
                                <div class="">

                                    <?php
                if (count($admin) == 0) { ?>
                                    <a href="accounts.view.php?user_id=<?php echo $account->user_id; ?>"
                                        class="m-.5 btn view btn-lg ">View</a>
                                    <a href="accounts.edit.php?user_id=<?php echo $account->user_id; ?>"
                                        class="m-.5 btn edit btn-lg disabled">Edit</a>
                                    <a href="accounts.delete.php?user_id=<?php echo $account->user_id; ?>"
                                        class="m-.5 btn del btn-lg disabled">Delete</a>
                                    <?php
                } else { ?>
                                    <a href="accounts.view.php?user_id=<?php echo $account->user_id; ?>"
                                        class="m-.5 btn   view btn-lg">View</a>
                                    <a href="accounts.edit.php?user_id=<?php echo $account->user_id; ?>"
                                        class="m-.5 btn  edit btn-lg">Edit</a>
                                    <a href="accounts.delete.php?user_id=<?php echo $account->user_id; ?>"
                                        class="m-.5  btn del btn-lg">Delete</a>
                                    <?php
                }
            ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="alert alert-warning">
                    No Account found
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</body>

</html>
