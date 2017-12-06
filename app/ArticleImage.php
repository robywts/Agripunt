<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_ID', 'image_url',
    ];

}
