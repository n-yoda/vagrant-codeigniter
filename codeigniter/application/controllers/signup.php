<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'userModel', true);
        $this->load->helper('url');
        $this->load->helper('html');
    }

    public function index()
    {
        $message = '';
        // POSTにデータがあれば登録
        if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
            try {
                $this->userModel->addUser($_POST['email'], $_POST['username'], $_POST['password']);
                // 登録出来たらそのままログイン
                $this->userModel->login($_POST['email'], $_POST['password']);
                redirect('timeline', 'refresh');
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }
        // サインアップビュー    
        $data = array('message' => $message);
        $this->load->view('signup_view', $data);
    }
}
