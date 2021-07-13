<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["email"])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ./pages/auth.php");
}

require_once("../db/connection.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/allUsers.css">
    <link rel="stylesheet" href="../css/settings.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="../fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="../css/posts.css">
</head>

<body>
    <div class="container">
        <div class="main-content">
            <?php require_once("../php/components/header.php") ?>
            <main>
                
             <form enctype="multipart/form-data" action="../php/uploadPhoto.php" method="POST" id="photoLoader">
             <!-- <input type="hidden" name="MAX_FILE_SIZE" value="50000" /> -->
             Загрузить фото: <input name="userfile" type="file" />
            <input type="submit" value="Отправить фото" />
</form>
            </main>
            <footer>
            </footer>
        </div>
    </div>
    <script>
       
    </script>
</body>

</html>