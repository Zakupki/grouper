// Scalable body background

var isBgLoaded = false,
    pageBg;

(function($){
    $.fn.scalable = function(o){
        o = $.extend({
            speed: 'normal'
        }, o || {});

        return this.each(function(){
            var canvas = this,
                $images = $('img:first', this);

            $images.each(function(i){
                if (this.complete) {
                    parse(this);
                } else {
                    this.onload = function(){
                        parse(this);
                    };
                }
            });

            function parse(image) {
                var $image = $(image),
                    ratio = image.clientWidth / image.clientHeight;

                scale(image, ratio);
                $(window).resize(function(){
                    scale(image, ratio);
                });

                $image.hide().css({'left': '50%', 'top': '50%'}).fadeIn(o.speed, function() {
                    isBgLoaded = true;
                });
            }

            function scale(image, ratio) {
                if (canvas.clientHeight * ratio > canvas.clientWidth) {
                    image.style.width = 'auto';
                    image.style.height = '100%';
                } else {
                    image.style.width = '100%';
                    image.style.height = 'auto';
                }

                image.style.marginLeft = -image.clientWidth / 2 + 'px';
                image.style.marginTop = -image.clientHeight / 2 + 'px';
            }
        });
    };
}) (jQuery);


// Smart resize
(function($) {
    
    var event = $.event,
        resizeTimeout;

    event.special[ "smartresize" ] = {
        setup: function() {
            $( this ).bind( "resize", event.special.smartresize.handler );
        },
        teardown: function() {
            $( this ).unbind( "resize", event.special.smartresize.handler );
        },
        handler: function( event, execAsap ) {
            // Save the context
            var context = this,
                args = arguments;

            // set correct event type
            event.type = "smartresize";

            if(resizeTimeout)
                clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                jQuery.event.handle.apply( context, args );
            }, execAsap === "execAsap"? 0 : 100);
        }
    }

    $.fn.smartresize = function( fn ) {
        return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
    };

})(jQuery);


// Flexible layout with 480px columns
var oldExtraColumns;

function flexibleModules() {
    var contentBlock = $('.g-content'),
        minmumBodyWidth = 940,
        columnWidth= 480,
        extraColumns = Math.floor(($('body').width() - minmumBodyWidth - 80) / columnWidth),
        contentWidth;

    if (extraColumns != oldExtraColumns) {
        if (extraColumns > 0) {
            contentWidth =  contentBlock.width(minmumBodyWidth + columnWidth * extraColumns).width();
        } else {
            contentWidth = contentBlock.width(minmumBodyWidth).width();
        };

        navBar(contentWidth);

        $('.g-logo-container').width(contentWidth);
        $('.g-player').width(contentWidth);
    };

    if ($('.b-container .b-slider')) {
        superPager();
    };
    oldExtraColumns = extraColumns;
}


// Resizable navigation
function navBar(contentWidth) {
    var navigationList = $('.b-navigation-list'),
        navigationTotalWidth = 0,
        firstHiddenItemPosition = false,
        dropdownIconWidth = 51;

    // Reseting dropdown
    navigationList.width(contentWidth).css({margin: '0 auto'});
    navigationList.find('.show-more').remove();
    navigationList.find('li').show();

    // Finding first extra item index
    navigationList.find('li').each(function() {
        var itemInnerWidth =  $(this).innerWidth();
        if ((dropdownIconWidth + itemInnerWidth) < contentWidth) {
            dropdownIconWidth += itemInnerWidth;
            navigationTotalWidth += itemInnerWidth;
        } else if (!firstHiddenItemPosition) {
            firstHiddenItemPosition = $(this).index();
        };
    });

    if (firstHiddenItemPosition !== false) {
        // Creating dropdown menu item
        var showMoreBlock = $('<li>&nbsp;<ul></ul></li>').addClass('show-more').appendTo(navigationList),
            dropdown = navigationList.find('.show-more > ul').addClass('b-dropdown').hide();

        // Filling dropdown with items
        var dropdownItems =  $('.g-navigation > ul > li').slice(firstHiddenItemPosition, -1);
        dropdownItems.clone().appendTo(dropdown);
        dropdownItems.hide();

        // Setting dropdown as current if contain current menu items
        dropdown.find('li').has('i') ? dropdown.find('li i').appendTo(showMoreBlock) : 0;

        // Hiding and showing dropdown
        showMoreBlock.hover(function() {
            dropdown.show();
        }, function() {
            dropdown.hide();
        });

        // Copy to outter func later
        $('.b-navigation-list a').click(function(event) {
            event.preventDefault();
            var backgroundBlock = $('.g-background'),
                backgroundUrl = $(this).attr('rel');

            if (pageBg != backgroundUrl) {
                pageBg = backgroundUrl;
                backgroundBlock.find('img:first').attr('src', backgroundUrl);
                backgroundBlock.scalable();
            };

            $.history.load($(this).attr('href'));
        });
    };
};


// Super pager
function superPager() {
    var slider = $('.b-container .b-slider'),
        itemsTotalWidth = slider.find('li').length * 480,
        contentWidth = $('.g-content').width() + 20,
        pagerItemsCounter = Math.ceil(itemsTotalWidth / contentWidth),
        pager = $('.b-pager');

    // Slider reset
    slider.css({marginLeft: 0});
    pager.empty();

    // Pager
    if (itemsTotalWidth > contentWidth) {
        for(i=0; i<pagerItemsCounter; i++) { pager.append('<li></li>'); };

        pager.find('li').each(function() {
            $(this).index() == 0 ? $(this).addClass('active') : 0;

            $(this).unbind().click(function() {
                pager.find('.active').removeClass('active');
                $(this).addClass('active');

                sliderMargin = ($(this).index() == 0) ? 0 : -($(this).index()) * contentWidth;
                slider.animate({marginLeft: sliderMargin}, 500);
            });
        });
    };
};


// Login box popup
function loginBox() {
    var gridOverlay = $('<div></div>').addClass('g-grid-overlay').appendTo('body'),
        loginBox = $('.b-login-box').show(),
        loginBoxOverlay = $('.b-login-box-overlay').show(),
        loginForm = loginBox.find('.login-form'),
        retrievePasswordForm = loginBox.find('.retrieve-password-form'),
        ua = navigator.userAgent,
        isiPad = /iPad/i.test(ua) || /iPhone OS 3_1_2/i.test(ua) || /iPhone OS 3_2_2/i.test(ua);

    loginBox.find('.login').focus();

    loginBox.find(' .close').unbind().click(function(event) {
        event.preventDefault();
        loginBox.hide();
        loginBoxOverlay.hide();
        gridOverlay.remove();
    });

    if (isiPad) {
        loginForm.html($('<span></span>').addClass('ipad-alert').html('Вы не можете зайти в систему управления контентом с данного устройства.').appendTo(loginForm));

    } else {
        loginForm.unbind().find(':submit').click(function(event) {
            event.preventDefault();

            var rememberMe = loginForm.find('.remember-me input').attr('checked') ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: '/user/login/',
                data: 'data={"token":"' + $('#token').val() + '", "email":"' + loginForm.find('.login').val() + '", "password":"' + loginForm.find('.password').val() + '", "action":1, "remember":' + rememberMe + '}',
                success: function(response) {
                    loginResponse = $.parseJSON(response);

                    $('#token').val(loginResponse.token);

                    loginResponse.error ? loginForm.find('.alert').html(loginResponse.status) : loginForm.submit();
                }
            });
        });
    };

    retrievePasswordForm.unbind().submit(function(event) {
        event.preventDefault();

        var formBlock = $(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: 'data={"email":"' + formBlock.find('.email').val() + '"}',
            success: function(data) {
                formBlock.find('.alert').html(data);
            }
        });
    });
};


// AJAX content loading
function quietContentLoading(sectionName) {
    var contentBlock = $('.g-content').height($('.g-content').height() == 0 ? 'auto' : $('.g-content').height()).html($('<div></div>').addClass('b-content-loading')),
        editModeLink = $('.exit-edit-mode'),
        navigationBlock = $('.g-navigation .b-navigation-list li.current').removeClass('current'),
        activeNavigationItem = $('a[href$="' + sectionName + '"]').parent().addClass('current');

    $.ajax({
        url: sectionName,
        context: contentBlock,
        success: function(data) {
            editModeLink.attr('href', '/admin' + sectionName);
            $(this).html($('<div></div>').addClass('g-ajax-content'));
            $(this).find('.g-ajax-content').append(data).fadeIn(500);
            flexibleModules();
        }
    });
};


// Init
$().ready(function() {
    $.history.init(function(hash){
        if (hash == '') {
            $('.g-content').html('');
            flexibleModules()
        } else {
            quietContentLoading(hash);
        };
    }, { unescape: "/" });

    $('.g-background').scalable();
    
    $('.g-header .login a').click(function(event) {
        event.preventDefault();
        loginBox();
    });

    $('.b-login-box .forgot-password').toggle(function() {
        $('.b-login-box .login-form').hide();
        $('.b-login-box .retrieve-password-form').show();
        $(this).html('Назад к логину');
    }, function() {
        $('.b-login-box .retrieve-password-form').hide();
        $('.b-login-box .login-form').show()
        $(this).html('Забыли пароль?');
    });
    
    $('.b-navigation-list a').click(function(event) {
        event.preventDefault();
        var backgroundBlock = $('.g-background'),
            backgroundUrl = $(this).attr('rel');
        
        if (pageBg != backgroundUrl && isBgLoaded) {
            pageBg = backgroundUrl;
            isBgLoaded = false;
            backgroundBlock.find('img:first').attr('src', backgroundUrl);
            backgroundBlock.scalable();
        };

        $.history.load($(this).attr('href'));
    });

    $(window).smartresize(function(){
        flexibleModules();
    });


    // Old browsers alert
    if ($.browser.msie && parseInt($.browser.version) < 8) {
        var $alert = $('.b-old-browser');

        $alert.find('h3').css('padding-top', $(window).height() / 2 - 140 + 'px');
        $alert.find('.b-browser-name').html('Internet Explorer ' + $.browser.version);
        $alert.show();
    };
});