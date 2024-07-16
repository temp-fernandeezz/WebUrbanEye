<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Reclamações Aprovadas', fn () => '👍 ' . Report::where('status', 'approved')->count()),
            Stat::make('Reclamações Recusadas', fn () => '👎 ' . Report::where('status', 'rejected')->count()),
            Stat::make('Reclamações Pendentes', fn () => '⏳ ' . Report::where('status', 'pending')->count()),
        ];
    }
}
