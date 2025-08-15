<?php

namespace Webkul\Subscriber\Services;

use Webkul\Subscriber\Models\Subscriber;
use Webkul\Subscriber\Models\SubscriberSearchIndex;

class SubscriberSearchIndexService
{
    public function rebuildSubscriberIndex(int $subscriberId): void
    {
        $subscriber = Subscriber::with('translations')->find($subscriberId);
        if (! $subscriber) {
            return;
        }

        SubscriberSearchIndex::where('subscriber_id', $subscriberId)->delete();

        foreach ($subscriber->translations as $translation) {
            $data = $this->buildIndexData($subscriber, $translation);
            SubscriberSearchIndex::create([
                'subscriber_id' => $subscriberId,
                'locale' => $translation->locale,
                ...$data,
            ]);
        }
    }

    public function updateSubscriberIndex(int $subscriberId, string $locale): void
    {
        $subscriber = Subscriber::with(['translations' => fn ($q) => $q->where('locale', $locale)])->find($subscriberId);
        if (! $subscriber || $subscriber->translations->isEmpty()) {
            SubscriberSearchIndex::where('subscriber_id', $subscriberId)->where('locale', $locale)->delete();
            return;
        }

        $translation = $subscriber->translations->first();
        $data = $this->buildIndexData($subscriber, $translation);
        SubscriberSearchIndex::updateOrCreate(
            ['subscriber_id' => $subscriberId, 'locale' => $locale],
            $data
        );
    }

    private function buildIndexData(Subscriber $subscriber, $translation): array
    {
        $searchText = implode(' ', array_filter([
            $translation->full_name,
            $translation->company,
            $translation->position,
            $translation->notes,
            $translation->village,
            $translation->dehkan_farm_name,
            $translation->temp_district,
            $translation->temp_jamoat,
            $subscriber->gender,
            $subscriber->status,
        ]));

        return [
            'full_name' => $translation->full_name,
            'company' => $translation->company,
            'position' => $translation->position,
            'village' => $translation->village,
            'status' => $subscriber->status,
            'gender' => $subscriber->gender,
            'search_text' => $searchText,
        ];
    }

    public function rebuildFullIndex(): void
    {
        SubscriberSearchIndex::truncate();

        Subscriber::with('translations')->chunk(1000, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                foreach ($subscriber->translations as $translation) {
                    SubscriberSearchIndex::create([
                        'subscriber_id' => $subscriber->id,
                        'locale' => $translation->locale,
                        ...$this->buildIndexData($subscriber, $translation),
                    ]);
                }
            }
        });
    }
}
