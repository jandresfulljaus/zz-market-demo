<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsEnabled
{
    /**
     * Scope a query to only include enabled rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled(Builder $query)
    {
        return $query->where('is_enabled', 1);
    }

    /**
     * Scope a query to only include disabled rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisabled(Builder $query)
    {
        return $query->where('is_enabled', 0);
    }
}
