<?php

namespace App\Filament\Resources\CourseSkillTitleResource\Pages;

use App\Filament\Resources\CourseSkillTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseSkillTitleResource::class;
    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
