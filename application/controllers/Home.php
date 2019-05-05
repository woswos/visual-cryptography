<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index($page = 'Home')
	{
		// Loading url helper
		$this->load->helper('url');

		$data['title'] = $page;

		// Load header
		$this->load->view('header', $data);

		// Load body
		$this->load->view('home');

		// Load footer
		$this->load->view('footer');
	}
}
