<?
$text = $_POST["text"];

$dateNow = new DateTime();
$dateNow = $dateNow->format("Y-m-d H:i:s");


if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];
$fname = $_SESSION["firstname"];
$sname = $_SESSION["surname"];
$avatar = $_SESSION["avatar"];

require_once("../db/connection.php");

try {

    $conn->exec("INSERT INTO posts (userId, content, createdTime) 
                             values('$userId', '$text', '$dateNow')");

    $stmt = $conn->prepare("select postId from posts order by postId DESC limit 1");
    $stmt->execute();
    $postId = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        "fullName" => "$fname $sname",
        "createdTime" => $dateNow,
        "content" => $text,
        "countLike" => 0,
        "postId" => $postId[0]["postId"],
        "avatar_path" => "../images/$avatar"
    ];

    echo json_encode($response);
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>