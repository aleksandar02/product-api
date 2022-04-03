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
        try {
            $this->conn->beginTransaction();

            $this->size = htmlspecialchars(strip_tags(floatval($jsonData->size)));

            $productId = $this->insertProductDetails($jsonData);

            if ($this->size > 0 == false) {
                throw new \Exception("Size value must be greater than 0!");
            }

            $insertProductAttributesQuery = "INSERT INTO productattributes (productId, size) VALUES(:productId, :size)";

            $insertProductAttributesStmt = $this->conn->prepare($insertProductAttributesQuery);
            $insertProductAttributesStmt->execute([
                'productId' => $productId,
                'size' => $this->size
            ]);

            $this->conn->commit();

            return array("message" => "Product created successfully!", "success" => true);

        } catch (\Exception $e) {
            $this->conn->rollback();

            return array("message" => $e->getMessage(), "success" => false);
        }
    }
}