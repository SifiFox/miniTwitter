<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["email"])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ./pages/auth.php");
}

require_once("../db/connection.php");

try {
    $sql = "SELECT id, Firstname, Sername, avatar_path from users";
    $sql2 = "SELECT subscriberId from subsribes where userId = {$_SESSION['userId']}";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $subscribers = $stmt2->fetch(PDO::FETCH_BOTH);

    if (!$subscribers) {
        $subscribers = ["nothing"];
    }

    foreach ($result as $key1 => $value1) {
        $fullname = "";
        foreach ($value1 as $key2 => $value2) {
            if ($key2 == "Firstname" || $key2 == "Sername")
                $fullname .= $value2 . " ";

            if ($key2 == "avatar_path")
                $result[$key1][$key2] = "../images/$value2";
        }
        $result[$key1]["fullName"] = $fullname;
    }
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/allUsers.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="../fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="../css/posts.css">
</head>

<body>
    <div class="container">
        <div class="main-content">
            <?php require_once("../php/components/header.php") ?>
            <main>
                <?php
                    foreach ($result as $key1 => $arr) {
                        if ($_SESSION["userId"] == $arr['id']) {
                            continue;
                        }
                        $elem = "<section class='user'>
                        <div class='user__miniavatar'>
                            <img src='../images/{$arr['avatar_path']}' width='70px' height='70px'>
                        </div>
                        <div class='user__info'>
                            <form action='./otherUserPage.php' method='post'>
                            <input type='hidden' name='userId' value='{$arr['id']}'>
                            <button class='user__name'>{$arr['fullName']}</button>
                            </form>";
                       
                        $elem .= "</div></section>";
                            
                        echo $elem;
                    }
                ?>
            </main>
            <footer>
            </footer>
        </div>
    </div>
    <script>
        function subscribe(userId) {
            let formData = new FormData();
            formData.append("id", userId);

            fetch("../php/subs/subscribe.php", {
                method: "POST",
                body: formData
            });
        }

        function unsubscribe(userId) {
            let formData = new FormData();
            formData.append("id", userId);

            fetch("../php/subs/unsubscribe.php", {
                method: "POST",
                body: formData
            });
        }
    </script>
</body>

</html>