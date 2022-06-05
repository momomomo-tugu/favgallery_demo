<!DOCTYPE html>
<html>

<head>
  <title>FAV GALLERY | タグ一覧</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
  <main class="mainContainer">
    <h2 class="pageTitle">タグ一覧</h2>
    <p>タグを選択すると関連アイテム一覧を表示します</p>
    <ul>
      <?php foreach ($tags as $tag) { ?>
        <li>
          <a class="tagList__link" href="tags_search.php?tag=<?= htmlspecialchars($tag['tag_name']) ?>">
            <?= htmlspecialchars($tag['tag_name']) ?>
          </a>
        </li>
      <?php } ?>
    </ul>

  </main>

</body>

</html>