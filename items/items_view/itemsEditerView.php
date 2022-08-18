<!DOCTYPE html>
<html>

<head>
    <title>FAV GALLERY | <?= htmlspecialchars($selectedItem['title']) ?></title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <main class="mainContainer">
        <h2 class="pageTitle">情報を編集</h2>
        <div class="itemDetail__head">
            <div class="itemDetail__headImage">
                <img src="../../assets/images/<?= htmlspecialchars($selectedItem['image_path']) ?>.png" alt="<?= htmlspecialchars($selectedItem['title']) ?>の画像" class="itemDetail__image">
            </div>
            <div class="itemDetail__headInfo">
                <div class="itemDetail__headInfo__wrapper">
                    <h2 class="itemDetail__title"><?= htmlspecialchars($selectedItem['title']) ?></h2>
                    <p class="itemDetail__description">
                        <?= htmlspecialchars($selectedItem['description']) ?>
                    </p>
                    <ul class="itemDetail__tags">
                        <?php
                        $taglist = explode(",", $selectedItem['tags']);
                        array_shift($taglist);
                        foreach ($taglist as $tag) {
                        ?>
                            <li class="itemDetail__tagList">
                                <a class="itemDetail__tagLink" href="../../tags/tags_controller/tags_search.php?tag=<?= htmlspecialchars($tag) ?>" class="tagList__link"># <?= htmlspecialchars($tag) ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <form action="items_editer.php" method="POST" class="itemEditerForm" onsubmit="return cancelsubmit();">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="item_id" value="<?= $selectedItem['id'] ?>">
            <input type="hidden" name="item_image" value="<?= $selectedItem['image_path'] ?>">
            <input type="hidden" name="contributor" value="<?= $_SESSION['member_id'] ?>">
            <div class="formContent">
                <label for="item_title" class="formLabel">タイトル</label><input type="text" name="item_title" id="item_title" class="registFormContent itemTitleForm" value="<?= $selectedItem['title'] ?>" />
            </div>
            <div class="formContent">
                <label for="item_description" class="formLabel">説明文</label><textarea name="item_description" id="item_description" class="registFormContent itemEditerForm__description" value="<?= $selectedItem['description'] ?>"></textarea>
            </div>
            <div>
                <p class="formLabel">タグ一覧</p>
                <input type="hidden" name="tags[]" value="none">
                <?php foreach ($tags as $tag) { ?>
                    <div class="itemEditerForm__tagBox">
                        <label class="formlabel">
                            <?php if (in_array($tag['tag_name'], $taglist)) { ?>
                                <input type="checkbox" name="tags[]" value="<?= $tag['tag_name'] ?>" id="item_tag" class="itemEditerForm__tagBox__tag" checked>
                            <?php } else { ?>
                                <input type="checkbox" name="tags[]" value="<?= $tag['tag_name'] ?>" id="item_tag">
                            <?php } ?>
                            <span class="itemEditerForm__tagBox__tag"><?= $tag['tag_name'] ?></span>
                        </label>
                    </div>
                <?php } ?>

            </div>
            <input type="text" name="tag_name" placeholder="タグを追加">
            <input type="submit" value="+" formaction="../../tags/tags_controller/tags_register.php">
            <div class="formContent itemEditerForm__release">
                <p class="itemEditerForm__release__title">公開設定</p>
                <?php if ($selectedItem['release_yn'] === 'y') { ?>
                    <input type="radio" name="release" value="y" checked>公開
                    <input type="radio" name="release" value="n">非公開
                <?php } else { ?>
                    <input type="radio" name="release" value="y">公開
                    <input type="radio" name="release" value="n" checked>非公開
                <?php } ?>
            </div>
            <input type="submit" value="更新" class="registButton">

            <input type="hidden" value="<?= $selectedItem['image_path'] ?>">
            <input type="submit" value="削除" class="registButton" id="deleteButton" onclick="return deleteCheck()" formaction="../items_controller/items_delete.php">
        </form>
    </main>

    <script src=" ../../js/jquery-3.5.1.min.js"></script>
    <script>
        function deleteCheck() {
            ret = window.confirm('本当に削除しますか？');
            if (ret == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>

</html>