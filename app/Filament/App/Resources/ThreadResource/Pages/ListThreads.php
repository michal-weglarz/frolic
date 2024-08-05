<?php

namespace App\Filament\App\Resources\ThreadResource\Pages;

use App\Filament\App\Resources\ThreadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThreads extends ListRecords
{
    protected static string $resource = ThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
