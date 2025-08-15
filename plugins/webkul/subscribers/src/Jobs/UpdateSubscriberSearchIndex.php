<?php

namespace Webkul\Subscriber\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Webkul\Subscriber\Services\SubscriberSearchIndexService;

class UpdateSubscriberSearchIndex implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $subscriberId;
    public $locale;

    public $timeout = 300;
    public $tries = 3;
    public $backoff = [60, 120, 300];

    public function __construct(int $subscriberId, ?string $locale = null)
    {
        $this->subscriberId = $subscriberId;
        $this->locale = $locale;
        $this->delay(now()->addSeconds(30));
    }

    public function handle(SubscriberSearchIndexService $service): void
    {
        if ($this->locale) {
            $service->updateSubscriberIndex($this->subscriberId, $this->locale);
        } else {
            $service->rebuildSubscriberIndex($this->subscriberId);
        }
    }

    public function uniqueId(): string
    {
        return "update_subscriber_index_{$this->subscriberId}_{$this->locale}";
    }
}
