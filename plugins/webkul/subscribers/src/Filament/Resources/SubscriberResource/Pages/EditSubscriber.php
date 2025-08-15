<?php

namespace Webkul\Subscriber\Filament\Resources\SubscriberResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Webkul\Subscriber\Filament\Resources\SubscriberResource;

class EditSubscriber extends EditRecord
{
    protected static string $resource = SubscriberResource::class;

    protected array $translations = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->translations = $data['translations'] ?? [];
        unset($data['translations']);
        return $data;
    }

    protected function afterSave(): void
    {
        foreach ($this->translations as $locale => $values) {
            $this->record->translations()->updateOrCreate(
                ['locale' => $locale],
                $values
            );
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['translations'] = $this->record->translations
            ->mapWithKeys(fn ($t) => [
                $t->locale => $t->only([
                    'full_name',
                    'company',
                    'position',
                    'source',
                    'notes',
                    'village',
                    'dehkan_farm_name',
                    'temp_district',
                    'temp_jamoat',
                ]),
            ])->toArray();

        return $data;
    }
}
