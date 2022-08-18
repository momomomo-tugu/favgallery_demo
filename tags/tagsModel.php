<?php
session_start();
require_once('Tag.php');
require_once('../../Common.php');

class TagsModel extends Common
{
    private function tagsForm()
    {
        // タグ登録画面へ移行
        if (isset($_SESSION['member'])) {
            $this->header();
            list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
            $errorMessage = '';
            require_once('../../tags/tags_view/tagsFormView.php');
        } else {
            header('Location: ../../login/login_controller/login_form.php');
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
                $uri = $_SERVER['HTTP_REFERER'];
                header("Location: " . $uri);
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
