<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use App\Models\Settings;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        $settings = Settings::current();
        
        return [
            Actions\Action::make('edit_settings')
                ->label('Edit Settings')
                ->icon('heroicon-o-pencil')
                ->color('primary')
                ->url(fn () => SettingsResource::getUrl('edit', ['record' => $settings->id])),
        ];
    }

    public function mount(): void
    {
        parent::mount();
        
        // Auto-redirect to edit page if only one record exists
        $settings = Settings::current();
        if (Settings::count() === 1) {
            $this->redirect(SettingsResource::getUrl('edit', ['record' => $settings->id]));
        }
    }
}