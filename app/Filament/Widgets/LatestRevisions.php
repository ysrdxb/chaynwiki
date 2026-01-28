<?php

namespace App\Filament\Widgets;

use App\Models\Revision;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRevisions extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Revision::where('status', 'pending')->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('article.title')
                    ->label('Article')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Contributor'),
                Tables\Columns\TextColumn::make('change_summary')
                    ->label('Summary')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Revision $record): string => "/admin/revisions") // Link to the resource list for now or a specific view if implemented
                    ->icon('heroicon-m-eye')
                    ->color('info'),
            ]);
    }
}
