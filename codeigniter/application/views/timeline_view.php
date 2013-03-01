<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>タイムライン</title>
    <?=link_tag('css/timeline.css') ?>
</head>
<body>
    <?= script_tag_jquery() ?>
    <?= script_tag(base_url('js/timeline.js')) ?>

    <div class="menu">
        <?php if($login): ?>
            <div class="menu_item"><?= htmlspecialchars($user->username) ?></div>
            <div class="menu_item"><?= htmlspecialchars($user->email) ?></div>
            <a href="logout"><div class="menu_item white_button">ログアウト</div></a>
        <?php else: ?>
            <div class="menu_item">ログインしていません。</div>
            <a href="login"><div class="menu_item white_button">ログイン</div></a>
        <?php endif; ?>
    </div>
    <?php if($login): ?>
        <?= form_open('timeline/tweet', array('id' => 'tweet_form')) ?>
            <div class="tweet_text">
                <?= form_textarea('text', '', 'maxlength="140" placeholder="ツイートする。"') ?>
            </div>
            <div class="tweet_submit">
                <?= form_submit('submit', 'ツイート') ?>
            </div>
        <?= form_close() ?>
    <?php endif; ?>

    <div class="tweets" id="tweets">
        <?php foreach($tweets as $tweet): ?>
            <div class="tweet white_button" id="<?= $tweet->tweet_id ?>">
                <div class="username"><?= htmlspecialchars($tweet->username) ?></div>
                <div class="text"><?= htmlspecialchars($tweet->text) ?></div>
                <div class="date"><?= htmlspecialchars($tweet->date) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="load_trigger"></div>
</body>
</html>