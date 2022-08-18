<?php
require_once('../../members/Member.php');
session_start();

class LoginModel extends Common
{

  function form()
  {
    // ログイン画面を表示する
    list($csrf_token, $_SESSION['csrf_token']) = $this->csrf();
    include('LoginFormView.php');
  }

  function login()
  {
    // ログイン処理
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
      $member_name = $_POST['member_name'];
      $password = $_POST['password'];

      $member = Member::find_account($member_name, $password);
      if (!empty($member)) {
        session_regenerate_id();
        $_SESSION['member'] = $member_name;
        $_SESSION['member_id'] = $member['id'];
        header('Location: ../../items/items_controller/items_index.php');
      } else {
        echo 'ログインできませんでした。';
      }
    } else {
      echo '不正な遷移です。';
    }
  }

  function logout()
  {
    // ログアウト処理
    $_SESSION = array();
    if (isset($_COOKIE[session_name()]) == true) {
      setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    header('Location: ../../items/items_controller/items_index.php');
  }
}
