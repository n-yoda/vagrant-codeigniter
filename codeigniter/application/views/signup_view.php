<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>ユーザー登録</title>
</head>
<body>
	<h2>ユーザー登録</h2>
	<?php $this->load->helper('form'); ?>
	<?php echo form_open('adduser'); ?>
	メールアドレス
	<?php echo form_input('email', 'nobuki.y@gmail.com'); ?>
	<br/>
	表示名
	<?php echo form_input('username', 'よだ'); ?>
	<br/>
	パスワード
	<?php echo form_password('password', '1456'); ?>
	<br/>
	<?php echo form_submit('submit', '登録'); ?>
	<?php echo form_close(); ?>
</body>
</html>