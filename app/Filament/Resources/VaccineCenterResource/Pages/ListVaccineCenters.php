<?php

namespace App\Filament\Resources\VaccineCenterResource\Pages;

use App\Filament\Resources\VaccineCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVaccineCenters extends ListRecords
{
    protected static string $resource = VaccineCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
