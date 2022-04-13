<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require "../controllers/ProductController.php";

use Api\Controller\ProductController;

$jsonData = json_decode(file_get_contents("php://input"));

$productController = new ProductController();

$productController->massDelete($jsonData);
