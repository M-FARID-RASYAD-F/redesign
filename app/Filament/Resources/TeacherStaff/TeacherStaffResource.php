<?php

namespace App\Filament\Resources\TeacherStaff;

use App\Filament\Resources\TeacherStaff\Pages\CreateTeacherStaff;
use App\Filament\Resources\TeacherStaff\Pages\EditTeacherStaff;
use App\Filament\Resources\TeacherStaff\Pages\ListTeacherStaff;
use App\Filament\Resources\TeacherStaff\Schemas\TeacherStaffForm;
use App\Filament\Resources\TeacherStaff\Tables\TeacherStaffTable;
use App\Models\TeacherStaff;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeacherStaffResource extends Resource
{
    protected static ?string $model = TeacherStaff::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema
    {
        return TeacherStaffForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeacherStaffTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeacherStaff::route('/'),
            'create' => CreateTeacherStaff::route('/create'),
            'edit' => EditTeacherStaff::route('/{record}/edit'),
        ];
    }
}
