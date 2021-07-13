<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["email"])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ./pages/auth.php");
}

$fname = $_SESSION["firstname"];
$sname = $_SESSION["surname"];
$birthday = $_SESSION["birthday"];
$registerDate = $_SESSION["registerDate"];
$avatar =  $_SESSION["avatar"];

require_once("./db/connection.php");
require_once("./php/getPosts.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="./css/styles.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="./fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="./css/posts.css">
</head>

<body>
    <div class="container">
     <?php require_once("./php/components/aside.php")?>
        <div class="main-content">
                <?php require_once("./php/components/header.php")?>
            <main>
                <section class="personality">
                    <div class="avatar">
                        <img src="../images/<?echo $avatar?>" alt="">
                    </div>
                    <div class="info">
                        <h3><?echo "$fname $sname"?></h3>
                        <div class="info-data">
                            <div class="parameters">
                                <p>Дата Рождения:</p>
                                <p>Дата Регистрации:</p>
                            </div>
                            <div class="values">
                                <p><?echo $birthday?></p>
                                <p><?echo $registerDate?></p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="main-mid">
                    <form action="" class="twit-form">
                        <textarea id="twitInput" placeholder="Что у вас интересного" maxlength="320" name="text"></textarea>
                        <input type="button" value="Опубликовать" id="createPostButton">
                    </form>
                </section>

                <section class="tape">
               
                </section>
            </main>
            <footer>
            </footer>
        </div>
    </div>

    <script src="./js/elementFactory.js"></script>
    <script src="./js/eventHandlers.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
                let obj = <?echo json_encode($result)?>;
                
                obj.forEach(elem => {
                    addPost(elem);
                })

            })
    </script>
</body>

</html>