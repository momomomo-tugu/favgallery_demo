<?php

require_once('../../Common.php');

class Item extends Common
{

  static function allItem()
  {
    // 登録されているアイテムの中から公開設定のものをすべて検索
    $items = [];
    try {
      $pdo = self::static_server();
      $stmt = $pdo->prepare('SELECT * FROM items WHERE release_yn="y"');
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($items, $row);
      }
    } catch (PDOException $e) {
      var_dump($e);
    }
    return $items;
  }

  static function getItem($id)
  {
    // 選択したアイテムを検索
    try {
      $selectedItem = [];
      $pdo = self::static_server();
      $stmt = $pdo->prepare('SELECT * FROM items WHERE id=:ID');
      $stmt->bindParam(':ID', $id);
      $stmt->execute();
      $selectedItem = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      var_dump($e);
    }
    return $selectedItem;
  }

  function itemRegist()
  {
    // アイテムをDB に保存
    try {
      $pdo = $this->server();
      $stmt = $pdo->prepare('insert into items (contributor, title, description, image_path, tags, release_yn) values ' .
        ' (:CONTRIBUTOR, :TITLE, :DESCRIPTION, :IMAGE_PATH, :TAGS, :RELEASE)');
      $stmt->bindParam(':CONTRIBUTOR', $this->contributor);
      $stmt->bindParam(':TITLE', $this->title);
      $stmt->bindParam(':DESCRIPTION', $this->description);
      $stmt->bindParam(':IMAGE_PATH', $this->image_path);
      $stmt->bindParam(':TAGS', $this->tags);
      $stmt->bindParam(':RELEASE', $this->release);
      return $stmt->execute();
    } catch (PDOException $e) {
      var_dump($stmt);
      echo $this->contributor;
      return false;
    }
  }

  function commentRegist()
  {
    // コメントをDB に保存
    try {
      $commentInfo = [];
      $pdo = $this->server();
      $stmt = $pdo->prepare('insert into comments (item_id, name, comment, dt) values ' .
        ' (:ITEM_ID, :NAME, :COMMENT, CURRENT_DATE)');
      $stmt->bindParam(':ITEM_ID', $this->item_id);
      $stmt->bindParam(':NAME', $this->name);
      $stmt->bindParam(':COMMENT', $this->comment);
      $commentInfo = $stmt->fetch(PDO::FETCH_ASSOC);
      return $stmt->execute();
    } catch (PDOException $e) {
      var_dump($stmt);
      return false;
    }
    return $commentInfo;
  }

  static function allComents($item_id)
  {
    // 関連付けて登録されているコメントをすべて検索
    $comments = [];
    try {
      $pdo = self::static_server();
      $stmt = $pdo->prepare('SELECT * FROM comments where item_id=:ITEM_ID ORDER BY id DESC');
      $stmt->bindParam(':ITEM_ID', $item_id);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($comments, $row);
      }
    } catch (PDOException $e) {
      var_dump($e);
    }
    return $comments;
  }

  static function myItem($id)
  {
    $myitem = array();
    try {
      $pdo = self::static_server();
      $stmt = $pdo->prepare('SELECT * FROM items where contributor=:MEMBER_ID');
      $stmt->bindParam(':MEMBER_ID', $id);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($myitem, $row);
      }
    } catch (PDOException $e) {
      var_dump($e);
    }
    return $myitem;
  }

  function itemUpdate()
  {
    // アイテムの情報を更新
    try {
      $pdo = $this->server();
      $stmt = $pdo->prepare('UPDATE items SET contributor=:CONTRIBUTOR, title=:TITLE, description=:DESCRIPTION, tags=:TAGS, release_yn=:RELEASE WHERE id=:ID');
      $stmt->bindParam(':ID', $this->id);
      $stmt->bindParam(':CONTRIBUTOR', $this->contributor);
      $stmt->bindParam(':TITLE', $this->title);
      $stmt->bindParam(':DESCRIPTION', $this->description);
      $stmt->bindParam(':TAGS', $this->tags);
      $stmt->bindParam(':RELEASE', $this->release);
      return $stmt->execute();
    } catch (PDOException $e) {
      var_dump($stmt);
      return false;
    }
  }

  function itemDelete()
  {
    // アイテムと関連するコメントを削除
    try {
      $pdo = $this->server();
      $pdo->beginTransaction();
      $del_items = $pdo->prepare('DELETE FROM items WHERE id=:ID');
      $del_items->bindParam(':ID', $this->id);
      $del_items->execute();

      $del_comment = $pdo->prepare('DELETE FROM comments WHERE item_id=:ID');
      $del_comment->bindParam(':ID', $this->id);
      $del_comment->execute();

      $pdo->commit();
      return true;
    } catch (PDOException $e) {
      $pdo->rollBack();
      var_dump($del_items);
      return false;
    }
  }
}
