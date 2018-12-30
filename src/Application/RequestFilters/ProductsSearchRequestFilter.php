<?php

namespace Skulditskiy\FashionTest\Application\RequestFilters;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;
use Zend\Validator\StringLength;

class ProductsSearchRequestFilter extends InputFilter
{
    public function __construct()
    {
        $brandInput = new Input('brand');
        $brandInput->setFallbackValue('');
        $brandInput->getValidatorChain()->attach(new StringLength(['max' => 255]));
        $this->add($brandInput);

        $titleInput = new Input('title');
        $titleInput->setFallbackValue('');
        $titleInput->getValidatorChain()->attach(new StringLength(['max' => 255]));
        $this->add($titleInput);

        $orderByInput = new Input('orderBy');
        $orderByInput->setFallbackValue('price');
        $orderByInput->getValidatorChain()->attach(new StringLength(['max' => 255]));
        $this->add($orderByInput);

        $orderDirectionInput = new Input('orderDirection');
        $orderDirectionInput->setFallbackValue('price');
        $orderDirectionInput->getValidatorChain()->attach(new StringLength(['max' => 6]));
        $this->add($orderDirectionInput);

        $limitInput = new Input('limit');
        $limitInput->setFallbackValue(10);
        $limitInput->getValidatorChain()->attach(new Digits());
        $this->add($limitInput);

        $offsetInput = new Input('offset');
        $offsetInput->setFallbackValue(0);
        $offsetInput->getValidatorChain()->attach(new Digits());
        $this->add($offsetInput);
    }
}
