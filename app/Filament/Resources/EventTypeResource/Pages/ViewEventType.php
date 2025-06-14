<?php

namespace App\Filament\Resources\EventTypeResource\Pages;

use App\Filament\Resources\EventTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEventType extends ViewRecord
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
