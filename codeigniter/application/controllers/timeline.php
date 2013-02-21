<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TimeLine extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('user_id')) {
			echo 'ログイン済み：';
			echo $this->session->userdata('user_id');
			echo '<br><a href="logout">ログアウト</a>';
		} else {
			echo 'ログインしてないです(´・ω・｀)';
		}
	}
	
}
