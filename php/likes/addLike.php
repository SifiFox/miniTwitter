<?
$postId = $_POST["postId"];

if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];

require_once("../../db/connection.php");

try {

    $conn->exec("INSERT INTO likes (postId, userId) 
                             values('$postId', '$userId')");

    
    $conn->exec("UPDATE posts set countLike = countLike + 1 where postId = $postId");
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
