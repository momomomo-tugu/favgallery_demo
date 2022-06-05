<!DOCTYPE html>
<html>

<head>
  <title>FAV GALLERY | トップページ</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/masonry.css">
</head>

<body>
  <main class="mainContainer">
    <div class="masonry-wrap">
      <ul class="masonry-indexView js-masonry-indexView">
        <?php foreach ($items as $item) { ?>
          <li class="item js-item">
            <div class="card">
              <a href="items_detail.php?id=<?= $item['id'] ?>">
                <img src="../../assets/images/<?= htmlspecialchars($item['image_path']) ?>">
              </a>
              <p class="thumbnailTitle"><?= htmlspecialchars($item['title']) ?></p>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>
  </main>

  <script src="../../js/jquery.js"></script>
  <script src="../../js/masonry.pkgd.min.js"></script>
  <script src="../../js/imagesloaded.pkgd.min.js"></script>
  <script src="../../js/main.js"></script>

</body>

</html>