<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Response;
use DB;

class TagController extends Controller
{
    public function getTagHoverData() {
   		$params = Request::all();
   		print_r($params);
    }
}
