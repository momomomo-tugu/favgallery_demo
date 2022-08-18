<?php
session_start();
require_once('../Member.php');
require_once('../../items/Item.php');
require_once('../../Common.php');

class MembersModel extends Common
{
    // メンバー追加画面の表示
    // パスワード再設定画面の表示
    function form($link)
    {
        $this->header();
        list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
        require_once($link);
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
                $existCheck = Member::existCheck($member_name);
                if ($existCheck != 0) {
                    $member = new Member();
                    $member->member_name = $member_name;
                    $member->password = $password;
                    if ($member->addMember()) {
                        header('Location: ../../login/login_controller/login_form.php');
                    } else {
                        echo '登録に失敗しました。';
                    }
                } else {
                    echo '使用できないユーザー名です';
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

    function membersPassReset()
    {
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $member_name = $_POST['member_name'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($member_name == '' || $password == '' || $password != $password2) {
                echo '入力項目に間違いがあります';
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $existCheck = Member::existCheck($member_name);
                if ($existCheck === 0) {
                    $member = new Member();
                    $member->member_name = $member_name;
                    $member->password = $password;
                    if ($member->passReset()) {
                        header('Location: ../../login/login_controller/login_form.php');
                    } else {
                        echo '登録に失敗しました。';
                    }
                } else {
                    echo '使用できないユーザー名です';
                }
            }
        } else {
            echo '不正な遷移です。';
        }
    }
}
