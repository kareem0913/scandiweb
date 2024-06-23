
<?php

include_once __DIR__ . '/abstract/Product.php';

use App\Product;

class Furniture extends Product
{
    private $db;
    private $height;
    private $width;
    private $length;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $price, $height, $width, $length)
    {
        parent::__construct($name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function validate()
    {
        $errors = parent::validate();

        if (!isset($this->height) || !is_numeric($this->height) || $this->height <= 0) {
            $errors['height'] = 'height must be a valid number greater than zero.';
        }
        if (!isset($this->width) || !is_numeric($this->width) || $this->width <= 0) {
            $errors['widht'] = 'wdith must be a valid number greater than zero.';
        }
        if (!isset($this->length) || !is_numeric($this->length) || $this->length <= 0) {
            $errors['length'] = 'length must be a valid number greater than zero.';
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
        $this->db->bind(4, "FURNITURE");
        $this->db->execute();

        // get last insert id in product table
        $lastId = $this->db->last_id();

        // add size value to dvd table 
        $this->db->query("INSERT INTO furniture (product_id, width, height, length) VALUES (?,?,?,?) ");
        $this->db->bind(1, $lastId);
        $this->db->bind(2, $this->width);
        $this->db->bind(3, $this->height);
        $this->db->bind(4, $this->length);
        $this->db->execute();
        return 'product is added successfully';
    }

    public function all()
    {
        $this->db->query("SELECT p.sku, p.name, p.price, F.width, F.height, F.length
             FROM products p JOIN furniture F ON p.id = F.product_id");

        return $this->db->selectAll();
    }

    // TODO - implement delete function 
    public function delete($id)
    {
    }
}
