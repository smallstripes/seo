<?php

namespace SmallStripes\Seo\Block\RichSnippets;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use SmallStripes\Seo\Model\Breadcrumbs as Model;

class Breadcrumbs extends Template
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var
     */
    protected $crumbs;
    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var
     */
    protected $reviewCount;

    /**
     * Breadcrumbs constructor.
     * @param Model $model
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Model $model,
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->model = $model;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function haveBreadcrumbs()
    {
        if ($this->crumbsCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function crumbsCount()
    {
        return count($this->getBreadcrumbs());
    }

    /**
     * @return array
     */
    public function getBreadcrumbs()
    {
        if (!$this->crumbs) {
            $this->crumbs = array();
            foreach ($this->model->getData() as $key => $item) {
                if ($key == 'home') {
                    $this->crumbs[] = array('link' => $item['link'], 'label' => $this->getStoreName());
                } elseif (isset($item['link']) && is_string($item['label'])) {
                    $this->crumbs[] = array('link' => $item['link'], 'label' => $item['label']);
                }
            }
        }
        return $this->crumbs;
    }

    /**
     * @return string
     */
    public function getStoreName()
    {
        return $this->_scopeConfig->getValue('general/store_information/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}
