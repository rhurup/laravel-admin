<?php

namespace Rhurup\Admin\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Rhurup\Admin\Facades\Admin;

/**
 * @mixin Action
 */
trait Authorizable
{
    /**
     * @param Model $model
     *
     * @return bool
     */
    public function passesAuthorization($model = null)
    {
        if (method_exists($this, 'authorize')) {
            return true === $this->authorize(Admin::user(), $model);
        }

        if ($model instanceof Collection) {
            $model = $model->first();
        }

        if ($model && method_exists($model, 'actionAuthorize')) {
            return true === $model->actionAuthorize(Admin::user(), get_called_class());
        }

        return true;
    }

    public function failedAuthorization()
    {
        return $this->response()->error(__('admin.deny'))->send();
    }
}
