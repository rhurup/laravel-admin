<?php

namespace Rhurup\Admin\Grid\Filter;

class Date extends AbstractFilter
{
    protected $query = 'whereDate';

    /**
     * @var string
     */
    protected $fieldName = 'date';

    public function __construct($column, $label = '')
    {
        parent::__construct($column, $label);

        $this->{$this->fieldName}();
    }
}
