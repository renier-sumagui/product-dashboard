<?php
defined('BASEPATH') OR exit;
date_default_timezone_set('Asia/Manila');

class Comment extends CI_Model{
    /*
     * This function adds a new comment to the database
     */
    public function add_comment($data){
        var_dump($data);
        if(empty($data['comment_content'])){
            return;
        }else{
            $query = "INSERT INTO comments (user_id, review_id, content, created_at, updated_at) VALUES
                        (?, ?, ?, ?, ?);";
            $values = array(
                        $data['user_id'],
                        $data['review_id'],
                        $this->security->xss_clean($data['comment_content']),
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s')
            );
            return $this->db->query($query, $values);
        }
    }

    /*
     * This function gets the comments per review. 
     */
    public function get_comments_per_review($review_id){
        $query = "SELECT user_id, CONCAT(users.first_name, ' ', users.last_name) as name, review_id, content, comments.created_at 
                    FROM comments 
                    INNER JOIN users
                    ON users.id = comments.user_id
                    WHERE review_id = ?
                    ORDER BY comments.created_at DESC;";
        return $this->db->query($query, $review_id)->result_array();
    }
}

?>