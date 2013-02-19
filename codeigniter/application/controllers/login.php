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

		// ログイン情報があればログイン
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$this->load->model('UserModel', 'user_model');
			$logined = $this->user_model->login();
			if ($logined) {
				redirect($redirect, 'refresh');
				return;
			} else {
				$message = 'IDまたはパスワードが違います。';
			}
		}

		$params = array('redirect' => $redirect, 'message' => $message);
		$this->load->view('login_view', $params);
	}

}
