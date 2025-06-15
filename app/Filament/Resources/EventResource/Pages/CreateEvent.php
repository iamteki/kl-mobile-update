<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->extraAttributes([
                    'x-data' => '{ submitting: false }',
                    'x-on:click' => '
                        submitting = true;
                        $dispatch("show-progress-modal");
                    '
                ]),
                
            $this->getCancelFormAction(),
        ];
    }

    protected function afterCreate(): void
    {
        $this->dispatch('form-completed');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Event created successfully!';
    }
}