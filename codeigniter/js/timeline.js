
// 初期化
$(document).ready(function(){
    tweetForm = $('#tweet_form');
    tweetText = $('.tweet_text > textarea');
    tweetPrototype = $('#prototype');
    loadTrigger = $('#load_trigger').hide();
    messageBox = $('#message').hide();

    // 自動更新の開始
    setInterval(getNewerTweets, 5000);

    // ローディング中かどうか
    isLoading = false;
    // サーバーから返ってくるツイート数が0ならこれ以上読込しようとしない
    dontLoadMore = false;

    // エンターキーで送信、[alt|shift] + enterで改行
    tweetText.keypress(function(e) {
        if (e.keyCode == 13) { // Enterが押された
            if (e.shiftKey || e.altKey) {

            } else {
                tweetForm.submit();
            }
        }
    });

    // 送信を制御
    tweetForm.submit(function(){
        // フォームを無効にする。
        tweetText.attr("disabled", "disabled");
        // POSTで送信
        $.ajax({
            dataType: 'text',
            url: tweetForm.attr('action'),
            type: tweetForm.attr('method'),
            data: {'text': tweetText.val()},
            error: handleAjaxError,
            success: function(result){
                tweetText.val('');
                getNewerTweets();
            },
            complete: function(){
                tweetText.removeAttr("disabled");
            }
        });
        return false;
    });

    // スクロールに古いツイートの読み込み
    $(window).scroll(function(){
        if (isScrolledIntoView(loadTrigger)) {
            getOlderTweets();
        }
    });
});

// 通信失敗時のメッセージ
function handleAjaxError(xmlHttpRequest, textStatus, errorThrown){
    showMessage(errorThrown);
}

// トースト型のメッセージを表示
function showMessage(message){
    messageBox.text(message);
    var left = $(window).scrollLeft() + $(window).width() / 2 - messageBox.width() / 2;
    var top = $(window).scrollTop() + $(window).height() / 2 - messageBox.height() / 2;
    messageBox.css({left: left, top: top});
    messageBox.fadeIn().delay(2000).fadeOut();
}

// afterの後にtweetsを追加
function insertTweets(tweets, after, animated)
{
    var before = after;
    for (var i = 0; i < tweets.length; i++){
        var clone = tweetPrototype.clone(true);
        var tweet = tweets[i];
        clone.attr('id', tweet.tweet_id);
        clone.find('.username').text(tweet.username);
        clone.find('.text').text(tweet.text);
        clone.find('.date').text(tweet.date);
        clone.insertAfter(before);
        clone.hide();
        clone.animate(animated ? {height:'show', opacity:'show'} : {opacity:'show'});
        before = clone;
    }
}

// 新しいツイートを取得
function getNewerTweets()
{
    if (isLoading) return;
    var newest = tweetPrototype.next();
    var id = 0;
    if (newest.length && $.isNumeric(newest.attr('id')))
        id = newest.attr('id');
    isLoading = true;
    $.ajax({
        dataType: "json",
        url: 'timeline/newer_tweets',
        type: 'POST',
        data: {'id': id},
        success: function(tweets){insertTweets(tweets, tweetPrototype, true);},
        complete: function(){isLoading = false;},
        error: handleAjaxError
    });
}

// 過去のツイートを取得
function getOlderTweets()
{
    if (isLoading || dontLoadMore) return;

    loadTrigger.show();
    var oldest = $('.tweet:last');
    var id = 4294967295;    //MYSQL_MAX_UNSIGNED_INT
    if ($.isNumeric(oldest.attr('id')))
        id = oldest.attr('id');
    isLoading = true;
    $.ajax({
        dataType: "json",
        url: 'timeline/older_tweets',
        type: 'POST',
        data: {'id': id},
        success: function(tweets){
            if (tweets.length == 0)
                dontLoadMore = true;
            else
                insertTweets(tweets, oldest, false);
        },
        complete: function(){
            loadTrigger.hide();
            isLoading = false;
        },
        error: handleAjaxError
    });
}

// 要素のスクロールによる可視不可視判定
function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}