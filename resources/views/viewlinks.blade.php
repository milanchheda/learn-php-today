<div class="container-fluid container">
    @foreach($allLinks as $user)
        <div class="col-xs-12 col-md-4 col-lg-4 col-sm-6 linksContainer" data-toggle="tooltip" data-placement="top" style="height: 220px;" link-id={{ $user->id }}>
            <div class="well" style="height: 100%">
                <h4 class="link-title">
                    <a href="post/{{ $user->slug }}">{{ $user->title }}
                        <small>
                        <?php
                            $parse = parse_url($user->link);
                            echo "(" . str_replace('www.', '', $parse['host']) . ")";
                        ?>
                        </small>
                    </a>
                </h4>
                <div class="description">{{ str_limit(strip_tags($user->content), 250) }}</div>
                <div class="pull-left leftBottom">{{ Carbon\Carbon::parse($user->published_on)->diffForHumans() }}</div>
                <div class="pull-right actionItems">
                    <a href="#" class="view">
                        <i class="fa fa-eye fa-2" aria-hidden="true" style="vertical-align: middle;font-size:16px;"></i>
                        <span class="" id="view_{{ $user->id }}">0</span>
                    </a>
                    <a href="http://twitter.com/share?text={{ $user->title }}&url={{ $user->link }}&via=learn_php_today" class="twitter-share-button" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
                        <i class="fa fa-twitter" aria-hidden="true" style="vertical-align: middle;font-size:16px;" data-toggle="tooltip" data-placement="top" title="Click to share on Twitter."></i>
                    </a>
                    <a href="#" class="upvote" data-toggle="tooltip" data-placement="top" title="Click to Upvote.">
                        <i class="fa fa-arrow-up fa-4" aria-hidden="true" style="vertical-align: middle; font-size:16px"></i>
                        <span class="" id="upvote_{{ $user->id }}">0</span>
                    </a>
                    <a href="#" class="recommend" data-toggle="tooltip" data-placement="top" title="Click to recommend.">
                        <i class="fa fa-heart recommendHeart" aria-hidden="true"></i>
                        <span class="" title="" dir="ltr"  id="recommend_{{ $user->id }}">0</span>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    <div class="pagination"> {{ $allLinks->links() }} </div>
</div>