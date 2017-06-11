function getPosts(page) {
    $.ajax({
        url : '?page=' + page,
        dataType: 'json',
    }).done(function (data) {
    	NProgress.set(100);
        $('#links-container').html(data);
        activateToolTip();
        populateNumbers();
        // assignVoting();
        location.hash = page;
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }).fail(function () {
        // alert('Posts could not be loaded.');
    });
}

function activateToolTip() {
    $('[data-toggle="tooltip"]').tooltip();
}

function populateNumbers() {
    // if($(".votingClass").length) {
        NProgress.start();
        var postIds = '';
        $(".linksContainer").each(function(){
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
        })
        .catch(function (error) {
            console.log(error);
        });
    // }
}

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

$(document).ready(function(){
    populateNumbers();
    activateToolTip();
    $(document).on('click', '.pagination a', function (e) {
        NProgress.start();
        getPosts($(this).attr('href').split('page=')[1]);
        e.preventDefault();
    });

    var loginForm = $("#loginForm");
    loginForm.submit(function(e){
        e.preventDefault();
        var formData = loginForm.serialize();
        $( '#login-errors-name' ).html( "" );
        $( '#login-errors-email' ).html( "" );
        $( '#login-errors-password' ).html( "" );
        $("#login-name").removeClass("has-error");
        $("#login-email").removeClass("has-error");
        $("#login-password").removeClass("has-error");

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

        $.ajax({
            url:'/register',
            type:'POST',
            data:formData,
            success:function(data){
                $('#registerModal').modal( 'hide' );
                location.reload(true);
            },
            error: function (data) {
                console.log(data.responseText);
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
});
