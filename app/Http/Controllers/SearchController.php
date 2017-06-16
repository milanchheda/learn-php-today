<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;

class SearchController extends Controller
{
    public function autocomplete()
    {
    	$term = request('term');
        $result = Links::whereName($term)->orWhere('title', 'LIKE', '%' . $term . '%')->get(['slug', 'title as value']);
        return response()->json($term);
    }
}
