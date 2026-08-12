<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Berita')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                FileUpload::make('thumbnail')
                    ->label('Gambar Sampul')
                    ->image()
                    ->directory('news-thumbnails'),
                RichEditor::make('content')
                    ->label('Konten Berita')
                    ->required()
                    ->columnSpanFull(),
                Select::make('author_id')
                    ->label('Penulis')
                    ->relationship('author', 'name')
                    ->required()
                    ->default(auth()->id()),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi'),
            ]);
    }
}
