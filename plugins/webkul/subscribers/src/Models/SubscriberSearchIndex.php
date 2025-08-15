<?php

namespace Webkul\Subscriber\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriberSearchIndex extends Model
{
    public $timestamps = false;

    protected $table = 'subscriber_search_index';

    protected $fillable = [
        'subscriber_id',
        'locale',
        'full_name',
        'company',
        'position',
        'village',
        'status',
        'gender',
        'search_text',
    ];
}
