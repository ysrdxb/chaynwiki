<?php

namespace App\Filament\Resources\Revisions;

use App\Filament\Resources\Revisions\Pages\ListRevisions;
use App\Models\Revision;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;

class RevisionResource extends Resource
{
    protected static ?string $model = Revision::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static \UnitEnum | string | null $navigationGroup = 'Moderation';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('article.title')
                    ->label('Article')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('Contributor')
                    ->sortable(),
                TextColumn::make('change_summary')
                    ->limit(50),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (Revision $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Revision $record) {
                        DB::transaction(function () use ($record) {
                            // Update the article with the snapshot data
                            $record->article->update($record->content_snapshot);
                            
                            // Mark this revision as approved
                            $record->update(['status' => 'approved']);
                            
                            // Increment user reputation
                            if ($record->user) {
                                $record->user->increment('reputation_score', 10);
                            }
                        });
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn (Revision $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn (Revision $record) => $record->update(['status' => 'rejected'])),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRevisions::route('/'),
        ];
    }
}
