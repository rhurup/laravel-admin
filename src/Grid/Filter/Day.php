<?php

namespace Rhurup\Admin\Grid\Filter;

class Day extends Date
{
    protected $query = 'whereDay';

    /**
     * @var string
     */
    protected $fieldName = 'day';
}
