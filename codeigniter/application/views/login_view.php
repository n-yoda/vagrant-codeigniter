<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>ログイン</title>
</head>
<body>
	<?php $this->load->helper('form'); ?>
	
	<?= form_open('login') ?>
		<h2>ログイン</h2>
		<?php echo (empty($message) ? '' : "$message <br/>"); ?>
		メールアドレス
		<?= form_input('email', '') ?>
		<br/>
		パスワード
		<?= form_password('password', '') ?>
		<br/>
		<?= form_submit('submit', 'ログイン') ?>
		<?= form_hidden('redirect', $redirect) ?>
	<?= form_close() ?>
	
	<p><a href="signup"> もしくは新規登録</a></p>
</body>
</html>