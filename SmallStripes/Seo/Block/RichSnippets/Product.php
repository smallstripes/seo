<?php

namespace SmallStripes\Seo\Block\RichSnippets;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;

class Product extends Template
{
    protected $registry;
    protected $reviewCount;

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

    public function getSku()
    {
        return $this->getProduct()->getSku();
    }

    public function getProductName()
    {
        return $this->getProduct()->getName();
    }

    public function getDescription()
    {
        return htmlspecialchars(trim(strip_tags($this->getProduct()->getShortDescription())));
    }

    public function getPriceCurrency()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

    public function getPrice()
    {
        return round($this->getProduct()->getPrice(), 2);
    }

    public function getAvailability()
    {
        if ($this->getProduct()->isAvailable()) {
            return 'http://schema.org/InStock';
        }
        return 'http://schema.org/OutOfStock';
    }

    public function getItemCondition()
    {
        return 'http://schema.org/NewCondition';
    }

    public function getPriceValidUntil()
    {
        return $this->getProduct()->getSpecialToDate();
    }

    public function getBrandName()
    {
        $optionId = $this->getProduct()->getManufacturer();
        $attr = $this->getProduct()->getResource()->getAttribute('manufacturer');
        if ($attr->usesSource()) {
            return $attr->getSource()->getOptionText($optionId);
        }
        return "";
    }

    public function haveImages()
    {
        return true;
    }

    public function getImages()
    {
        $images = array();
        foreach ($this->getProduct()->getMediaGalleryImages() as $image) {
            $images[] = '"' . $image->getData('large_image_url') . '"';
        }
        return $images;
    }

    public function haveReviews()
    {
        if ($this->getReviewCount() > 0) {
            return true;
        }
        return false;
    }

    public function getReviewCount()
    {
        if (!$this->reviewCount) {
            $this->reviewCount = $this->getProduct()->getRatingSummary()->getReviewsCount();
        }
        return $this->reviewCount;
    }

    public function getRatingSummary()
    {
        return $this->getProduct()->getRatingSummary()->getRatingSummary();
    }
}
