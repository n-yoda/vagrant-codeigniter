<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>ユーザー登録</title>
</head>
<body>
	<?php $this->load->helper('form'); ?>
	<?= form_open('signup') ?>
		<h2>ユーザー登録</h2>
		<?php echo (empty($message) ? '' : "$message <br/>"); ?>
		メールアドレス
		<?= form_input('email', '') ?>
		<br/>
		表示名
		<?= form_input('username', '') ?>
		<br/>
		パスワード
		<?= form_password('password', '') ?>
		<br/>
		<?= form_submit('submit', '登録') ?>
	<?= form_close() ?>

	<p><a href="login">ログイン画面に戻る</a></p>
</body>
</html>