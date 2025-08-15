<?php

namespace Webkul\Subscriber\Filament\Resources\SubscriberResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Webkul\Subscriber\Filament\Resources\SubscriberResource;

class CreateSubscriber extends CreateRecord
{
    protected static string $resource = SubscriberResource::class;

    protected array $translations = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->translations = $data['translations'] ?? [];
        unset($data['translations']);
        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->translations as $locale => $values) {
            $this->record->translations()->updateOrCreate(
                ['locale' => $locale],
                $values
            );
        }
    }
}
