<?php

namespace Webkul\Subscriber\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Subscriber\Jobs\UpdateSubscriberSearchIndex;
use Webkul\Subscriber\Models\Subscriber;
use Webkul\Subscriber\Models\SubscriberSearchIndex;

class SubscriberTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'subscriber_id',
        'locale',
        'full_name',
        'company',
        'position',
        'source',
        'notes',
        'village',
        'dehkan_farm_name',
        'temp_district',
        'temp_jamoat',
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    protected static function booted(): void
    {
        static::saved(fn (SubscriberTranslation $translation) => UpdateSubscriberSearchIndex::dispatch($translation->subscriber_id, $translation->locale));

        static::deleted(fn (SubscriberTranslation $translation) => SubscriberSearchIndex::where('subscriber_id', $translation->subscriber_id)
            ->where('locale', $translation->locale)
            ->delete());
    }
}
