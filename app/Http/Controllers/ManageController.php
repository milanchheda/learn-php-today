<?php

namespace App\Http\Controllers;

use App\Link;
use App\LinkView;
use View;
use Request;
use Response;
use DB;
use Auth;


class ManageController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    // $this->middleware('auth');
	}

    public function index()
    {
    	die("STOPPED HERE");
    }

    public function showLinks() {
    	if (Request::ajax()) {
    		$params = Request::all();
    		$data = Link::select(DB::raw('links.*, link_views.view_count,  link_views.upvote_count,  link_views.recommend_count'))->join('link_views', 'links.id', 'link_views.link_id')->orderBy('links.id', 'desc')->paginate(10);
    		return Response::json(View::make('datatablemore', compact('data'))->render());    
    	}
        $data = Link::select(DB::raw('links.*'))->join('link_views', 'links.id', 'link_views.link_id')->orderBy('links.id', 'desc')->paginate(10);
        return View::make('datatable', compact('data'));
        // return view ( 'datatable' )->withData ( $data );
    }

    public function deleteLink(Request $request) {
        $params = Request::all();
        $linkViewId = LinkView::where('link_id', '=', $params['id'])->pluck('id');
        Link::find( $request->id )->delete();
        LinkView::find( $linkViewId )->delete();
        return response()->json();
    } 
}
