<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserCountWidget extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('Usuários Registrados', fn () => '👤 ' . User::count()),
            Stat::make('Reclamações Registradas', fn () => '📝 ' . Report::count()),
        ];
    }
}
