<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PpdbRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_pendaftaran')
                    ->disabled()
                    ->required(),
                TextInput::make('full_name')
                    ->required(),
                Select::make('gender')
                    ->options(['L' => 'L', 'P' => 'P'])
                    ->required(),
                DatePicker::make('birth_date')
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('parent_name')
                    ->required(),
                TextInput::make('parent_phone')
                    ->tel()
                    ->required(),
                TextInput::make('major_choice')
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'diverifikasi' => 'Diverifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ])
                    ->default('pending')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
