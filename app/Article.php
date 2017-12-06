<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rssfeed_ID', 'article_title', 'article_summary', 'article_content', 'article_author', 'article_pubdate', 'article_comment', 'article_active',
    ];

}
