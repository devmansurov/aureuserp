<?php

namespace Webkul\Subscriber\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Subscriber\Jobs\UpdateSubscriberSearchIndex;
use Webkul\Subscriber\Models\SubscriberTranslation;
use Webkul\Subscriber\Models\SubscriberSearchIndex;

class Subscriber extends Model
{
    protected $fillable = [
        'gender',
        'birthdate',
        'is_land_near_yard',
        'is_land_rented',
        'has_barn',
        'has_pasture',
        'has_dehkan_farm',
        'is_test_team',
        'land_total',
        'excel_row_id',
        'is_location_verified',
        'is_rejected',
        'status',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_land_near_yard' => 'boolean',
        'is_land_rented' => 'boolean',
        'has_barn' => 'boolean',
        'has_pasture' => 'boolean',
        'has_dehkan_farm' => 'boolean',
        'is_test_team' => 'boolean',
        'land_total' => 'decimal:2',
        'is_location_verified' => 'boolean',
        'is_rejected' => 'boolean',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(SubscriberTranslation::class);
    }

    protected static function booted(): void
    {
        static::created(fn (Subscriber $subscriber) => UpdateSubscriberSearchIndex::dispatch($subscriber->id));

        static::updated(function (Subscriber $subscriber) {
            if ($subscriber->wasChanged([
                'gender', 'status', 'is_rejected', 'is_location_verified'
            ])) {
                UpdateSubscriberSearchIndex::dispatch($subscriber->id);
            }
        });

        static::deleted(fn (Subscriber $subscriber) => SubscriberSearchIndex::where('subscriber_id', $subscriber->id)->delete());
    }
}
