<?php
    if (!isset($_SESSION['user'])) {
        if ($page_title == "OOZ-Dashboard") {
            header('Location:pages/login.php');
        } else {
            header('Location:login.php');
        }
    }
