<?php

namespace App\Filament\Resources\PpdbRegistrations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PpdbRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_pendaftaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->badge(),
                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('parent_name')
                    ->searchable(),
                TextColumn::make('parent_phone')
                    ->searchable(),
                TextColumn::make('major_choice')
                    ->searchable()
                    ->label('Pilihan Jurusan'),
                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'diverifikasi' => 'Diverifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
