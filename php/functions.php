<?php

function checkEmail($mail)
{
    require("../db/connection.php");
    $sql = "SELECT `Email` FROM users WHERE `Email`= ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$mail]);

    if ($stmt->rowCount()) {
        $GLOBALS["emailMessage"] = "Такой email уже зарегистрирован";
        $conn = null;

        return true;
    } else {
        $conn = null;
        return false;
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>