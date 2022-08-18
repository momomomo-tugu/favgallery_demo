<!DOCTYPE html>
<html>

<head>
    <title>FAV GALLERY | タグ関連アイテム一覧</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/masonry.css">
</head>

<body>
    <main class="mainContainer">
        <?php $tag_name = $_GET['tag']; ?>
        <h2 class="pageTitle"><?= $tag_name ?></h2>
        <div class="masonry-wrap">
            <ul class="masonry-tagsSearchView js-masonry-tagsSearchView">
                <?php foreach ($tagSearch as $relatedItem) { ?>
                    <li class="item js-item">
                        <div class="card">
                            <a href="../../items/items_controller/items_detail.php?id=<?= $relatedItem['id'] ?>">
                                <img src="../../assets/images/<?= htmlspecialchars($relatedItem['image_path']) ?>.png">
                            </a>
                            <p class="thumbnailTitle"><?= htmlspecialchars($relatedItem['title']) ?></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </main>

    <script src="../js/jquery.js"></script>
    <script src="../js/masonry.pkgd.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>