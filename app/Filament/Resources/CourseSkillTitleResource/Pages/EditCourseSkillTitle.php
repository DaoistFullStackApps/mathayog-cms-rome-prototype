<?php

namespace App\Filament\Resources\CourseSkillTitleResource\Pages;

use App\Filament\Resources\CourseSkillTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseSkillTitle extends EditRecord
{
    protected static string $resource = CourseSkillTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
