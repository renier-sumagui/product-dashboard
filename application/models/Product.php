<?php
defined('BASEPATH') OR exit('No direct file access allowed.');

class Product extends CI_Model{
    /**
     * This will get all the products
     */
    public function get_all_products(){
        $query = "SELECT id, name, price, description, quantity_sold, inventory_count FROM products";
        return $this->db->query($query)->result_array();
    }

    /**
     * This will get a product based on the id
     */
    public function get_product($id){
        $query = "SELECT id, name, price, description, quantity_sold, inventory_count, DATE_FORMAT(created_at, '%M %D %Y') AS date
                    FROM products 
                    WHERE id = ?";
        return $this->db->query($query, $id)->row_array();
    }

    /**
     * This will validate the form when adding a product
     */
    public function validate_product(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        $this->form_validation->set_rules('inventory_count', 'Inventory count', 'required');
        if(!$this->form_validation->run()){
            return validation_errors();
        }else{
            return 'success';
        }
    }

    public function add_product($post){
        $query = "INSERT INTO products (name, price, description, quantity_sold, inventory_count, created_at, updated_at) VALUES
                    (?, ?, ?, ?, ?, ?, ?);";
        $values = array(
            $this->security->xss_clean($post['name']),
            $this->security->xss_clean($post['price']),
            $this->security->xss_clean($post['description']),
            0,
            $this->security->xss_clean($post['inventory_count']),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );
        return $this->db->query($query, $values);
    }

    public function edit_product($post){
        $query = "UPDATE products 
                    SET name = ?, description = ?, price = ?, inventory_count = ?, updated_at = ?
                    WHERE id = ?;";
        $values = array(
            $this->security->xss_clean($post['name']),
            $this->security->xss_clean($post['description']),
            $this->security->xss_clean($post['price']),
            $this->security->xss_clean($post['inventory_count']),
            date('Y-m-d H:i:s'),
            $post['product_id']
        );
        return $this->db->query($query, $values);
    }

    public function remove_product($id){
        $query = "DELETE FROM products 
                    WHERE id = ?;";
        return $this->db->query($query, array($id));
    }
}

?>
