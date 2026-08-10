<?php

namespace App\Filament\Resources\TeacherStaff\Pages;

use App\Filament\Resources\TeacherStaff\TeacherStaffResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeacherStaff extends ListRecords
{
    protected static string $resource = TeacherStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
