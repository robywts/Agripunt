<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rssfeed extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rssfeed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_ID', 'rss_description', 'rss_url', 'rss_urlerror', 'rss_publishdirect', 'rss_active', 'rss_lastreaddata',
    ];

}
