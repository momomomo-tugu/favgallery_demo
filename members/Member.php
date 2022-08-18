<?php

require_once('../../Common.php');

class Member extends Common
{
  static function existCheck($member_name)
  {
    $existCheck = 0;
    try {
      $pdo = self::static_server();
      $stmt = $pdo->prepare('SELECT * FROM members WHERE name=:NAME');
      $stmt->bindParam(':NAME', $member_name);
      $stmt->execute();
      $member = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($member['name'] == $member_name) {
        return 0;
      } else {
        return 1;
      }
    } catch (PDOException $e) {
      var_dump($e);
      return 1;
    }
  }

  function addMember()
  {
    try {
      // メンバーをDBに保存
      $pdo = $this->server();
      $stmt = $pdo->prepare('INSERT INTO members (name,password) VALUES (:MEMBER_NAME, :PASSWORD)');
      $stmt->bindParam(':MEMBER_NAME', $this->member_name);
      $stmt->bindParam(':PASSWORD', $this->password);
      return $stmt->execute();
    } catch (Exception $e) {
      print 'ただいま障害により大変ご迷惑をおかけしております。';
      exit();
    }
  }

  static function find_account($member_name, $password)
  {
    // DB からレコードを引く処理
    $member = array();
    try {
      $pdo = self::static_server();
      $stmt = $pdo->prepare('SELECT * FROM members WHERE name=:MEMBER_NAME');
      $stmt->bindParam(':MEMBER_NAME', $member_name);
      $stmt->execute();
      $member = $stmt->fetch(PDO::FETCH_ASSOC);
      $hashedPassword = $member['password'];
      if (password_verify($password, $hashedPassword)) {
        return $member;
      }
    } catch (PDOException $e) {
      print 'ただいま障害により大変ご迷惑をおかけしております。';
      return false;
    }
  }

  function passReset()
  {
    try {
      // パスワードをアップデート
      $pdo = $this->server();
      $stmt = $pdo->prepare('UPDATE members SET password=:PASSWORD WHERE name=:MEMBER_NAME');
      $stmt->bindParam(':MEMBER_NAME', $this->member_name);
      $stmt->bindParam(':PASSWORD', $this->password);
      return $stmt->execute();
    } catch (Exception $e) {
      print 'ただいま障害により大変ご迷惑をおかけしております。';
      exit();
    }
  }
}
