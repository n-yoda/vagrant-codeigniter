<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddUser extends CI_Controller {

    function __construct()
    {
    	parent::__construct();
    	$this->load->model('UserModel', 'user_model', TRUE);
    	$this->load->helper('url');
    	$this->load->helper('html');
    }

	public function index()
	{
		$added = $this->user_model->add_user();

		// デバッグ表示
		echo $this->input->post('email');
		echo br(1);
		echo $this->input->post('username');
		echo br(1);
		echo $this->input->post('password');
		echo br(1);

		if ($added) {
			$this->user_model->login();
			redirect('timeline', 'refresh');
		} else {
			echo 'ユーザーを追加出来ませんでした。';
		}
	}
}

?>