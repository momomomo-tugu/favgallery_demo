<!DOCTYPE html>
<html>

<head>
    <title>FAV GALLERY | <?= htmlspecialchars($selectedItem['title']) ?></title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/lightbox.css">
</head>

<body>
    <main class="mainContainer">
        <div class="itemDetail__head">
            <div class="itemDetail__headImage">
                <a href="../../assets/images/<?= htmlspecialchars($selectedItem['image_path']) ?>.png" data-lightbox="image">
                    <img src="../../assets/images/<?= htmlspecialchars($selectedItem['image_path']) ?>.png" alt="<?= htmlspecialchars($selectedItem['title']) ?>の画像" class="itemDetail__image">
                </a>
            </div>
            <div class="itemDetail__headInfo">
                <h2 class="itemDetail__title"><?= htmlspecialchars($selectedItem['title']) ?></h2>

                <ul class="itemDetail__tags">
                    <?php
                    $taglist = explode(",", $selectedItem['tags']);
                    array_shift($taglist);
                    foreach ($taglist as $tag) {
                    ?>
                        <li class="itemDetail__tagList nowrap">
                            <a class="itemDetail__tagLink" href="../../tags/tags_controller/tags_search.php?tag=<?= htmlspecialchars($tag) ?>" class="tagList__link nowrap"># <?= htmlspecialchars($tag) ?></a>
                        </li>
                    <?php } ?>
                    <li class="itemDetail__tagList">
                        <?php
                        if (isset($_SESSION['member_id'])) {
                            if ($_SESSION['member_id'] == $selectedItem['contributor']) {
                                echo '<a href="../items_controller/items_editerForm.php?id=' . $selectedItem['id'] . '">編集</a>';
                            }
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <p class="itemDetail__description">
            <?= htmlspecialchars($selectedItem['description']) ?>
        </p>

        <br>

        <form action="items_detail.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($selectedItem['id']) ?>">
            <div>
                <div class="itemDetail__commentName">
                    <label for="comment__name">投稿者</label><br>
                    <input type="text" name="name" value="匿名" id="comment__name">
                </div>
                <div>
                    <label for="comment">コメント入力欄</label>
                    <textarea name="comment" id="comment" class="itemDetail__commentForm"></textarea>
                </div>
                <div><button class="itemDetail__commentButton" name="comment_submit">投稿する</button></div>
            </div>
        </form>

        <br>

        <table>
            <tr>
                <th>投稿者</th>
                <th>コメント</th>
                <th>日付</th>
            </tr>
            <?php
            foreach ($comments as $comment) {
            ?>
                <tr class="itemDetail__commentline">
                    <td class="itemDetail__commenter"><?= htmlspecialchars($comment['name']) ?></td>
                    <td class="itemDetail__comment"><?= htmlspecialchars($comment['comment']) ?></td>
                    <td class="itemDetail__commentDate"><?= htmlspecialchars($comment['dt']) ?></td>
                </tr>
            <?php } ?>

        </table>
    </main>

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/lightbox.js"></script>
</body>

</html>