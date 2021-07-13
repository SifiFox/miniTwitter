<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["email"])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ./pages/auth.php");
}
if (isset($_POST["userId"])) {
    $_SESSION["otherUserId"] = $_POST["userId"];
}
$otherUserId = $_SESSION["otherUserId"];
$userId = $_SESSION["userId"];

require_once("../db/connection.php");

$sql2 = "SELECT id FROM subsribes WHERE userId = $userId AND subscriberId = $otherUserId";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$subscribeId = $stmt2->fetchAll(PDO::FETCH_ASSOC);

require_once("../php/getPosts.php");




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="../css/styles.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="../fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="../css/posts.css">
</head>

<body>
    <div class="container">
    <?php require_once("../php/components/aside.php")?>
        <div class="main-content">
                <?php require_once("../php/components/header.php")?>
            <main>
                <section class="personality">
                    <div class="avatar">
                        <img src="<?php echo '../images/' . $otherUserData[0]['avatar_path']?>" alt="">
                    </div>
                    <div class="info">
                        <h3><?echo "{$otherUserData[0]['Firstname']} {$otherUserData[0]['Sername']}"?></h3>
                        <div class="info-data">
                            <div class="parameters">
                                <p>Дата Рождения:</p>
                                <p>Дата Регистрации:</p>
                            </div>
                            <div class="values">
                                <p><?echo "{$otherUserData[0]['Birthday_date']}"?></p>
                                <p><?echo "{$otherUserData[0]['Register_date']}"?></p>
                            </div>
                        </div>
                        <?php if (!sizeof($subscribeId)): ?>
                            <form action="../php/subs/subscribe.php" method="POST">
                            <input type="submit" class="friend__input" value="Подписаться">
                            <input name='id'type="hidden" value="<?=$otherUserId?>">
                        </form>
                        <?php endif; ?>            
                    </div>
                </section>

                <section class="tape">
                   
                </section>
            </main>
            <footer>
                </footer>
            </div>
        </div>

    <script src="../js/elementFactory.js"></script>
    <script src="../js/eventHandlers.js"></script>
    <script src="../js/function.js"></script>
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