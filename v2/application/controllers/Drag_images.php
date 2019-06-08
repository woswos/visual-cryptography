<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drag_images extends CI_Controller {

	public function index($page = 'Home')
	{
		// Load body
		$this->load->view('drag_images');
	}
}
