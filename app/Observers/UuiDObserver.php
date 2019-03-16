<?php

namespace App\Observers;

use Illuminate\Support\Str;

class UuiDObserver
{
    public function creating($model)
    {
        if (empty($model->uuid)) {
            $model->uid = (string) Str::uuid();
        }
    }
}
