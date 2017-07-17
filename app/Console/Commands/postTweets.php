<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Feeds;
use App\Link;
use App\LinkView;
use Twitter;
use Carbon\Carbon;

class postTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post tweets';

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
        $firstDayOfPrevMonth = new Carbon('first day of last month');
        $allLinks = Link::with('tagged')->where('published_on', '>', $firstDayOfPrevMonth)->inRandomOrder()->first();
        $shareURL = $allLinks['link'] . '?ref=learnphptoday';
        $allStrings = explode(' ', $allLinks['title']);
        $keywordsArray = [
            'php',
            'laravel',
            'docker',
            'aws',
            'homestead',
            'symfony',
            'css',
            'javascript',
            'react',
            'vagrant',
            'composer',
            'api',
            'typescript',
            'vue',
            'jquery',
            'nginx',
            'apache',
            'lamp',
            'solr',
            'lucene',
            'elasticsearch',
            'security',
            'drupal',
            'wordpress',
            'joomla',
            'git',
            'github',
            'google',
            'linux',
            'nodejs',
            'mongodb',
            'java',
            'chrome',
            'twitter'
        ];
        array_walk($allStrings, function(&$item, $a, $keywordsArray) { 
            if(in_array(strtolower($item), $keywordsArray))
                $item = '#' . $item;
        }, $keywordsArray);
        $tweetText = implode(' ', $allStrings);
        
        Twitter::postTweet(['status' => substr($tweetText, 0, 100) . ' ' . $shareURL . ' #learnphptoday', 'format' => 'json']);
        // die();
    }
}
