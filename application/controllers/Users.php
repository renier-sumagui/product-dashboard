<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('User');
    }
    public function login(){
        if($this->session->userdata('is_logged_in')){
            redirect('dashboard');
        }
        $this->load->view('users/login');
    }

    public function logoff(){
        $this->session->sess_destroy();
        redirect('users/login');
    }

    public function login_user(){
            $validate = $this->User->validate_login_form();
            if($validate == 'success'){
                $get_user = $this->User->get_user($this->input->post('email'));
                if($get_user == null){
                    $this->session->set_flashdata('message', '<p>Invalid email or password</p>');
                    redirect('users/login');
                }else{
                    $encrypted_password = md5($this->input->post('password')).$get_user['salt'];
                    if($encrypted_password == $get_user['password']){
                        $this->session->set_userdata('user_id', $get_user['id']);
                        $this->session->set_userdata('is_admin', $get_user['is_admin']);
                        $this->session->set_userdata('name', $get_user['name']);
                        $this->session->set_userdata('is_logged_in', true);
                        redirect('dashboard');
                    }else{
                        $this->session->set_flashdata('message', '<p>Invalid email or password.</p>');
                        redirect('users/login');
                    }
                }
            }else{
                $this->session->set_flashdata('message', $validate);
                redirect('users/login');
            }
        
    }

    public function register(){
        if(!empty($this->session->userdata('message'))){
            $view_data['message'] = $this->session->flashdata('message');
            $this->load->view('users/register', $view_data);
        }else{
            $this->load->view('users/register');
        }
    }

    public function edit(){
        $this->load->view('users/edit');
    }

    /*
     * This function will validate the fields by calling the 'validate_user_information' model method.
     * If the fields are valid not valid, it will store the validation errors in the flashdata.
     * Else, it will call the 'edit_user' model method to update the user's email, first name, and last name.
     */
    public function edit_user(){
        $validate = $this->User->validate_user_information();
        if($validate !== 'success'){
            $this->session->set_flashdata('message', $validate);
            redirect('users/edit');
        }else{
            $this->User->edit_user_information($this->input->post());
            $this->session->set_flashdata('message', '<p>User information successfully updated</p>');
            redirect('users/edit');
        }
    }

    /*
     * This function will validate the fields by calling the 'validate_new_password' model method.
     * If the fields are valid not valid, it will store the validation errors in the flashdata.
     * Else, it will call the 'edit_password' model method to update the user's password.
     */
    public function edit_password(){
        $validate = $this->User->validate_new_password();
        if($validate !== 'success'){
            $this->session->set_flashdata('message', $validate);
            redirect('users/edit');
        }else{
            $validate_old_password = $this->User->validate_old_password($this->input->post('old_password'));
            if($validate_old_password !== 'success'){
                $this->session->set_flashdata('message', $validate_old_password);
                redirect('users/edit');
            }
            $this->User->edit_password($this->input->post('new_password'));
            $this->session->set_flashdata('message', '<p>Password successfully updated</p>');
            redirect('users/edit');
        }
    }


    /*
      This function will register the user to the database if it passed the validations
      , this will also add an admin user if the database has no registered user.
     */
    public function register_user(){
        $result = $this->User->validate_registration_form();
        if($result == 'success'){
            $query = $this->User->check_if_there_is_no_user();
            if($query['count'] == 0){
                $this->User->add_admin_user($this->input->post());
            }else{
                $this->User->add_user($this->input->post());
            }
            $result = '<p>User successfully created.</p>';
            $this->session->set_flashdata('message', $result);
            redirect('users/register');
        }else{
            $this->session->set_flashdata('message', $result);
            redirect('users/register');
        }
    }
}

?>