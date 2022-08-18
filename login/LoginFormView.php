<!DOCTYPE html>

<head>
  <title>FAV GALLERY | ログイン</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<html>

<body>
  <header class="header">
    <div class="header__navigation">
      <div>
        <a href="../../items/items_controller/items_index.php" class="header__navigation__indexLink">FAV GALLERY</a></h1>
      </div>
      <nav class="header__navigation__globalLink">
        <a href="../../items/items_controller/items_form.php" class="header__navigation__globalLink__choices">作品を登録</a>
        <a href="../../tags/tags_controller/tags_form.php" class="header__navigation__globalLink__choices">タグを登録</a>
        <a href="../../tags/tags_controller/tags_index.php" class="header__navigation__globalLink__choices">タグ一覧</a>
        <a href="../../members/members_controller/members_index.php" class="header__navigation__globalLink__choices">マイページ</a>
      </nav>
    </div>
    <div class="header__whois">
      <p>ようこそ ゲスト様</p>
    </div>
  </header>

  <main class="mainContainer">
    <form action="login_action.php" method="POST" class="loginForm">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <div class="formContent">
        <label for="member_name">アカウント</label>
        <input type="text" name="member_name" id="member_name" class="loginFormContent" />
      </div>
      <div class="formContent">
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password" class="loginFormContent" />
        <a href="../../members/members_controller/members_passResetForm.php" class="passResetLink">パスワードを忘れた方はこちら</a>
      </div>
      <div class="loginButton__wrapper">
        <button class="loginButton">ログイン</button>
      </div>
      <a href="../../members/members_controller/members_form.php" class="memberRegistButton">初めての方はこちら</a>
    </form>
  </main>

</body>

</html>