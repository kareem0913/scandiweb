<?php

require_once __DIR__ . "/../../config/database.php";  // database class 
require_once __DIR__ . "/../models/Book.php";
require_once __DIR__ . "/../models/Dvd.php";
require_once __DIR__ . "/../models/Furniture.php";


class ProductController
{


    public function index()
    {
        $book = new Book(new Database);
        $dvd = new DVD(new Database);
        $furniture = new Furniture(new Database);
        return array_merge($book->all(), $dvd->all(), $furniture->all());
    }

    public function addProduct()
    {
        // TODO - implement switch case between type of product 

        // NOTE - Book 
        // $newProduct = new Book(new Database);  // new instance from Book class
        // $newProduct->create('last test product in book', 34, 43);

        // NOTE - DVD
        // $newProduct = new DVD(new Database);
        // $newProduct->create('dvd product', 34, 43);

        // NOTE - Furniture
        $newProduct = new Furniture(new Database);  // new instance from Book class
        $newProduct->create('last test product in book', 34, 43, 50, 20);
        //////////////////////////////////////////////////////////////////////////////////


        // validate data
        $erros = $newProduct->validate();

        // cheak if there is error, if there return errors, else save product in databaes;
        if (!empty($erros)) {
            return $erros;
        } else {
            return $newProduct->save();
        }
    }

    public function deleteProduct($id)
    {
    }
}

$obj = new ProductController();

echo "<pre>";
print_r($obj->addProduct());
print_r($obj->index());
