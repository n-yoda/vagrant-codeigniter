<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>タイムライン</title>
    <?=link_tag('css/timeline.css') ?>
    <?=link_tag('css/indicator.css') ?>
</head>
<body>
    <?= script_tag_jquery() ?>
    <?= script_tag(base_url('js/timeline.js')) ?>
    <div id="message"></div>

    <div class="menu">
        <?php if($user != null): ?>
            <div class="menu_item"><?= htmlspecialchars($user->username) ?></div>
            <div class="menu_item"><?= htmlspecialchars($user->email) ?></div>
            <a href="logout" class="menu_item white_button">ログアウト</a>
        <?php else: ?>
            <div class="menu_item">ログインしていません。</div>
            <a href="login" class="menu_item white_button">ログイン</a>
        <?php endif; ?>
    </div>

    <?php if($user != null): ?>
        <?= form_open('timeline/tweet', array('id' => 'tweet_form')) ?>
            <div class="tweet_text">
                <?= form_textarea('text', '', 'maxlength="140" placeholder="ツイートする。（Shift+Returnで改行）"') ?>
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
                <pre class="text"><?= htmlspecialchars($tweet->text) ?></pre>
                <div class="date"><?= htmlspecialchars($tweet->date) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="load_trigger">
        <!-- cssによるローディングインディケーター -->
        <div id="circularG">
            <div id="circularG_1" class="circularG"></div>
            <div id="circularG_2" class="circularG"></div>
            <div id="circularG_3" class="circularG"></div>
            <div id="circularG_4" class="circularG"></div>
            <div id="circularG_5" class="circularG"></div>
            <div id="circularG_6" class="circularG"></div>
            <div id="circularG_7" class="circularG"></div>
            <div id="circularG_8" class="circularG"></div>
        </div>
    </div>

</body>
</html>