<?php

class UserModel extends CI_Model {

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
            $this->_create_table();
        }
    }

    // テーブルを新規作成
    private function _create_table()
    {
        $this->load->dbforge();

        $fields = array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'email' => array('type' => 'VARCHAR', 'constraint' => '256'),
            'username' => array('type' =>'VARCHAR', 'constraint' => '64'),
            'password_hash' => array('type' => 'VARCHAR', 'constraint' => '64'),
            'register_date' => array('type' => 'DATETIME')
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table(self::TABLE_NAME);
    }

    // ユーザーを追加してユーザ情報を返す
    function add_user($email, $username, $password)
    {
        // emailアドレスがログインIDなので重複チェック
        $count = $this->db->from(self::TABLE_NAME)->where('email', $email)->count_all_results();
        if ($count > 0) {
            throw new Exception("メールアドレスが既に使用されています。");
        }
 
        $this->email = $email;
        $this->username = $username;
        $this->password_hash = do_hash($password);
        $this->register_date = date("Y-m-d H:i:s", time());

        $this->db->insert(self::TABLE_NAME, $this);
        $this->id = $this->db->insert_id();
        return $this;
    }

    // ログインしてユーザ情報を返す
    // セキュリティ的にはpassword_hashとかも保存しとくべき？
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
            return $user;
        }
        throw new Exception("メールアドレスまたはパスワードが違います。");
    }

    // ログアウト
    function logout()
    {
        $this->session->unset_userdata('user_id');
    }
}
