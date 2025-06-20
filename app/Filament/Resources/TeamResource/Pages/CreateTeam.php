<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no sort_order is set, set it to the next available order
        if (!isset($data['sort_order']) || $data['sort_order'] === 0) {
            $maxOrder = \App\Models\Team::max('sort_order') ?? 0;
            $data['sort_order'] = $maxOrder + 1;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Team member created successfully!';
    }
}