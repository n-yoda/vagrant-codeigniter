<?php
require_once('usermodel.php');

class TweetModel extends CI_Model {

    const TABLE_NAME = 'tweets';

    public $tweet_id = NULL;
    public $user_id = '';
    public $username = '';
    public $text = '';
    public $date = '';

    function __construct()
    {
        parent::__construct();

        // テーブルが無ければ作る。
        if (!$this->db->table_exists(self::TABLE_NAME))
        {
            $this->createTable();
        }
    }

    // テーブルを新規作成
    function createTable()
    {
        $this->load->dbforge();
        $fields = array(
            'tweet_id' => array('type' => 'INT', 'unsigned' => true, 'auto_increment' => true),
            'user_id' => array('type' => 'INT', 'unsigned' => true),
            'text' => array('type' =>'VARCHAR', 'constraint' => '140'),
            'register_date' => array('type' => 'DATETIME')
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('tweet_id', true);
        $this->dbforge->create_table(self::TABLE_NAME);
    }

    // ツイートを追加して成功したらtrueを返す
    function addTweet($user_id, $text)
    {
        $tweet = array(
            'user_id' => $user_id,
            'text' => $text,
            'register_date' => date("Y-m-d H:i:s", time()),
        );
        $this->db->insert(self::TABLE_NAME, $tweet);
        return true;
    }

    // ツイートの取得。
    // tweet_id $compare $id という条件で探す。
    function getTweets($count, $desc = true, $id = '', $compare = '=')
    {
        $userTable = UserModel::TABLE_NAME;
        $tweetTable = self::TABLE_NAME;
        $this->db->select("tweet_id, user_id, text, {$tweetTable}.register_date as date, username");
        if (!empty($id)) {
            $this->db->where('tweet_id ' . $compare, $id);
        }
        $this->db->from($tweetTable);
        $this->db->join($userTable, "{$userTable}.id = {$tweetTable}.user_id", 'inner');
        $this->db->order_by('tweet_id', $desc ? 'desc' : 'asc');
        $this->db->limit($count);

        return $this->db->get();
    }

    // 指定したidより古いツイートを取得。
    function getOlderTweets($id, $count, $desc = true)
    {
        return $this->getTweets($count, $desc, $id, '<');
    }

    // 指定したidより新しいツイートを取得。
    function getNewerTweets($id, $count, $desc = true)
    {
        return $this->getTweets($count, $desc, $id, '>');
    }
}
