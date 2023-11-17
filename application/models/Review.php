<?php
defined('BASEPATH') OR exit('No direct file access allowed');
date_default_timezone_set('Asia/Manila');
class Review extends CI_Model{
    public function add_review($post){
        $query = "INSERT INTO reviews (product_id, user_id, content, created_at, updated_at) VALUES 
                    (?, ?, ?, ?, ?);";
        $values = array(
            $post['product_id'],
            $this->session->userdata['user_id'],
            $post['review_content'],
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );
        return $this->db->query($query, $values);
    }

    public function get_product_reviews($id){
        $query = "SELECT reviews.id as review_id, CONCAT(users.first_name, ' ', users.last_name) AS name, reviews.content, DATE_FORMAT(reviews.created_at, '%Y-%m-%d %H:%i:%s') AS date 
                    FROM reviews
                    INNER JOIN users
                    ON users.id = reviews.user_id
                    WHERE product_id = ?
                    ORDER BY date DESC;";
        return $this->db->query($query, $id)->result_array();
    }
}


?>