<?php
session_start();
require_once('Item.php');
require_once('../../tags/Tag.php');

class ItemsModel
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
                        <a href="items_index.php" class="header__navigation__indexLink">FAV GALLERY</a>
                    </div>
                    <nav class="header__navigation__globalLink">
                        <a href="items_form.php" class="header__navigation__globalLink__choices">作品を登録</a>
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

    // private function index()
    // {
    //     // アイテム一覧画面へ移行
    //     // $this->header();
    //     $items = Item::allItem();
    //     // $items = new Item();
    //     // $items->allItem();
    //     require_once('items_view/itemsIndexView.php');
    // }

    // public 

    private function index()
    {
        // アイテム一覧画面へ移行
        $this->header();
        // $items = Item::allItem();
        $item = new Item();
        $items = $item->allItem();
        require_once('items_view/itemsIndexView.php');
    }

    public function get_index()
    {
        return $this->index();
    }

    private function form()
    {
        // アイテム登録画面へ移行
        if (isset($_SESSION['member'])) {
            $this->header();
            list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
            $tags = Tag::get_allTags();
            require_once('items_view/itemsFormView.php');
        } else {
            header('Location: ../../login/login_controller/login_form.php');
        }
    }

    public function get_form()
    {
        return $this->form();
    }

    function itemRegister()
    {
        // アイテム登録
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $item_contributor = $_POST['contributor'];
            $item_title = $_POST['item_title'];
            $item_description = $_POST['item_description'];
            $item_image = $_FILES['item_image'];
            $item_tag = $_POST['tags'];
            $item_release = $_POST['release'];

            if ($item_image['size'] == 0) {
                $this->header();
                list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
                $tags = Tag::get_allTags();
                $errorMessage = '!! 画像が選択されていません';
                require_once('items_view/itemsFormView.php');
            } else {
                $image_hash = hash_file('md5', $item_image['tmp_name']);
                move_uploaded_file($item_image['tmp_name'], "../../assets/images/${image_hash}");
                $item_taglist = implode(",", $item_tag);

                $item = new Item();
                $item->contributor = $item_contributor;
                $item->title = $item_title;
                $item->description = $item_description;
                $item->image_path = $image_hash;
                $item->tags = $item_taglist;
                $item->release = $item_release;
                if ($item->itemRegist()) {
                    header('Location: items_index.php');
                } else {
                    echo $item_contributor;
                    echo '登録に失敗しました。';
                }
            }
        } else {
            header('Location: items_form.php');
        }
    }

    private function itemDetail()
    {
        // アイテム詳細画面へ移行

        // コメント登録
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            if (isset($_POST['comment_submit'])) {
                $item_id = $_POST['id'];
                $item_commentName = $_POST['name'];
                $item_comment = $_POST['comment'];
                $comment = new Item();
                $comment->name = $item_commentName;
                $comment->item_id = $item_id;
                $comment->comment = $item_comment;
                if ($comment->commentRegist()) {
                } else {
                    echo '登録に失敗しました。';
                }
            } else {
                header('Location: items_controller/items_form.php');
            }
        }

        // 詳細画面を表示
        if (isset($item_id)) {
            $id = $item_id;
        } else {
            $id = $_GET['id'];
        }
        $this->header();
        list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
        $selectedItem = Item::getItem($id);
        $comments = Item::allComents($id);
        require_once('items_view/itemsDetailView.php');
    }

    public function get_itemDetail()
    {
        return $this->itemDetail();
    }
}
