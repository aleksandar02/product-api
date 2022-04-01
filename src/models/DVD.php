<?php

namespace Api\Model;

require_once "Product.php";

class DVD extends Product
{
    public $size;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($jsonData)
    {
        echo "Creating DVD!";
        return true;
    }
}