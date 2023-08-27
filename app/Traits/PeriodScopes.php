<?php

namespace App\Traits;

use App\Enums\Period;

trait PeriodScopes
{
    public function scopeFromPeriod($query, Period $period)
    {
        return match ($period) {
            Period::YEARLY => $query->fromLastYear(),
            Period::MONTHLY => $query->fromLastMonth(),
            Period::WEEKLY => $query->fromLastWeek(),
        };
    }

    public function scopeFromLastYear($query)
    {
        return $query->where('start_time', '>', now()->subYear()->startOfYear())
            ->where('start_time', '<', now()->subYear()->endOfYear());
    }

    public function scopeFromLastMonth($query)
    {
        return $query->where('start_time', '>', now()->subMonth()->startOfMonth())
            ->where('start_time', '<', now()->subMonth()->endOfMonth());
    }

    public function scopeFromLastWeek($query)
    {
        return $query->where('start_time', '>', now()->subWeek()->startOfWeek())
            ->where('start_time', '<', now()->subWeek()->endOfWeek());
    }
}

