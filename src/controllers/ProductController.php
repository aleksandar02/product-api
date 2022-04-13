<?php

namespace Api\Controller;

require '../config/Database.php';
require "../factories/ProductFactory.php";

use PDO;
use Api\Config\Database;
use Api\Factory\ProductFactory;

class ProductController
{
    private $conn;

    public function __construct() 
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($jsonData) 
    {
        try {
            $productType = $jsonData->type;

            $productFactory = new ProductFactory();
            $product = $productFactory->createProduct($productType, $this->conn);

            $result = $product->create($jsonData);

            if ($result["success"] == true) {
                http_response_code(200);
            } else {
                http_response_code(503);
            }

            echo json_encode($result);

        } catch (\Exception $e) {
            http_response_code(503);
            echo json_encode(array("message" => $e->getMessage(), "success" => false));
        }
    }

    public function read() 
    {
        try {
            $selectProductsQuery = "SELECT p.id, p.sku, p.name, p.price, p.type, pa.weight, pa.size, pa.width, pa.height, pa.length FROM product AS p INNER JOIN productattributes AS pa ON p.id = pa.productId WHERE p.id = pa.productId";

            $selectProductsStmt = $this->conn->query($selectProductsQuery);
    
            $products = $selectProductsStmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($products);        
            
        } catch (\Exception $e) {
            http_response_code(503);
            echo json_encode(array("message" => "Something went wrong!", "success" => false));
        } 
    }

    public function massDelete($jsonData) 
    {
        try {
            $productIds = $jsonData->ids;

            $productIdsToString = implode(", ", $productIds);
          
            $deleteProductQuery = "DELETE FROM product WHERE id IN (" . $productIdsToString . ")";

            $deleteProductStmt = $this->conn->prepare($deleteProductQuery);
            
            $deleteProductStmt->execute();

            http_response_code(200);
            echo json_encode(array("message" => "Products are successfully deleted!", "success" => true));

        } catch (\Exception $e) {
            http_response_code(503);
            echo json_encode(array("message" => "Something went wrong!", "success" => false));
        }
    }
}
