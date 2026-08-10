<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Category'),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                TextInput::make('thumbnail'),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required()
                    ->label('Author'),
                DateTimePicker::make('published_at'),
            ]);
    }
}
