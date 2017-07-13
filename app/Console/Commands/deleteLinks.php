<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Link;
use App\LinkView;
use Carbon\Carbon;
use Artisan;

class deleteLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old links';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allLinks = Link::select(DB::raw('links.id, link_views.id as linkViewId'))->where('links.created_at', '<', Carbon::now()->subDays(30))->join('link_views', 'links.id', 'link_views.link_id')->where('link_views.view_count', '<' , 10)->where('link_views.upvote_count', '=' , 0)->where('link_views.recommend_count', '=' , 0)->get();
        foreach($allLinks as $links) {
            $linksArray[$links->id] = $links->id;
            $linkViewArray[$links->linkViewId] = $links->linkViewId;
        }
        Link::destroy($linksArray);
        LinkView::destroy($linkViewArray);
        Artisan::call('cache:clear');
    }
}
