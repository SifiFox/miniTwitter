<?
$text = htmlspecialchars($_POST["text"]); 
$postId = $_POST["postId"];


$dateNow = new DateTime();
$dateNow = $dateNow->format("Y-m-d H:i:s");


if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];
$fname = $_SESSION["firstname"];
$sname = $_SESSION["surname"];
$avatar = $_SESSION["avatar"];

require_once("../db/connection.php");

try {

    $conn->exec("INSERT INTO comments (userId, postId, content, createdTime) 
                             values('$userId', '$postId','$text', '$dateNow')");

    $stmt = $conn->prepare("select commentId from comments order by commentId DESC limit 1");
    $stmt->execute();
    $comId = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        "fullName" => "$fname $sname",
        "createdTime" => $dateNow,
        "content" => $text,
        "countLike" => 0,
        "commentId" => $comId[0]["commentId"],
        "avatar" => "../images/$avatar"
    ];

    echo json_encode($response);
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>