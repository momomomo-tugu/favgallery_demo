<?php
session_start();
require_once('../Member.php');
require_once('../../items/Item.php');

class MembersModel
{

    function csrf()
    {
        $toke_byte = random_bytes(16);
        $csrf_token = bin2hex($toke_byte);
        $_SESSION['csrf_token'] = $csrf_token;
        return array($csrf_token, $_SESSION['csrf_token']);
    }

    private function whois()
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

    private function header()
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
                        <a href="../../tags/tags_controller/tags_form.php" class="header__navigation__globalLink__choices">タグを登録</a>
                        <a href="../../tags/tags_controller/tags_index.php" class="header__navigation__globalLink__choices">タグ一覧</a>
                        <a href="../../members/members_controller/members_index.php" class="header__navigation__globalLink__choices">マイページ</a>
                    </nav>
                </div>
        ';
        echo '<div class="header__whois">';
        echo '<p>ようこそ ' . htmlspecialchars($login_user) . '様</p>';
        echo '<a href="' . $linkUrl . '" class="header__whois__loginout">' . htmlspecialchars($linkWord) . '</a>';
        echo '</div></header>';
    }

    // メンバー追加画面を表示する
    function form()
    {
        $this->header();
        list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
        require_once('membersFormView.php');
    }

    // メンバー追加処理を行う
    function addMember()
    {
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $member_name = $_POST['member_name'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($member_name == '' || $password == '' || $password != $password2) {
                echo '入力項目に間違いがあります';
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $member = new Member();
                $member->member_name = $member_name;
                $member->password = $password;
                if ($member->addMember()) {
                    header('Location: ../../login/login_controller/login_form.php');
                } else {
                    echo '登録に失敗しました。';
                }
            }
        } else {
            echo '不正な遷移です。';
        }
    }

    function membersIndex()
    {
        if (isset($_SESSION['member'])) {
            $this->header();
            list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
            $id = $_SESSION['member_id'];
            $myitem = Item::myItem($id);
            require_once('members_view/membersIndexView.php');
        } else {
            header('Location: ../../login/login_controller/login_form.php');
        }
    }
}
