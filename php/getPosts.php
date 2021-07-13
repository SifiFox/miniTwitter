<?

if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];

if (isset($_POST["userId"])) {
    $otherUserid = $_POST["userId"];
} else {
    $otherUserid = $userId;
}


// require_once("./db/connection.php");

try {
    $sql = "select posts.content, posts.countLike, posts.createdTime, posts.postId,users.avatar_path ,users.Firstname, users.Sername, users.Birthday_date, users.Register_date
    from posts, users 
    where posts.userId = $otherUserid AND users.id = $otherUserid order by createdTime asc";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $stmt2 = $conn->prepare("select postId from likes where userId = $userId");
    $stmt2->execute();

    $stmt3 = $conn->prepare("SELECT postId from posts WHERE userId = $userId");
    $stmt3->execute();

    $stmt4 = $conn->prepare("SELECT * from users WHERE id = $otherUserid");
    $stmt4->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ownLike = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $ownPost = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    $otherUserData = $stmt4->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $key1 => $value1) {
        $fullname = "";
        foreach ($value1 as $key2 => $value2) {
            if ($key2 == "Firstname" || $key2 == "Surname")
                $fullname .= $value2 . " ";

            if ($key2 == "avatar_path")
                $result[$key1][$key2] = "../images/$value2";

            if ($key2 == "postId") {
                foreach ($ownLike as $key => $value) {
                    if ($value2 == $ownLike[$key]["postId"]) {
                        $result[$key1]["ownLike"] = "true";
                    }
                }

                foreach ($ownPost as $key => $value) {
                    if ($value2 == $ownPost[$key]["postId"]) {
                        $result[$key1]["ownPost"] = "true";
                    }
                }
            }  
        }
        $result[$key1]["fullName"] = $fullname;
    }
    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>