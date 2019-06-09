<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_v1 extends CI_Controller {

	public function index($page = 'App v1')
	{
		// Loading url helper
		$this->load->helper('url');

		$data['title'] = $page;

		// Load header
		$this->load->view('header', $data);

		// Load body
		$this->load->view('app_v1');

		// Load footer
		$this->load->view('footer');
	}
}
