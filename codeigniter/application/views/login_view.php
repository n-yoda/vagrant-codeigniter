<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログイン</title>
</head>
<body>
    <?= form_open('login') ?>
        <h2>ログイン</h2>
        <?= validation_errors() ?>

        メールアドレス
        <?= form_input('email', set_value('email')) ?>
        <br/>

        パスワード
        <?= form_password('password', '') ?>
        <br/>

        <?= form_submit('submit', 'ログイン') ?>
    <?= form_close() ?>
    
    <p><a href="signup"> もしくは新規登録</a></p>
</body>
</html>