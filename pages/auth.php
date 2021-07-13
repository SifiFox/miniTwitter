<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();

require_once("../db/connection.php");
require_once("../php/functions.php");

$errorMessage = "";

if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    $email = $_SESSION["email"];
    $password = $_SESSION["password"]; 
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
}
// check user in db
$sql_check_user = "SELECT * from users where Email = :email AND Password = :pass";
$stmt = $conn->prepare($sql_check_user);
$stmt->execute(['email' => $email, 'pass' => $password]);


$arr = $stmt->fetch(PDO::FETCH_ASSOC);

if ($arr) {
    $_SESSION["userId"] = $arr["id"];
    $_SESSION["email"] = $arr["Email"];
    $_SESSION["firstname"] = $arr["Firstname"];
    $_SESSION["surname"] = $arr["Sername"];
    $_SESSION["birthday"] = $arr["Birthday_date"];
    $_SESSION["password"] = $arr["Password"];
    $_SESSION["registerDate"] = $arr["Register_date"];
    $_SESSION["avatar"] = $arr["avatar_path"];

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ../main.php");
} else if (isset($_POST["logInBtn"]) && !empty($_POST["logInBtn"])) {
    $errorMessage = "Неправильные логин или пароль";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/auth.css">

</head>

<body>
    <div class="search-block" id="main">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="logIn" method="POST">
            <div>
                <input type="text" placeholder="email" title="Введите email" name="email" id="email" value="<? echo $email ?>">
                <input type="password" placeholder="пароль" title="Введите пароль" name="password" id="pass">
                <input type="submit" value="Войти" name="logInBtn"><br>
                <span class="error"><? echo $errorMessage ?></span>
            </div>
        </form>
        <div class="introduction">
            <p>Войди и делись своими впечатлениями</p>
        </div>
        <div class="registration">
            <p>Нету аккаунта?</p>
            <a href="./register.php">Зарегистрироваться</a>
        </div>
    </div>

    <script src="../js/auth.js"></script>
</body>

</html>

<?php


?>