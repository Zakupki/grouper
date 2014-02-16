/* CONSTANTS
----------------------------------------------- */
var TPL = '',
    BASE = '',
    LANG = '';

$('meta').each(function(){
    switch (this.name) {
        case 'tpl':
            TPL = this.content;
            break;
        case 'base':
            BASE = this.content;
            break;
        case 'lang':
            LANG = this.content;
            break;
    }
});

ZeroClipboard.setMoviePath(BASE + 'swf/clipboard.swf');



/* CUFON
----------------------------------------------- */
Cufon.replace('h1', {fontFamily: 'Helios Light', textShadow: '#fff 0 1px', separate: 'none'});
Cufon.replace('.comments h2', {fontFamily: 'Helios Light', textShadow: '#fff 0 1px', separate: 'none'});
Cufon.replace('.events .title strong, .event .title h2', {fontFamily: 'Arial', color: '-linear-gradient(#87b9c7, #467f90)', textShadow: '#fff 0 1px'});





/* FORMS
----------------------------------------------- */
/* jselect
----------------------------------------------- */
(function($){
var $document = $(document),
    $jselects;
$.fn.jselect = function(){
    return this.each(function(){
        var $select = $(this),
            $form = $select.closest('form'),
            $options = $select.find('option'),
            $jselect = $('<div class="jselect"><div class="jselect-title"><div class="jselect-title-r"><div class="jselect-title-l"><div class="jselect-title-text"></div></div></div><div class="jselect-arrow"></div></div><div class="jselect-list"><div class="jselect-list-top-r"><div class="jselect-list-top-l"></div></div><div class="jselect-list-r"><div class="jselect-list-l"><div class="jselect-list-wrap"><div class="jselect-list-content"></div></div></div></div><div class="jselect-list-bot-r"><div class="jselect-list-bot-l"></div></div></div></div>'),
            $title = $('.jselect-title', $jselect),
            $titleText = $('.jselect-title-text', $jselect),
            $list = $('.jselect-list', $jselect),
            $listContent = $('.jselect-list-content', $jselect),
            $arrow = $('.jselect-arrow', $jselect),
            $items = $();

        $titleText.html($options.eq(this.selectedIndex).html());

        $options.each(function(index){
            var $option = $(this);
            if ($option.prop('disabled')) {
                return;
            }
            var $item = $('<div />', {
                'class': 'jselect-li',
                'html': this.innerHTML || '&nbsp;',
                'click': function(){
                    set(index);
                    close();
                }
            });
            $items = $items.add($item);
        });

        $listContent.html($items);

        $jselect.width($select.width()).click(function(e){
            e.stopPropagation();
        }).bind('selectstart', function(e){
            e.preventDefault();
        });

        $select.hide().after($jselect);

        $jselects = $('.jselect');

        $title.add($select).click(function(e){
            open();
        });

        $document.click(function(){
            close();
        });
        
        $form.reset(function(){
            $titleText.html($options.eq($select[0].selectedIndex).html());
        });

        function open() {
            close();
            $jselect.addClass('jselect-open');
        }

        function close() {
            $jselects.removeClass('jselect-open');
        }

        function set(index) {
            $select[0].selectedIndex = index;
            $select.triggerHandler('change');
            $titleText.html($options.eq(index).html());
        }
    });
};
})(jQuery);










/* PLUGINS
----------------------------------------------- */
/* fn.userURL
----------------------------------------------- */
(function($){
$.fn.userURL = function(buttonID, wrapID){
    return this.each(function(){
        var text = $('.input-text .input', this).html(),
            clipboard = new ZeroClipboard.Client();
        clipboard.setText(text);
        clipboard.glue(buttonID, wrapID);
    });
};
})(jQuery);


/* teasers
----------------------------------------------- */
(function($){
var $h1 = $('h1');
$.fn.teasers = function(o){
    o = $.extend({
        speed: 150
    }, o);
    return this.each(function(){
        var $root = $(this),
            $teasers = $('.teaser', $root),
            $titles = $('.title', $teasers),
            $items = $('.teaser-content', $root),
            changeH1 = $root.is('.teasers-h1'),
            currentIndex = $teasers.index($teasers.filter('.teaser-act'));
        $.address.bind('change', function(){
            if (location.hash.indexOf('#content') == 0) {
                var index = parseInt(location.hash.substr(8)) - 1;
                show(index);
            }
        });
        function show(index) {
            if (isNaN(index) || index == currentIndex || index < 0 || index >= $items.length) {
                return;
            }
            $teasers.removeClass('teaser-act').eq(index).addClass('teaser-act');
            if (changeH1) {
                var h1Text = $titles.eq(index).html();
                $h1.html(h1Text);
                Cufon.refresh('h1');
            }
            $root.height($root.height());
            $items.removeClass('teaser-content-act').stop(true, true).eq(index).hide().addClass('teaser-content-act').fadeIn(o.speed);
            $root.height('');
            currentIndex = index;
        }
    });
};
})(jQuery);




















/* events
----------------------------------------------- */
(function($){
$.fn.events = function(o){
    o = $.extend({
        speed: 150
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $list = $('.events-list', $root);
// Love
        (function(){
            var url = decodeURIComponent($('input[name="places_love_url"]', $root).val()),
                busy = false;
            $list.on('click', '.place-love-link .i', function(){
                love(this);
            });
            function love(el) {
                if (busy) {
                    return;
                }
                busy = true;
                var $el = $(el),
                    $place = $el.closest('.place-info'),
                    id = $place.find('input[name="place_id"]').html(),
                    state = !$el.is('.act'),
                    $total = $place.find('.place-loved div'),
                    total = $total.html();
                $el.toggleClass('act');
                $.post(url, {id: id, state: state, total: total, token: $.token()}, function(data){
                    $.token(data.token);
                    $el.toggleClass('act', data.state);
                    $total.html(data.total);
                    busy = false;
                }, 'json');
            }
        })();
// More
        (function(){
            var $more = $('.more', $root),
                $loading = $('.loading', $more),
                url = decodeURIComponent($('input[name="more_url"]', $root).val()),
                offset = $('input[name="more_offset"]', $root).val(),
                busy = false;
            $more.on('click', '.more-link span', function(){
                more();
            });
            function more() {
                if (busy) {
                    return;
                }
                busy = true;
                $loading.css({'left': 0, 'top': 0});
                $.post(url, {offset: offset, token: $.token()}, function(data){
                    $.token(data.token);
                    $loading.css({'left': -9999, 'top': -9999});
                    if (data.error) {
                        busy = false;
                    } else {
                        $('.events-last', $list).removeClass('events-last');
                        $list.append($(data.content).hide().fadeIn(o.speed));
                        Cufon.refresh('.events .title strong');
                        if (data.last) {
                            $more.hide();
                        }
                        offset = data.offset;
                        busy = false;
                    }
                }, 'json');
            }
        })();
    });
};
})(jQuery);



/* places
----------------------------------------------- */
(function($){
$.fn.places = function(o){
    o = $.extend({
        speed: 150
    }, o || {});

    return this.each(function(){
        var $root = $(this),
            $list = $('.places-list', $root);
// Love
        (function(){
            var url = decodeURIComponent($('input[name="love_url"]', $root).val()),
                busy = false;
            $list.on('click', '.love-link .i', function(){
                love(this);
            });
            function love(el) {
                if (busy) {
                    return;
                }
                busy = true;
                var $el = $(el),
                    $place = $el.closest('.places-li'),
                    id = $place.find('input[name="id"]').val(),
                    state = !$el.is('.act'),
                    $total = $place.find('.loved div'),
                    total = $total.html();
                $el.toggleClass('act');
                $.post(url, {id: id, state: state, total: total, token: $.token()}, function(data){
                    $.token(data.token);
                    $el.toggleClass('act', data.state);
                    $total.html(data.total);
                    busy = false;
                }, 'json');
            }
        })();
// More
        (function(){
            var $more = $('.more', $root),
                $loading = $('.loading', $more),
                url = decodeURIComponent($('input[name="more_url"]', $root).val()),
                offset = $('input[name="more_offset"]', $root).val(),
                busy = false;
            $more.on('click', '.more-link span', function(){
                more();
            });
            function more() {
                if (busy) {
                    return;
                }
                busy = true;
                $loading.css({'left': 0, 'top': 0});
                $.post(url, {offset: offset, token: $.token()}, function(data){
                    $.token(data.token);
                    $loading.css({'left': -9999, 'top': -9999});
                    if (data.error) {
                        busy = false;
                    } else {
                        $('.events-last', $list).removeClass('events-last');
                        $list.append($(data.content).hide().fadeIn(o.speed));
                        if (data.last) {
                            $more.hide();
                        }
                        offset = data.offset;
                        busy = false;
                    }
                }, 'json');
            }
        })();
    });
};
})(jQuery);



/* regionPopup
----------------------------------------------- */
(function($){
$.fn.regionPopup = function(o){
    o = $.extend({
        speed: 150,
        maxFields: 5
    }, o || {});

    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $fieldset = $('.fieldset', $form);

        $(o.link).popup({
            src: o.src,
            beforeShowWindow: function(){
                $('input:text:first', $fieldset).focus();
            }
        });

        $form.ajaxForm({
            dataType: 'json',
            beforeSubmit: function(){
                $.popup.hideWindow();
                $.popup.showLoading();
            },
            success: function(data){
                $.alert({
                    content: data.status,
                    afterClose: function(){
                        if (!data.error) {
                            location.reload(true);
                        }
                    }
                });
            }
        });

        $fieldset.on('focus', '.field-placeholder input:text', function(){
            $(this).closest('.field').removeClass('field-placeholder');
        }).on('blur', 'input:text', function(){
            if (!this.value.trim()) {
                this.value = '';
                $(this).closest('.field').addClass('field-blank field-placeholder');
            }
        }).on('keyup', 'input:text', function(){
            var $field = $(this).closest('.field');
            if (this.value.trim()) {
                $field.removeClass('field-blank');
                addPlaceholder();
            } else {
                $field.addClass('field-blank');
                removePlaceholders();
            }
        }).on('click', '.remove-link span', function(){
            var $field = $(this).closest('.field');
            removeField($field);
        }).sortable({stack: $('.field', $fieldset), handle: '.handle'});

        function addPlaceholder() {
            if ($('.field', $form).length >= o.maxFields || $('.field-placeholder', $form).length) {
                return;
            }
            var $field = $('.field:first', $fieldset).clone(true),
                nextIndex = getNextIndex();
            $field.addClass('field-placeholder field-blank');
            $('input:text', $field).val('').attr('name', 'city[' + nextIndex + ']');
            $fieldset.append($field.hide().fadeIn(o.speed));
        }

        function removePlaceholders() {
            $fields = $('.field-placeholder', $form);
            $fields.fadeOut(o.speed, function(){
                $fields.remove();
            });
        }

        function removeField($field) {
            if ($('.field', $form).length > 1) {
                $field.fadeOut(o.speed, function(){
                    $field.remove();
                });
            } else {
                $('input:text', $field).val('').attr('name', 'city[0]');
                $field.addClass('field-placeholder field-blank');
            }
        }

        function getNextIndex() {
            var lastIndex = 0;
            $('input:text', $fieldset).each(function(){
                var index = parseInt(this.name.substr(5));
                if (index > lastIndex) {
                    lastIndex = index;
                }
            });
            return lastIndex + 1;
        }
    });
};
})(jQuery);



/* popup
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        xhr = null,
        kind = '',
        $src = $(),
        $object = $(),
        $doc = $(document),
        $popup = $('<div class="popup"><div class="popup-window"><div class="popup-r"><div class="popup-l"><div class="popup-content"></div></div></div><div class="popup-rt"><div class="popup-lt"></div></div><div class="popup-rb"><div class="popup-lb"></div></div><div class="popup-close"><i class="i"></i></div></div><div class="popup-loading"><i class="i"></i></div><div class="popup-overlay"></div></div>'),
        $window = $popup.find('.popup-window'),
        $close = $popup.find('.popup-close'),
        $content = $popup.find('.popup-content'),
        $overlay = $popup.find('.popup-overlay'),
        $loading = $popup.find('.popup-loading');

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
            var rel = $(el).attr('rel') || '',
                href = $(el).attr('href') || '';

            if (rel.indexOf('popup:') == 0) {
                params.href = rel.substr(6);
            } else if (href) {
                params.href = href;
            }
        }

        o = $.extend({}, $.popup.defaults, params);

        $doc.bind('keyup.popup', function(e){
            if (e.which == 27 && o.closeOnEsc) {
                close();
            }
        });

        if (o.extraClass) {
            $popup.addClass(o.extraClass);
        }

        if (o.content) {
            kind = 'html';
        } else if (o.src) {
            kind = 'inline';    
        } else if (o.href) {
            if (o.href.indexOf('#') == 0) {
                kind = 'href';
            } else {
                kind = 'ajax';
            }
        }

        handle();
    }

    function handle() {
        showOverlay();

        switch (kind) {
            case 'html':
                html();
                break;
            case 'inline':
                inline();
                break;
            case 'href':
                href();
                break;
            case 'ajax':
                ajax();
                break;
        }
        
        function html() {
            if (o.content.jquery) {
                $object = o.content;
            } else {
                $object = $(o.content);
            }
            content();
            showWindow();
        }
    
        function inline() {
            if (o.src.jquery) {
                $src = o.src;
            } else {
                $src = $(o.src);
            }
            $object = $src.contents();
            content();
            showWindow();
        }
    
        function href() {
            $src = $(o.href);
            $object = $src.contents();
            content();
            showWindow();
        }
    
        function ajax() {
            showLoading();
            xhr = $.get(o.href, function(data){
                $object = $(data);
                content();
                hideLoading();
                showWindow();
            });
        }
    }

    function content() {
        $content.html($object);
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

    function error(message) {
        $.popup.showOverlay();
        $content.html('error: ' + message);
        $.popup.hideLoading();
        $.popup.showWindow();
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

    function clear() {
        $loading.css({'left': '', 'top': ''});
        $window.stop(true).css({'left': '', 'top': '', 'opacity': '', 'margin': ''});
        $doc.unbind('.popup');

        if (o.extraClass) {
            $popup.removeClass(o.extraClass);
        }

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
        kind = '';
        $src = $();
        $object = $();
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

    $.popup.showOverlay = function(callback){
        $popup.css({'left': 0, 'top': 0});
        if (callback) {
            callback(el);
        }
    };

    $.popup.hideOverlay = function(callback){
        $popup.css({'left': -9999, 'top': -9999});
        if (callback) {
            callback(el);
        }
    };

    $.popup.showLoading = function(callback){
        $loading.css({'left': '50%', 'top': '50%'});
        if (callback) {
            callback(el);
        }
    };

    $.popup.hideLoading = function(callback){
        $loading.css({'left': -9999, 'top': -9999});
        if (callback) {
            callback(el);
        }
    };

    $.popup.showWindow = function(callback) {
        $window.stop(true).css({'opacity': 0, 'left': '50%', 'top': '50%', 'margin-left': -($window.width() / 2), 'margin-top': -($window.height() / 2)}).fadeTo(o.speed, 1, function(){
            if (callback) {
                callback(el);
            }
        });
    }

    $.popup.hideWindow = function(callback){
        $window.stop(true).fadeTo(o.speed, 0, function(){
            if (callback) {
                callback(el);
            }
        });
    };

    $.popup.close = function(callback){
        $.popup.hideLoading();
        $.popup.hideWindow(function(){
            $.popup.hideOverlay(callback);
            clear();
            $doc.unbind('.alert');
            $doc.unbind('.confirm');
        });
    };

    $.popup.get = function(){
        return o;
    };

    $.popup.set = function(params){
        $.extend(o, params);
    };

    $.popup.init = function(){
        if ($('.popup').length) {
            return;
        }
    
        $('body').append($popup);

        $window.click(function(e){
            e.stopPropagation();
        });
    
        $close.add($loading).click(close).bind('selectstart', function(e){
            e.preventDefault();
        });

        $overlay.click(function(){
            if (o.closeOnOverlay) {
                close();
            }
        }).bind('selectstart', function(e){
            e.preventDefault();
        });
    };

    $.popup.defaults = {
        speed: 150,
        extraClass: '',
        closeOnEsc: true,
        closeOnOverlay: false
    };

    $(function(){
        $.popup.init();
    });
})(jQuery);



/* alert
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        $doc = $(document),
        $alert = $('<div class="alert-popup"><div class="alert-popup-content"></div><div class="alert-popup-ok"><i class="i"></i></div></div>'),
        $content = $('.alert-popup-content', $alert),
        $ok = $('.alert-popup-ok', $alert);

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

        $doc.bind('keyup.alert', function(e){
            if (e.which == 13 && o.okOnEnter) {
                ok();
            }
        });

        content();
        open();
    }

    function content() {
        $content.html(o.content);
    }

    function open() {
        $.popup(el, {
            content: $alert,
            extraClass: 'popup-alert' + (o.extraClass ? ' ' + o.extraClass : ''),
            beforeShowOverlay: o.beforeShowOverlay,
            showOverlay: o.showOverlay,
            afterShowOverlay: o.afterShowOverlay,
            beforeShowWindow: o.beforeShowWindow,
            showWindow: o.showWindow,
            afterShowWindow: o.afterShowWindow,
            beforeClose: o.beforeClose,
            close: o.close,
            afterClose: o.afterClose,
            closeOnEsc: o.closeOnEsc,
            closeOnOverlay: o.closeOnOverlay
        });
    }

    function ok() {
        if (o.ok) {
            o.ok(el);
        } else {
            $.alert.ok();
        }
    }
    
    function close() {
        if (o.beforeClose) {
            o.beforeClose(el);
        }

        if (o.close) {
            o.close(el, o.afterClose);
        } else {
            $.alert.close(o.afterClose);
        }
    }

    function clear() {
        o = {};
        el = {};
        $doc.unbind('.alert');
        $doc.unbind('.confirm');
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

    $.alert.showOverlay = function(callback){
        $.popup.showOverlay(callback);
    };

    $.alert.hideOverlay = function(callback){
        $.popup.hideOverlay(callback);
    };

    $.alert.showLoading = function(callback){
        $.popup.showLoading(callback);
    };

    $.alert.hideLoading = function(callback){
        $.popup.hideLoading(callback);
    };

    $.alert.showWindow = function(callback){
        $.popup.showWindow(callback);
    };

    $.alert.hideWindow = function(callback){
        $.popup.hideWindow(callback);
    };

    $.alert.ok = function(){
        close();
    };

    $.alert.close = function(callback){
        $.popup.close(callback);
        clear();
    };

    $.alert.get = function(){
        return o;
    };

    $.alert.set = function(params){
        $.extend(o, params);
    };

    $.alert.init = function(){
        $ok.click(ok).bind('selectstart', function(e){
            e.preventDefault();
        }).focus();
    };

    $.alert.defaults = {
        speed: 150,
        content: '',
        extraClass: '',
        okOnEnter: true,
        closeOnEsc: true,
        closeOnOverlay: false
    };

    $(function(){
        $.alert.init();
    });
})(jQuery);



/* confirm
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        $doc = $(document),
        $confirm = $('<div class="confirm-popup"><div class="confirm-popup-content"></div><div class="confirm-popup-cancel"><i class="i"></i></div><div class="confirm-popup-ok"><i class="i"></i></div></div>'),
        $content = $('.confirm-popup-content', $confirm),
        $ok = $('.confirm-popup-ok', $confirm),
        $cancel = $('.confirm-popup-cancel', $confirm);

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

        $doc.bind('keyup.confirm', function(e){
            if (e.which == 13 && o.okOnEnter) {
                ok();
            }

            if (e.which == 27 && o.cancelOnEsc) {
                cancel();
            }
        });

        content();
        open();
    }

    function content() {
        $content.html(o.content);
    }

    function open() {
        $.popup(el, {
            content: $confirm,
            extraClass: 'popup-confirm' + (o.extraClass ? ' ' + o.extraClass : ''),
            beforeShowOverlay: o.beforeShowOverlay,
            showOverlay: o.showOverlay,
            afterShowOverlay: o.afterShowOverlay,
            beforeShowWindow: o.beforeShowWindow,
            showWindow: o.showWindow,
            afterShowWindow: o.afterShowWindow,
            beforeClose: o.beforeClose,
            close: o.close,
            afterClose: o.afterClose,
            closeOnEsc: o.closeOnEsc,
            closeOnOverlay: o.closeOnOverlay
        });
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
    
    function close() {
        if (o.beforeClose) {
            o.beforeClose(el);
        }

        if (o.close) {
            o.close(el, o.afterClose);
        } else {
            $.confirm.close(o.afterClose);
        }
    }

    function clear() {
        o = {};
        el = {};
        $doc.unbind('.alert');
        $doc.unbind('.confirm');
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

    $.confirm.showOverlay = function(callback){
        $.popup.showOverlay(callback);
    };

    $.confirm.hideOverlay = function(callback){
        $.popup.hideOverlay(callback);
    };

    $.confirm.showLoading = function(callback){
        $.popup.showLoading(callback);
    };

    $.confirm.hideLoading = function(callback){
        $.popup.hideLoading(callback);
    };

    $.confirm.showWindow = function(callback){
        $.popup.showWindow(callback);
    };

    $.confirm.hideWindow = function(callback){
        $.popup.hideWindow(callback);
    };

    $.confirm.ok = function(){
        close();
    };

    $.confirm.cancel = function(){
        close();
    };

    $.confirm.close = function(callback){
        $.popup.close(callback);
        clear();
    };

    $.confirm.get = function(){
        return o;
    };

    $.confirm.set = function(params){
        $.extend(o, params);
    };

    $.confirm.init = function(){
        $ok.click(ok);
        $cancel.click(cancel);
    };

    $.confirm.defaults = {
        speed: 150,
        content: 'Продолжить?',
        extraClass: '',
        okOnEnter: true,
        cancelOnEsc: true,
        closeOnEsc: true,
        closeOnOverlay: false
    };

    $(function(){
        $.confirm.init();
    });
})(jQuery);



/* token
----------------------------------------------- */
(function($){
var $token = $();
$(function(){
    $token = $('meta[name="token"]');
});
$.token = function(value){
    if (value) {
        $token.attr('content', value);
    } else {
        return $token.attr('content');
    }
};
})(jQuery);


/* authForm
----------------------------------------------- */
(function($){
$.fn.authForm = function(o){
    o = $.extend({
        link: ''
    }, o);
    return this.each(function(){
        var $form = $(this),
            $loginInput = $('input[name="login"]', $form),
            $status = $('.status', $form);
        $(o.link).popup({
            src: o.src,
            beforeShowWindow: function(){
                $loginInput.focus();
            }
        });
        var validator = $form.validate({
            highlight: function(el){
                $(el).closest('.field').addClass('field-error');
            },
            unhighlight: function(el){
                $(el).closest('.field').removeClass('field-error');
            },
            errorPlacement: function(){},
            submitHandler: function(form){
                $form.ajaxSubmit({
                    data: {token: $.token()},
                    dataType: 'json',
                    success: function(data){
                        $.token(data.token);
                        if (data.error) {
                            $loginInput.focus();
                            $status.html(data.status).fadeIn(o.speed);
                        } else {
                            $status.hide();
                            form.submit();
                        }
                    }
                });
            }
        });
    });
};
})(jQuery);



/* INIT
----------------------------------------------- */
$(function(){
// high
    $('.teasers').teasers();
    $('.select select').jselect();

// low
    $('.events').events();
    $('.places').places();
    $('.user-url').userURL('user-url-copy', 'user-url-copy-wrap');

// popups
    $('.faq a').popup({extraClass: 'popup-video'});
    $('.region-popup').regionPopup({link: '.region-popup-link', src: '#region-popup-src'});
    $('.auth-popup form').authForm({link: '.auth-popup-link', src: '#auth-popup-src'});
});






