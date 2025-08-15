<?php

namespace Webkul\Locale;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Webkul\Support\Package;

class LocalePlugin implements Plugin
{
    public function getId(): string
    {
        return 'locales';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        if (! Package::isPluginInstalled('locales')) {
            return;
        }

        $panel->when($panel->getId() == 'admin', function (Panel $panel) {
            $panel->discoverResources(in: $this->getPluginBasePath('/Filament/Resources'), for: 'Webkul\\Locale\\Filament\\Resources');
        });
    }

    public function boot(Panel $panel): void
    {
        //
    }

    protected function getPluginBasePath($path = null): string
    {
        $reflector = new \ReflectionClass(get_class($this));

        return dirname($reflector->getFileName()).($path ?? '');
    }
}
