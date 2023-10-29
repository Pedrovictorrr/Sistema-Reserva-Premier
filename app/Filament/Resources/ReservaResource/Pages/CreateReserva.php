<?php

namespace App\Filament\Resources\ReservaResource\Pages;

use App\Filament\Resources\ReservaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReserva extends CreateRecord
{
    protected static string $resource = ReservaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{   
  
   

    $data['user_id'] = auth()->id();
 
    return $data;
}
}
