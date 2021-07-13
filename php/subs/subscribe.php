<?php 
if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];

$otherUserId = $_POST["id"];

require_once("../../db/connection.php");

try {
    $stmt = $conn->prepare("INSERT INTO subsribes (userId, subscriberId) 
                            values ($userId, $otherUserId)");

    $stmt->execute();                                 
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
$conn = null;
?>
