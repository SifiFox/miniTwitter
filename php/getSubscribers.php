<?
if (session_status() != PHP_SESSION_ACTIVE) session_start();
$userId = $_SESSION["userId"];

require_once("./db/connection.php");

try {
    $userId = 1;
    $sql = "SELECT subscriberId FROM subsribes WHERE userId = $userId";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $subscribersIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arr = [];

    foreach ($subscribersIds as $item){
        foreach ($item as $item2){
            $arr[] = $item2;
        }
    }

    $in = '(' . implode(',', $arr) . ')';

    $sql2 = 'SELECT * FROM users where users.id IN ' . $in;
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);

    
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>