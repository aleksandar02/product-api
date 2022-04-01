<?php

namespace Api\Model;

require_once "Product.php";

class Furniture extends Product
{
    public $dimensions;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($jsonData)
    {
        echo "Creating Furniture!";
        return true;
    }
}