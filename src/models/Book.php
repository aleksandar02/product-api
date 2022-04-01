<?php

namespace Api\Model;

require_once "Product.php";
require_once "../validation/ValidateInterface.php";
require_once "../validation/ProductValidator.php";

use Api\Validation\ValidateInterface;
use Api\Validation\ProductValidator;

class Book extends Product implements ValidateInterface
{
    public $weight;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($jsonData) {
        echo "Creating Book!";

        $this->SKU = htmlspecialchars(strip_tags($jsonData->SKU));
        $this->name = htmlspecialchars(strip_tags($jsonData->name));
        $this->price = htmlspecialchars(strip_tags($jsonData->price));
        $this->type = htmlspecialchars(strip_tags($jsonData->type));
        $this->weight = htmlspecialchars(strip_tags($jsonData->weight));

        $productValidator = new ProductValidator();
        $message = $productValidator->validate($this);

        // After validation insert in db

        // Other classes need to implement ValidateInterface

        return true;
    }

    public function validateAttribute()
    {
        echo "Validating weight!";
    }
}