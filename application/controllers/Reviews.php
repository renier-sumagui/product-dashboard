<?php
defined('BASEPATH') OR exit('No direct file access allowed');

class Reviews extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Review');
    }

    public function add_review(){
        $this->Review->add_review($this->input->post());
        redirect('products/show/'.$this->input->post('product_id'));
    }
}



?>