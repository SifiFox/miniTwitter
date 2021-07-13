<?
$postId = $_POST["postId"];

if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];
$fname = $_SESSION["firstname"];
$sname = $_SESSION["surname"];
$avatar = $_SESSION["avatar"];

require_once("../db/connection.php");

try {
    $sql = "SELECT comments.content, comments.createdTime, comments.commentId, users.avatar_path ,users.Firstname, users.Sername
    FROM comments
    JOIN users 
    where comments.postId=$postId AND comments.userId=users.id ORDER BY createdTime DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    
     echo json_encode($result);
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>