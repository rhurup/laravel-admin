<?php

namespace Rhurup\Admin\Grid\Concerns;

use Rhurup\Admin\Grid\Tools\Footer;

trait HasFooter
{
    /**
     * @var \Closure
     */
    protected $footer;

    /**
     * Set grid footer.
     *
     * @return $this|\Closure
     */
    public function footer(?\Closure $closure = null)
    {
        if (!$closure) {
            return $this->footer;
        }

        $this->footer = $closure;

        return $this;
    }

    /**
     * Render grid footer.
     *
     * @return string
     */
    public function renderFooter()
    {
        if (!$this->footer) {
            return '';
        }

        return (new Footer($this))->render();
    }
}
