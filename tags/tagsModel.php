<?php
session_start();
require_once('Tag.php');

class TagsModel
{

    private function csrf()
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

    private function tagsForm()
    {
        // タグ登録画面へ移行
        if (isset($_SESSION['member'])) {
            $this->header();
            list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
            $errorMessage = '';
            require_once('tags_view/tagsFormView.php');
        } else {
            header('Location: ../login/login_controller/login_form.php');
        }
    }

    public function get_tagsForm()
    {
        return $this->tagsForm();
    }

    function tagRegister()
    {
        // タグ登録
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $tag_name = $_POST['tag_name'];

            if (empty($tag_name)) {
                list($login_user, $linkUrl, $linkWord) = $this->whois();
                list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
                $errorMessage = '!! タグ名を入力してください';
                require_once('tags_view/tagsFormView.php');
            } else {
                $tag = new Tag();
                $tag->tag_name = $tag_name;
                if ($tag->set_tagRegist()) {
                    $uri = $_SERVER['HTTP_REFERER'];
                    header("Location: " . $uri);
                } else {
                    echo '登録に失敗しました。';
                }
            }
        } else {
            header('Location: tags_form.php');
        }
    }

    private function tagsIndex()
    {
        // タグ一覧画面へ移行
        $this->header();
        $tags = Tag::get_allTags();
        require_once('tags_view/tagsIndexView.php');
    }

    public function get_tagsIndex()
    {
        return $this->tagsIndex();
    }

    private function tagSearch()
    {
        // 選択されたタグ名に関連したアイテム一覧画面へ移行
        $this->header();
        $tag_name = $_GET['tag'];
        $tagSearch = Tag::get_searchRelatedItem($tag_name);
        require_once('tags_view/tagsSearchView.php');
    }

    public function get_tagSearch()
    {
        return $this->tagSearch();
    }
}
