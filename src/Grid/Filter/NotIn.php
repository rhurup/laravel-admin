<?php

namespace Rhurup\Admin\Grid\Filter;

class NotIn extends In
{
    protected $query = 'whereNotIn';
}
