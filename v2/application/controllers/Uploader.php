<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Uploader extends CI_Controller {

	public function index()
	{
		$this->load->library('session');

		$new_name = time()."_".$_FILES["file"]['name'];


		$existing_session[] = $this->session->userdata('last_uploaded_file');

		$existing_session[] = $new_name;

    $this->session->set_userdata('last_uploaded_file', $existing_session);

		$config['file_name'] = $new_name;
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = 1024;


    $this->load->library('upload', $config);
		$this->upload->do_upload('file');


		print_r('Image Uploaded Successfully.');
        exit;
	}
}
