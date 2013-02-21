<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>タイムライン</title>
</head>
<body>
<?= form_open('') ?>
<h2>ツイート</h2>
<?= validation_errors() ?>

<?= form_input('text', set_value('text')) ?>
<?= form_submit('submit', 'ツイート') ?>
<?= form_close() ?>

<div class="tweets">
</div>

</body>
</html>