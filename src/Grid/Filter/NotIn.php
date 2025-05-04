<?php

namespace Encore\Admin\Grid\Filter;

class NotIn extends In
{
    protected $query = 'whereNotIn';
}
