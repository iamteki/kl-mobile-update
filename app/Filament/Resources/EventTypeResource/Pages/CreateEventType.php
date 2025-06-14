<?php

namespace App\Filament\Resources\EventTypeResource\Pages;

use App\Filament\Resources\EventTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEventType extends CreateRecord
{
   protected static string $resource = EventTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no order is set, set it to the next available order
        if (!isset($data['order']) || $data['order'] === 0) {
            $maxOrder = \App\Models\EventType::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }

        return $data;
    }
}
