<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

use Filament\Infolists;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->lesson_title;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('lesson_title')
                    ->required()
                    ->maxLength(100)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lesson_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Lesson Title')
                    ->schema([
                        Group::make([
                            Infolists\Components\TextEntry::make('lesson_title')
                                ->hiddenLabel(),
                        ]),
                    ])->compact(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VideosRelationManager::class,
            RelationManagers\ActivitiesRelationManager::class,
            RelationManagers\ExercisesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
            'view' => Pages\ViewLesson::route('/{record}'),
        ];
    }
}
