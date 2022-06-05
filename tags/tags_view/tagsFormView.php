<!DOCTYPE html>
<html>

<head>
  <title>FAV GALLERY | タグ登録</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
  <main class="mainContainer">
    <h2 class="pageTitle">タグ登録</h2>
    <p><?= $errorMessage ?></p>
    <form action="tags_register.php" method="POST" class="tagRegistForm">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <div><label for="tag_name">タグ名</label><br><input type="text" name="tag_name" id="tag_name" class="registFormContent" />
        <div>
          <button class="registButton">登録</button>
    </form>
  </main>
</body>

</html>