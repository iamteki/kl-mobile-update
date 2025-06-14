<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestimonial extends CreateRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no order is set, set it to the next available order
        if (!isset($data['order']) || $data['order'] === 0) {
            $maxOrder = \App\Models\Testimonial::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }

        return $data;
    }
}
