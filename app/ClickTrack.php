<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClickTrack extends Model
{		
		// public $timestamps = false;
    	protected $table = 'click_track';
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'link_id', 
            'browser', 
            'browser_version', 
            'is_mobile', 
            'device_type', 
            'os', 
            'os_version', 
            'timezome', 
            'city', 
            'state', 
            'country',
            'referrer'
        ];
        protected $dates = ['created_at', 'updated_at'];
}
