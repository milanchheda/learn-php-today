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
use SEO;
use App;
use URL;
use Analytics;
use Helper;
use Jenssegers\Agent\Agent;
use App\ClickTrack;

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
        // $user = Auth::user();
        // $user->follow(171); 
        // dd(Helper::ip_info("173.252.110.27"));
        // dd(Request::ip());
        if (Request::ajax()) {
            $params = Request::all();
            $allLinks = Link::with('tagged');
            if(isset($params['searchTerm']) && !empty($params['searchTerm'])) {
                $searchTerm = $params['searchTerm'];
                $allLinks = $allLinks->where('links.title', 'like', '%' . $searchTerm . '%');
                Analytics::trackEvent('homepage', 'search', 'search', $searchTerm);
            }
            $allLinks = $allLinks->orderBy('links.id', 'desc')->simplePaginate(12);
            if(Request::has('more') && Request::get('more') > 0) {
                return Response::json(View::make('viewmorelinks', compact('allLinks'))->render());
            } else {
                return Response::json(View::make('viewlinks', compact('allLinks'))->render());    
            }
            
        } else {
            // $allLinks = Link::with('tagged')->orderBy('published_on', 'desc')->simplePaginate(12);
            $allLinks = Cache::remember('homepage', 10, function () {
                return Link::with('tagged')->orderBy('links.id', 'desc')->simplePaginate(12);
            });
        }
        return View::make('home', compact('allLinks'));
        // return view('home');
    }

    public function myUpvotes() {
        $getExisting = DB::table('user_activites')->where('user_id', '=', Auth::id())->select('upvotes')->get()->toArray();
        $usersVotes = $getExisting[0]->upvotes;
        $allLinks = Link::wherein('id', explode(',', $usersVotes))->orderBy('id', 'desc')->paginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));
    }

    public function myRecommends() {
        $getExisting = DB::table('user_activites')->where('user_id', '=', Auth::id())->select('recommends')->get()->toArray();
        $usersVotes = $getExisting[0]->recommends;
        $allLinks = Link::wherein('id', explode(',', $usersVotes))->orderBy('id', 'desc')->paginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));
    }

    public function showPost($slug)
    {
        $model = new Link();
        $urlOfSlug = $model->getSlugId($slug);
        
        $this->track($urlOfSlug['id']);

        SEO::setTitle($urlOfSlug['title']);
        SEO::opengraph()->setUrl(Request::url());
        SEO::opengraph()->setSiteName('Learn PHP Today');
        SEO::setCanonical(Request::url());
        SEO::twitter()->setSite('@learn_php_today');

        $urlOfSlug['urlOfSlug'] = $urlOfSlug['link'];
        // return View::make('showpost', $urlOfSlug);
        // Analytics::trackEvent('post', 'click', 'link', $urlOfSlug['link'] . '?ref=learnphptoday');
        return redirect($urlOfSlug['link'] . '?ref=learnphptoday');
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
        Analytics::trackPage();
        $allLinks = Link::with('tagged')->select(DB::raw('links.*'))->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.view_count', '>' , 0)->orderBy('link_views.view_count', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            $params = Request::all();
            if($params['more']) {
                return Response::json(View::make('viewmorelinks', compact('allLinks'))->render());
            }
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));     
    }

    public function topUpvotes() {
        Analytics::trackPage();
        $allLinks = Link::with('tagged')->select(DB::raw('links.*'))->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.upvote_count', '>' , 0)->orderBy('link_views.upvote_count', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));     
    }

    public function topRecommends() {
        Analytics::trackPage();
        $allLinks = Link::with('tagged')->select(DB::raw('links.*'))->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.recommend_count', '>' , 0)->orderBy('link_views.recommend_count', 'desc')->simplePaginate(12);
        if (Request::ajax()) {
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        }
        return View::make('home', compact('allLinks'));     
    }

    public function showTaggedLinks($slug) {
        Analytics::trackPage();
        if (Request::ajax()) {
            $params = Request::all();
            $allLinks = Link::withAllTags([$slug])->orderBy('links.id', 'desc')->simplePaginate(12);
            if($params['more']) {
                return Response::json(View::make('viewmorelinks', compact('allLinks'))->render());
            }
            return Response::json(View::make('viewlinks', compact('allLinks'))->render());
        } else {
            $allLinks = Cache::remember("tag:". $slug, 60, function () use($slug) {
                return Link::withAllTags([$slug])->orderBy('links.id', 'desc')->simplePaginate(12);
            });
            // $allLinks = Link::withAllTags([$slug])->orderBy('published_on', 'desc')->simplePaginate(12);    
        }
        
        return View::make('home', compact('allLinks'));
    }

    public function showAllTags() {
        Analytics::trackPage();
        $model = new Link();
        $allTags['allTags'] = $model->getAllTagsAndCounts();
        return View::make('tags', $allTags);
    }

    public function addTags() {
        if(Auth::check() && Auth::user()->hasRole('administrators')) {
            $allLinksWithoutTags['allExistingTags'] = Link::existingTags()->pluck('name');
            $allLinksWithoutTags['allLinksWithoutTags'] = Link::select(DB::raw('links.*'))->leftJoin('tagging_tagged', 'tagging_tagged.taggable_id', '=', 'links.id')->whereNull('tagging_tagged.taggable_id')->orWhere('tagging_tagged.tag_slug', 'uncategorized')->simplePaginate(100);
            return View::make('tags.index', $allLinksWithoutTags);
        } else{
            abort(403, 'Unauthorized action.');
        }
    }

    public function saveTagsForLinks() {
        $params = Request::all();
        if($params['linksId'] != '') {
            $tagsArray = explode(',', $params['tags']);
            $linksIds = explode(',', rtrim($params['linksId'], ','));
            foreach ($linksIds as $key => $value) {
                $linkObj = Link::find($value);
                $linkObj->untag();
                $linkObj->tag($tagsArray);
            }
            return response()->json(200);
        } else {
            return response()->json(401);
        }
    }

    public function createRssFeed() {
       /* create new feed */
       $feed = App::make("feed");

       /* creating rss feed with our most recent 20 posts */
       $posts = \DB::table('links')->select(DB::raw('links.*'))->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.view_count', '>' , 10)->orderBy('links.created_at', 'desc')->take(20)->get();

       /* set your feed's title, description, link, pubdate and language */
       $feed->title = 'Learn PHP Today';
       $feed->description = 'LearnPHPToday is a website for developers to read news and feeds related to PHP, Laravel, Symfony and everything related to PHP. Learn something new everyday.';
       $feed->logo = env('APP_URL') . '/images/logo_1.jpg';
       $feed->link = url('feed');
       $feed->setDateFormat('datetime');
       $feed->pubdate = $posts[0]->published_on;
       $feed->lang = 'en';
       $feed->setShortening(true);
       $feed->setTextLimit(300);

       foreach ($posts as $post)
       {
           $feed->add($post->title, '', URL::to('post/'.$post->slug), $post->published_on, $post->content, $post->content);
       }

       return $feed->render('rss');
    }
    
    public function track($linkId = '') {
        $params = Request::all();
        $linkIdToUse = '';
        if(isset($params['link_id']) && is_numeric($params['link_id'])) {
            $linkIdToUse = $params['link_id'];
            $browserToUse = (isset($params['browser']) && $params['browser'] != '') ? $params['browser'] : NULL;
            $isMobileToUse = (isset($params['isMobile']) && $params['isMobile'] != '') ? $params['isMobile'] : NULL;
            $deviceTypeToUse = (isset($params['deviceType']) && $params['deviceType'] != '') ? $params['deviceType'] : NULL;
            $osToUse = (isset($params['OS']) && $params['OS'] != '') ? $params['OS'] : NULL;
            $osVersionToUse = (isset($params['osVersion']) && $params['osVersion'] != '') ? $params['osVersion'] : NULL;
            $browserVersionToUse = (isset($params['browserVersion']) && $params['browserVersion'] != '') ? $params['browserVersion'] : NULL;
            $timezoneToUse = (isset($params['timeZone']) && $params['timeZone'] != '') ? $params['timeZone'] : NULL;
        } else if(isset($linkId) && is_numeric($linkId)) {
            $linkIdToUse = $linkId;
            $agent = new Agent();
            $browserToUse = $agent->browser();
            $isMobileToUse = $agent->isPhone();
            $deviceTypeToUse = $agent->device();
            $osToUse = $agent->platform();
            $osVersionToUse = $agent->version($osToUse);
            $browserVersionToUse = $agent->version($browserToUse);
            $timezoneToUse = NULL;
        }

        if($linkIdToUse != '' && is_numeric($linkIdToUse)) {
            $ipInfo = Helper::ip_info(Request::ip());
            $newClickTrack = new ClickTrack();
            $newClickTrack->link_id = $linkIdToUse;
            $newClickTrack->browser = $browserToUse;
            $newClickTrack->timezome = $timezoneToUse;
            $newClickTrack->is_mobile = $isMobileToUse;
            $newClickTrack->device_type = $deviceTypeToUse;
            $newClickTrack->os_version = $osVersionToUse;
            $newClickTrack->os = $osToUse;
            $newClickTrack->browser_version = $browserVersionToUse;
            $newClickTrack->city = (isset($ipInfo['city']) && $ipInfo['city'] != '') ? $ipInfo['city'] : NULL;
            $newClickTrack->state = (isset($ipInfo['state']) && $ipInfo['state'] != '') ? $ipInfo['state'] : NULL;
            $newClickTrack->country = (isset($ipInfo['country']) && $ipInfo['country'] != '') ? $ipInfo['country'] : NULL;
            $newClickTrack->referrer = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : NULL;
            $newClickTrack->save();
            DB::table('link_views')->where('link_id', '=', $linkIdToUse)->increment('view_count');
        }
    }    
}
