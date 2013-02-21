<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        // リダイレクトの指定が無ければTimeLineにリダイレクト
        $redirect = '';
        if (isset($_POST['redirect']))
            $redirect = $_POST['redirect'];
        else
            $redirect = 'timeline';

        // 直前のログイン失敗メッセージ
        $message = '';

        // POSTデータがあればログイン
        if (isset($_POST['email']) && isset($_POST['password'])) {
            try {
                $this->load->model('UserModel', 'userModel');
                $this->userModel->login($_POST['email'], $_POST['password']);
                redirect($redirect, 'refresh');
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        $params = array('redirect' => $redirect, 'message' => $message);
        $this->load->view('login_view', $params);
    }

}
