<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if(($data['type'] == "select") || ($data['type'] == "checkpbox") || ($data['type'] == "radio")){
            $data['additional_info'] = json_decode($data['additional_info']);
        }
        
        return $data;
    }
}
