<?php

class TweetModel extends CI_Model {

    const TABLE_NAME = 'tweets';

    public $id = NULL;
    public $user_id = '';
    public $text = '';
    public $register_date = '';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('security');

        // テーブルが無ければ作る。
        if (!$this->db->table_exists(self::TABLE_NAME))
        {
            createTable();
        }
    }

    // テーブルを新規作成
    function createTable()
    {
        $this->load->dbforge();
        $fields = array(
            'id' => array('type' => 'INT', 'unsigned' => true, 'auto_increment' => true),
            'user_id' => array('type' => 'INT', 'unsigned' => true),
            'text' => array('type' =>'VARCHAR', 'constraint' => '140'),
            'register_date' => array('type' => 'DATETIME')
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table(self::TABLE_NAME);
    }

    // ツイートを追加してツイートデータを返す
    function addTweet($user_id, $text)
    { 
        $this->user_id = $user_id;
        $this->text = $text;
        $this->register_date = date("Y-m-d H:i:s", time());

        $this->db->insert(self::TABLE_NAME, $this);
        $this->id = $this->db->insert_id();
        return $this;
    }

    // 全てのツイートを取得。
    function getAllTweets($desc)
    {
        return $query->result();
    }
}
