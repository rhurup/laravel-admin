<?php

namespace Rhurup\Admin\Grid\Filter;

class Month extends Date
{
    protected $query = 'whereMonth';

    /**
     * @var string
     */
    protected $fieldName = 'month';
}
