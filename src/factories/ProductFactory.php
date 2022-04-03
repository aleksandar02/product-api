<?php

namespace Api\Factory;

require "../models/Book.php";
require "../models/DVD.php";
require "../models/Furniture.php";

use Api\Model\Book;
use Api\Model\DVD;
use Api\Model\Furniture;

class ProductFactory
{
    public function createProduct($type, $conn) {
        switch ($type) {
            case 1:
                return new Book($conn);
                break;
            case 2:
                return new DVD($conn);
                break;
            case 3:
                return new Furniture($conn);
                break;
            default:
                break;
        }
    }
}