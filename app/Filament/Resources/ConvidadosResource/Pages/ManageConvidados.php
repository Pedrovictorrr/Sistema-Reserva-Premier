<?php

namespace App\Filament\Resources\ConvidadosResource\Pages;

use App\Filament\Resources\ConvidadosResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConvidados extends ManageRecords
{
    protected static string $resource = ConvidadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
