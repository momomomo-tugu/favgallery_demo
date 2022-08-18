<?php
session_start();

require_once('../../Common.php');
require_once('Item.php');
require_once('../../tags/Tag.php');
require_once('../../vendor/autoload.php');

// use \Verot\Upload\Upload;


class ItemsModel extends Common
{
    private function index()
    {
        // アイテム一覧画面へ移行
        $this->header();
        $items = Item::allItem();
        require_once('items_view/itemsIndexView.php');
    }

    public function get_index()
    {
        return $this->index();
    }

    function form()
    {
        // アイテム登録画面へ移行
        if (isset($_SESSION['member'])) {
            $this->header();
            list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
            $id = $_SESSION['member_id'];
            $tags = Tag::get_allTags();
            require_once('items_view/itemsFormView.php');
        } else {
            header('Location: ../../login/login_controller/login_form.php');
        }
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
                $handle = new \Verot\Upload\Upload($_FILES['item_image'], 'ja_JP');
                if ($handle->uploaded) {
                    $handle->file_overwrite     = TRUE;
                    $handle->image_resize       = true;
                    $handle->image_convert      = 'png';
                    $handle->file_auto_rename   = false;
                    $handle->file_src_name_body = $image_hash;
                    $handle->image_ratio_y      = true;
                    $handle->image_x            = 920;
                }

                $handle->process('../../assets/images/');
                if ($handle->processed) {
                    // var_dump($handle);
                    $handle->clean();
                } else {
                    echo '写真の登録に失敗しました';
                    echo 'error : ' . $handle->error;
                }
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

    function itemEditerForm()
    {
        $id = $_GET['id'];

        $this->header();
        list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
        $selectedItem = Item::getItem($id);
        $tags = Tag::get_allTags();
        require_once('items_view/itemsEditerView.php');
    }

    function itemEditer()
    {
        // アイテム更新
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $item_id          = $_POST['item_id'];
            $item_contributor = $_POST['contributor'];
            $item_title       = $_POST['item_title'];
            $item_description = $_POST['item_description'];
            $item_tag         = $_POST['tags'];
            $item_release     = $_POST['release'];

            $item_taglist = implode(",", $item_tag);

            $item = new Item();
            $item->id          = $item_id;
            $item->contributor = $item_contributor;
            $item->title       = $item_title;
            $item->description = $item_description;
            $item->tags        = $item_taglist;
            $item->release     = $item_release;
            if ($item->itemUpdate()) {
                header('Location: items_editerForm.php?id=' . $item_id);
            } else {
                echo '登録に失敗しました。';
            }
        } else {
            header('Location: items_form.php');
        }
    }

    function itemDelete()
    {
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $id    = $_POST['item_id'];
            $image = $_POST['item_image'];

            $image_path = '../../assets/images/' . $image . '.png';
            $image_deletepath = '../../assets/deletedImages/' . $image . '.png';

            if (rename($image_path, $image_deletepath)) {
                $item = new Item();
                $item->id = $id;
                $item->image = $image;
                if ($item->itemDelete()) {
                    unlink('../../assets/deletedImages/' . $image . '.png');
                    header('Location: ../../members/members_controller/members_index.php');
                } else {
                    rename($image_deletepath, $image_path);
                    echo '削除に失敗しました';
                }
            } else {
                echo '削除に失敗しました';
            }
        }
    }
}
