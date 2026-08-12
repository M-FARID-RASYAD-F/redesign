<?php

namespace App\Filament\Resources\TeacherStaff\Schemas;

use Filament\Forms\Components\FileUpload;
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
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nip')
                    ->label('NIP')
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('Jabatan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('subject')
                    ->label('Mata Pelajaran')
                    ->maxLength(255),
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('teachers'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Non-aktif',
                    ])
                    ->default('aktif')
                    ->required(),
            ]);
    }
}
