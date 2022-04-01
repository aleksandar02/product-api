<?php

namespace Api\Validation;

class ProductValidator
{
    private $message = null;

    public function validate(ValidateInterface $product)
    {
        $product->validateAttribute();
    }
}