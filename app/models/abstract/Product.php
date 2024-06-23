<?php


namespace App;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
        $this->genrateSku();
    }

    private function genrateSku()
    {
        $this->sku = uniqid() . time();
    }

    public function validate()
    {
        $errors = [];
        if (!isset($this->name) || empty($this->name)) {
            $errors['name'] = "Name is required.";
        }

        if (!isset($this->price) || !is_numeric($this->price) || $this->price <= 0) {
            $errors['price'] = "Price must be a valid number greater than zero.";
        }
        return $errors;
    }


    abstract public function all();

    abstract public function save();


    abstract public function delete($id);
}
