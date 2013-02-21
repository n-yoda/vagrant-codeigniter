<?php

class UserModel extends CI_Model {

    const TABLE_NAME = 'users';

    var $id = NULL;
    var $email = '';
    var $password_hash = '';
    var $username = '';
    var $register_date = '';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('security');

        // テーブルが無ければ作る。
        if (!$this->db->table_exists(self::TABLE_NAME))
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
    }

    // 成功したらTRUEを返す
    function add_user()
    {
        $this->email = $_POST['email'];
        $this->username = $_POST['username'];
        $this->password_hash = do_hash($_POST['password']);
        $this->register_date = date("Y-m-d H:i:s", time());

        $this->db->insert(self::TABLE_NAME, $this);
        $this->id = $this->db->insert_id();
        return TRUE;
    }

    function login()
    {
        $email = $_POST['email'];
        $password_hash = do_hash($_POST['password']);
        $login_cond = array('email' => $email, 'password_hash' => $password_hash);
        $query = $this->db->get_where(self::TABLE_NAME, $login_cond);

        if ($query->num_rows() > 0) {
            // idのみセッションに保存し、他はその都度データベースアクセス。
            $users = $query->result();
            $user = $users[0];
            $login_data = array('user_id' => $user->id);
            $this->session->set_userdata($login_data);
            return TRUE;
        }
        return FALSE;
    }

    function logout()
    {
        $this->session->unset_userdata('user_id');
    }
}

?>