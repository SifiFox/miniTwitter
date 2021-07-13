<?
$postId = $_POST["postId"];

if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];

require_once("../db/connection.php");

try {
    $conn->exec("DELETE from likes where postId = $postId  AND userId = $userId");
    $conn->exec("DELETE from comments where postId = $postId  AND userId = $userId");
    $conn->exec("DELETE from posts where postId = $postId AND userId = $userId");
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
