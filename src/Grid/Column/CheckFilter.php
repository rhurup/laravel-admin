<?php

namespace Encore\Admin\Grid\Column;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Model;

class CheckFilter extends Filter
{
    /**
     * @var array
     */
    protected $options;

    /**
     * CheckFilter constructor.
     */
    public function __construct(array $options)
    {
        $this->options = $options;

        $this->class = [
            'all' => uniqid('column-filter-all-'),
            'item' => uniqid('column-filter-item-'),
        ];
    }

    /**
     * Add a binding to the query.
     *
     * @param array $value
     */
    public function addBinding($value, Model $model)
    {
        if (empty($value)) {
            return;
        }

        $model->whereIn($this->getColumnName(), $value);
    }

    /**
     * Add script to page.
     *
     * @return void
     */
    protected function addScript()
    {
        $script = <<<SCRIPT
$('.{$this->class['all']}').on('ifChanged', function () {
    if (this.checked) {
    
    } else {
    
    }
    return false;
});

SCRIPT;

        Admin::script($script);
    }

    /**
     * Render this filter.
     *
     * @return string
     */
    public function render()
    {
        $value = $this->getFilterValue([]);

        $lists = collect($this->options)->map(function ($label, $key) use ($value) {
            $checked = in_array($key, $value) ? 'checked' : '';

            return <<<HTML
<li class="" style="margin: 0;">
    <div class="form-check ps-0">
        <input type="checkbox" class="{$this->class['item']}" name="{$this->getColumnName()}[]" value="{$key}" {$checked}/>
        <label class="form-check-label" for="checkDefault">
        {$label}
        </label>
    </div>
</li>
HTML;
        })->implode("\r\n");

        $this->addScript();

        $allCheck = (count($value) === count($this->options)) ? 'checked' : '';
        $active = empty($value) ? '' : 'text-yellow';

        return <<<EOT
<span class="dropdown">
<form action="{$this->getFormAction()}" pjax-container style="display: inline-block;">
    <a href="javascript:void(0);" class="dropdown-toggle {$active}" data-bs-toggle="dropdown">
        <i class="fa fa-filter"></i>
    </a>
    <ul class="dropdown-menu" role="menu" style="padding: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);left: -70px;border-radius: 0;">

        <li>
            <ul style='padding: 0;'>
            <li class="" style="margin: 0;">
                <div class="form-check ps-0">
                    <input type="checkbox" class="{$this->class['all']}" {$allCheck}/>
                    <label class="form-check-label" for="checkDefault">
                        {$this->trans('all')}
                    </label>
                </div>
            </li>
                <li><hr class="dropdown-divider"></li>
                {$lists}
            </ul>
        </li>
        <li class="divider"></li>
        <li class="text-right">
            <button class="btn btn-sm btn-flat btn-primary pull-left" data-loading-text="{$this->trans('search')}..."><i class="fa fa-search"></i>&nbsp;&nbsp;{$this->trans('search')}</button>
            <span><a href="{$this->getFormAction()}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-undo"></i></a></span>
        </li>
    </ul>
</form>
</span>
EOT;
    }
}
