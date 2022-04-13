<?php

namespace Api\Model;

require_once "Product.php";

class Furniture extends Product
{
    public $width;
    public $height;
    public $lenght;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($jsonData)
    {
        try {
            $this->conn->beginTransaction();

            $this->width = htmlspecialchars(strip_tags(floatval($jsonData->width)));
            $this->height = htmlspecialchars(strip_tags(floatval($jsonData->height)));
            $this->length = htmlspecialchars(strip_tags(floatval($jsonData->length)));

            $productId = $this->insertProductDetails($jsonData);

            if ($this->width > 0 == false || $this->height > 0 == false || $this->length > 0 == false) {
                throw new \Exception("HxWxL value must be greater than 0!");
            }

            $insertProductAttributesQuery = "INSERT INTO productattributes (productId, width, height, length) VALUES(:productId, :width, :height, :length)";

            $insertProductAttributesStmt = $this->conn->prepare($insertProductAttributesQuery);
            $insertProductAttributesStmt->execute([
                'productId' => $productId,
                'width' => $this->width,
                'height' => $this->height,
                'length' => $this->length
            ]);

            $this->conn->commit();

            return array("message" => "Product created successfully!", "success" => true);

        } catch (\Exception $e) {
            $this->conn->rollback();

            return array("message" => $e->getMessage(), "success" => false);
        }
    }
}
