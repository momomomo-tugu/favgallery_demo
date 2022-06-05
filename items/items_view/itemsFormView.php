<!DOCTYPE html>
<html>

<head>
	<title>FAV GALLERY | 作品登録</title>
	<link rel="stylesheet" href="../../css/style.css">
</head>

<body>
	<main class="mainContainer">
		<h2 class="pageTitle">作品登録</h2>
		<?php
		if (isset($errorMessage)) {
			echo '<p class="errorMessage">' . $errorMessage . '</p>';
		}
		?>
		<form action="items_register.php" method="POST" enctype="multipart/form-data" class="itemRegistForm" onsubmit="return cancelsubmit();">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
			<input type="hidden" name="contributor" value="<?= $_SESSION['member_id'] ?>">
			<div class="formContent">
				<label for="item_title" class="formLabel">タイトル</label><input type="text" name="item_title" id="item_title" class="registFormContent itemTitleForm" value="" />
			</div>
			<div class="formContent">
				<label for="item_description" class="formLabel">説明文</label><textarea name="item_description" id="item_description" class="registFormContent itemDescriptionForm" value=""></textarea>
			</div>
			<div class="formContent">
				<label for="item_image" class="formLabel">画像 <span class="formLabel__span">※必須項目です</span> </label>
				<input type="file" name="item_image" id="item_image" class="registFormContent" value="" />
			</div>
			<div>
				<p class="formLabel">タグ一覧</p>
				<input type="hidden" name="tags[]" value="none">
				<?php foreach ($tags as $tag) { ?>
					<div class="formContent">
						<label class="formlabel">
							<input type="checkbox" name="tags[]" value="<?= $tag['tag_name'] ?>" id="item_tag" class="item_tag">
							<?= $tag['tag_name'] ?>
						</label>
					</div>
				<?php } ?>

			</div>
			<input type="text" name="tag_name" placeholder="タグを追加">
			<input type="submit" value="+" formaction="../../tags/tags_controller/tags_register.php">
			<div class="formContent">
				<p>公開設定</p>
				<input type="radio" name="release" value="y" checked>公開
				<input type="radio" name="release" value="n">非公開
			</div>
			<input type="submit" value="登録" class="registButton">
		</form>

	</main>
</body>

</html>