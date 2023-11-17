<?php
defined('BASEPATH') OR exit('No direct file access allowed');

class Comments extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Comment');
    }

    /*
     This function will call the add_comment model method to add a new comment to the database 
     */
    public function add_comment(){
        $data = $this->input->post();
        $data['user_id'] = $this->session->userdata('user_id');
        $this->Comment->add_comment($data);
        redirect('products/show/'.$data['product_id']);
    }

    public function get_comments(){

    }
}


?>