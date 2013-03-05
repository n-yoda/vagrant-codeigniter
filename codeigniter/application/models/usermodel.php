<?php

class UserModel extends CI_Model
{

    const TABLE_NAME = 'users';

    public $id = NULL;
    public $email = '';
    public $password_hash = '';
    public $username = '';
    public $register_date = '';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('security');

        // テーブルが無ければ作る。
        if (!$this->db->table_exists(self::TABLE_NAME))
        {
            $this->createTable();
        }
    }

    // テーブルを新規作成
    private function createTable()
    {
        $this->load->dbforge();

        $fields = array(
            'id' => array('type' => 'INT', 'unsigned' => true, 'auto_increment' => true),
            'email' => array('type' => 'VARCHAR', 'constraint' => '256'),
            'username' => array('type' =>'VARCHAR', 'constraint' => '64'),
            'password_hash' => array('type' => 'VARCHAR', 'constraint' => '64'),
            'register_date' => array('type' => 'DATETIME')
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table(self::TABLE_NAME);
    }

    // ユーザーを追加する
    function addUser($email, $username, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password_hash = do_hash($password);
        $this->register_date = date("Y-m-d H:i:s", time());

        $this->db->insert(self::TABLE_NAME, $this);
        $this->id = $this->db->insert_id();
        return $this;
    }

    // ユーザーの情報を取得
    function getUser($id)
    {
        $users = $this->db->get_where(self::TABLE_NAME, array('id' => $id))->result();
        return $users[0];
    }

    // 既にメールアドレスが使われているかどうかチェック
    function isEmailUsed($email)
    {
        $query = $this->db->from(self::TABLE_NAME)->where('email', $email);
        $count = $query->count_all_results();
        return $count > 0;
    }    

    // ログイン出来たらtrueを返す
    function login($email, $password)
    {
        $password_hash = do_hash($password);
        $login_cond = array('email' => $email, 'password_hash' => $password_hash);
        $query = $this->db->get_where(self::TABLE_NAME, $login_cond);

        if ($query->num_rows() > 0) {
            // idのみセッションに保存し、他はその都度データベースアクセス。
            $users = $query->result();
            $user = $users[0];
            $login_data = array('user_id' => $user->id);
            $this->session->set_userdata($login_data);
            return true;
        } else {
            return false;
        }
    }

    // ログアウト
    function logout()
    {
        $this->session->unset_userdata('user_id');
    }

    // ログイン済みかどうか
    function isLoggedIn()
    {
        return $this->getLoggedInUserId() != false;
    }

    // ログイン済みのユーザーデータを返す
    function getLoggedInUser()
    {
        if($this->isLoggedIn())
            return $this->getUser($this->getLoggedInUserId());
        else
            return null;
    }

    // ログイン済みのIDを返す
    function getLoggedInUserId()
    {
        return $this->session->userdata('user_id');
    }

}
