<?php

namespace Api\Controller;

require '../config/Database.php';
require "../models/Book.php";
require "../models/DVD.php";
require "../models/Furniture.php";

use Api\Config\Database;
use Api\Model\Book;
use Api\Model\DVD;
use Api\Model\Furniture;

class ProductController
{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($jsonData) {
        $productType = $jsonData->type;

        if ($productType == 1) {
            $book = new Book($this->conn);

            $this->sendOutput($book->create($jsonData));
        
        } else if ($productType == 2) {
            $dvd = new DVD($this->conn);

            $this->sendOutput($dvd->create($jsonData));

        } else if ($productType == 3) {
            $furniture = new Furniture($this->conn);
            
            $this->sendOutput($furniture->create($jsonData));
        }
    }

    private function sendOutput($result) {
        if ($result) {
            http_response_code(201);

            echo json_encode(array('message' => 'Product Created Successfully!', 'created' => 'true'));
        } else {
            // set response code - 503 service unavailable
            http_response_code(503);

            echo json_encode(array('message' => 'Unable to create the Product!', 'created' => 'false'));
        }
    }
}