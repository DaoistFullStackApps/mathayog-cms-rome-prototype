<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSkillTitleResource\Pages;
use App\Filament\Resources\CourseSkillTitleResource\RelationManagers;
use App\Filament\Resources\LessonResource\Pages\CreateLesson;
use App\Filament\Resources\LessonResource\Pages\EditLesson;
use App\Filament\Resources\LessonResource\Pages\ListLessons;
use App\Models\CourseSkillTitle;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class CourseSkillTitleResource extends Resource
{
    protected static ?string $model = CourseSkillTitle::class;

    protected static ?string $singularLabel = 'Course';
    protected static ?string $pluralLabel = 'Courses';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->course_title;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_title')
                    ->options([
                        'Counting to 1,000 Using Blocks' => 'Counting to 1,000 Using Blocks',
                        'Counting to 1,000 Using Place Values' => 'Counting to 1,000 Using Place Values',
                        'Illustrating Numbers to 1,000 Using Blocks' => 'Illustrating Numbers to 1,000 Using Blocks',
                        'Comparing Numbers to 1,000 (Comparing Hundreds)' => 'Comparing Numbers to 1,000 (Comparing Hundreds)',
                        'Ordering Numbers to 1,000 (Comparing Hundreds)' => 'Ordering Numbers to 1,000 (Comparing Hundreds)',
                    ])
                    ->required(),

                TextInput::make('skill_name')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course_title')
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Manage course content')
                    ->color('success')
                    ->icon('heroicon-m-academic-cap')
                    ->url(fn(CourseSkillTitle $record): string => self::getUrl('lessons.index', [
                        'parent' => $record->id,
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCourseSkillTitles::route('/'),
            'create' => Pages\CreateCourseSkillTitle::route('/create'),
            'edit' => Pages\EditCourseSkillTitle::route('/{record}/edit'),

            // Lessons 
            'lessons.index' => ListLessons::route('/{parent}/lessons'),
            'lessons.create' => CreateLesson::route('/{parent}/lessons/create'),
            'lessons.edit' => EditLesson::route('/{parent}/lessons/{record}/edit'),
        ];
    }

    public static function getUrl(string $name = 'index', array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

        $routeBaseName = static::getRouteBaseName(panel: $panel);
        $routeFullName = "{$routeBaseName}.{$name}";
        $routePath = Route::getRoutes()->getByName($routeFullName)->uri();

        if (str($routePath)->contains('{parent}')) {
            $parameters['parent'] ??= (request()->route('parent') ?? request()->input('parent'));
        }

        return route($routeFullName, $parameters, $isAbsolute);
    }
}
