<?php
include '../db/db_conn.php';
include "../auth/auth.check.php";

try {
    $pdo = pdo_init();
        
    $stmt = $pdo->exec("DELETE FROM products WHERE id = '{$_GET['id']}'");
    if ($stmt) {
        $_SESSION['stat'] = [
                'class' => 'success',
                'message' => "Deleted Successfully!"
            ];
        header("Location: products.php");
    }
} catch (PDOException $e) {
    echo "ERROR: {$e->getMessage()}";
}
