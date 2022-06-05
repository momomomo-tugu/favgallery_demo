<?php
class Member
{

  private function server()
  {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=hoge;charset=utf8;', 'hogehoge', 'hogehogehoge');
    return $pdo;
  }

  private static function static_server()
  {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=hoge;charset=utf8;', 'hogehoge', 'hogehogehoge');
    return $pdo;
  }

  function addMember()
  {
    try {
      // メンバーをDBに保存
      $pdo = $this->server();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    $staff = array();
    try {
      $pdo = self::static_server();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare('SELECT * FROM members WHERE name=:MEMBER_NAME');
      $stmt->bindParam(':MEMBER_NAME', $member_name);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $hashedPassword = $row['password'];
      if (password_verify($password, $hashedPassword)) {
        $staff = $row;
      }
    } catch (PDOException $e) {
      print 'ただいま障害により大変ご迷惑をおかけしております。';
    }
    return $staff;
  }
}
