<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\NestedForm;
use Encore\Admin\Widgets\Form as WidgetForm;

class Table extends HasMany
{
    /**
     * @var string
     */
    protected $viewMode = 'table';

    /**
     * Table constructor.
     *
     * @param string $column
     * @param array  $arguments
     */
    public function __construct($column, $arguments = [])
    {
        $this->column = $column;

        if (1 === count($arguments)) {
            $this->label = $this->formatLabel();
            $this->builder = $arguments[0];
        }

        if (2 === count($arguments)) {
            list($this->label, $this->builder) = $arguments;
        }
    }

    /**
     * @return array
     */
    protected function buildRelatedForms()
    {
        //        if (is_null($this->form)) {
        //            return [];
        //        }

        $forms = [];

        if ($values = old($this->column)) {
            foreach ($values as $key => $data) {
                if (1 === $data[NestedForm::REMOVE_FLAG_NAME]) {
                    continue;
                }

                $forms[$key] = $this->buildNestedForm($this->column, $this->builder, $key)->fill($data);
            }
        } else {
            foreach ($this->value ?? [] as $key => $data) {
                if (isset($data['pivot'])) {
                    $data = array_merge($data, $data['pivot']);
                }
                if (is_array($data)) {
                    $forms[$key] = $this->buildNestedForm($this->column, $this->builder, $key)->fill($data);
                }
            }
        }

        return $forms;
    }

    public function prepare($input)
    {
        $form = $this->buildNestedForm($this->column, $this->builder);

        $prepare = $form->prepare($input);

        return collect($prepare)->reject(function ($item) {
            return 1 === $item[NestedForm::REMOVE_FLAG_NAME];
        })->map(function ($item) {
            unset($item[NestedForm::REMOVE_FLAG_NAME]);

            return $item;
        })->toArray();
    }

    protected function getKeyName()
    {
        if (is_null($this->form)) {
            return;
        }

        return 'id';
    }

    protected function buildNestedForm($column, \Closure $builder, $key = null)
    {
        $form = new NestedForm($column);

        if ($this->form instanceof WidgetForm) {
            $form->setWidgetForm($this->form);
        } else {
            $form->setForm($this->form);
        }

        $form->setKey($key);

        call_user_func($builder, $form);

        $form->hidden(NestedForm::REMOVE_FLAG_NAME)->default(0)->addElementClass(NestedForm::REMOVE_FLAG_CLASS);

        return $form;
    }

    public function render()
    {
        return $this->renderTable();
    }
}
