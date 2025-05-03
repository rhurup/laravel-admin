<?php

namespace Rhurup\Admin\Grid\Actions;

use Rhurup\Admin\Actions\RowAction;

class Edit extends RowAction
{
    /**
     * @return array|string|null
     */
    public function name()
    {
        return __('admin.edit');
    }

    /**
     * @return string
     */
    public function href()
    {
        return "{$this->getResource()}/{$this->getKey()}/edit";
    }
}
