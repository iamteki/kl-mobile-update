<?php

// app/Filament/Resources/ContactInquiryResource/Pages/ViewContactInquiry.php

namespace App\Filament\Resources\ContactInquiryResource\Pages;

use App\Filament\Resources\ContactInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactInquiry extends ViewRecord
{
    protected static string $resource = ContactInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function afterMount(): void
    {
        // Automatically mark as read when viewed
        if ($this->record->status === 'new') {
            $this->record->markAsRead();
        }
    }
}