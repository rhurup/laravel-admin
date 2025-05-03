<?php

namespace Rhurup\Admin\Grid\Displayers;

use Illuminate\Contracts\Support\Renderable;
use Rhurup\Admin\Admin;
use Rhurup\Admin\Grid\Simple;

class Modal extends AbstractDisplayer
{
    /**
     * @var string
     */
    protected $renderable;

    /**
     * @return string
     */
    protected function getLoadUrl()
    {
        $renderable = str_replace('\\', '_', $this->renderable);

        return route(admin_get_route('handle-renderable'), compact('renderable'));
    }

    /**
     * @param \Closure|string $callback
     *
     * @return mixed|string
     */
    public function display($callback = null)
    {
        if (2 === func_num_args()) {
            list($title, $callback) = func_get_args();
        } elseif (1 === func_num_args()) {
            $title = $this->trans('title');
        }

        $html = '';

        if ($async = is_subclass_of($callback, Renderable::class)) {
            $this->renderable = $callback;
        } else {
            $html = call_user_func_array($callback->bindTo($this->row), [$this->row]);
        }

        return Admin::component('admin::components.column-modal', [
            'url' => $this->getLoadUrl(),
            'async' => $async,
            'grid' => is_subclass_of($callback, Simple::class),
            'title' => $title,
            'html' => $html,
            'key' => $this->getKey(),
            'value' => $this->value,
            'name' => $this->getKey().'-'.str_replace('.', '_', $this->getColumn()->getName()),
        ]);
    }
}
