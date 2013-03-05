<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'userModel', true);
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        // エラー出力のスタイル
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // 検証
        $v = $this->form_validation;
        $v->set_rules('email', 'メールアドレス', 'trim|required|valid_email|max_length[256]|callback_emailDuplicate');
        $v->set_rules('username', '表示名', 'trim|required|alpha_dash|max_length[64]');
        $v->set_rules('password', 'パスワード', 'trim|required|min_length[4]|matches[passconf]');
        $v->set_rules('passconf', 'パスワードの確認', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('signup_view');
        } else {
            // データベース保存時のエラーは別処理
            // ここをバリデーションに含めると、無駄にデータベースアクセスすることになるのでダメ。           
            try {
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $this->userModel->addUser($email, $username, $password);
                $this->load->view('signup_succeed');
            } catch (Exception $e) {
                // ユーザーには「予期せぬエラー」とだけ表示する。
                $this->load->view('signup_failed');
                log_message('error', $e->getMessage());
            }
        }
    }

    // メールアドレスの重複チェック   
    function emailDuplicate($email)
    {
        $check = $this->userModel->isEmailUsed($email);
        if ($check)
            $this->form_validation->set_message('emailDuplicate', 'このメールアドレスは既に使用されています。');
        return !$check;
    }
}
