<?php

namespace Encore\Admin\Grid\Filter;

class Month extends Date
{
    protected $query = 'whereMonth';

    /**
     * @var string
     */
    protected $fieldName = 'month';
}
