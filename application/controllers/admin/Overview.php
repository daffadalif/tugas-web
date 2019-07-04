<?php

class Overview extends CI_Controller {
	public function _contruct()
	{
		parent::_contruct();
	}

	public function index()
	{
		// load view admin/overview.php
    	$this->load->library('user_agent');
		$data['ip_address'] = $this->input->ip_address();
		$data['browser'] = $this->agent->browser();
		$this->load->view("admin/overview",$data);
	}
}