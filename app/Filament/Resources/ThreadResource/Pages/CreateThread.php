<?php

namespace App\Filament\Resources\ThreadResource\Pages;

use App\Filament\Resources\ThreadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateThread extends CreateRecord
{

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected static string $resource = ThreadResource::class;
}
