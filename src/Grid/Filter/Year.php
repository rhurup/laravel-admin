<?php

namespace Rhurup\Admin\Grid\Filter;

class Year extends Date
{
    protected $query = 'whereYear';

    /**
     * @var string
     */
    protected $fieldName = 'year';
}
