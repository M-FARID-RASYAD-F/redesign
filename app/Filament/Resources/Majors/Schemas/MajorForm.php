<?php

namespace App\Filament\Resources\Majors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MajorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Jurusan'),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi Jurusan')
                    ->rows(4),
                TextInput::make('icon')
                    ->maxLength(10)
                    ->placeholder('Contoh: ⚡ atau 🎨')
                    ->label('Simbol/Emoji Icon'),
            ]);
    }
}
