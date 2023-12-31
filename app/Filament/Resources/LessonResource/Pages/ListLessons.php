<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\CourseSkillTitleResource;
use App\Filament\Resources\LessonResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ListLessons extends ListRecords
{
    use HasParentResource;

    protected static string $parentResource = CourseSkillTitleResource::class;
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn (): string => $this->getParentResource()::getUrl('lessons.create', [
                    'parent' => $this->parent,
                ])),
        ];
    }

    public function table(Table $table): Table
    {
        return parent::table($table)
            ->pushActions([
                // Actions need to be moved to List as table action does not have access to the parent resource
                Action::make('Manage  content')
                    ->color('success')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (Model $record): string => CourseSkillTitleResource::getUrl('lessons.edit', [
                        'record' => $record,
                        'parent' => $this->parent,
                    ])),
                DeleteAction::make(),
            ]);
    }
}
