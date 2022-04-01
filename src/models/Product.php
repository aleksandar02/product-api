<?php

namespace Api\Model;

abstract class Product
{
    protected $conn;
    protected $table = "product";

    public $id;
    public $SKU;
    public $name;
    public $price;
    public $type;

    abstract function create($jsonData);
}