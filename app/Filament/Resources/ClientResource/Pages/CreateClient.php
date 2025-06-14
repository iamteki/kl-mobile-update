<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no order is set, set it to the next available order for the selected line
        if (!isset($data['order']) || $data['order'] === 0) {
            $maxOrder = \App\Models\Client::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }

        return $data;
    }
}
