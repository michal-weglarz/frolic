<?php

namespace App\Filament\App\Resources\CategoryResource\RelationManagers;

use App\Filament\App\Resources\CategoryResource\Pages\ViewCategory;
use App\Filament\App\Resources\ThreadResource\Pages\EditThread;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThreadsRelationManager extends RelationManager
{
    protected static string $relationship = 'threads';
    protected static ?string $recordTitleAttribute = 'slug';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->required(),
                Forms\Components\Toggle::make('is_pinned'),
                Forms\Components\Toggle::make('is_locked'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\BooleanColumn::make('is_pinned'),
                Tables\Columns\BooleanColumn::make('is_locked'),
                Tables\Columns\TextColumn::make('view_count'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->recordUrl(
                fn (Model $record): string => EditThread::getUrl([$record->slug]),
            );
    }
}
