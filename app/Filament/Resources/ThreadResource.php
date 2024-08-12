<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThreadResource\Pages;
use App\Filament\Resources\ThreadResource\RelationManagers;
use App\Models\Thread;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\Hidden::make('slug'),
//                Forms\Components\Select::make('user_id')
//                    ->relationship('user', 'id')
//                    ->a
//                    ->columnSpanFull(),
//                Forms\Components\Toggle::make('is_pinned')
//                    ->required(),
//                Forms\Components\Toggle::make('is_locked')
//                    ->required(),
//                Forms\Components\TextInput::make('view_count')
//                    ->integer()
//                    ->disabled()
//                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->searchable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\BooleanColumn::make('is_pinned'),
                Tables\Columns\BooleanColumn::make('is_locked'),
                Tables\Columns\TextColumn::make('view_count')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('creator.name')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
//            ->recordUrl(
//                fn (Model $record): string => Pages\ViewThread::getUrl([$record->slug]),
//            );
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')->columnSpanFull(),
                TextEntry::make('content')->columnSpanFull(),
                TextEntry::make('slug')->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThreads::route('/'),
            'create' => Pages\CreateThread::route('/create'),
            'edit' => Pages\EditThread::route('/{record}/edit'),
            'view' => Pages\ViewThread::route('/{record}'),
        ];
    }
}
