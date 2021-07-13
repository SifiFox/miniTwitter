<?php
$fnameMessage = $snameMessage = $passMessage = $birthdayMessage = "";
$reg_email = "/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/";
$reg_name = "/^[А-Я][а-я]{1,20}$|^[A-Z][a-z]{1,20}$/";

$emailMessage = "";

require_once("../php/functions.php");
require("../db/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = test_input($_POST["firstname"]);
    $surname = test_input($_POST["surname"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $birthday = test_input($_POST["birthday"]);
}
$validFname = preg_match($reg_name, $firstname);
$validSname = preg_match($reg_name, $surname);
$validPass = !empty($password);
$validBirthday = !empty($birthday);
$validEmail = preg_match($reg_email, $email) && !checkEmail($email);


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
    <div class="popup" id="popup">
        <div>
            <h3>Регистрация</h3>
            <a href="./auth.php">&times;</a>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="signUp" method="POST">

            <label for="email">Email</label>
            <input type="text" placeholder="Email" id="email" value="<? echo $email ?>" name="email">
            <span class="error" id="emailErr"><? echo $emailMessage ?></span>

            <label for="fname">Имя</label>
            <input type="text" placeholder="Имя" id="fname" value="<? echo $firstname ?>" name="firstname">
            <span class="error" id="fnameErr"><?echo $fnameMessage?></span>

            <label for="surname">Фамилия</label>
            <input type="text" placeholder="Фамилия" id="surname" value="<? echo $surname ?>" name="surname">
            <span class="error" id="snameErr"><?echo $snameMessage?></span>

            <label for="password">Пароль</label>
            <input type="password" placeholder="Пароль" id="password" value="<? echo $password ?>" name="password">
            <span class="error" id="passErr"><?echo $passMessage?></span>

            <label for="birthday">Дата Рождения</label>
            <input type="date" id="birthday" value="<? echo $birthday ?>" name="birthday">
            <span class="error" id="birthErr"><?echo $birthdayMessage?></span>

            <input type="submit" value="Зарегистрироваться" id="register">
        </form>
    </div>
    <script src="../js/check.js"></script>
</body>

</html>
<?php
$dateNow = date("y.m.d");

if ( $validFname && $validSname && $validEmail && $validPass && $validBirthday) {
try {

$insertSQL = "INSERT users(Email, Firstname, Sername, Register_date, Birthday_date, Password)
                values (:email, :firstname, :surname, :register_date, :birthday, :pass)";
$params = [
    "email" => $email,
    "firstname" => $firstname,
    "surname" => $surname,
    "register_date" => $dateNow,
    "birthday" => $birthday,
    "pass" => $password,
];
$stmt = $conn->prepare($insertSQL);
$stmt->execute($params);

echo "<script>cangritulateUser() </script>";
} catch(PDOException $e) {
    echo $e->getMessage();
}

$conn = null;
}
?>
<?php

// if ( !$validFname ) {
//     $fnameMessage = "Заполните имя";
// } 
// if ( !$validSname ) {
//     $snameMessage = "Заполните фамилию";
// } 

// if ( !$validPass ) {
//     $passMessage = "Заполните пароль";
// } 
// if ( !$validBirthday ) {
//     $birthdayMessage = "Заполните это поле";
// } 


?>
