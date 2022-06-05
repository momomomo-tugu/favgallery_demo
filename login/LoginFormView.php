<!DOCTYPE html>

<head>
  <title>FAV GALLERY | ログイン</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<html>

<body>
  <header class="header">
    <h1 class="header__mainTitle"><a href="../../items/items_controller/items_index.php" class="header__indexLink">FAV GALLERY</a></h1>
    <p>ようこそ ゲスト様</p>
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
      </div>
      <div class="loginButton__wrapper">
        <button class="loginButton">ログイン</button>
      </div>
      <a href="../../members/members_controller/members_form.php" class="memberRegistButton">初めての方はこちら</a>
    </form>
  </main>

</body>

</html>