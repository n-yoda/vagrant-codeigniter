<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

    function __construct()
    {
    	parent::__construct();
    	$this->load->model('UserModel', 'user_model', TRUE);
    	$this->load->helper('url');
    	$this->load->helper('html');
    }

	public function index()
	{
		$message = '';
		// POSTにデータがあれば登録
		if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
			try {
				$this->user_model->add_user($_POST['email'], $_POST['username'], $_POST['password']);
				// 登録出来たらそのままログイン
				$this->user_model->login($_POST['email'], $_POST['password']);
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
