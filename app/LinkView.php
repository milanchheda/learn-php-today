<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkView extends Model
{
    protected $table = 'link_views';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link_id', 'view_count', 'upvote_count', 'recommend_count'
    ];
}
