<?php

namespace SmallStripes\Seo\Plugin;

use SmallStripes\Seo\Model\Breadcrumbs as Model;

class Breadcrumbs
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Breadcrumbs constructor.
     * @param Model $model
     */
    function __construct(
        Model $model
    ) {
        $this->model = $model;
    }

    /**
     * @param \Magento\Theme\Block\Html\Breadcrumbs $subject
     * @param $crumbName
     * @param $crumbInfo
     * @return null
     */
    public function beforeAddCrumb(\Magento\Theme\Block\Html\Breadcrumbs $subject, $crumbName, $crumbInfo)
    {
        $this->model->setData($crumbName, $crumbInfo);
        return null;
    }
}