bioEp.init({
    html: '<div id="mc_embed_signup"><h2>Subscribe our Newsletter</h2><p>Join the daily newsletter and never miss out on important updates and news. You can expect quick tips, links to interesting tutorials, updates and packages. We will never ever ever ever send you ads as spam. </p><form action="//learnphptoday.us16.list-manage.com/subscribe/post?u=48ed5ee6722b8f1018036ed76&amp;id=426dfb94e2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate><div id="mc_embed_signup_scroll"><input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email address" required><div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_48ed5ee6722b8f1018036ed76_426dfb94e2" tabindex="-1" value=""></div><div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div></div></form></div>',
    css: '#mc_embed_signup {font-size: 12px;}#mc_embed_signup h2 {padding: 10px 0 0 14px; font-size: 2.0em; color: #f4645f;}#mc_embed_signup_scroll{float: left; width: 100%;} #mc_embed_signup_scroll .clear{position: absolute; right: 20px;} #mc_embed_signup input.email{width: 96%;} #mc_embed_signup p {font-size: 14px; padding:1px 9px 0 14px;}',
    delay: 2,
    cookieExp: 7,
    height: 225,
    width: 500
});
var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

if(isMobile) {
    $("#searchContainer").hide();
    $("#navbar-collapse-0").addClass('collapse');
    $(".pagination").show();
} else {
    $("#navbar-collapse-0").hide();
    $(".pagination").hide();
    $("#manageContainer .pagination").show();
}

function getPosts(page, searchTerm, params) {
    var more = 0;
    if(typeof params === 'object'){
        more = 1;
    }
    $.ajax({
        url : window.location.pathname + '?page=' + page,
        dataType: 'json',
        data: {searchTerm: searchTerm, more: more},
    }).done(function (response) {
        if(typeof params === 'object'){
            $(".pagination").remove();
            $('#links-container .infinite-scroll').append(response);
            $(".pagination").hide();
        } else {
            var containerId = 'links-container';
            if($('#links-container').length) {
                containerId = 'links-container';
            } else if($('#manageContainer').length) {
                containerId = 'manageContainer';
            }
            $('#' + containerId).html(response);
            location.hash = page;
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
        
        if(searchTerm == '')
            NProgress.set(100);
        activateToolTip();
        populateNumbers();
        // assignVoting();
        
    }).fail(function () {
        // alert('Posts could not be loaded.');
    });
}

function activateToolTip() {
    if($('[data-toggle="tooltip"]').length)
        $('[data-toggle="tooltip"]').tooltip();
}

function populateNumbers() {
    NProgress.start();
    var postIds = '';
    var classToUse = 'linksContainer';
    if($(".view-more").length) {
        classToUse = 'view-more';
    }
    $("." + classToUse).each(function(){
        postIds += $(this).attr('link-id') + ',';
    });
    axios.post('/numbers/fetch', {
        postIds: postIds
    })
    .then(function (response) {
        if(response.data) {
            $.each(response.data.stats, function(k, v){
                $('#view_' + k).text(v.view_count);
                $('#upvote_' + k).text(v.upvote_count);
                $('#recommend_' + k).text(v.recommend_count);
            });

            $.each(response.data.upvotes, function(k, v){
                $('#upvote_' + v).prev().addClass('active');
            });

            $.each(response.data.recommends, function(k, v){
                $('#recommend_' + v).prev().addClass('active');
            });
        }
        NProgress.set(100);
        if($(".view-more").length) {
            $(".view-more").removeClass('view-more');
        }
    })
    .catch(function (error) {
        console.log(error);
    });
}

$(document.body).on('click', '.post-link', function(e){
    e.preventDefault();
    var urlToGo = $(this).attr('href');
    track($(this).parents(".linksContainer:first").attr('link-id'), urlToGo);
    window.open(urlToGo);
    return false;
    // ga('send', 'event', 'outbound_link', urlToGo,
    //     {
    //         'hitCallback': function () {
    //             document.location = urlToGo;
    //         }
    //     }
    // );
});

$(document.body).on('click', '.upvote, .recommend', function(){
    var fieldToUpdate = $(this).find('span');
    var currentCount = parseInt(fieldToUpdate.text());
    var increDecre = '';
    if(!$(this).find('i').hasClass('active')) {
        $(this).find('i').addClass('active');
        increDecre = 1;
        currentCount++;
    } else {
        $(this).find('i').removeClass('active');
        increDecre = 0;
        currentCount--;
    }
    axios.post('/numbers/update', {
        action: $(this).attr('class'),
        link_id: $(this).parents(".linksContainer:first").attr('link-id'),
        increDecre: increDecre
    })
    .then(function (response) {
        fieldToUpdate.text(currentCount);
        NProgress.set(100);
    })
    .catch(function (error) {
        console.log(error);
        $("#loginNavigation").trigger('click');
    });
    return false;
});

// Toggling the 'opened' css class will trigger the show/hide animation
$(document.body).on('click', '.showSocialButtons', function(e){
    $('.socialPlugin .socials').removeClass('opened');
    e.preventDefault();
    $(this).parent().find('.socials').toggleClass('opened');
});

$(document.body).on('click', '#existingUserLogin', function(){
    $("#registerModal .close").click();
    $("#loginNavigation").trigger('click');
});

$(document.body).on('click', '#newUserLogin', function(){
    $("#loginModal .close").click();
    $("#registerNavigation").trigger('click');
});

/* when a user clicks, toggle the 'is-animating' class */
$(".recommendHeart").on('click touchstart', function(){
  $(this).toggleClass('is_animating');
});

/*when the animation is over, remove the class*/
$(".recommendHeart").on('animationend', function(){
  $(this).toggleClass('is_animating');
});

$(document).on('click', '#searchIcon', function(){
    $("#searchContainer #search").slideToggle('slow');
});

$("#search").on('keyup', function(e){
    var searchTerm = $(this).val();
    $("#searchContainer #searchclear").hide();
    if(e.keyCode == 8) {
        getPosts(1, $("#search").val(), '');
    } else if(searchTerm.length > 2) {
        $("#searchContainer #searchclear").show();
        setTimeout(function(){
            getPosts(1, searchTerm, '');
        }, 1000);
    }
});

$("#searchMobile").on('keyup', function(e){
    var searchTerm = $(this).val();
    if(searchTerm.length > 2) {
        // $("#searchContainer #searchclear").show();
        setTimeout(function(){
            getPosts(1, searchTerm, '');
        }, 1000);
    }
});

$(document).on('click', '#searchclear', function(){
    $("#search").val('');
    var pageNumberToUse = 1;
    if($('#links-container').data('pg-no')) {
        pageNumberToUse = $('#links-container').data('pg-no');
    }
    getPosts(pageNumberToUse, $("#search").val(), '');
    $('#searchIcon').trigger('click');
});

$(document).on('click', '.pagination a', function (e, params) {
    var pageNumber = $(this).attr('href').split('page=')[1];
    if(pageNumber !== undefined) {
        NProgress.start();
        $('#links-container').data('pg-no', pageNumber);
        getPosts(pageNumber, $("#search").val(), params);
        e.preventDefault();
    }
});

$(document).on('click', '#saveTags', function(){
    var linksId = '';
    $(".linksCheckbox:checked").each(function(){
       linksId += $(this).val() + ',';
    });
    axios.post('/saveTagsForLinks', {
        tags: $("#selectedTags").val(),
        linksId: linksId
    })
    .then(function (response) {
        if(response.status == 200 && response.statusText == 'OK') {
            location.reload();
        } else {
            alert('Oops! Encountered some error. Refresh and try again.');
        }
    });
});

// $(document).on('click', '#feedback-button', function(){
//     axios.get('/feedback')
//         .then(function (response) {
//         console.log(response);
//     })
//         .catch(function (error) {
//         console.log(error);
//     });
// });

function fetchData(){
    var fetch_data = '';  
    var element = $(this);  
    var id = element.attr("tagid");
    axios.post('/tag-data', {
        id: id
    })
    .then(function (response) {

    });

    return fetch_data;  
}

var page = 1;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page) {
    if($("#links-container").length)
        $(".pagination a[rel='next']").trigger('click', {'loadmore': 1});
}

$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" Delete");
    $('#footer_action_button').removeClass('glyphicon-check');
    $('#footer_action_button').addClass('glyphicon-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').removeClass('edit');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('Delete');
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    var stuff = $(this).data('info').split(',');
    $('.did').text(stuff[0]);
    $('.dname').html(stuff[1] +" "+stuff[2]);
    $('#myManageLinkModal').modal('show');
});

$('#myManageLinkModal').on('click', '.delete', function() {
    $.ajax({
        type: 'post',
        url: '/manage/delete-link',
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('.did').text()
        },
        success: function(data) {
            $('.item' + $('.did').text()).remove();
        }
    });
});

$(document).ready(function(){
    // if($('#datatable').length) {
    //     $('#datatable').DataTable();
    // }
    
    populateNumbers();
    activateToolTip();

    // $('.tag').popover({  
    //     title:fetchData,  
    //     html:true,
    //     trigger: "hover",
    //     placement:'right'  
    // }); 

    if($('#tagsSelector #tags').length) {
        $('#tagsSelector #tags').selectize({
            delimiter: ',',
            persist: false,
            valueField: 'tag',
            labelField: 'tag',
            searchField: 'tag',
            options: tags,
            create: false,
            maxOptions: 100,
            hideSelected: true,
            create: function(input) {
                return {
                    tag: input
                }
            },
            onChange: function(value) {
                $("#selectedTags").val(value);
            }
        });
    }

    var loginForm = $("#loginForm");
    loginForm.submit(function(e){
        e.preventDefault();
        var formData = loginForm.serialize();
        $('#login-errors-name').html("");
        $('#login-errors-email').html("");
        $('#login-errors-password').html("");
        $("#login-name").removeClass("has-error");
        $("#login-email").removeClass("has-error");
        $("#login-password").removeClass("has-error");
        $("#loginToSystem").html('<i class="fa fa-spinner fa-spin"></i> Logging...');
        $.ajax({
            url:'/login',
            type:'POST',
            data:formData,
            success:function(data){
                $('#loginModal').modal( 'hide' );
                location.reload(true);
            },
            error: function (data) {
                console.log(data.responseText);
                var obj = jQuery.parseJSON( data.responseText );
                if(obj.email){
                    $("#login-email").addClass("has-error");
                    $( '#login-errors-email' ).html( obj.email );
                }
                if(obj.password){
                    $("#login-password").addClass("has-error");
                    $( '#login-errors-password' ).html( obj.password );
                }
            }
        });
    });

    var registerForm = $("#registerForm");
    registerForm.submit(function(e){
        e.preventDefault();
        var formData = registerForm.serialize();
        $( '#register-errors-name' ).html( "" );
        $( '#register-errors-email' ).html( "" );
        $( '#register-errors-password' ).html( "" );
        $("#register-name").removeClass("has-error");
        $("#register-email").removeClass("has-error");
        $("#register-password").removeClass("has-error");
        $("#registerToSystem").html('<i class="fa fa-spinner fa-spin"></i> Registering...');
        $.ajax({
            url:'/register',
            type:'POST',
            data:formData,
            success:function(data){
                $("#registerModal .alert-success").text('You have successfully registered. An email is sent to you for verification.').removeClass('hidden');
                registerForm[0].reset();
                grecaptcha.reset();
                $("#registerToSystem").html('Register');
                // setTimeout(function(){
                //     $("#registerModal .close").click();
                //     // $('#registerModal').modal( 'hide' );
                // }, 2000);
                // $('#registerModal').modal( 'hide' );
                // location.reload(true);
            },
            error: function (data) {
                var obj = jQuery.parseJSON( data.responseText );
               if(obj.name){
                    $("#register-name").addClass("has-error");
                    $( '#register-errors-name' ).html( obj.name );
                }
                if(obj.email){
                    $("#register-email").addClass("has-error");
                    $( '#register-errors-email' ).html( obj.email );
                }
                if(obj.password){
                    $("#register-password").addClass("has-error");
                    $( '#register-errors-password' ).html( obj.password );
                }
            }
        });
    });

    var feedbackForm = $("#feedbackForm");
    feedbackForm.submit(function(e){
        feedbackForm.find('.form-group').removeClass('has-error');
        feedbackForm.find('.text-danger').text('');
        feedbackForm.find(".alert-success").addClass('hidden');
        e.preventDefault();
        var formData = feedbackForm.serialize();
        $.ajax({
            url:'/feedback',
            type:'POST',
            data:formData,
            dataType: 'JSON',
            success:function(response) {
                $("#feedbackModal .alert-success").text(response.message).removeClass('hidden');
                feedbackForm[0].reset();
                setTimeout(function(){
                    $("#feedbackModal .close").click();
                }, 2000);
            },
            error: function(response) {
                var obj = jQuery.parseJSON( response.responseText );
                $.each(obj, function(k, v){
                    if($("input[name="+k+"]").length) {
                        $("input[name="+k+"]").parent().addClass('has-error');
                        $("input[name="+k+"]").next().text(v);    
                    } else if($("textarea[name="+k+"]").length) {
                        $("textarea[name="+k+"]").parent().addClass('has-error');
                        $("textarea[name="+k+"]").next().text(v);    
                    }
                    
                });
            }
        });
    });
});

function track(link_id, urlToGo) {

    var client = new ClientJS();
    var browser = client.getBrowser(); // Get Browser
    var browserVersion = client.getBrowserVersion(); // Get Browser Version
    var OS = client.getOS(); // Get OS Version
    var osVersion = client.getOSVersion(); // Get OS Version
    var deviceType = client.getDeviceType(); // Get Device Type
    var isMobile = client.isMobile(); // Check For Mobile
    var timeZone = client.getTimeZone(); // Get Time Zone
    
    axios.post('/track', {
            link_id: link_id,
            browser: browser,
            timeZone:timeZone,
            isMobile:isMobile,
            deviceType:deviceType,
            osVersion:osVersion,
            OS:OS,
            browserVersion:browserVersion,
    }).then(function (response) {
        // window.location = urlToGo;
        populateNumbers();
    });
}