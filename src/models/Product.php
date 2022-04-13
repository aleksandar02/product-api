<?php

namespace Api\Model;

abstract class Product
{
    protected $conn;

    public $id;
    public $sku;
    public $name;
    public $price;
    public $type;

    abstract public function create($jsonData);

    public function insertProductDetails($jsonData) 
    {
        $this->sku = htmlspecialchars(strip_tags($jsonData->sku));
        $this->name = htmlspecialchars(strip_tags($jsonData->name));
        $this->price = htmlspecialchars(strip_tags(floatval($jsonData->price)));
        $this->type = htmlspecialchars(strip_tags(intval($jsonData->type)));

        $insertProductQuery = "INSERT INTO product (sku, name, price, type) VALUES(:sku, :name, :price, :type)";

        $insertProductStmt = $this->conn->prepare($insertProductQuery);

        $insertProductStmt->execute([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'type' => $this->type,
        ]);
        
        $productId = $this->conn->lastInsertId();

        return $productId;
    }
}
