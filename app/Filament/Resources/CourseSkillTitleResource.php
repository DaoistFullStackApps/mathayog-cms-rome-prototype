<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSkillTitleResource\Pages;
use App\Filament\Resources\CourseSkillTitleResource\RelationManagers;
use App\Models\CourseSkillTitle;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseSkillTitleResource extends Resource
{
    protected static ?string $model = CourseSkillTitle::class;
    protected static ?string $singularLabel = 'Course';
    protected static ?string $pluralLabel = 'Courses';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('skill_name')
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCourseSkillTitles::route('/'),
        ];
    }
}
