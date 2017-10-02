<?php

namespace SmallStripes\Seo\Block\RichSnippets;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class Product extends Template
{
    protected $registry;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getProductName()
    {
        return $this->getProduct()->getName();
    }

}
