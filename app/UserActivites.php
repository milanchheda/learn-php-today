<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class UserActivites extends Model
{
    protected $table = 'user_activites';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'recommends', 'upvotes'
    ];

    public function updateUpvotesReco($action, $linkId) {
    	$getExisting = DB::table($this->table)->where('user_id', '=', Auth::id())->select('upvotes', 'recommends')->get()->toArray();
    }
}
