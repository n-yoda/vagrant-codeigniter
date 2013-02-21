<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザー登録</title>
</head>
<body>
    <?= form_open('signup') ?>
        <h2>ユーザー登録</h2>
        メールアドレス
        <?= form_error('email') ?>
        <?= form_input('email', set_value('email')) ?>
        <br/>
        表示名
        <?= form_error('username') ?>
        <?= form_input('username', set_value('username'), 'maxlength="64"') ?>
        <br/>
        パスワード
        <?= form_error('password') ?>
        <?= form_password('password', set_value('password')) ?>
        <br/>
        パスワード確認
        <?= form_error('passconf') ?>
        <?= form_password('passconf', set_value('passconf')) ?>
        <br/>
        <?= form_submit('submit', '登録') ?>
    <?= form_close() ?>

    <p><a href="login">ログイン画面に戻る</a></p>
</body>
</html>