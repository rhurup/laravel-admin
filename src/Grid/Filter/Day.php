<?php

namespace Encore\Admin\Grid\Filter;

class Day extends Date
{
    protected $query = 'whereDay';

    /**
     * @var string
     */
    protected $fieldName = 'day';
}
