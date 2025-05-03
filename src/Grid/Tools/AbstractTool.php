<?php

namespace Rhurup\Admin\Grid\Tools;

use Illuminate\Contracts\Support\Renderable;
use Rhurup\Admin\Grid;

abstract class AbstractTool implements Renderable
{
    /**
     * @var Grid
     */
    protected $grid;

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * Toggle this button.
     *
     * @return $this
     */
    public function disable(bool $disable = true)
    {
        $this->disabled = $disable;

        return $this;
    }

    /**
     * If the tool is allowed.
     */
    public function allowed()
    {
        return !$this->disabled;
    }

    /**
     * Set parent grid.
     *
     * @return $this
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    abstract public function render();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
