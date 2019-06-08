<?php
   class Session_controller extends CI_Controller {

      public function index() {
         //loading session library
         $this->load->library('session');

         //adding data to session
         //$this->session->set_userdata('name','virat');

         //$this->session->unset_userdata('name');

         $this->load->view('session_view');
      }

      public function reset() {
         //loading session library
         $this->load->library('session');
         $this->session->sess_destroy();

         $this->load->library('session');

         $this->load->helper('url');
         redirect('session_controller', 'refresh');
      }

   }
?>
