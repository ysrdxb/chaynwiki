<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Articles', \App\Models\Article::count())
                ->description('All music records')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
            Stat::make('Community Members', \App\Models\User::count())
                ->description('Active sonic nodes')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Pending Revisions', \App\Models\Revision::where('status', 'pending')->count())
                ->description('Moderation queue')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning'),
        ];
    }
}
