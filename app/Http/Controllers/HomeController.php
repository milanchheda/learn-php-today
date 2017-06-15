<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
// use Illuminate\Http\Request;
use App\Link;
use View;
use Request;
use Response;
use DB;
use Auth;
use App\UserActivites;
use Cache;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Redis::set('name', 'Taylor');
        $allLinks = Cache::remember('homepage', 10, function () {
            return Link::orderBy('published_on', 'desc')->simplePaginate(12);
        });
        // $allLinks = Link::orderBy('published_on', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));
        // return view('home');
    }

    public function myUpvotes() {
        $getExisting = DB::table('user_activites')->where('user_id', '=', Auth::id())->select('upvotes')->get()->toArray();
        $usersVotes = $getExisting[0]->upvotes;
        $allLinks = Link::wherein('id', explode(',', $usersVotes))->orderBy('published_on', 'desc')->paginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));
    }

    public function myRecommends() {
        $getExisting = DB::table('user_activites')->where('user_id', '=', Auth::id())->select('recommends')->get()->toArray();
        $usersVotes = $getExisting[0]->recommends;
        $allLinks = Link::wherein('id', explode(',', $usersVotes))->orderBy('published_on', 'desc')->paginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));
    }

    public function showPost($slug)
    {
        $model = new Link();
        $urlOfSlug = $model->getSlugId($slug);
        return redirect($urlOfSlug);
    }

    public function fetchNumbers() {
        $params = Request::all();
        $resultArray = [];
        $params['postIds'] = explode(',', rtrim($params['postIds'], ','));
        $result = DB::table('link_views')->wherein('link_id', $params['postIds'])->select('link_id', 'view_count', 'upvote_count', 'recommend_count')->get()->toArray();

        foreach ($result as $key => $value) {
            $resultArray[$value->link_id]['view_count'] = $value->view_count;
            $resultArray[$value->link_id]['upvote_count'] = $value->upvote_count;
            $resultArray[$value->link_id]['recommend_count'] = $value->recommend_count;
        }

        $recommends = $upVotes = [];
        $result_more = DB::table('user_activites')->where('user_id', '=', Auth::id())->select('upvotes', 'recommends')->get()->toArray();
        if(isset($result_more[0])) {
            if($result_more[0]->upvotes)
                $upVotes =  explode(',', $result_more[0]->upvotes);
            if($result_more[0]->recommends)
                $recommends =  explode(',', $result_more[0]->recommends);
        }
            

        echo json_encode(array('stats' => $resultArray, 'upvotes' => $upVotes, 'recommends' => $recommends));
        die();
    }

    public function updateNumbers() {
        $params = Request::all();
        $resultArray = [];
        
        switch ($params['action']) {
            case 'upvote':
                if($params['increDecre'] == 1) {
                    DB::table('link_views')->where('link_id', '=', $params['link_id'])->increment('upvote_count');
                } else {
                    DB::table('link_views')->where('link_id', '=', $params['link_id'])->decrement('upvote_count');
                }
                break;
            case 'recommend':
                if($params['increDecre'] == 1) {
                    DB::table('link_views')->where('link_id', '=', $params['link_id'])->increment('recommend_count');
                } else {
                    DB::table('link_views')->where('link_id', '=', $params['link_id'])->decrement('recommend_count');
                }
                break;
            default:
                # code...
                break;
        }

        $getExisting = DB::table('user_activites')->where('user_id', '=', Auth::id())->select('upvotes', 'recommends')->get()->toArray();
        if(empty($getExisting)) {
            switch ($params['action']) {
                case 'upvote':
                    $UserActivitesObj = new UserActivites();
                    $UserActivitesObj->user_id = Auth::id();
                    $UserActivitesObj->upvotes = $params['link_id'];
                    $UserActivitesObj->recommends = 0;
                    $UserActivitesObj->save();
                    break;
                case 'recommend':
                    $UserActivitesObj = new UserActivites();
                    $UserActivitesObj->user_id = Auth::id();
                    $UserActivitesObj->upvotes = 0;
                    $UserActivitesObj->recommends = $params['link_id'];
                    $UserActivitesObj->save();
                    break;
                
                default:
                    # code...
                    break;
            }
        } else {
            $linkIdArray = [];
            $existingUpvotes = $existingRecommends = $fieldName = '';
            switch ($params['action']) {
                case 'upvote':
                    if($getExisting[0]->upvotes) {
                        $existingUpvotes = $getExisting[0]->upvotes;
                    }

                    if($params['increDecre'] == 1) {
                        $finalVotes = $params['link_id'];
                        if($existingUpvotes != '') {
                            $finalVotes = $existingUpvotes . ',' . $params['link_id'];
                        }
                    } else {
                        $existingUpvotesArray = explode(',', $existingUpvotes);
                        $existingUpvotesArray = array_flip($existingUpvotesArray);
                        unset($existingUpvotesArray[$params['link_id']]);
                        $existingUpvotesArray = array_flip($existingUpvotesArray);
                        $finalVotes = implode(',', $existingUpvotesArray);
                    }
                    $fieldName = 'upvotes';
                    break;
                case 'recommend':
                    if($getExisting[0]->recommends) {
                        $existingRecommends = $getExisting[0]->recommends;
                    }
                    if($params['increDecre'] == 1) {
                        $finalVotes = $params['link_id'];
                        if($existingRecommends != '') {
                            $finalVotes = $existingRecommends . ',' . $params['link_id'];
                        }
                    } else {
                        $existingRecommendsArray = explode(',', $existingRecommends);
                        $existingRecommendsArray = array_flip($existingRecommendsArray);
                        unset($existingRecommendsArray[$params['link_id']]);
                        $existingRecommendsArray = array_flip($existingRecommendsArray);
                        $finalVotes = implode(',', $existingRecommendsArray);   
                    }
                    $fieldName = 'recommends';
                    break;
            }

            if($fieldName != '') {
                $user = UserActivites::where("user_id",Auth::id())
                                ->update( 
                                       array( 
                                                $fieldName => $finalVotes,
                                            )
                                        );
            }
        }
    }

    public function topViews() {
        $allLinks = DB::table('links')->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.view_count', '>' , 0)->orderBy('link_views.view_count', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));     
    }

    public function topUpvotes() {
        $allLinks = DB::table('links')->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.upvote_count', '>' , 0)->orderBy('link_views.upvote_count', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));     
    }

    public function topRecommends() {
        $allLinks = DB::table('links')->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.recommend_count', '>' , 0)->orderBy('link_views.recommend_count', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));     
    }
}
