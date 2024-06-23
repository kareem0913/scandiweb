<?php

include_once __DIR__ . '/abstract/Product.php';

use App\Product;

class Book extends Product
{
    private $db;
    private $weight;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $price, $weight)
    {
        parent::__construct($name, $price);
        $this->weight = $weight;
    }

    public function validate()
    {
        $errors = parent::validate();

        if (!isset($this->weight) || !is_numeric($this->weight) || $this->weight <= 0) {
            $errors['weight'] = 'Weight must be a valid number greater than zero.';
        }

        return $errors;
    }

    public function save()
    {
        // add product 
        $this->db->query("INSERT INTO products (sku, name, price, product_type) VALUES (?, ?, ?, ?)");
        $this->db->bind(1, $this->sku);
        $this->db->bind(2, $this->name);
        $this->db->bind(3, $this->price);
        $this->db->bind(4, "BOOK");
        $this->db->execute();

        // get last insert id in product table
        $lastId = $this->db->last_id();

        // add weight value to book table 
        $this->db->query("INSERT INTO book (product_id, weight) VALUES (?,?) ");
        $this->db->bind(1, $lastId);
        $this->db->bind(2, $this->weight);
        $this->db->execute();
        return 'product is added successfully';
    }

    public function all()
    {
        $this->db->query("SELECT p.sku, p.name, p.price, B.weight
             FROM products p JOIN book B ON p.id = B.product_id");

        return $this->db->selectAll();
    }

    // TODO - implement delete function 
    public function delete($id)
    {
    }
}
