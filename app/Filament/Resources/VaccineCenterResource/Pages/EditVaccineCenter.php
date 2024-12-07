<?php

namespace App\Filament\Resources\VaccineCenterResource\Pages;

use App\Filament\Resources\VaccineCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVaccineCenter extends EditRecord
{
    protected static string $resource = VaccineCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
