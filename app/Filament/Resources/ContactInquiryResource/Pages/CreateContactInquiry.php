<?php
// app/Filament/Resources/ContactInquiryResource/Pages/CreateContactInquiry.php
namespace App\Filament\Resources\ContactInquiryResource\Pages;

use App\Filament\Resources\ContactInquiryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactInquiry extends CreateRecord
{
    protected static string $resource = ContactInquiryResource::class;
}