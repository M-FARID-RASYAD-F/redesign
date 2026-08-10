<?php

namespace App\Filament\Resources\TeacherStaff\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeacherStaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('position')
                    ->required(),
                TextInput::make('subject'),
                TextInput::make('photo'),
                TextInput::make('nip'),
                Select::make('status')
                    ->options(['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'])
                    ->default('aktif')
                    ->required(),
            ]);
    }
}
