<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SoftDeleteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getTable() . '.status', '!=', 'ex');
    }
}
