<?php

namespace Encore\Admin\Grid\Filter\Presenter;

use Encore\Admin\Facades\Admin;

class Checkbox extends Radio
{
    protected function prepare()
    {

        Admin::script($script);
    }
}
