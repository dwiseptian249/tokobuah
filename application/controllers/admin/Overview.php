<?php
 
class Overview extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
    }
 
    public function index()
    {
        // load view <admin>
        $this->load->view("admin/overview");
    }

    public function abc() {
        echo base_url();
    }
}