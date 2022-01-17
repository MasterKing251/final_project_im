<?php
   
    if (isset($_SESSION['user'])) {
        if ($page_title == "OOZ-Dashboard") {
            header('Location:../index.php');
        } else {
            header('Location:../index.php');
        }
    }
