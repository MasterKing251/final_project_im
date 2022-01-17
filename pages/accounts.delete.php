<?php
$page_title = "Delete";
include "../auth/no.auth.check.php";
include "../includes/header.php";




if (!isset($_GET['user_id'])) {
    $_SESSION['status'] = [
        'class' => 'danger',
        'message' => 'You cannot delete this account without an ID.'
    ];
    header("Location: accounts.php");
}
    try {
        $pdo = pdo_init();
        $accounts = $pdo->query("SELECT * FROM user_info WHERE user_info.user_id={$_GET['user_id']}")->fetchAll(PDO::FETCH_OBJ);
       
        

        if (count($accounts) == 0) {
            $_SESSION['status'] = [
            'class' => 'danger',
            'message' => 'ID supplied in deleting the account is invalid.'
        ];
            header("Location: accounts.php");
        }
        $account = $accounts[0];
        $user = $_SESSION['user'];
        if ($account->user_id == $_GET['user_id']) {
            $_SESSION['status'] = [
                'class' => 'success',
                'message' => 'Account successfully deleted.'
            ];
            header('Location: accounts.php');
        }
        
        $accountType;
        $accountId;
        if ($account->user_type == "ADMIN") {
            $accountType="admin_info";
            $accountId = "user_id";
        } elseif ($account->user_type == "EMPLOYEE") {
            $accountType="emp_info";
            $accountId = "user_emp";
        } else {
            $accountType="cash_info";
            $accountId = "user_cash";
        }
        
        $results = $pdo->prepare("DELETE FROM ".$accountType." WHERE user_id=".$account->user_id);
        $results->execute();
        if ($results) {
            try {
                $results = $pdo->prepare("DELETE FROM `user_info` WHERE user_id=".$account->user_id);
                $results->execute();
                if ($results) {
                    $_SESSION['status'] = [
                        'class' => 'success',
                        'message' => 'Account successfully deleted.'
                    ];
                    header('Location: accounts.php');
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
