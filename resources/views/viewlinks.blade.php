<div class="container-fluid container">
    @foreach($allLinks as $user)
    <?php
        if($user->tags) {
            $tagHtml = '';
            $count = 0;
            foreach($user->tags as $tag) {
                if($count == 5)
                    break;
                $tagUrl = url('/') . '/tag/' . $tag->slug;
                $tagHtml .= "<a href='" . $tagUrl . "' class='tag'>" . strtoupper($tag->name) . "</a>";
                $count++;
            }
        }
    ?>

        <div class="col-xs-12 col-md-4 col-lg-4 col-sm-6 linksContainer" data-toggle="tooltip" data-placement="top" style="height: 250px;" link-id={{ $user->id }}>
            <div class="well" style="height: 100%">
                <h4 class="link-title">
                    <a href="/post/{{ $user->slug }}" title="{{ $user->title }}">{{ $user->title }}
                        <small>
                        <?php
                            $parse = parse_url($user->link);
                            $source = str_replace('www.', '', $parse['host']);
                            echo "(" . $source . ")";
                            $shareURL = url('/') . '/post/' . $user->slug;
                        ?>
                        </small>
                    </a>
                </h4>
                <div class="description">{{ str_limit(strip_tags($user->content), 200) }}</div>
                <!-- <div class="pull-left leftBottom">{{ Carbon\Carbon::parse($user->published_on)->diffForHumans() }}</div> -->
                <?php
                    if($tagHtml != '') {
                ?>
                    <div class="pull-left leftBottom50px link-tags clearfix">
                        {!! $tagHtml !!}
                    </div>
                <?php        
                    }
                ?>
                
                <div class="pull-left actionItems">
                    <a href="#" class="view">
                        <i class="fa fa-eye fa-2" aria-hidden="true" style="vertical-align: middle;font-size:12px;"></i>
                        <span class="" id="view_{{ $user->id }}">0</span>
                    </a>

                   <!--  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareURL }}&title={{ $user->title }}&summary=&source={{ $source }}" class="linkedin">
                        <i class="fa fa-linkedin" aria-hidden="true" style="vertical-align: middle;font-size:12px;" data-toggle="tooltip" data-placement="top" title="Click to share on LinkedIN."></i>
                    </a>

                    <a href="http://www.facebook.com/sharer.php?u={{ $shareURL }}" target="_BLANK" class="facebook">
                        <i class="fa fa-facebook" aria-hidden="true" style="vertical-align: middle;font-size:12px;" data-toggle="tooltip" data-placement="top" title="Click to share on Facebook."></i>
                    </a>

                    <a href="http://twitter.com/share?text={{ $user->title }}&url={{ $shareURL }}&via=learn_php_today" class="twitter-share-button twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
                        <i class="fa fa-twitter" aria-hidden="true" style="vertical-align: middle;font-size:12px;" data-toggle="tooltip" data-placement="top" title="Click to share on Twitter."></i>
                    </a> -->
                    <a href="#" class="upvote" data-toggle="tooltip" data-placement="top" title="Click to Upvote.">
                        <i class="fa fa-arrow-up fa-4" aria-hidden="true" style="vertical-align: middle; font-size:12px"></i>
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