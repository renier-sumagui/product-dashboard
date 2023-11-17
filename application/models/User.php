<?php
// defined('BASEPATH') OR exit('No direct file access allowed');
date_default_timezone_set('Asia/Manila');
class User extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }

    /**
     * This will get a user based on email
     */
    public function get_user($email){
        $query = "SELECT id, CONCAT(first_name, ' ', last_name) AS name, is_admin, password, salt FROM users WHERE email = ?";
        $value = $this->security->xss_clean($email);
        return $this->db->query($query, $value)->row_array();
    }

    /**
     * This function will check if there is no user in the database.
     */
    public function check_if_there_is_no_user(){
        return $this->db->query("SELECT COUNT(*) as count FROM users;")->row_array();
    }

    /**
     * This will add a new user
     */
    public function add_user($post){
        $salt = md5(openssl_random_pseudo_bytes(20));
        $encrypted_password = md5($post['password']).$salt;
        $query = "INSERT INTO users (first_name, last_name, email, password, salt, is_admin, created_at, updated_at) VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?);";
        
        $values = array(
            $this->security->xss_clean($post['first_name']),
            $this->security->xss_clean($post['last_name']),
            $this->security->xss_clean($post['email']),
            $this->security->xss_clean($encrypted_password),
            $this->security->xss_clean($salt),
            false,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );

        return $this->db->query($query, $values);
    }

    /**
     * This will add a new admin user
     */
    public function add_admin_user($post){
        $salt = md5(openssl_random_pseudo_bytes(20));
        $encrypted_password = md5($post['password']).$salt;
        $query = "INSERT INTO users (first_name, last_name, email, password, salt, is_admin, created_at, updated_at) VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?);";
        
        $values = array(
            $this->security->xss_clean($post['first_name']),
            $this->security->xss_clean($post['last_name']),
            $this->security->xss_clean($post['email']),
            $this->security->xss_clean($encrypted_password),
            $this->security->xss_clean($salt),
            true,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s') 
        );

        return $this->db->query($query, $values);
    }

    /**
     * This will edit the login form
     */
    public function validate_login_form(){
        $email_errors = array(
            'required' => 'Invalid email or password',
            'valid_email' => 'Invalid email or password'
        );
        $password_errors = array(
            'required' => 'Invalid email or password'
        );
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', $email_errors);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', $password_errors);
        if(!$this->form_validation->run()){
            return validation_errors();
        }else{
            return 'success';
        }
    }

    /**
     * This will validate the registration form
     */
    public function validate_registration_form(){
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array('is_unique' => 'Invalid email.'));
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', "trim|required|matches[password]", array('matches'=>'Passwords must match'));
        if(!$this->form_validation->run()){
            return validation_errors();
        }else{
            return 'success';
        }
    }

    /**
     * This will edit the user's information
     */
    public function edit_user_information($post){
        $query = "UPDATE users 
                    SET email = ?, first_name = ?, last_name = ?, updated_at = ?
                    WHERE id = ?;";
        $values = array(
            $this->security->xss_clean($post['email']),
            $this->security->xss_clean($post['first_name']),
            $this->security->xss_clean($post['last_name']),
            date('Y-m-d H:i:s'),
            $this->session->userdata('user_id')
        );
        return $this->db->query($query, $values);
    }

    /**
     * Validate new user information
     */
    public function validate_user_information(){
        $email = array(
            'required' => 'Invalid email',
            'valid_email' => 'Invalid email'
        );
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', $email);
        $this->form_validation->set_rules('first_name', 'First name', 'trim|required', array('required' => 'Invalid first name'));
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|required',  array('required' => 'Invalid last name'));
        if(!$this->form_validation->run()){
            return validation_errors();
        }else{
            return 'success';
        }
    }

    /**
     * This will edit the password
     */
    public function edit_password($password){
        $salt = md5(openssl_random_pseudo_bytes(25));
        $encrypted_password = md5($password).$salt;
        $query = "UPDATE users 
                    SET password = ?, salt = ?, updated_at = ?
                    WHERE id = ?";
        $values = array(
            $this->security->xss_clean($encrypted_password),
            $this->security->xss_clean($salt),
            date('Y-m-d H:i:s'),
            $this->session->userdata('user_id')
        );
        return $this->db->query($query, $values);
    }

    /**
     * Validate new password
     */
    public function validate_new_password(){
        $new_password = array(
            'required' => 'New password is required',
            'min_length' => 'Password must be at least 8 characters in length'
        );
        $password_confirmation = array(
            'required' => 'Passwords must match',
            'matches' => 'Passwords must match'
        );
        $this->form_validation->set_rules('old_password', 'Old password', 'trim|required', array('required' => 'Old password is required'));
        $this->form_validation->set_rules('new_password', 'New password', 'trim|required|min_length[8]', $new_password);
        $this->form_validation->set_rules('password_confirmation', 'Password confirmation', 'trim|required|matches[new_password]', $password_confirmation);
        if(!$this->form_validation->run()){
            return validation_errors();
        }else{
            return 'success';
        }
    }

    /**
     * This function will validate the old password that the user inputed
     */
    public function validate_old_password($old_password){
        $query = "SELECT password, salt
                    FROM users
                    WHERE id = ?";
        $password = $this->db->query($query, $this->session->userdata('user_id'))->row_array();
        
        $encrypted_password = md5($old_password).$password['salt'];
        if($password['password'] == $encrypted_password){
            return 'success';
        }else{
            return "<p>Wrong password</p>";
        }
    }
}

?>