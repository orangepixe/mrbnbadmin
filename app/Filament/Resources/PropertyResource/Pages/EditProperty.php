<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProperty extends EditRecord
{
    protected static string $resource = PropertyResource::class;



    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction()
            ->formId('form'),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
