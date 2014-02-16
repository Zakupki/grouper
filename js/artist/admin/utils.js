/* POPUP
----------------------------------------------- */
/* popup
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        xhr = null,
        $src = $(),
        $object = $(),
        $doc = $(document),
        $popup = $('<div class="popup"><div class="popup-window"><div class="popup-r"><div class="popup-l"><div class="popup-content"></div></div></div><div class="popup-rt"><div class="popup-lt"></div></div><div class="popup-rb"><div class="popup-lb"></div></div><div class="popup-close"><i class="i"></i></div></div><div class="popup-loading"><i class="i"></i></div><div class="popup-overlay"></div></div>'),
        $window = $popup.find('.popup-window'),
        $close = $popup.find('.popup-close'),
        $content = $popup.find('.popup-content'),
        $overlay = $popup.find('.popup-overlay'),
        $loading = $popup.find('.popup-loading');
    function init() {
        if ($('.popup').length) {
            return;
        }
        $('body').append($popup);
        $window.on('click', function(e){
            e.stopPropagation();
        });
        $close.add($loading).on('click', close).on('selectstart', function(e){
            e.preventDefault();
        });
        $overlay.on('click', function(){
            if (o.closeOnOverlay) {
                close();
            }
        }).on('selectstart', function(e){
            e.preventDefault();
        });
    }
    function clear() {
        $popup.css({'left': ''});
        $loading.css({'left': ''});
        $window.stop(true).css({'left': '', 'opacity': '', 'margin': ''});
        if ($src.length) {
            $src.html($object);
        } else {
            $object.detach();
        }
        if (xhr) {
            xhr.abort();
        }
        o = {};
        el = {};
        xhr = null;
        $src = $();
        $object = $();
    }
    function start(param1, param2) {
        clear();
        var params = {};
        if (param1) {
            if (param1.nodeType) {
                el = param1;
            } else {
                params = param1;
            }
        }
        if (param2) {
            params = param2;
        }
        if (!params.href && el.nodeType) {
            var rel = $(el).attr('rel'),
                href = $(el).attr('href');
            if (rel && rel.indexOf('popup:') == 0 && rel.substr(6).length > 1) {
                params.href = rel.substr(6);
            } else if (href) {
                params.href = href;
            }
        }
        o = $.extend({}, $.popup.defaults, params);
        handle();
    }
    function handle() {
        if (o.content) {
            html();
        } else if (o.text) {
            text();
        } else if (o.src) {
            inline();
        } else if (o.href) {
            if (o.href.indexOf('#') == 0) {
                href();
            } else {
                ajax();
            }
        } else {
            empty();
        }
        $popup.addClass(o.extraClass);
        $close.toggle(o.showClose);
        function html() {
            showOverlay();
            $object = $(o.content);
            $content.html($object);
            showWindow();
        }
        function text() {
            showOverlay();
            $object = $('<div class="popup-text">' + o.text + '</div>');
            $content.html($object);
            showWindow();
        }
        function inline() {
            showOverlay();
            $src = $(o.src);
            $object = $src.contents();
            $content.html($object);
            showWindow();
        }
        function href() {
            showOverlay();
            $src = $(o.href);
            $object = $src.contents();
            $content.html($object);
            showWindow();
        }
        function ajax() {
            showOverlay();
            showLoading();
            xhr = $.get(o.href, function(data){
                $object = $(data);
                $content.html($object);
                hideLoading();
                showWindow();
            });
        }
        function empty() {
            showOverlay();
        }
    }
    function showOverlay() {
        if (o.beforeShowOverlay) {
            o.beforeShowOverlay(el);
        }
        if (o.showOverlay) {
            o.showOverlay(el, o.afterShowOverlay);
        } else {
            $.popup.showOverlay(o.afterShowOverlay);
        }
    };
    function hideOverlay() {
        if (o.beforeHideOverlay) {
            o.beforeHideOverlay(el);
        }
        if (o.hideOverlay) {
            o.hideOverlay(el, o.afterHideOverlay);
        } else {
            $.popup.afterHideOverlay(o.afterHideOverlay);
        }
    };
    function showLoading() {
        if (o.beforeShowLoading) {
            o.beforeShowLoading(el);
        }
        if (o.showLoading) {
            o.showLoading(el, o.afterShowLoading);
        } else {
            $.popup.showLoading(o.afterShowLoading);
        }
    }
    function hideLoading() {
        if (o.beforeHideLoading) {
            o.beforeHideLoading(el);
        }
        if (o.hideLoading) {
            o.hideLoading(el, o.afterHideLoading);
        } else {
            $.popup.hideLoading(o.afterHideLoading);
        }
    }
    function showWindow() {
        if (o.beforeShowWindow) {
            o.beforeShowWindow(el);
        }
        if (o.showWindow) {
            o.showWindow(el, o.afterShowWindow);
        } else {
            $.popup.showWindow(o.afterShowWindow);
        }
    }
    function hideWindow() {
        if (o.beforeHideWindow) {
            o.beforeHideWindow(el);
        }
        if (o.hideWindow) {
            o.hideWindow(el, o.afterHideWindow);
        } else {
            $.popup.hideWindow(o.afterHideWindow);
        }
    }
    function error() {
        close();
    }
    function close() {
        if (o.beforeClose) {
            o.beforeClose(el);
        }
        if (o.close) {
            o.close(el, o.afterClose);
        } else {
            $.popup.close(o.afterClose);
        }
    }
    $.fn.popup = function(params){
        return this.click(function(e){
            e.preventDefault();
            $.popup(this, params);
        });
    };
    $.popup = function(param1, param2){
        start(param1, param2);
    };
    $.popup.showOverlay = function(complete){
        $popup.css({'left': 0});
        if (complete) {
            complete(el);
        }
        $doc.on('keyup.popup', function(e){
            if (e.which == 27 && o.closeOnEsc) {
                close();
            }
        });
    };
    $.popup.hideOverlay = function(complete){
        $popup.css({'left': ''});
        if (complete) {
            complete(el);
        }
    };
    $.popup.showLoading = function(complete){
        $loading.css({'left': '50%'});
        if (complete) {
            complete(el);
        }
    };
    $.popup.hideLoading = function(complete){
        $loading.css({'left': ''});
        if (complete) {
            complete(el);
        }
    };
    $.popup.showWindow = function(complete) {
        $window.stop(true).css({'opacity': 0, 'left': '50%', 'margin-left': -($window.width() / 2), 'margin-top': -($window.height() / 2)}).fadeTo(o.speed, 1, function(){
            if (complete) {
                complete(el);
            }
        });
    }
    $.popup.hideWindow = function(complete){
        $window.stop(true).fadeTo(o.speed, 0, function(){
            if (complete) {
                complete(el);
            }
        });
    };
    $.popup.close = function(complete){
        $.popup.hideLoading();
        $.popup.hideWindow(function(){
            $.popup.hideOverlay(complete);
            if (o.extraClass) {
                $popup.removeClass(o.extraClass);
            }
            $doc.off('.popup');
            clear();
        });
    };
    $.popup.get = function(){
        return o;
    };
    $.popup.set = function(params){
        $.extend(o, params);
    };
    $.popup.defaults = {
        speed: 100,
        showClose: true,
        closeOnEsc: true
    };
    $(function(){
        init();
    });
})(jQuery);


/* alert
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        $doc = $(document),
        $alert = $('<div class="alert"><div class="alert-content"></div><div class="alert-buttons"><div class="alert-ok"><i class="i"></i></div></div></div>'),
        $content = $('.alert-content', $alert),
        $ok = $('.alert-ok', $alert);
    function init() {
        $ok.on('click', ok).on('selectstart', function(e){
            e.preventDefault();
        });
    }
    function clear() {
        o = {};
        el = {};
    }
    function start(param1, param2) {
        clear();
        var params = {};
        if (param1) {
            if (param1.nodeType) {
                el = param1;
            } else {
                params = param1;
            }
        }
        if (param2) {
            params = param2;
        }
        o = $.extend({}, $.alert.defaults, params);
        handle();
    }
    function handle() {
        var params = $.extend({}, o);
        params.text = null;
        params.content = $alert;
        params.beforeShowOverlay = function(){
            if (o.beforeShowOverlay) {
                o.beforeShowOverlay(el);
            }
            $doc.on('keyup.alert', function(e){
                if (e.which == 13 && o.okOnEnter) {
                    ok();
                }
            });
        };
        params.afterClose = function(){
            if (o.afterClose) {
                o.afterClose(el);
            }
            $doc.off('.alert');
        };
        if (o.content) {
            $content.html(o.content);
        } else if (o.text) {
            $content.html('<div class="confirm-text">' + o.text + '</div>');
        } else {
            params.content = null;
        }
        $.popup(el, params);
    }
    function ok() {
        if (o.ok) {
            o.ok(el);
        } else {
            $.alert.ok();
        }
    }
    $.fn.alert = function(params){
        return this.click(function(e){
            e.preventDefault();
            $.alert(this, params);
        });
    };
    $.alert = function(param1, param2){
        start(param1, param2);
    };
    $.alert.ok = function(){
        $.popup.close(function(){
            $doc.off('.alert');
        });
    };
    $.alert.defaults = {
        showClose: false,
        okOnEnter: true
    };
    $(function(){
        init();
    });
})(jQuery);



/* confirm
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        $doc = $(document),
        $confirm = $('<div class="confirm"><div class="confirm-content"></div><div class="confirm-buttons"><div class="confirm-cancel"><i class="i"></i></div><div class="confirm-ok"><i class="i"></i></div></div></div>'),
        $content = $('.confirm-content', $confirm),
        $ok = $('.confirm-ok', $confirm),
        $cancel = $('.confirm-cancel', $confirm);
    function init() {
        $ok.on('click', ok).on('selectstart', function(e){
            e.preventDefault();
        });
        $cancel.on('click', cancel).on('selectstart', function(e){
            e.preventDefault();
        });
    }
    function start(param1, param2) {
        clear();
        var params = {};
        if (param1) {
            if (param1.nodeType) {
                el = param1;
            } else {
                params = param1;
            }
        }
        if (param2) {
            params = param2;
        }
        o = $.extend({}, $.confirm.defaults, params);
        handle();
    }
    function handle() {
        var params = $.extend({}, o);
        params.text = null;
        params.content = $confirm;
        params.beforeShowOverlay = function(){
            if (o.beforeShowOverlay) {
                o.beforeShowOverlay(el);
            }
            $doc.on('keyup.confirm', function(e){
                if (e.which == 13 && o.okOnEnter) {
                    ok();
                }
                if (e.which == 27 && o.cancelOnEsc) {
                    cancel();
                }
            });
        };
        params.afterClose = function(){
            if (o.afterClose) {
                o.afterClose(el);
            }
            $doc.off('.confirm');
        };
        if (o.content) {
            $content.html(o.content);
        } else if (o.text) {
            $content.html('<div class="confirm-text">' + o.text + '</div>');
        } else {
            params.content = null;
        }
        $.popup(el, params);
    }
    function ok() {
        if (o.ok) {
            o.ok(el);
        } else {
            $.confirm.ok();
        }
    }
    function cancel() {
        if (o.cancel) {
            o.cancel(el);
        } else {
            $.confirm.cancel();
        }
    }
    function clear() {
        o = {};
        el = {};
    }
    $.fn.confirm = function(params){
        return this.click(function(e){
            e.preventDefault();
            $.confirm(this, params);
        });
    };
    $.confirm = function(param1, param2){
        start(param1, param2);
    };
    $.confirm.ok = function(){
        $.popup.close(function(){
            $doc.off('.alert');
        });
    };
    $.confirm.cancel = function(){
        $.popup.close(function(){
            $doc.off('.alert');
        });
    };
    $.confirm.defaults = {
        text: '',
        showClose: false,
        okOnEnter: true,
        cancelOnEsc: true
    };
    $(function(){
        init();
    });
})(jQuery);




/* lang */
var laguagedata={
	1:{
		eventReccounOff: 'Выключить реккаунт',
		eventReccounOn: 'Включить реккаунт',
		reccountStateOn: 'Сейчас ваш реккаунт включен',
		reccountStateOff: 'Сейчас ваш реккаунт выключен',
		moveAllVideo: 'Перенести всё видео',
        moveAllReleases: 'Перенести все релизы',
        deleteAction: 'Удалить',
		confirm: 'Вы уверены?',
	    commentsRemoveConfirm: 'Вы уверены, что хотите удалить комментарий?',
	    basicAdminTurnOnConfirm: 'Вы уверены, что хотите включить реккаунт?',
	    basicAdminTurnOffConfirm: 'Вы уверены, что хотите выключить реккаунт?',
	    teasersAdminRemoveConfirm: 'Вы уверены, что хотите удалить баннер?',
	    eventAdminAvatarRemoveConfirm: 'Вы уверены, что хотите удалить аватар?',
	    eventAdminPosterRemoveConfirm: 'Вы уверены, что хотите удалить постер?',
	    eventAdminRemoveConfirm: 'Вы уверены, что хотите удалить это событие?',
	    videoAdminVideoRemoveConfirm: 'Вы уверены, что хотите удалить это видео?',
	    videoAdminPreviewRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
	    trackAdminTrackRemoveConfirm: 'Вы уверены, что хотите удалить трек?',
	    trackAdminCoverRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
	    galleryAdminGalleryRemoveConfirm: 'Вы уверены, что хотите удалить галерею?',
	    galleryAdminImageRemoveConfirm: 'Вы уверены, что хотите удалить фото?',
	    months: [
	        ['Январь', 'Января'],
	        ['Февраль', 'Февраля'],
	        ['Март', 'Марта'],
	        ['Апрель', 'Апреля'],
	        ['Май', 'Мая'],
	        ['Июнь', 'Июня'],
	        ['Июль', 'Июля'],
	        ['Август', 'Августа'],
	        ['Сентябрь', 'Сентября'],
	        ['Октябрь', 'Октября'],
	        ['Ноябрь', 'Ноября'],
	        ['Декабрь', 'Декабря']
	    ],
	    weekdays: ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье']
	},
	2:{
		eventReccounOff: 'Switch reccount off',
		eventReccounOn: 'Switch reccount on',
		reccountStateOn: 'Reccount is now on',
		reccountStateOff: 'Reccount is now off',
		moveAllVideo: 'Import all videos',
        moveAllReleases: 'Import all releases',
        deleteAction: 'Delete',
		confirm: 'Are you sure?',
	    commentsRemoveConfirm: 'Вы уверены, что хотите удалить комментарий?',
	    basicAdminTurnOnConfirm: 'Are you sure to switch reccount off?',
	    basicAdminTurnOffConfirm: 'Are you sure to switch reccount on?',
	    teasersAdminRemoveConfirm: 'Вы уверены, что хотите удалить баннер?',
	    eventAdminAvatarRemoveConfirm: 'Вы уверены, что хотите удалить аватар?',
	    eventAdminPosterRemoveConfirm: 'Вы уверены, что хотите удалить постер?',
	    eventAdminRemoveConfirm: 'Вы уверены, что хотите удалить это событие?',
	    videoAdminVideoRemoveConfirm: 'Вы уверены, что хотите удалить это видео?',
	    videoAdminPreviewRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
	    trackAdminTrackRemoveConfirm: 'Вы уверены, что хотите удалить трек?',
	    trackAdminCoverRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
	    galleryAdminGalleryRemoveConfirm: 'Вы уверены, что хотите удалить галерею?',
	    galleryAdminImageRemoveConfirm: 'Вы уверены, что хотите удалить фото?',
	    months: [
	        ['Январь', 'Января'],
	        ['Февраль', 'Февраля'],
	        ['Март', 'Марта'],
	        ['Апрель', 'Апреля'],
	        ['Май', 'Мая'],
	        ['Июнь', 'Июня'],
	        ['Июль', 'Июля'],
	        ['Август', 'Августа'],
	        ['Сентябрь', 'Сентября'],
	        ['Октябрь', 'Октября'],
	        ['Ноябрь', 'Ноября'],
	        ['Декабрь', 'Декабря']
	    ],
	    weekdays: ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье']
	}
};
/*laguagedata[1]=11;
laguagedata[2]=22;*/

var lang = laguagedata[languageId];
//alert(lang.confirm);


// Dynamic navigation plugin
(function($) {
    $.fn.navigationBar = function(options){
        return this.each(function(){
            options = $.extend(true, {
                dropdownIconWidth: 51
            }, options);
            
            var navigationList = $(this).children(':first'),
                navigationVisibleWidth = $('.g-content').width(),
                navigationTotalWidth = 0,
                firstHiddenItemPosition = false;
            
            navigationList.width(navigationVisibleWidth);
            
            // Reseting dropdown
            $('.show-more').remove();
            navigationList.find('li').show();
            
            // Finding first extra item index
            navigationList.find('li').each(function() {
                if ((options.dropdownIconWidth + $(this).innerWidth()) < navigationVisibleWidth) {
                    options.dropdownIconWidth += $(this).innerWidth();
                    navigationTotalWidth += $(this).innerWidth();
                } else if (!firstHiddenItemPosition) {
                    firstHiddenItemPosition = $(this).index();
                };
            });
            
            
            if (firstHiddenItemPosition !== false) {
                // Creating dropdown menu item
                $('<li>&nbsp;<ul></ul></li>').addClass('show-more').appendTo(navigationList);
                $('.show-more > ul').addClass('b-dropdown').hide();
                
                // Filling dropdown with items
                $('.g-navigation > ul > li').slice(firstHiddenItemPosition, -1).clone().appendTo('.b-dropdown');
                $('.g-navigation > ul > li').slice(firstHiddenItemPosition, -1).hide();
                
                // Setting dropdown as current if contain current menu items
                if ($('.b-dropdown li').has('i')) {$('.b-dropdown li i').appendTo($('.show-more'));};
                
                if ($('.g-submenu-slim').length > 0) {
                    if ($('.b-dropdown li').has('b')) {$('.b-dropdown li b').appendTo($('.show-more'));};
                };
                
                // Hiding and showing dropdown
                $('.show-more').hover(function() {
                    //$(this).css('backgroundPosition', '-27px 15px');
                    $('.b-dropdown').show();
                }, function() {
                    //$(this).css('backgroundPosition', '12px 15px');
                    $('.b-dropdown').hide();
                });
            };
        });
    };
})(jQuery);


// Resizable navigation
function navBar() {
    var navigationList = $('.b-navigation-list'),
        navigationTotalWidth = 0,
        firstHiddenItemPosition = false,
        dropdownIconWidth = 51,
        contentWidth = $('.g-content').width();

    // Reseting dropdown
    navigationList.width(contentWidth).css({margin: '0 auto -20px'});
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
    };
};


// Social services links sorter
(function($) {
    $.fn.socialServicesLinksSorter = function(options){
        return this.each(function(){
            options = $.extend(true, {
                servicesMaxAmount: 10,
                extraItem: 1
            }, options);

            var $form = $(this),
                $servicesContainer = $('.b-accounts', $form).sortable({stop: function() {
                    rebuildPreviewBar();
                }}),
                $iconsBar = $('.b-social-services ul', $form),
                $showTweet = $('.show-tweet', $form),
                $showNews = $('.show-news', $form),
                $showNothing = $('.show-nothing', $form),
                $addEmptyService = $('.b-button-set .add-item', $form),
                $save = $('.b-button-set .save-items', $form),
                servicesCounter = 0;


            // create social service node will all controls and add it to container
            function addItem(id, socialid, url, active, img) {
                var $socialService = $servicesContainer.find('.hidden').clone().removeClass('hidden').appendTo($servicesContainer);

                if (id) {
                    $socialService.attr('id', id).addClass(socialid).data('bgIcon', img);
                    $socialService.find('.url').val(url).attr('disabled', 'disabled');

                    if (active ==  '0') {
                        $socialService.find('.hide-item').attr('checked', true);
                    };
                };

                if (socialid == 227 || socialid == 232 || socialid == 198 || socialid == 342 || socialid == 343) {

                    switch (socialid) {
                        case '227':
                        case '232':
                        case '342':
                        case '343':
                            var buttonText = lang.moveAllVideo;
                            break;
                        case '198':
                            var buttonText = lang.moveAllReleases;
                            break;
                    };

                    setSocialLinkSync($socialService, socialid, buttonText);
                };

                $socialService.find('.url').focusout(function() {
                    validateUrl($socialService, $(this), $(this).val());
                });

                $socialService.find('.hide-item').click(function() {
                    rebuildPreviewBar();
                });

                $socialService.find('.delete').click(function() {
                    $socialService.remove();
                    rebuildPreviewBar();
                    servicesCounter--;
                    
                    if (servicesCounter < options.servicesMaxAmount) {
                        $addEmptyService.show();
                    };
                });
                
                servicesCounter++;

                if (servicesCounter >= options.servicesMaxAmount) {
                    $addEmptyService.hide();
                };
            };


            function setSocialLinkSync($socialService, id, buttonText) {
                var socialServiceUrl = $socialService.find('.url').val();
                $socialService.find('.url').addClass('with-button');

                $('<span>' + buttonText + '</span>').addClass('sync sync-' + id).insertAfter($socialService.find('.url')).click(function() {
                    $.popup();
                    $.popup.showLoading();

                    $.post(
                        '/file/checksocialprofile/',
                        'url=' + socialServiceUrl + '&socialid=' + id,
                        function(response) {
                            response = $.parseJSON(response);

                            if (response.error) {
                                $.alert({
                                    content: response.status
                                });
                                return;
                            };

                            $.popup.close();
                            $.confirm({
                                text: response.status,
                                ok: function() {
                                    $.popup.hideWindow();
                                    $.popup.showLoading();

                                    $.post(
                                        '/file/getsocialprofile/',
                                        'url=' + socialServiceUrl + '&socialid=' + id + '&count=' + response.count,
                                        function(response) {
                                            response = $.parseJSON(response);

                                            if (response.error) {
                                                $.alert({
                                                    content: response.status
                                                });
                                                return;
                                            };

                                            $.alert({
                                                content: response.status
                                            });
                                        }
                                    );
                                }
                            });
                        }
                    );
                });
            };


            
            // validating URL according to the available services list
            function validateUrl($linkNode, socialUrl) {
                $.post(
                    '/reccount/findsocial/',
                    {url: "socialUrl"},
                    function(response) {
                        if (response == 'null') {
                            //errorPopup('This social network isnt exist');
                        } else {
                            var newService = $.parseJSON(response);

                            if ($servicesContainer.find('li').hasClass(newService.id)) {
                                if ($servicesContainer.find('li.' + newService.id) !== $linkNode) {
                                    //errorPopup('Эта соцсеть уже есть в списке');
                                    //$linkNode.remove();
                                };
                            } else {
                                $linkNode.removeClass().addClass(newService.id).data('bgIcon', newService.url);
                                rebuildPreviewBar();
                            };
                        };
                    }
                );
            };
            
            
            // Rebuilding preview bar according to the list of links
            function rebuildPreviewBar() {
                $iconsBar.empty();
                
                $servicesContainer.find('li').each(function() {
                    var $linkNode = $(this);

                    if (!$linkNode.hasClass('hidden') && $linkNode[0].className.length > 0) {
                        $('<li></li>').addClass($linkNode[0].className).css('background-image', 'url(' + $linkNode.data('bgIcon') + ')').appendTo($iconsBar);
                        
                        if ($linkNode.find('.hide-item').is(':checked')) {
                            $iconsBar.find('.' + $linkNode[0].className).hide();
                        };
                    };
                });

                // last tweet to view check
                if ($iconsBar.find('.222').length > 0) {
                    $showTweet.removeAttr('disabled');
                    if ($showTweet.attr('checked')) {
                        options.extraItem = 3;
                        
                        $iconsBar.find('.222').show().clone().removeClass('222').addClass('twitter-active').html('Текст поседнего твита').appendTo('.b-social-services ul');
                        $iconsBar.find('.222').hide();
                    };

                } else {
                    if ($showTweet.attr('checked')) {
                        $showTweet.attr('checked', false);
                        $showNothing.attr('checked', true);
                    };
                    $showTweet.attr('disabled', 'disabled');
                };


                // last news to view check
                if ($showNews.attr('checked')) {
                    options.extraItem = 2;
                
                    var $newsTeaser = $('<li><span></span><span></span></li>').appendTo($iconsBar).addClass('news');
                    $newsTeaser.find('span:first').addClass('logo').html('Новости');
                    $newsTeaser.find('span:last').html('Текст последней новости');
                };


                // bloody nothing to view check
                if ($showNothing.attr('checked')) {
                    options.extraItem = 1;
                };
            };
            
            
            // Converting social services links list into JSON and saving
            function saveLinksList () {
                $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
                $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

                socialServices.sociallist = [];
                socialServices.socialmode = options.extraItem;

                $servicesContainer.find('li:visible').each(function() {
                    var socialServiceItem = {};
                    socialServiceItem.id = ($(this).attr('id') ? $(this).attr('id') : '' );
                    socialServiceItem.socialid = ($(this).attr('class') ? $(this).attr('class') : '' );
                    socialServiceItem.url = encodeURIComponent($(this).find('.input input').val());
                    socialServiceItem.active = $(this).find('.hide-item').attr('checked') ? '0' : '1';
                    socialServices.sociallist.push(socialServiceItem);
                });
                
                $.ajax({
                    type: 'POST',
                    url: '/reccount/updatesocial/',
                    data: 'data=' + $.toJSON(socialServices),
                    success: function(response) {
                        socialServices = $.parseJSON(response);
                        socialServices.errorid ? errorPopup(socialServices.errormessage) : init();
                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    }
                 });
            };
            
            
            $addEmptyService.click(function() {addItem();});

            
            // Observing click on saveLinksList button
            $save.click(function() {saveLinksList();});


            // Observing news and last tweet radiobutton click
            $('.b-options').delegate('input', 'click', function() {rebuildPreviewBar();});


            function init() {
                $servicesContainer.find('li:visible').remove();
                servicesCounter = 0;

                if (socialServices.sociallist) {
                    $.each(socialServices.sociallist, function(i, item) {addItem(item.id, item.socialid, item.url, item.active, item.img);});
                } else {
                    addItem();
                };

                //extraItem = socialServicesList.socialmode;
                // Extra item initialization
                if (socialServices.socialmode == '2') {
                    $showNews.attr('checked', true);

                } else if (socialServices.socialmode == '3') {
                    $showTweet.attr('checked', true);
                } else {
                    $showNothing.attr('checked', true);
                };

                rebuildPreviewBar();
            };

            init();
        });
    };
})(jQuery);



// Menu customizer
(function($) {
    $.fn.menuCustomizer = function(options){
        return this.each(function(){

            var menuItemsList = $.parseJSON(customizedMenuItemsList),
                itemsBlock = $('.b-menu-items').sortable(),
                saveButton = $('.b-button-set .save-items');

            
            function addMenuItem(id, name, original, url, itemid, active, menutypeid, menutypename) {
                var newItem = itemsBlock.find('.hidden').clone().removeClass('hidden').appendTo(itemsBlock);
                
                newItem.data('id', id).data('itemid', itemid).data('menutypeid', menutypeid);
                newItem.find('.lang-first').val(name)
                newItem.find('.url').val(url)
                newItem.find('.template b').html(menutypename);

                if (active == '0') {
                    newItem.find('.hidden-item input').attr('checked', true);
                };

                if (original == '1') {
                    newItem.find('.url').attr('disabled', 'disabled');
                    newItem.find('.delete-item').remove();
                    newItem.find('.duplicate-item').click(function() {
                        var duplicatedItem = newItem.clone().appendTo(itemsBlock);

                        duplicatedItem.removeData('id')
                        duplicatedItem.find('.url').val('').removeAttr('disabled');
                        duplicatedItem.find('.duplicate-item').remove();

                        $('<a>'+lang.deleteAction+'</a>').addClass('delete-item').attr('href', '#').insertBefore(duplicatedItem.find('.hidden-item')).click(function() {
                            duplicatedItem.remove();
                        });
                    });

                } else {
                    newItem.find('.duplicate-item').remove();
                    newItem.find('.delete-item').click(function() {
                        newItem.remove();
                    });
                };
            };
            

            function saveMenuItemsList() {
                $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
                $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

                menuItemsList.menulist = {};
                
                itemsBlock.find('li:visible').each(function(i) {
                        menuItemsList.menulist[i] = {};
                        menuItemsList.menulist[i].id = $(this).data('id');
                        menuItemsList.menulist[i].itemid = $(this).data('itemid');
                        menuItemsList.menulist[i].menutypeid = $(this).data('menutypeid');
                        menuItemsList.menulist[i].menutypename = $(this).find('.template b').html();
                        menuItemsList.menulist[i].name = secureString($(this).find('.lang-first').val());
                        menuItemsList.menulist[i].original = $(this).find('.duplicate-item').length > 0 ? 1 : 0;
                        menuItemsList.menulist[i].url = $(this).find('.url').attr('value');
                        menuItemsList.menulist[i].active = $(this).find('.hidden-item input').attr('checked') ? 0 : 1;
                });

                
                $.ajax({
                    type: 'POST',
                    url: '/reccount/updatemenu/',
                    data: 'data=' + $.toJSON(menuItemsList),
                    success: function(response){
                        menuItemsList = $.parseJSON(response);
                        menuItemsList.errorid ? errorPopup(menuItemsList.errormessage) : init();

                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    }
                 });
            };


            saveButton.click(function() {saveMenuItemsList();});

            
            function init() {
                itemsBlock.find('li:visible').remove();
                
                $.each(menuItemsList.menulist, function(i, item) {
                    addMenuItem(item.id, item.name, item.original, item.url, item.itemid, item.active, item.menutypeid, item.menutypename);
                });
            };

            
            init();
        });
    };
})(jQuery);

function errorPopup(errorMessage) {
    $('<div></div>').addClass('g-overlay-superblack').appendTo('body');
    $('.b-error-box').css({'top': $(window).height() / 2 - 95  + 'px', 'left': Math.floor($(window).width() / 2) - 230 + 'px'}).show();
    $('.b-error-box').find('.message').html(errorMessage);
    
    $('.b-error-box').find('.close').click(function(event) {
        event.preventDefault();
        $(this).parent().hide();
        $('.g-overlay-superblack').remove();
    });
    
    $('.b-error-box').find('.submit').click(function(event) {
        event.preventDefault();
        $(this).parent().parent().hide();
        $('.g-overlay-superblack').remove();
    });
};



function coversLibraryInit(coverId, coverUrl) {
   var library = $('#covers-library').show(),
        coversList = library.find('.covers img'),
        itemsCounter = coversList.length,
        pagesCounter = Math.ceil(itemsCounter / 12),
        addBlock = $('#adding-popup').hide(),
        addBlockBorderOverlay = $('.g-overlay-border').hide(),
        addBlockBorderOverlayClone = $('<div></div>').addClass('g-overlay-border').appendTo('body').css({
            'width': library.outerWidth() + 30 + 'px',
            'height': library.outerHeight() + 30 + 'px',
            'margin': -library.outerHeight() / 2 - 10 + 'px 0 0 ' + (-library.outerWidth() / 2 - 15) + 'px'
        }).show();

   coversList.hide().css('border', '2px solid #FFF').slice(0, 12).show();
   library.find('.pager').empty();

   if (pagesCounter > 1) {
      for (i = 0; i < pagesCounter; i++) {
          $('<li><a href=""></a></li>').appendTo('#covers-library .pager');

          var pagerLink = $('#covers-library .pager li:last-child a');

          pagerLink.html(i + 1);

          $('#covers-library .pager li:last-child a').click(function(event) {
                event.preventDefault();
                coversList.hide();

                var pagerCounter = +$(this).html(),
                    finish = pagerCounter * 12,
                    start = finish - 12;

                coversList.slice(start, finish).show();
          });
      };
   };

    coversList.each(function(){
        $(this).click(function() {
            coversList.css('border', '2px solid #FFF');
            $(this).css('border', '2px solid #C00');
            addBlock.find('.cover img').attr('rel', $(this).attr('rel'));
            addBlock.find('.cover img').attr('src', $(this).attr('src'));
            addBlock.find('.delete').show()
        });
    });

    library.find('.ok').click(function(event) {
        event.preventDefault();
        library.hide();
        addBlockBorderOverlayClone.remove();
        addBlock.show();
        addBlockBorderOverlay.show();
    });

    library.find('.cancel').click(function(event) {
        event.preventDefault();
        addBlock.find('.cover img').attr('rel', coverId);
        addBlock.find('.cover img').attr('src', coverUrl);

        library.hide();
        addBlockBorderOverlayClone.remove();
        addBlock.show();
        addBlockBorderOverlay.show();
    });
};




function initCrop(imageUrl, type) {
    var addBlock = $('#adding-popup').hide(),
        addBlockOverlay = $('.g-overlay-border').hide(),
        cropBlock = $('<div></div>').addClass('g-crop').appendTo('body').hide(),
        cropTarget = $('<img />').attr('src', imageUrl).appendTo(cropBlock),
        cropJson = {},
        scale = 1,
        maxImgWidth = document.documentElement.clientWidth - 150,
        maxImgHeight = document.documentElement.clientHeight - 150;

        if (type == 1) {
            var cropHeight = 100,
                cropWidth = 220,
                cropRatio = 2.2;

        } else if (type == 2) {
            var cropHeight = 220,
                cropWidth = 220,
                cropRatio = 1;
        } else {
            var cropHeight = 220,
                cropWidth = 580,
                cropRatio = 2.64;
        };
    

    cropTarget.load(function() {
        cropBlock.show();

        var imgWidth = cropTarget.width(),
            imgHeight = cropTarget.height();

        if (imgWidth > maxImgWidth || imgHeight > maxImgHeight) {
             scale = (maxImgWidth / imgWidth < maxImgHeight / imgHeight) ? maxImgWidth / imgWidth : maxImgHeight / imgHeight;
        };


        cropTarget.css({
            'width': Math.floor(imgWidth * scale),
            'height': Math.floor(imgHeight * scale)
        });
        
        cropBlock.css('margin', '-' + Math.round(imgHeight * scale / 2 + 25) + 'px 0 0 -' + Math.round(imgWidth * scale / 2) + 'px')


        $(this).Jcrop({
            aspectRatio: cropRatio,
            setSelect: [cropWidth, cropHeight, 0, 0],
            minSize: [cropWidth, cropHeight],
            onChange: function (c) {
                cropJson.url = imageUrl;
                cropJson.x = c.x;
                cropJson.y = c.y;
                cropJson.width = c.w;
                cropJson.height = c.h;
                cropJson.size = type;
            }
        });

        // Crop and proceed
        $('<a href="#"></a>').addClass('save').appendTo(cropBlock).click(function(event) {
            event.preventDefault();

            cropJson.x = cropJson.x / scale;
            cropJson.y = cropJson.y / scale;
            cropJson.width = cropJson.width / scale;
            cropJson.height = cropJson.height / scale;

            $.post(
                '/file/crop/',
                'data=' + $.toJSON(cropJson),
                function(croppedImageUrl) {
                    $('.cover img').attr('rel', '').attr('src', croppedImageUrl);
                    cropBlock.remove();
                    addBlock.find('.delete').show();
                    addBlockOverlay.show();
                    addBlock.show();
                }
            );
        });

        // Cancel crop
        $('<a href="#"></a>').addClass('cancel').appendTo(cropBlock).click(function(event) {
            event.preventDefault();
            cropBlock.remove();
            addBlockOverlay.show();
            addBlock.show();
        });
    });
};




function secureString(str) {
    return encodeURIComponent((str + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
};



function turnReccount() {
    var blackOverlay = $('<div></div>').addClass('g-overlay-superblack').appendTo('body'),
            reccountSwitchOverlay = $('<div></div>').addClass('b-reccount-switch-overlay').appendTo('body'),
            reccountSwitchBlock = $('<div></div>').addClass('b-reccount-switch').appendTo('body'),
            closeButton = $('<a href></a>').addClass('b-close-button').appendTo(reccountSwitchBlock),
            switchButton = $('<a href></a>').addClass('b-switch-button').appendTo(reccountSwitchBlock).click(function(event) { event.preventDefault(); }),
            switchMessage = $('<span></span>').addClass('b-switch-message').appendTo(reccountSwitchBlock),
            reccountStatus;

    closeButton.click(function(event) {
        event.preventDefault();
        blackOverlay.remove();
        reccountSwitchOverlay.remove();
        reccountSwitchBlock.remove();
    })

    $.ajax({
        type: 'POST',
        url: '/reccount/sitestatus/',
        success: function(status) {
            if (status == 1) {
                switchButton.html(lang.eventReccounOff);
                switchMessage.html(lang.reccountStateOn);
            } else {
                switchButton.html(lang.eventReccounOn);
                switchMessage.html(lang.reccountStateOff);
            };

            reccountStatus = status;
            switchButton.click(function() {
                changeReccountStatus();
            });
        }
    });

    function changeReccountStatus() {
        $.ajax({
            type: 'POST',
            url: '/reccount/setsitestatus/',
            data: 'data=' + (reccountStatus == 1 ? 0 : 1),
            success: function(status) {
                if (status == 1) {
                    switchButton.html(lang.eventReccounOff);
                    switchMessage.html(lang.reccountStateOn);
                } else {
                    switchButton.html(lang.eventReccounOn);
                    switchMessage.html(lang.reccountStateOff);
                };

                reccountStatus = status;
            }
        });
    };
};


function flexibleModuleColumn() {
    var windowWidth = $(window).width();

    if (windowWidth > 940 ) {
        var contentBlock = $('.g-content');
        contentBlock.width(940);

        var extraColumns = Math.floor((windowWidth - 940 -100) / 480 );

        if (extraColumns > 0) {
            contentBlock.width(940 + extraColumns * 480);
    
            if ($('.b-news-menu')) {
                $('.b-news-menu').width($('.g-content').width());
            }
        };
        $('.g-submenu').css('padding', '0 ' +Math.floor(($(window).width() - $('.g-content').width()) / 2) + 'px');
        } else {
        $('.g-content').width(940);
        $('.g-submenu').css('padding', '0 0');
        }
};

// Page init
$().ready(function() {
    flexibleModuleColumn();
    navBar();
    
    // Social services links
    $('.b-links').socialServicesLinksSorter();
    
    // Menu items customization
    $('.b-menu-customization').menuCustomizer();

    $('.reccount-switcher a').click(function(event) {
        event.preventDefault();
        turnReccount();
    });
    
    $(window).resize(function() {
        flexibleModuleColumn();
        navBar();
    });

    if (isQuotaLimitReached == 1) {
        var $upload = $('.g-content .upload');
        
        $upload.find('input').remove();
        $upload.css('cursor', 'pointer').click(function() {
           var $limitReached = $('.b-limit-reached').css({
                    'top': Math.floor($(window).height() / 2) - 55  + 'px',
                    'left': Math.floor($(window).width() / 2) - 230 + 'px'
                }).show(),
                $limitBorder = $('.b-limit-reached-border').css({
                    'width': $limitReached.outerWidth() + 30 + 'px',
                    'height': $limitReached.outerHeight() + 30 + 'px',
                    'top': Math.floor($(window).height() / 2) - 70  + 'px',
                    'left': Math.floor($(window).width() / 2) - 245 + 'px'
                }).show(),
                $overlay = $('<div></div>').addClass('g-overlay-superblack').appendTo('body');

            $limitReached.find('.close').click(function(event) {
                event.preventDefault();
                $limitReached.hide();
                $limitBorder.hide();
                $overlay.remove();
            });
        });
    };
});