<?php

class Common
{
    protected function server()
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=hoge;charset=utf8;', 'hogehoge', 'hogehogehoge');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    protected static function static_server()
    {
        // ↓ サーバー環境
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=hoge;charset=utf8;', 'hogehoge', 'hogehogehoge');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    protected function csrf()
    {
        $toke_byte = random_bytes(16);
        $csrf_token = bin2hex($toke_byte);
        $_SESSION['csrf_token'] = $csrf_token;
        return array($csrf_token, $_SESSION['csrf_token']);
    }

    protected function whois()
    {
        if (isset($_SESSION['member'])) {
            $login_user = $_SESSION['member'];
            $linkUrl = '../../login/login_controller/login_logout.php';
            $linkWord = 'ログアウト';
        } else {
            $login_user = 'ゲスト';
            $linkUrl = '../../login/login_controller/login_form.php';
            $linkWord = '会員ログイン';
        }
        return array($login_user, $linkUrl, $linkWord);
    }

    protected function header()
    {
        list($login_user, $linkUrl, $linkWord) = $this->whois();
        echo '
            <header class="header">
                <div class="header__navigation">
                    <div>
                        <a href="../../items/items_controller/items_index.php" class="header__navigation__indexLink">FAV GALLERY</a>
                    </div>
                    <nav class="header__navigation__globalLink">
                        <a href="../../items/items_controller/items_form.php" class="header__navigation__globalLink__choices">作品を登録</a>
                        <a href="../../tags/tags_controller/tags_index.php" class="header__navigation__globalLink__choices">タグ一覧</a>
                        <a href="../../members/members_controller/members_index.php" class="header__navigation__globalLink__choices">マイページ</a>
                    </nav>
                </div>
        ';
        echo '<div class="header__whois">';
        echo '<p><span class="nowrap">ようこそ </span><span class="nowrap">' . htmlspecialchars($login_user) . '様</span></p>';
        echo '<a href="' . $linkUrl . '" class="header__whois__loginout">' . htmlspecialchars($linkWord) . '</a>';
        echo '</div>';

        echo
        '

            <!-- ハンバーガーメニュー -->
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="globalMenuSp">
                <ul>
                    <li>
                        <div class="globalMenuSp__header__whois">
        ';

        echo '<p class="globalMenuSp__welcome"><span class="nowrap">ようこそ </span><span class="nowrap">' . htmlspecialchars($login_user) . '様</span></p>';
        echo '<li class="hover">';
        echo '<a href="' . $linkUrl . '" class="globalMenuSp__loginout">' . htmlspecialchars($linkWord) . '</a>';
        echo '</li>';
        echo '</div>';

        echo '
                    </li>
                    <li class="hamburger__li">
                        <a href="../../items/items_controller/items_form.php" class="header__navigation__globalLink__choices">作品を登録</a>
                    </li>
                    <li class="hamburger__li">
                        <a href="../../tags/tags_controller/tags_index.php" class="header__navigation__globalLink__choices">タグ一覧</a>
                    </li>
                    <li class="hamburger__li">
                        <a href="../../members/members_controller/members_index.php" class="header__navigation__globalLink__choices">マイページ</a>
                    </li>
                </ul>
            </nav>
            <!-- ハンバーガーメニュー -->
            </header>
        ';
    }
}
