<?php
defined('BASEPATH') OR exit('No direct file access allowed');

class Dashboard extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Product');
    }

    public function index(){
        if($this->session->userdata('is_admin') == 0){
            redirect('dashboard/user');
        }else{
            redirect('dashboard/admin');
        }
        
    }

    public function admin(){
        $view_data['products'] = $this->Product->get_all_products();
        $this->load->view('dashboard/admin', $view_data);
    }

    public function user(){
        $view_data['products'] = $this->Product->get_all_products();
        $this->load->view('dashboard/user', $view_data);
    }
}

?>