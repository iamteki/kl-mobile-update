<?php

// app/Filament/Resources/ContactInquiryResource/Pages/EditContactInquiry.php

namespace App\Filament\Resources\ContactInquiryResource\Pages;

use App\Filament\Resources\ContactInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactInquiry extends EditRecord
{
    protected static string $resource = ContactInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Automatically mark as read when edited
        if ($this->record->status === 'new') {
            $this->record->markAsRead();
        }
    }
}
