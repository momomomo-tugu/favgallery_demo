<!DOCTYPE html>
<html>

<head>
    <title>FAV GALLERY | パスワード再設定</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <main class="mainContainer">
        <p>パスワード再設定</p>
        <form action="members_passReset.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <p>ユーザーネームを入力してください。</p>
            <input type="text" name="member_name">
            <p>パスワードを入力してください。</p>
            <input type="password" name="password">
            <p>パスワードをもう一度入力してください。</p>
            <input type="password" name="password2">
            <div class="loginButton__wrapper">
                <button class="loginButton">登録</button>
            </div>
        </form>
    </main>
</body>

</html>