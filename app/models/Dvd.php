
<?php

include_once __DIR__ . '/abstract/Product.php';

use App\Product;

class DVD extends Product
{
    private $db;
    private $size;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $price, $size)
    {
        parent::__construct($name, $price);
        $this->size = $size;
    }

    public function validate()
    {
        $errors = parent::validate();

        if (!isset($this->size) || !is_numeric($this->size) || $this->size <= 0) {
            $errors['size'] = 'Size must be a valid number greater than zero.';
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
        $this->db->bind(4, "DVD");
        $this->db->execute();

        // get last insert id in product table
        $lastId = $this->db->last_id();

        // add size value to dvd table 
        $this->db->query("INSERT INTO dvd (product_id, size) VALUES (?,?) ");
        $this->db->bind(1, $lastId);
        $this->db->bind(2, $this->size);
        $this->db->execute();
        return 'product is added successfully';
    }

    public function all()
    {
        $this->db->query("SELECT p.sku, p.name, p.price, D.size
             FROM products p JOIN dvd B ON p.id = D.product_id");

        return $this->db->selectAll();
    }

    // TODO - implement delete function 
    public function delete($id)
    {
    }
}
