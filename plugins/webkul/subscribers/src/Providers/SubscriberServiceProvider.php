<?php

namespace Webkul\Subscriber\Providers;

use Webkul\Support\Console\Commands\InstallCommand;
use Webkul\Support\Console\Commands\UninstallCommand;
use Webkul\Support\Package;
use Webkul\Support\PackageServiceProvider;
use Webkul\Subscriber\Console\Commands\RebuildSubscriberSearchIndex;

class SubscriberServiceProvider extends PackageServiceProvider
{
    public static string $name = 'subscribers';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                '2025_03_10_000000_create_subscribers_subscribers_table',
                '2025_03_10_000001_create_subscribers_subscriber_translations_table',
                '2025_03_10_000002_create_subscribers_subscriber_search_index_table',
            ])
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->runsMigrations();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->hasCommands([
                RebuildSubscriberSearchIndex::class,
            ]);
    }

    public function packageBooted(): void
    {
        //
    }
}
