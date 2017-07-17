<!-- <div class="profile-cover" style="background: rgb(77, 66, 97);">
    <div class="container padding-top-3 user-select full-width">
        <div class="cols-flex">
            <div class="category-header-left">
                <div class="profile-avatar">
                    <a href="/@dummy" class="router-link-exact-active router-link-active"><img src="/imgs/default-avatar.png" alt="" class="circle">
                    </a>
                </div>
            </div>
            <div class="category-header-middle">
                <h1>
                        
                    </h1> <a href="/@dummy" class="router-link-exact-active router-link-active"><h2><i aria-hidden="true" class="v-icon v-atsign"></i>dummy
                        </h2></a>
                <p></p> <span class="inline-block"><i aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="" class="v-icon v-submissions" data-original-title="Submissions"></i>2
                    </span> <span class="inline-block"><i aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="" class="v-icon v-chat" data-original-title="Comments"></i>2
                    </span> <span class="inline-block"><i aria-hidden="true" class="v-icon v-calendar"></i>Joined: Jul 3rd
                    </span>
            </div>
            <div class="category-header-right">
                <div class="karma">
                    <div class="karma-number">
                        1
                    </div>
                    <div class="karma-text">
                        Post Karma
                    </div>
                </div>
                <div class="karma">
                    <div class="karma-number">
                        0
                    </div>
                    <div class="karma-text">
                        Comment Karma
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="container-fluid container">
    <div class="infinite-scroll">
    @foreach($allLinks as $user)
    <?php
        if($user->tags) {
            $tagHtml = '';
            $count = 0;
            foreach($user->tags as $tag) {
                if($count == 5)
                    break;
                $tagUrl = url('/') . '/tag/' . $tag->slug;
                $tagHtml .= "<a href='" . $tagUrl . "' class='tag' tagid=" . $tag->id . ">" . strtoupper($tag->name) . "</a>";
                $count++;
            }
            // $appendCount = count($user->tags) > 5 ? count($user->tags) - 5 : 0;
            // if($appendCount) {
            //     $tagHtml .= "<a href='" . $tagUrl . "' class='tag countTag'>" . $appendCount . "</a>";
            // }
        }
    ?>

        <div class="col-xs-12 col-md-4 col-lg-4 col-sm-6 linksContainer" data-toggle="tooltip" data-placement="top" style="height: 180px;" link-id={{ $user->id }}>
            <div class="well" style="height: 100%">
                <h1 class="link-title">
                    <a class="post-link" href="{{ $user->link }}?ref=learnphptoday" title="{{ $user->title }}">{{ $user->title }}
                        <small>
                        <?php
                            $parse = parse_url($user->link);
                            $source = str_replace('www.', '', $parse['host']);
                            echo "(" . $source . ")";
                            $shareURL = $user->link . '?ref=learnphptoday';
                        ?>
                        </small>
                    </a>
                </h1>
                <!-- <div class="description">{{ str_limit(strip_tags($user->content), 200) }}</div> -->
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
                        <i class="fa fa-eye fa-lg" aria-hidden="true" style="vertical-align: middle;"></i>
                        <span class="" id="view_{{ $user->id }}">0</span>
                    </a>
                    <a href="#" class="upvote" data-toggle="tooltip" data-placement="top" title="Click to Upvote.">
                        <i class="fa fa-arrow-up  fa-lg" aria-hidden="true" style="vertical-align: middle;"></i>
                        <span class="" id="upvote_{{ $user->id }}">0</span>
                    </a>
                    <a href="#" class="recommend" data-toggle="tooltip" data-placement="top" title="Click to bookmark.">
                        <i class="fa fa-bookmark fa-lg recommendHeart" aria-hidden="true"  style="vertical-align: middle;"></i>
                        <span class="" title="" dir="ltr"  id="recommend_{{ $user->id }}">0</span>
                    </a>

                    <div class="pull-right socialShareButtons">
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareURL }}&title={{ $user->title }}&summary=&source={{ $source }}" class="linkedin">
                            <i class="fa fa-linkedin fa-lg" aria-hidden="true" style="vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="Click to share on LinkedIN."></i>
                        </a>

                        <a href="http://www.facebook.com/sharer.php?u={{ $shareURL }}" target="_BLANK" class="facebook">
                            <i class="fa fa-facebook fa-lg" aria-hidden="true" style="vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="Click to share on Facebook."></i>
                        </a>

                        <a href="http://twitter.com/share?text={{ $user->title }}&url={{ $shareURL }}" class="twitter-share-button twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
                            <i class="fa fa-twitter fa-lg" aria-hidden="true" style="vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="Click to share on Twitter."></i>
                        </a>
                        <a href="http://www.reddit.com/submit?url={{ $shareURL }}&title={{ $user->title }}" target="_BLANK" class="reddit">
                            <i class="fa fa-reddit fa-lg" aria-hidden="true" style="vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="Click to share on Reddit."></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="pagination"> {{ $allLinks->links() }} </div>
    </div>
</div>