<?php

namespace SmallStripes\Seo\Model;

class Breadcrumbs
{
    /**
     * @var array
     */
    public $data;


    /**
     * @param $key
     * @param $value
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}