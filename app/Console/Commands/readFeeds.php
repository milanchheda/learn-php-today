<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Feeds;
use App\Link;
use App\LinkView;

class readFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeds:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updated feeds.';

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
        $allSources = DB::table('sources')->where('status', '=', 1)->get()->pluck('xml_url')->toArray();
        $linksArray = [];
        $feed = Feeds::make($allSources, 10);
        $data = array(
            'items'     => $feed->get_items()
        );
        foreach ($data['items'] as $key => $item) {
            $linksArray['title'][] = $item->get_title();
            $linksArray['link'][] = $item->get_permalink();
            $linksArray['date'][] = date('Y-m-d H:i:s', strtotime(str_replace(' | ', '', $item->get_date('j F Y | g:i a'))));

            if($item->get_date('j F Y | g:i a') != '') {
                $slug = str_slug($item->get_title(), '-');
                $checkIfExist = DB::table('links')->where('slug', '=', $slug)->get()->pluck('id')->toArray();
                if(empty($checkIfExist)) {
                    $postDate = date('Y-m-d H:i:s', strtotime(str_replace(' | ', '', $item->get_date('j F Y | g:i a'))));
                    // DB::beginTransaction();
                    try {
                        $newLink = new Link();
                        $newLink->title = $item->get_title();
                        $newLink->published_on = $postDate;
                        $newLink->link = $item->get_permalink();
                        $newLink->slug = $slug;
                        $newLink->content = substr($item->get_description(), 0, 700);
                        $newLink->save();

                        if($newLink->id) {
                            $newLinkView = new LinkView();
                            $newLinkView->link_id = $newLink->id;
                            $newLinkView->view_count = 0;
                            $newLinkView->upvote_count = 0;
                            $newLinkView->recommend_count = 0;
                            $newLinkView->save();
                        }
                    } catch (\Exception $e) {
                        // DB::rollback();
                    }
                }
            }
        }
    }
}
