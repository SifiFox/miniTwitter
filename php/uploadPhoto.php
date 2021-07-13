<?php
$uploaddir = '../images/';
$jpegRegexp = "/\.jpg$/";
$filename = basename($_FILES["userfile"]["name"]);

$isJPG = preg_match($jpegRegexp, $filename);

if ($isJPG) {
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        if (session_status() != PHP_SESSION_ACTIVE) session_start();
            $userId = $_SESSION["userId"];

            require_once("../db/connection.php");
            try {
                     $conn->exec("UPDATE users set avatar_path = '$filename' where id = $userId");
                     
                     $_SESSION["avatar"] = $filename;

                     header("HTTP/1.1 301 Moved Permanently");
                     header("Location: ../main.php");
             
                }  catch (PDOException $e){
                    echo "Error: " . $e->getMessage();
                    }

            $conn = null;
    } else {
    echo "Сбой фаших фото.\n";
        }
} else {
    echo "Ошибка, только jpg фортам!\n";
}
