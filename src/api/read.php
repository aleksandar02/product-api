<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require "../controllers/ProductController.php";

use Api\Controller\ProductController;

$productController = new ProductController();

$productController->read();
