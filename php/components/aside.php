<aside>
<?php 
$userId = $_SESSION["userId"];
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];

$dbPath = $url == 'http://project1/pages/otherUserPage.php' ? '../db/connection.php' : './db/connection.php';
$unsubscribePath = $url == 'http://project1/pages/otherUserPage.php' ? '../../php/subs/unsubscribe.php' : './php/subs/unsubscribe.php';
include($dbPath);

try {
    $sql = "SELECT subscriberId FROM subsribes WHERE userId = $userId";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $subscribersIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    $users = [];

    if ($subscribersIds) {
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
    }
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
                <aside>
            <div class="top">
                <h4> <i class="fas fa-chevron-left"></i>Друзья</h4>
               <a href="../pages/allUsers.php" class="search-block">Найти новых друзей <i class="fas fa-search"></i> </a>
            </div>
            <form action="" class="friendSearch">
                <input type="text" placeholder="Введите имя" id="nameInput">
                <p>
                  <input type="button" value="Искать" id="search">
                  <input type="button" value="Сбросить" id="reset">
                </p>
            </form>

            <!-- Friend list -->
            <article class="friend-list">
            <?php foreach($users as $user): ?>
                <section class="friend">
                    <div class="friend__miniavatar">
                        <img src="../images/<?=$user['avatar_path'] ?>" alt="" width="70px" height="70px">
                    </div>
                    <div class="friend__info">
                        <span class="friend__name"><?=$user['Firstname']?> <?=$user['Sername']?></span>
                        <form action="<?= $unsubscribePath?>" method="POST">
                        <input type="submit" class="friend__input" value="Перестать читать">
                        <input name='id'type="hidden" value="<?=$user['id']?>">
                        </form>
                    </div>
                </section>
            <?php endforeach; ?>

            </article>
            <div class="bot">
            </div>
        </aside>
            <div class="bot">
            </div>
        </aside>

        <script>
                const searchInput = document.querySelector("#nameInput");
                const friends = <?= json_encode($users)?>;
                const wrapper = document.querySelector(".friend-list");
                function friendBlock(avatarPath, name, friendId) {
                    return `<section class="friend">
                    <div class="friend__miniavatar">
                        <img src="../images/${avatarPath}" alt="" width="70px" height="70px">
                    </div>
                    <div class="friend__info">
                        <span class="friend__name">${name}</span>
                        <form action="<?= $unsubscribePath?>" method="POST">
                        <input type="submit" class="friend__input" value="Перестать читать">
                        <input name='id'type="hidden" value="${friendId}">
                        </form>
                    </div>
                </section>`;
                }

            search.addEventListener("click", () => {
                const result = [];
                friends.forEach(elem => {
                    const fullname = elem.Firstname + " " + elem.Sername;
                    if (fullname.includes(searchInput.value)) {
                        elem.fullname = fullname;
                        result.push(elem);
                    }
                });

                wrapper.innerHTML = "";
                result.forEach(elem => {
                    wrapper.innerHTML += friendBlock(elem.avatar_path, elem.fullname, elem.id)
                }) 
            })
            reset.addEventListener("click", () => {
                wrapper.innerHTML = "";
                searchInput.value = "";
                friends.forEach(elem => {
                    wrapper.innerHTML += friendBlock(elem.avatar_path, elem.Firstname+" "+elem.Sername
                    , elem.id)
                }) 
            })
            </script>