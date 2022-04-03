<?php

namespace Api\Model;

require_once "Product.php";

class Book extends Product
{
    public $weight;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($jsonData) {
        try {
            $this->conn->beginTransaction();

            $this->weight = htmlspecialchars(strip_tags(floatval($jsonData->weight)));

            $productId = $this->insertProductDetails($jsonData);

            if ($this->weight > 0 == false) {
                throw new \Exception("Weight value must be greater than 0!");
            }

            $insertProductAttributesQuery = "INSERT INTO productattributes (productId, weight) VALUES(:productId, :weight)";

            $insertProductAttributesStmt = $this->conn->prepare($insertProductAttributesQuery);
            $insertProductAttributesStmt->execute([
                'productId' => $productId,
                'weight' => $this->weight
            ]);

            $this->conn->commit();

            return array("message" => "Product created successfully!", "success" => true);

        } catch (\Exception $e) {
            $this->conn->rollback();

            return array("message" => $e->getMessage(), "success" => false);
        }
    }
}