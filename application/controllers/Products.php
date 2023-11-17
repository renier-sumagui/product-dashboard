<?php
defined('BASEPATH') OR exit('No direct file access allowed');

class Products extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Product');
        $this->load->model('Review');
        $this->load->model('Comment');
    }

    /*
     * This function will load the 'new' view file
     */
    public function new(){
        $this->load->view('products/new');
    }

    /**
     * This function will call the model method 'validate_product' to validate the post data
     * If the validation has an error, it will store the validation errors in the flashdata
     * Else, it will add an new product
     */
    public function add_new_product(){
        $validate = $this->Product->validate_product();
        if($validate !== 'success'){
            $this->session->set_flashdata('message', $validate);
            redirect('products/new');
        }else{
            $this->Product->add_product($this->input->post());
            $this->session->set_flashdata('message', '<p>Product successfully added</p>');
            redirect('products/new');
        }
    }

    /**
     * This function will call the model method 'validate_product' to validate the POST data
     * If the validation has an error, the validation errors will be stored in the flashdata
     * Else, the product will be updated
     */
    public function edit_product(){
        $validate = $this->Product->validate_product();
        if($validate !== 'success'){
            $this->session->set_flashdata('message', $validate);
            redirect('products/edit/'.$_POST['product_id']);
        }else{
            $this->Product->edit_product($this->input->post());
            $this->session->set_flashdata('message', '<p>Product successfully updated</p>');
            redirect('products/edit/'.$_POST['product_id']);
        }
    }

    /*
     * This function will load the 'edit' view file
     */
    public function edit($id){
        $view_data['product_id'] = $id;
        $this->load->view('products/edit', $view_data);
    }

    /*
     * This function will show the product and its reviews and comments
     * The date and time of each reviews and comments will also be calculated in this function.
     */
    public function show($id){
        $view_data['product'] = $this->Product->get_product($id);
        $product_reviews = $this->Review->get_product_reviews($id);
        foreach($product_reviews as $review){
            $view_data['comments'][] = $this->Comment->get_comments_per_review($review['review_id']);
        }
        $product_reviews = $this->Review->get_product_reviews($id);
        if(!empty($view_data['comments'])){
            $comments = $view_data['comments'];
        }
        foreach($product_reviews as $key => &$review){
            $now  = strtotime(date('Y-m-d H:i:s'));
            $review_date = strtotime($review['date']);
            $time = floor(($now - $review_date) / 60); /* THIS GETS THE TIME IN MINUTES */
            if($time >= 10080){ /* THIS CHECKS IF MINUTES IS GREATER THAN OR EQUAL TO A WEEK */
                $date = date_create($review['created_at']);
                $review['date'] = date_format($date, 'M jS Y');
            }else if($time >= 1440){ /* THIS CHECKS IF TIME IS GREATER THAN OR EQUAL TO A DAY */
                $time = floor(($time/60)/24);
                $review['date'] = $time.' day(s) ago';
            }else if($time >= 60){ /* THIS CHECKS IF TIME IS GREATER THAN OR EQUAL TO AN HOUR */
                $time = floor($time/60);
                $review['date'] = $time.' hour(s) ago';
            }else{ /* IF ANY OF THE ABOVE IS FALSE, THEN THE TIME WILL BE IN MINUTES */
                $review['date'] = $time.' minute(s) ago';
            }
            if(!empty($comments[$key])){
                foreach($comments[$key] as &$comment){
                    $now  = strtotime(date('Y-m-d H:i:s'));
                    $comment_date = strtotime($comment['created_at']);
                    $time = floor(($now - $comment_date) / 60); /* THIS GETS THE TIME IN MINUTES */
                    if($time >= 10080){
                        $date = date_create($comment['created_at']);
                        $comment['created_at'] = date_format($date, 'M jS Y');
                    }else if($time >= 1440){ /* THIS CHECKS IF TIME IS GREATER THAN OR EQUAL TO A DAY */
                        $time = floor(($time/60)/24);
                        $comment['created_at'] = $time.' day(s) ago';
                    }else if($time >= 60){ /* THIS CHECKS IF TIME IS GREATER THAN OR EQUAL TO AN HOUR */
                        $time = floor($time/60);
                        $comment['created_at'] = $time.' hour(s) ago';
                    }else{
                        $comment['created_at'] = $time.' minute(s) ago';
                    }
                }
            }
        }
        $view_data['product_reviews'] = $product_reviews;
        if(isset($comments)){
            $view_data['comments'] = $comments;
        }
        $this->load->view('products/show', $view_data);
    }

    /**
     * This function will call the model method 'remove_product' to remove the the product
     */
    public function remove_product($id){
        $this->Product->remove_product($id);
        redirect('dashboard');
    }
}


?>