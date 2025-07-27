<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettings extends EditRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Settings'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Settings updated successfully!';
    }

    protected function mutateFormDataBeforeSave(array $data): array
{
    // Remove empty URL fields to keep the database clean
    $socialFields = [
        'facebook_url', 
        'twitter_url', 
        'instagram_url', 
        'linkedin_url', 
        'youtube_url',
        'tiktok_url'
    ];
    
    foreach ($socialFields as $field) {
        if (empty($data[$field])) {
            $data[$field] = null;
        }
    }

    return $data;
}
}