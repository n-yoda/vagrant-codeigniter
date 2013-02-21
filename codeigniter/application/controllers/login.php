<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('UserModel', 'userModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // リダイレクトの指定が無ければTimeLineにリダイレクト
        $redirect = '';
        if (isset($_POST['redirect']))
            $redirect = $_POST['redirect'];
        else
            $redirect = 'timeline';

        // エラー出力のスタイル
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // 検証（ログインも同時に行う）
        $v = $this->form_validation;
        $v->set_rules('email', 'メールアドレス', 'trim|required|valid_email');
        $v->set_rules('password', 'パスワード', 'trim|required|callback_login');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
            redirect($redirect);
        }
    }

    // バリデーター用のログインコールバック
    function login($password)
    {
        $email = $this->input->post('email');
        if ($this->userModel->login($email, $password)) {
            return true;
        } else {
            $this->form_validation->set_message('login', 'メールアドレスまたはパスワードが違います。');
            return false;
        }
    }

}
