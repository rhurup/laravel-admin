<?php

namespace Rhurup\Admin\Grid\Tools;

use Illuminate\Support\Collection;
use Rhurup\Admin\Admin;

class BatchActions extends AbstractTool
{
    /**
     * @var Collection
     */
    protected $actions;

    /**
     * @var bool
     */
    protected $enableDelete = true;

    /**
     * @var bool
     */
    private $holdAll = false;

    /**
     * BatchActions constructor.
     */
    public function __construct()
    {
        $this->actions = new Collection();

        $this->appendDefaultAction();
    }

    /**
     * Append default action(batch delete action).
     *
     * return void
     */
    protected function appendDefaultAction()
    {
        $this->add(new BatchDelete(trans('admin.batch_delete')));
    }

    /**
     * Disable delete.
     *
     * @return $this
     */
    public function disableDelete(bool $disable = true)
    {
        $this->enableDelete = !$disable;

        return $this;
    }

    /**
     * Disable delete And Hode SelectAll Checkbox.
     *
     * @return $this
     */
    public function disableDeleteAndHodeSelectAll()
    {
        $this->enableDelete = false;

        $this->holdAll = true;

        return $this;
    }

    /**
     * Add a batch action.
     *
     * @return $this
     */
    public function add($title, ?BatchAction $action = null)
    {
        $id = $this->actions->count();

        if (1 === func_num_args()) {
            $action = $title;
        } elseif (2 === func_num_args()) {
            $action->setTitle($title);
        }

        if (method_exists($action, 'setId')) {
            $action->setId($id);
        }

        $this->actions->push($action);

        return $this;
    }

    /**
     * Setup scripts of batch actions.
     *
     * @return void
     */
    protected function addActionScripts()
    {
        $this->actions->each(function ($action) {
            $action->setGrid($this->grid);

            if (method_exists($action, 'script')) {
                Admin::script($action->script());
            }
        });
    }

    /**
     * Render BatchActions button groups.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->enableDelete) {
            $this->actions->shift();
        }

        $this->addActionScripts();

        return Admin::component('admin::grid.batch-actions', [
            'all' => $this->grid->getSelectAllName(),
            'row' => $this->grid->getGridRowName(),
            'actions' => $this->actions,
            'holdAll' => $this->holdAll,
        ]);
    }
}
