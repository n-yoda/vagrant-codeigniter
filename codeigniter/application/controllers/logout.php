<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        // リダイレクトの指定が無ければLoginにリダイレクト
        $redirect = '';
        if (isset($_POST['redirect']))
            $redirect = $_POST['redirect'];
        else
            $redirect = 'login';

        // ログアウト
        $this->load->model('UserModel', 'userModel');
        $this->userModel->logout();
        redirect($redirect, 'refresh');
    }

}
