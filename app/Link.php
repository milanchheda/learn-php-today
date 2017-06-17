<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Conner\Tagging\Model\Tag;

class Link extends Model
{
    use \Conner\Tagging\Taggable;

	protected $table = 'links';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'link', 'slug', 'content', 'published_on'
    ];
    protected $dates = ['created_at', 'updated_at', 'published_on'];


    public function getSlugId($slug) {
    	if(isset($slug) && trim($slug) != '') {
    		$result = Self::where('slug', '=', $slug)->select('id', 'link')->get()->toArray();
    		DB::table('link_views')->where('link_id', '=', $result[0]['id'])->increment('view_count');
    		return $result[0]['link'];
    	}
    }

    public function getAllTagsAndCounts()
    {
        $allTags = Tag::where('count', '>', 2)->orderBy('count', 'desc')->get();
        return $allTags;
    }
}
