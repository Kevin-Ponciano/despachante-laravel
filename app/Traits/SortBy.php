<?php

namespace App\Traits;

trait SortBy
{
    public $sortField, $sortDirection = 'desc', $iconDirection = 'up';
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function iconDirectionUpdate()
    {
        $this->iconDirection = $this->sortDirection === 'asc' ? 'up' : 'down';
    }
}
