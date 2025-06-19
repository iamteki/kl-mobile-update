<?php
// app/Filament/Resources/ContactInquiryResource/Pages/ListContactInquiries.php

namespace App\Filament\Resources\ContactInquiryResource\Pages;

use App\Filament\Resources\ContactInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContactInquiries extends ListRecords
{
    protected static string $resource = ContactInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action for contact inquiries as they come from the frontend
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge(ContactInquiryResource::getModel()::count()),
            'new' => Tab::make('New')
                ->badge(ContactInquiryResource::getModel()::new()->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->new()),
            'read' => Tab::make('Read')
                ->modifyQueryUsing(fn (Builder $query) => $query->read()),
            'replied' => Tab::make('Replied')
                ->modifyQueryUsing(fn (Builder $query) => $query->replied()),
            'archived' => Tab::make('Archived')
                ->modifyQueryUsing(fn (Builder $query) => $query->archived()),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'new';
    }
}