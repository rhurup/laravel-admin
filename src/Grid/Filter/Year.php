<?php

namespace Encore\Admin\Grid\Filter;

class Year extends Date
{
    protected $query = 'whereYear';

    /**
     * @var string
     */
    protected $fieldName = 'year';
}
