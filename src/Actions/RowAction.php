<?php

namespace Encore\Admin\Actions;

use Encore\Admin\Grid\Column;
use Illuminate\Http\Request;

abstract class RowAction extends GridAction
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $row;

    /**
     * @var Column
     */
    protected $column;

    /**
     * @var string
     */
    public $selectorPrefix = '.grid-row-action-';

    /**
     * @var bool
     */
    protected $asColumn = false;

    /**
     * Get primary key value of current row.
     */
    protected function getKey()
    {
        return $this->row->getKey();
    }

    /**
     * Set row model.
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function row($key = null)
    {
        if (0 === func_num_args()) {
            return $this->row;
        }

        return $this->row->getAttribute($key);
    }

    /**
     * Set row model.
     *
     * @param \Illuminate\Database\Eloquent\Model $row
     *
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    public function getRow()
    {
        return $this->row;
    }

    /**
     * @return $this
     */
    public function setColumn(Column $column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Show this action as a column.
     *
     * @return $this
     */
    public function asColumn()
    {
        $this->asColumn = true;

        return $this;
    }

    /**
     * @return string
     */
    public function href()
    {
    }

    public function retrieveModel(Request $request)
    {
        if (!$key = $request->get('_key')) {
            return false;
        }

        $modelClass = str_replace('_', '\\', $request->get('_model'));

        if ($this->modelUseSoftDeletes($modelClass)) {
            return $modelClass::withTrashed()->findOrFail($key);
        }

        return $modelClass::findOrFail($key);
    }

    public function display($value)
    {
    }

    /**
     * Render row action.
     *
     * @return string
     */
    public function render()
    {
        if ($href = $this->href()) {
            return "<a href='{$href}'>{$this->name()}</a>";
        }

        $this->addScript();

        $attributes = $this->formatAttributes();

        return sprintf(
            "<a data-_key='%s' href='javascript:void(0);' class='%s' {$attributes}>%s</a>",
            $this->getKey(),
            $this->getElementClass(),
            $this->asColumn ? $this->display($this->row($this->column->getName())) : $this->name()
        );
    }
}
