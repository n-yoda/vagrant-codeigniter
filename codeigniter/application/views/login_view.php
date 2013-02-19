<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>ログイン</title>
</head>
<body>
	<h2>ログイン</h2>
	<?php $this->load->helper('form'); ?>
	<?php echo form_open('login'); ?>
	メールアドレス
	<?php echo form_input('email', ''); ?>
	<br/>
	パスワード
	<?php echo form_password('password', ''); ?>
	<br/>
	<?php echo $message . '<br/>'; ?>
	<?php echo form_submit('submit', 'ログイン'); ?>
	<?php 
		echo form_hidden('redirect', $redirect);
		echo form_close();
	?>
</body>
</html>