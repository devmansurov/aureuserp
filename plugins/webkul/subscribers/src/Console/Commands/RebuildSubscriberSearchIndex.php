<?php

namespace Webkul\Subscriber\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Subscriber\Services\SubscriberSearchIndexService;

class RebuildSubscriberSearchIndex extends Command
{
    protected $signature = 'subscriber:rebuild-index {--subscriber-id= : Rebuild index for specific subscriber}';

    protected $description = 'Rebuild subscriber search index';

    public function handle(SubscriberSearchIndexService $service): void
    {
        $subscriberId = $this->option('subscriber-id');

        if ($subscriberId) {
            $this->info("Rebuilding search index for subscriber {$subscriberId}...");
            $service->rebuildSubscriberIndex((int) $subscriberId);
            $this->info('Done!');
        } else {
            $this->info('Rebuilding full search index...');
            $service->rebuildFullIndex();
            $this->info('Search index rebuilt successfully!');
        }
    }
}
