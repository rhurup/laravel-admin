<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Admin;

class RowSelector extends AbstractDisplayer
{
    public function display()
    {
        Admin::script($this->script());

        return <<<EOT
<input type="checkbox" class="{$this->grid->getGridRowName()}-checkbox" data-id="{$this->getKey()}"  autocomplete="off"/>
EOT;
    }

    protected function script()
    {
        $all = $this->grid->getSelectAllName();
        $row = $this->grid->getGridRowName();

        $selected = trans('admin.grid_items_selected');

        return <<<EOT
EOT;
    }
}
