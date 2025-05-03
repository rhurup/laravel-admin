<?php

namespace Rhurup\Admin\Grid\Displayers;

use Illuminate\Support\Arr;
use Rhurup\Admin\Admin;

class Select extends AbstractDisplayer
{
    public function display($options = [])
    {
        return Admin::component('admin::grid.inline-edit.select', [
            'key' => $this->getKey(),
            'value' => $this->getValue(),
            'display' => Arr::get($options, $this->getValue(), ''),
            'name' => $this->getPayloadName(),
            'resource' => $this->getResource(),
            'trigger' => "ie-trigger-{$this->getClassName()}",
            'target' => "ie-template-{$this->getClassName()}",
            'options' => $options,
        ]);
    }
}
