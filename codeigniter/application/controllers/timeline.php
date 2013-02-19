<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TimeLine extends CI_Controller {

	public function index()
	{
		echo $this->session->userdata('user_id');
	}
	
}
