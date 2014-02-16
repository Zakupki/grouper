/* CONSTANTS
----------------------------------------------- */
var metas = document.getElementsByTagName('meta'),
    TPL = '',
    BASE = '',
    LANG = '';

for (i = 0; i < metas.length; i++) {
    switch (metas[i].name) {
        case 'tpl':
            TPL = metas[i].content;
            break;
        case 'base':
            BASE = metas[i].content;
            break;
        case 'lang':
            LANG = metas[i].content;
            break;
    }
}

/* TPL = 'http://work.atelier.ua/'; */

soundManager.url = '/swf/';
soundManager.debugMode = false;
soundManager.flashVersion = 9;
var jplayer;


/* CUFON
----------------------------------------------- */
Cufon.replace('.widget-title h2', {fontFamily: 'Helios Light', /*color: '-linear-gradient(#c00, #900)',*/ textShadow: '#fff 0 1px', separate: 'none'});
Cufon.replace('.comments-title h2', {fontFamily: 'Helios Light', color: '#999', separate: 'none'});
Cufon.replace('.events .title strong, .event h2 strong, .gallery .header h1, .place .descr h2 strong', {fontFamily: 'Arial', /*color: '-linear-gradient(#c00, #900)',*/ textShadow: '#fff 0 1px'});



/* FORMS
----------------------------------------------- */
/* form
----------------------------------------------- */
(function($){
$.fn.form = function(o){
    return this.each(function(){
        $.form(this, o);
    });
};
$.form = function(form, o){
    o = $.extend({}, $.form.defaults, o);
    var $form = $(form),
        url = o.url || $form.attr('action'),
        validator = $form.validate({
            highlight: function(el){
                $(el).closest('.field').addClass('field-error');
            },
            unhighlight: function(el){
                $(el).closest('.field').removeClass('field-error');
            },
            errorPlacement: function(){},
            rules: o.rules,
            submitHandler: function(){
                if (o.confirmText) {
                    $.confirm({
                        content: o.confirmText,
                        ok: function(){
                            submitHandler();
                        }
                    });
                } else if (o.beforeSubmit) {
                    o.beforeSubmit(submitHandler);
                } else {
                    submitHandler();
                }
            }
        });
    function submitHandler() {
        $('input, button, select, textarea', $form).blur();
        if (o.ajax) {
            $form.ajaxSubmit({
                url: url,
                data: o.data,
                dataType: 'json',
                beforeSubmit: function(){
                    $.popup();
                    $.popup.showLoading();
                },
                success: function(data){
                    if (data.error) {
                        $.alert({
                            content: data.status
                        });
                        return;
                    }
                    if (o.reset) {
                        validator.resetForm();
                        $form.trigger('afterReset');
                    }
                    if (o.reload) {
                        $.popup.close(function(){
                            location.reload(true);
                        });
                    } else {
                        if (data.status) {
                            $.alert({
                                content: data.status
                            });
                        } else {
                            $.popup.close();
                        }
                    }
                    o.complete(data);
                }
            });
        } else {
            form.action = url;
            form.submit();
        }
    }
};
$.form.defaults = {
    url: '',
    ajax: true,
    reset: true,
    reload: false,
    data: {},
    rules: {},
    confirmText: '',
    complete: function(){}
};
})(jQuery);



/* inputFile
----------------------------------------------- */
(function($){
$.fn.inputFile = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form'),
            $browse = $('.input-file-browse', $root),
            $input = $('input', $root),
            $label = $('.input-file-label', $root),
            $name = $('.input-file-name', $root),
            $cancel = $('.input-file-cancel', $root);
        $input.change(function(){
            var path = $input.val(),
                name = path.substr(path.lastIndexOf('\\') + 1);
            $name.html(name);
            $browse.add($label).hide();
            $name.add($cancel).fadeIn(o.speed);
        });
        $cancel.click(function(){
            cancel();
        });
        $form.reset(function(){
            reset();
        });
        function cancel() {
            $input.val('');
            $name.empty();
            $name.add($cancel).hide();
            $browse.add($label).fadeIn(o.speed);
        }
        function reset() {
            $name.add($cancel).hide();
            $browse.add($label).show();
        }
    });
};
})(jQuery);



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
            $listContent = $('.jselect-list-content', $jselect),
            $items = $();
        $titleText.html($options.eq(this.selectedIndex).html() || '&nbsp;');
        $options.each(function(index){
            var $option = $(this);
            if ($option.prop('disabled')) {
                return;
            }
            var $item = $('<div />', {
                'class': 'jselect-li',
                'html': $option.html() || '&nbsp;',
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
            e.stopPropagation();
            open();
        });
        $document.click(function(){
            close();
        });
        $form.reset(function(){
            $titleText.html($options.eq($select[0].selectedIndex).html() || '&nbsp;');
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
            $titleText.html($options.eq(index).html() || '&nbsp;');
        }
    });
};
})(jQuery);


/* registration
 ----------------------------------------------- */
(function($){
    $.fn.registration = function(){
        return this.each(function(){
            var $form = $(this).find('form'),
                formAction = $form.attr('action'),
                $passwordOldInput = $('#user-form-password-old'),
                $passwordInput = $('#user-form-password'),
                $passwordCheckInput = $('#user-form-password-check');

            var validator = $form.validate({
                rules: {
                    login: {
                        remote: {
                            url: formAction,
                            type: 'post',
                            data: {check: 1}
                        }
                    },
                    email: {
                        remote: {
                            url: formAction,
                            type: 'post',
                            data: {check: 1}
                        }
                    },
                    /*password_old: {
                        required: function(el) {
                            if ($passwordInput.val() || $passwordCheckInput.val()) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },*/
                    password: {
                        required: function(el) {
                            if ($passwordOldInput.val() || $passwordCheckInput.val()) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    password_check: {
                        required: function(el) {
                            if ($passwordOldInput.val() || $passwordInput.val()) {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        equalTo: '#user-form-password'
                    }
                },
                highlight: function(el){
                    $(el).closest('.field').addClass('field-error');
                },
                unhighlight: function(el){
                    $(el).closest('.field').removeClass('field-error');
                },
                submitHandler: function(form){
                    $('input, button, select, textarea', $form).blur();
                    $form.ajaxSubmit({
                        //data: {token: $tokenInput.val()},
                        dataType: 'json',
                        beforeSubmit: function(){
                            $.popup();
                            $.popup.showLoading();
                        },
                        success: function(data){
                            //$tokenInput.val(data.token);
                            validator.resetForm();
                            $form.trigger('afterReset');

                            $.alert({
                                content: data.status,
                                afterClose: function(){
                                    if (data.redirect) {
                                        location.replace(data.redirect);
                                    }
                                }
                            });
                        }
                    });
                }
            });

            /*$('.facebook .unlink', $form).click(function() {
                var $attachedAccounts = $('.attached-accounts', $form),
                    isPasswordExist = $('#is_password_exist', $form).val(),
                    $confirmPopupContent = '<span>Вы действительно хотите отсоединить facebook-аккаунт?</span>',
                    facebookId = $('#facebook_id', $form).val(),
                    postData = '';

                if (isPasswordExist == 0) {
                    $confirmPopupContent = '<i class="password-caption">Введите новый пароль</i><input class="new-password" type="password" value="" /><i class="password-confirm-caption">Новый пароль ещё разок</i><input class="new-password-confirm" type="password" value="" />'
                };

                $.confirm({
                    content: $confirmPopupContent,
                    extraClass: 'detach-account',
                    yes: function() {
                        $.confirm.hideWindow();
                        $.confirm.showLoading();

                        if (isPasswordExist == 0) {
                            if ($('.detach-account .new-password').val() != $('.detach-account .new-password-confirm').val()) {
                                $.alert({
                                    content: 'Вы ввели разные пароли'
                                });
                                return;
                            };

                            postData = 'accountid=' + facebookId + '&password=0&new_password=' + $('.detach-account .new-password').val() + '&new_password_confirm=' + $('.detach-account .new-password-confirm').val();
                        } else {
                            postData = 'accountid=' + facebookId + '&password=1'
                        };

                        $.ajax({
                            type: 'POST',
                            url: '/facebook/unlink/',
                            data: postData,
                            success: function(response){
                                response = $.parseJSON(response);

                                if (response.error) {
                                    $.alert({
                                        content: response.status
                                    });
                                    return;
                                };

                                $.confirm.close();
                                $attachedAccounts.fadeOut(500);
                            }
                        });
                    }
                });
            });*/
        });
    };
})(jQuery);



/* registration
 ----------------------------------------------- */
(function($){
    $.fn.registrationInfoEdit = function(){
        return this.each(function(){
            var $form = $(this).find('form'),
                formAction = $form.attr('action'),
                $passwordOldInput = $('#user-form-password-old'),
                $passwordInput = $('#user-form-password'),
                $passwordCheckInput = $('#user-form-password-check');

            var validator = $form.validate({
                rules: {
                    password_old: {
                     required: function(el) {
                     if ($passwordInput.val() || $passwordCheckInput.val()) {
                     return true;
                     } else {
                     return false;
                     }
                     }
                     },
                    password: {
                        required: function(el) {
                            if ($passwordOldInput.val() || $passwordCheckInput.val()) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    password_check: {
                        required: function(el) {
                            if ($passwordOldInput.val() || $passwordInput.val()) {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        equalTo: '#user-form-password'
                    }
                },
                highlight: function(el){
                    $(el).closest('.field').addClass('field-error');
                },
                unhighlight: function(el){
                    $(el).closest('.field').removeClass('field-error');
                },
                submitHandler: function(form){
                    $('input, button, select, textarea', $form).blur();
                    $form.ajaxSubmit({
                        //data: {token: $tokenInput.val()},
                        dataType: 'json',
                        beforeSubmit: function(){
                            $.popup();
                            $.popup.showLoading();
                        },
                        success: function(data){
                            //$tokenInput.val(data.token);
                            validator.resetForm();
                            $form.trigger('afterReset');

                            $.alert({
                                content: data.status,
                                afterClose: function(){
                                    if (data.redirect) {
                                        location.replace(data.redirect);
                                    }
                                }
                            });
                        }
                    });
                }
            });

        });
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
            $status = $('.status', $form),
            $retrievePassword = $('.retrieve-password', $form),
            isRetrieve = false;

        $(o.link).popup({
            src: o.src,
            beforeShowWindow: function(){
                $loginInput.focus();
            }
        });

        $retrievePassword.toggle(function(event) {
            event.preventDefault();
            isRetrieve = true;
            $retrievePassword.html(langBackToLogin);
            $form.attr('action', '/user/retrieve/');
            $form.find('.login-block').hide(10, function() {
                $form.find('.password-block').show();
            });
        }, function(event) {
            event.preventDefault();
            isRetrieve = false;
            $retrievePassword.html(langForgotPassword);
            $form.attr('action', '/user/login/');
            $form.find('.password-block').hide(10, function() {
                $form.find('.login-block').show();
            });
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
                    dataType: 'json',
                    success: function(data){
                        if (isRetrieve) {
                            if (data.error) {
                                $status.html(data.status).fadeIn(o.speed);
                            } else {
                                $status.hide();
                                $.alert({text: data.status});
                            };
                        } else {
                            if (data.error) {
                                $loginInput.focus();
                                $status.html(data.status).fadeIn(o.speed);
                            } else {
                                $status.hide();
                                form.submit();
                            };
                        };
                    }
                });
            }
        });
    });
};
})(jQuery);



/* reset
----------------------------------------------- */
(function($){
$.fn.reset = function(callback){
    return this.each(function(){
        if (typeof this.reset != 'function') {
            return;
        }
        if (typeof callback == 'function') {
            $(this).bind('afterReset', callback);
        } else {
            this.reset();
            $(this).trigger('afterReset');
        }
    });
};
})(jQuery);



/* placeholder
----------------------------------------------- */
(function($){
$.fn.placeholder = function(className, test){
    className = className || 'placeholder';
    return this.each(function(){
        if (this.nodeName.toLowerCase() != 'label') {
            return;
        }
        var $label = $(this),
            $input = $('#' + $label.attr('for')),
            placeholder = $label.html();
        init();
        if (!$input.data('placeholder')) {
            $input.closest('form').reset(function(){
                init();
            });
        }
        $input.off('.placeholder').on('focusin.placeholder', function(){
            if ($input[0].value == placeholder) {
                $input[0].value = '';
                $input.removeClass(className);
            }
        }).on('focusout.placeholder', function(){
            if ($input[0].value == '') {
                $input[0].value = placeholder;
                $input.addClass(className);
            }
        }).data('placeholder', placeholder);
        function init() {
            if ($input[0].value == '' || $input[0].value == placeholder) {
                $input[0].value = placeholder;
                $input.addClass(className);
            } else {
                $input.removeClass(className);
            }
        }
    });
};
})(jQuery);



/* MISC
----------------------------------------------- */
/* widget
----------------------------------------------- */
(function($){
$.fn.widget = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $m1 = $('.widget-m1', $root);
        $root.hover(
            function(){
                $m1.stop(true, true).fadeIn(o.speed);
            },
            function(){
                $m1.stop(true, true).fadeOut(o.speed);
            }
        );
    });
};
})(jQuery);



/* events
----------------------------------------------- */
(function($){
$.fn.events = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $list = $(this),
            $moreForm = $list.closest('.widget').find('.widget-more-link form'),
            $loading = $('.i-loading', $moreForm)
            busy = false;
        init();
        function init() {
            $('.events-li', $list).each(function(){
                var $item = $(this),
                    $controls = $('.controls', $item),
                    hidden = true;
                $item.unbind().hover(
                    function(){
                        if (hidden) {
                            $controls.css({'opacity': 0, 'margin': 0});
                        }
                        hidden = false;
                        $controls.stop(true).animate({'opacity': 1}, {queue: false, duration: o.speed});
                    },
                    function(){
                        $controls.stop(true).animate({'opacity': 0}, {queue: false, duration: o.speed, complete: function(){
                            $controls.css({'margin': ''});
                            hidden = true;
                        }});
                    }
                );
            });
        }
        $moreForm.click(function(){
            more();
        });
        function more() {
            if (busy) {
                return;
            }
            busy = true;
            $moreForm.ajaxSubmit({
                //dataType: 'json',
                data: {
                    count: $('.events-li').length,
                    eventpast: isPast
                },
                beforeSubmit: function(){
                    $loading.css({'margin': 0});
                },
                success: function(data) {
                    $loading.css({'margin': ''});
                    $('.events-li', $list).removeClass('events-last');
                    $list.append($(data).hide().fadeIn(o.speed));

                    if (typeof isLast == 'boolean') {
                        $('.widget-more-link').remove();
                    };

                    init();
                    busy = false;
                }
            });
        }
    });
};
})(jQuery);



/* galleries
----------------------------------------------- */
(function($){
$.fn.galleries = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $list = $(this),
            $moreForm = $list.closest('.widget').find('.widget-more-link form'),
            $loading = $('.i-loading', $moreForm)
            busy = false;
        init();
        function init() {
            $('.li', $list).each(function(){
                var $item = $(this),
                    $controls = $('.controls', $item),
                    hidden = true;
                $item.unbind().hover(
                    function(){
                        if (hidden) {
                            $controls.css({'opacity': 0, 'margin': 0});
                        }
                        hidden = false;
                        $controls.stop(true).animate({'opacity': 1}, {queue: false, duration: o.speed});
                    },
                    function(){
                        $controls.stop(true).animate({'opacity': 0}, {queue: false, duration: o.speed, complete: function(){
                            $controls.css({'margin': ''});
                            hidden = true;
                        }});
                    }
                );
            });
        }
        $moreForm.click(function(){
            more();
        });
        function more() {
            if (busy) {
                return;
            }
            busy = true;
            $moreForm.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function(){
                    $loading.css({'margin': 0});
                },
                success: function(data){
                    $loading.css({'margin': ''});
                    $list.append($(data.content).hide().fadeIn(o.speed));
                    init();
                    busy = false;
                }
            });
        }
    });
};
})(jQuery);



/* videos
----------------------------------------------- */
(function($){
$.fn.videos = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $list = $(this),
            $moreForm = $list.closest('.widget').find('.widget-more-link form'),
            $loading = $('.i-loading', $moreForm),
            busy = false;
        init();
        function init() {
            $('.li', $list).each(function(){
                var $item = $(this),
                    $controls = $('.controls', $item),
                    hidden = true;
                $item.hoverToggle({el: $controls}).find('.image > a, .i-play a').fancybox({
                    margin: 105,
                    padding: 0,
                    speedIn: 100,
                    speedOut: 100,
                    changeSpeed: 100,
                    changeFade: 100,
                    overlayColor: '#000',
                    overlayOpacity: .7,
                    centerOnScroll: true
                });
            });
        }
        $moreForm.click(function(){
            more();
        });
        function more() {
            if (busy) {
                return;
            }
            busy = true;
            $moreForm.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function(){
                    $loading.css({'margin': 0});
                },
                success: function(data){
                    $loading.css({'margin': ''});
                    $list.append($(data.content).hide().fadeIn(o.speed));
                    init();
                    busy = false;
                }
            });
        }
    });
};
})(jQuery);



/* tracks
----------------------------------------------- */
(function($){
$.fn.tracks = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $list = $(this),
            $moreForm = $list.closest('.widget').find('.widget-more-link form'),
            $loading = $('.i-loading', $moreForm),
            busy = false;
        init();
        function init() {
            $('.li', $list).each(function(){
                var $item = $(this),
                    $controls = $('.controls', $item),
                    $play = $('.i-play', $item),
                    trackArtist = $('input[name="artist"]', $item).val(),
                    trackName = $('input[name="name"]', $item).val(),
                    trackURL = $('input[name="url"]', $item).val(),
                    trackDownload = $('input[name="download"]', $item).val(),
                    hidden = true;

                $item.hoverToggle({el: $controls});

                $play.unbind().click(function(){
                    var $item = $(this).closest('.li'),
                        playlist = [
                            {
                                artist: trackArtist,
                                name: trackName,
                                url: trackURL,
                                download: trackDownload
                            }
                        ];
                    jplayer.playlist(playlist);
                    jplayer.play(0);
                });
            });
        }
        $moreForm.click(function(){
            more();
        });
        function more() {
            if (busy) {
                return;
            }
            busy = true;
            $moreForm.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function(){
                    $loading.css({'margin': 0});
                },
                success: function(data){
                    $loading.css({'margin': ''});
                    $list.append($(data.content).hide().fadeIn(o.speed));
                    init();
                    busy = false;
                }
            });
        }
    });
};
})(jQuery);



/* place
----------------------------------------------- */
(function($){
$.fn.place = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $controls = $('.controls', $root),
            hidden = true;
        $root.hover(
            function(){
                if (hidden) {
                    $controls.css({'opacity': 0, 'margin': 0});
                }
                hidden = false;
                $controls.stop(true).animate({'opacity': 1}, {queue: false, duration: o.speed});
            },
            function(){
                $controls.stop(true).animate({'opacity': 0}, {queue: false, duration: o.speed, complete: function(){
                    $controls.css({'margin': ''});
                    hidden = true;
                }});
            }
        );
        $('.b-video', $root).each(function(){
            var $item = $(this),
                $controls = $('.controls', $item),
                hidden = true;
            $item.hoverToggle({el: $controls}).find('.image > a, .i-play a').fancybox({
                margin: 105,
                padding: 0,
                speedIn: 100,
                speedOut: 100,
                changeSpeed: 100,
                changeFade: 100,
                overlayColor: '#000',
                overlayOpacity: .7,
                centerOnScroll: true
            });
        });
    });
};
})(jQuery);



/* contacts
----------------------------------------------- */
(function($){
$.fn.contacts = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        $('td', this).each(function(){
            var $td = $(this),
                $controls = $('.controls', $td),
                hidden = true;
            $td.hover(
                function(){
                    if (hidden) {
                        $controls.css({'opacity': 0, 'margin': 0});
                    }
                    hidden = false;
                    $controls.stop(true).animate({'opacity': 1}, {queue: false, duration: o.speed});
                },
                function(){
                    $controls.stop(true).animate({'opacity': 0}, {queue: false, duration: o.speed, complete: function(){
                        $controls.css({'margin': ''});
                        hidden = true;
                    }});
                }
            );
        });
    });
};
})(jQuery);



/* newsFeed
----------------------------------------------- */
(function($){
$.fn.newsFeed = function(o){
    o = $.extend({
        speed: 100,
        interval: 7000
    }, o || {});

    return this.each(function(){
        var $items = $('.li', this),
            currentIndex = 0;
        
        setInterval(function(){
            var index = currentIndex + 1 < $items.length ? currentIndex + 1 : 0;
            $items.eq(currentIndex).fadeOut(o.speed, function(){
                $items.eq(index).fadeIn(o.speed, function(){
                    currentIndex = index;
                });
            });
        }, o.interval);
    });
};
})(jQuery);



/* rate
----------------------------------------------- */
(function($){
$.fn.rate = function(){
    return this.each(function(){
        var $root = $(this),
            $total = $('.total', $root),
            $likeLink = $('.like-link', $root),
            $dislikeLink = $('.dislike-link', $root),
            itemID = $('input[name="item_id"]', $root).val(),
            url = $('input[name="url"]', $root).val(),
            total = $('input[name="total"]', $root).val(),
            current = $('input[name="current"]', $root).val(),
            busy = false;

        $likeLink.on('click', '.i', function(){
            like();
        });
    
        $dislikeLink.on('click', '.i', function(){
            dislike();
        });

        function like() {
            var rate = current <= 0 ? 1 : 0;
            setRate(rate);
        }
    
        function dislike() {
            var rate = current >= 0 ? -1 : 0;
            setRate(rate);
        }
    
        function setRate(rate) {
            if (busy) {
                return;
            }
            
            busy = true;
    
            $likeLink.toggleClass('act', rate > 0);
            $dislikeLink.toggleClass('act', rate < 0);
    
            $.post(url, {id: itemID, rate: rate, total_rate: total, current_rate: current}, function(data) {
                var totalHTML = '(' + (data.total_rate > 0 ? '+' : '') + data.total_rate + ')';
                $total.html(totalHTML);
                total = data.total_rate;
                current = rate;
                busy = false;
            }, 'json');
        }
    });
};
})(jQuery);



/* share
----------------------------------------------- */
(function($){
var $doc = $(document);

$.fn.share = function(o){
    o = $.extend({
        speed: 100,
        easing: 'easeOutExpo'
    }, o);

    return this.each(function(){
        var $root = $(this),
            $links = $('.links', $root),
            url = $('input[name="url"]', $root).val(),
            itemID = $('input[name="item_id"]', $root).val(),
            visible = false,
            busy = false;

        $('.i', this).click(function(e){
            e.stopPropagation();
            toggle();
        });

        $doc.click(function(){
            hide();
        });

        $links.click(function(e){
            e.stopPropagation();
        }).find('a').click(function(){
            var service = $(this).attr('rel'),
                $total = $('.total', this);

            $.post(url, {item_id: itemID, service: service}, function(data){
                $total.html(data.total);
            }, 'json');

            hide();
        });
        
        function toggle() {
            if (visible) {
                hide();
            } else {
                show();
            }
        }

        function show() {
            if (busy || visible) {
                return;
            }
            
            busy = true;
            
            $links.hide().css({'left': '50%', 'top': 10}).animate({
                'top': 0
            }, {
                queue: false,
                easing: o.easing,
                duration: o.speed
            }).fadeIn(o.speed, function(){
                visible = true;
                busy = false;
            });
        }

        function hide() {
            if (busy || !visible) {
                return;
            }
            
            busy = true;

            $links.animate({
                'top': -10
            }, {
                queue: false,
                easing: o.easing,
                duration: o.speed
            }).fadeOut(o.speed, function(){
                $links.css({'left': -9999, 'top': -9999}).show();
                visible = false;
                busy = false;
            });
        }
    });
};
})(jQuery);



/* comments
----------------------------------------------- */
(function($){
var $win = $(window),
    $doc = $(document),
    $body;


$(function(){
    $body = $('html, body');
});


$.fn.comments = function(o){
    return this.each(function(){
        $.comments(this, o);
    });
};


$.comments = function(root, o){
    o = $.extend({}, $.comments.defaults, o);

    var $root = $(root),
        $tree = $('.comments-tree', $root),
        $replyLinks = $('.reply-link', $tree),
        removeURL = $('input[name="remove_url"]', $tree).val(),
        $add = $('.comments-add', $root),
        $addLink = $('.add-link', $add),
        $formBox = $('.comments-form', $add),
        $form = $('form', $formBox),
        itemID = $('input[name="item_id"]', $form).val(),
        parentID = 0,
        $messageInput = $('textarea[name="message"]', $form),
        busy = false;

// Expand
    $tree.on('click', '.expand-link .i', function(){
        expand(this);
    });
    
    $tree.on('click', '.remove-link .i', function(){
        var el = this;
        $.confirm({
            content: o.removeConfirm,
            ok: function(){
                removeComment(el);
            }
        });        
    });

// Comment Actions
    $tree.on('click', '.reply-link span', function(){
        showReplyForm(this);
    });

// Add Comment
    $add.on('click', '.add-link span', function(){
        showAddForm();
    });

// Message Form
    var validator = $form.validate({
        highlight: function(el) {
            $(el).closest('.field').addClass('field-error');
        },
        unhighlight: function(el) {
            $(el).closest('.field').removeClass('field-error');
        },
        errorPlacement: function(){},
        submitHandler: function(){
            $('input, button, select, textarea', $form).blur();
            $form.ajaxSubmit({
                data: {parent_id: parentID},
                dataType: 'json',
                beforeSubmit: function(){
                    $.popup();
                    $.popup.showLoading();
                },
                success: function(data){
                    validator.resetForm();
                    $form.trigger('afterReset');
                    if (data.error) {
                        resetForm();
                        $.alert({text: data.status});
                    } else {
                        addComment(data);
                        $.popup.close();
                    }
                }
            });
        }
    });

    function expand(el) {
        $(el).closest('.ti').removeClass('ti-collapsed');
    }

    function initComment($comment) {
        $replyLinks = $('.reply-link', $tree);
    }

    function addComment(data) {
        var $parentComment = $formBox.closest('.ti'),
            $parentContent = $formBox.closest('.content'),
            $comment = $(data.content);
        resetForm();
        initComment($comment);
        $tree.removeClass('comments-tree-empty');
        if ($parentComment.length) {
            $parentComment.children('.ti:last').removeClass('ti-last');
            $parentComment.append($comment.hide().fadeIn(o.speed));
            $parentContent.addClass('content-has-reply')
        } else {
            $tree.children('.ti:last').removeClass('ti-last');
            $tree.append($comment.hide().fadeIn(o.speed));
        }
        var winHeight = $win.height() - $('.player').height(),
            winScrollTop = $win.scrollTop(),
            commentOffsetTop = $comment.offset().top + $comment.outerHeight() + 10;
        if (commentOffsetTop > winScrollTop + winHeight) {
            var scrollTop = commentOffsetTop - winHeight;
            $body.animate({scrollTop: scrollTop}, {queue: false, easing: o.easing, duration: o.speed});
        }
    }

    function removeComment(el) {
        $.popup.hideWindow();
        $.popup.showLoading();
        var $comment = $(el).closest('.ti'),
            $content = $(el).closest('.content'),
            id = $comment.attr('id').substr(7),
            userID = $comment.children('input[name="userid"]').val();
        $.post(removeURL, {id: id, userid: userID}, function(data) {
            resetForm();
            if (data.error) {
                $.alert({text: data.status});
            } else {
                $.popup.close();
                $comment.children('.i-branch').addClass('i-branch-removed');
                $content.html(data.content).addClass('content-removed');
            }
        }, 'json');
    }

    function showReplyForm(el) {
        var $replyLink = $(el).closest('.reply-link'),
            $oldParent = $formBox.parent();
        parentID = $replyLink.closest('.ti').attr('id').substr(7);
        $oldParent.height($oldParent.height());
        $formBox.hide();
        $addLink.show();
        validator.resetForm();
        $form.trigger('afterReset');
        $replyLinks.show();
        $replyLink.hide().after($formBox.fadeIn(o.speed));
        $oldParent.height('');
        $messageInput.focus();
    }

    function showAddForm() {
        var $oldParent = $formBox.parent();
        parentID = 0;
        $oldParent.height($oldParent.height());
        $formBox.hide();
        $replyLinks.show();
        validator.resetForm();
        $form.trigger('afterReset');
        $addLink.hide().after($formBox.fadeIn(o.speed));
        $oldParent.height('');
        $messageInput.focus();
    }

    function resetForm() {
        var $oldParent = $formBox.parent();
        parentID = 0;
        if ($oldParent.is($add)) {
            validator.resetForm();
            $form.trigger('afterReset');
        } else {
            $oldParent.height($oldParent.height());
            $formBox.hide();
            $replyLinks.show();
            validator.resetForm();
            $form.trigger('afterReset');
            $addLink.hide().after($formBox.fadeIn(o.speed));
            $oldParent.height('');
        }
    }
};

$.comments.defaults = {
    speed: 100,
    easing: 'easeOutExpo',
    removeConfirm: lang.commentsRemoveConfirm
};
})(jQuery);



/* jflow
----------------------------------------------- */
(function($){
$.fn.jflow = function(o){
    o = $.extend({
        speed: 450,
        navSpeed: 100,
        pagerSpeed: 100,
        easing: 'easeOutExpo',
        interval: 7000
    }, o || {});

    return this.each(function(){
        var $root = $(this),
            $content = $('.jflow', $root),
            $pager = $('.jflow-pager', $root);

        if (!$content.length || !$pager.length) {
            return;
        }

        var $list = $('.jflow-list', $content),
            $items = $('.jflow-li', $content),
            $prev = $('.jflow-prev', $content),
            $next = $('.jflow-next', $content),
            $pages,

            contentWidth = $content.width(),
            listWidth = $list.width(),
            gap = parseInt($items.css('padding-left')),
            pagesTotal = Math.ceil((listWidth - gap) / contentWidth),

            currentIndex = 0,
            t,
            busy = false;

        if (listWidth - gap <= contentWidth) {
            return;
        }

        delayedNext();

        (function(){
            $prev.click(function(){
                prev();
            });
            $next.click(function(){
                next();
            });
            $content.hover(
                function(){
                    $prev.add($next).animate({'width': 80}, {queue: false, duration: o.navSpeed});
                },
                function(){
                    $prev.add($next).animate({'width': 0}, {queue: false, duration: o.navSpeed});
                }
            );
            var pagesHTML = '';
            for (i = 1; i <= pagesTotal; i++) {
                pagesHTML += '<div class="jflow-pi"><span>' + i + '</span></div>';
            }
            $pages = $(pagesHTML);
            $pages.eq(currentIndex).addClass('jflow-pi-act');
            $pages.last().addClass('jflow-pi-last');
            $pages.click(function(){
                go($pages.index(this));
            });
            $pager.css('opacity', 0).html($pages).fadeTo(o.pagerSpeed, 1);
        })();

        function prev() {
            go(currentIndex - 1);
        }

        function next() {
            go(currentIndex + 1);
        }

        function delayedNext() {
            t = setTimeout(next, o.interval);
        }

        function go(index) {
            if (busy || index == currentIndex) {
                return;
            }

            $items.eq(index).trigger('showBanner');
            
            clearTimeout(t);

            if (index < 0) {
                index = pagesTotal - 1;
            } else if (index >= pagesTotal) {
                index = 0;
            }

            $pages.removeClass('jflow-pi-act').eq(index).addClass('jflow-pi-act');

            var listCSSLeft = index * (contentWidth + gap);

            if (listCSSLeft > listWidth - gap - contentWidth) {
                listCSSLeft = listWidth - gap - contentWidth;
            }

            $list.animate({'left': -listCSSLeft}, {queue: false, easing: o.easing, duration: o.speed, complete: function(){
                currentIndex = index;
                busy = false;
                delayedNext();
            }});
        }

        $items.eq(0).trigger('showBanner');

    });
};
})(jQuery);



/* player
----------------------------------------------- */
(function($){
$.fn.player = function(o){
    o = $.extend({
        speed: 100,
        riseSpeed: 300,
        easing: 'easeOutExpo',
        refs: '',
        index: 0,
        volume: 70,
        repeat: false,
        autoLoad: false,
        autoPlay: false,
        autoAdvance: true,
        playlist: {},
        height: 100,
        marginBottom: 0
    }, o);

    if (typeof o.playlist != 'object' || !o.playlist.length) {
        return this;
    }

    return this.each(function(){
        var root = this,
            $root = $(root),
            $refs = $(o.refs);

        jplayer = $('.jplayer', $root).jplayer({
            speed: o.speed,
            index: o.index,
            volume: o.volume,
            repeat: o.repeat,
            autoLoad: o.autoLoad,
            autoPlay: o.autoPlay,
            autoAdvance: o.autoAdvance,
            playlist: o.playlist
        });

        $root.animate({
            height: o.height
        }, {
            queue: false,
            duration: o.riseSpeed
        }).unbind('.player').bind('play.player', function(el, index){
            $refs.removeClass('act').eq(index).addClass('act');
        });

        $refs.click(function(){
            var index = $refs.index(this);
            play(index);
        });
        
        function play(index) {
            jplayer.play(index);
        }

        if (o.marginBottom) {
            setPosition(root, o.marginBottom);
            $(window).unbind('.player').bind('resize.player scroll.player', function(){
                setPosition(root, o.marginBottom);
            });
        }
    });

    function setPosition(el, marginBottom) {
        var scrollTop = window.scrollY || document.documentElement.scrollTop,
            scrollHeight = document.documentElement.scrollHeight,
            clientHeight = document.documentElement.clientHeight;

        if (scrollHeight - clientHeight - scrollTop - marginBottom <= 0) {
            el.style.position = 'absolute';
            el.style.bottom = marginBottom + 'px';
        } else {
            el.style.position = '';
            el.style.bottom = '';
        }
    }
};
})(jQuery);



/* jplayer
----------------------------------------------- */
(function($){
$.fn.jplayer = function(o){
    o = $.extend({
        speed: 100,
        index: 0,
        muted: false,
        volume: 70,
        repeat: false,
        autoLoad: false,
        autoPlay: false,
        autoAdvance: true,
        playlist: {}
    }, o);

    if (typeof o.playlist != 'object' || !o.playlist.length) {
        return false;
    }

    var $root = $(this),
        $prev = $('.jplayer-prev', $root),
        $next = $('.jplayer-next', $root),
        $stop = $('.jplayer-stop', $root),
        $play = $('.jplayer-play', $root),
        $download = $('.jplayer-download', $root),
        $title = $('.jplayer-title', $root),
        $titleArtist = $('.jplayer-title-artist', $root),
        $titleName = $('.jplayer-title-name', $root),
        $time = $('.jplayer-time', $root),
        $timePosition = $('.jplayer-time-position', $root),
        $timeDuration = $('.jplayer-time-duration', $root),
        $positionBar = $('.jplayer-position-bar', $root),
        $positionHandle = $('.jplayer-position-handle', $root),
        $loadedBar = $('.jplayer-loaded-bar', $root),
        $mute = $('.jplayer-mute', $root),
        $volumeBar = $('.jplayer-volume-bar', $root),
        $volumeHandle = $('.jplayer-volume-handle', $root),
        sound,
        muted,
        currentIndex,
        currentVolume,
        positionHandled = false,
        interface = {
        		playlist: function(playlist, index){
                if (typeof playlist != 'object' || !playlist.length) {
                    return false;
                }
        		    stop();
                o.playlist = playlist;
        		    o.index = index || 0;
        		},
            play: function(index) {
                play(index);
            }
        };

    soundManager.onready(function(){
        muted = o.muted;
        currentIndex = o.index;
        currentVolume = o.volume;
        initControls();
        setVolume(o.volume);
        toggleMute(!o.muted);
        $volumeHandle.show();
        if (o.autoPlay) {
            play(o.index);
        } else if (o.autoLoad) {
            load(o.index);
        }
    });

    function initControls() {
        $prev.click(function(){
            prev();
        });
        $next.click(function(){
            next();
        });
        $stop.click(function(){
            stop();
        });
        $play.click(function(){
            togglePause();
        });
        $positionBar.slider({
            max: 10000,
            start: function(){
                positionHandled = true;
            },
            slide: function(e, ui){
                var percent = ui.value * 100 / 10000;
                setTimePosition(percent);
            },
            stop: function(e, ui){
                var percent = ui.value * 100 / 10000;
                setPosition(percent)
                positionHandled = false;
            }
        });
        $mute.click(function(){
            toggleMute();
        });
        $volumeBar.slider({
            slide: function(e, ui){
                var percent = ui.value;
                setVolume(percent);
            }
        });
    }
    
    function load(index) {
        if (sound) {
            $time.hide();
            $positionHandle.hide();
            sound.destruct();
        }
        setDownload(index);
        $title.hide();
        setTitle(index);
        $title.fadeIn(o.speed);
        sound = soundManager.createSound({
            id: 'sound' + index,
            url: o.playlist[index].url,
            volume: currentVolume,
            autoLoad: true,
            autoPlay: false,
            multiShot: false,
            whileloading: function(){
                updateLoaded();
                updateTimeDuration();
            },
            whileplaying: function(){
                updatePosition();
                updateTimePosition();
            },
            onfinish: function(){
                onFinish();
            }
        });
        if (sound.readyState === 1) {
            if (muted) {
                sound.mute();
            } else {
                sound.unmute();
            }
            setTimePosition(0);
            setTimeDuration(0);
            $time.fadeIn(o.speed);
            $positionBar.slider('option', 'value', 0);
            $positionHandle.show();
        }
        currentIndex = index;
    }

    function play(index) {
        load(index);
        if (!sound) {
            return false;
        }
        sound.play();
        $play.addClass('jplayer-playing');
        $root.trigger('play', index);
    }

    function togglePause(state) {
        if (sound && sound.playState === 1) {
            if (state === true) {
                resume();
            } else if (state === false) {
                pause();
            } else if (sound.paused) {
                resume();
            } else {
                pause();
            }
        } else if (state !== false) {
            play(currentIndex);
        }
    }

    function pause() {
        if (!sound) {
            return false;
        }
        sound.pause();
        $play.removeClass('jplayer-playing');
    }

    function resume() {
        if (!sound) {
            return false;
        }
        sound.resume();
        $play.addClass('jplayer-playing');
    }

    function stop() {
        if (!sound) {
            return false;
        }
        sound.stop();
        $play.removeClass('jplayer-playing');
        $positionBar.slider('option', 'value', 0);
    }

    function prev(forcePlay) {
        var index = currentIndex - 1;
        if (index < 0) {
            if (o.repeat) {
                index = playlist.length - 1;
            } else {
                stop();
                return;
            }
        }
        if (sound && sound.playState === 1 || forcePlay === true) {
            play(index);
        } else {
            load(index);
        }
    }

    function next(forcePlay) {
        var index = currentIndex + 1;
        if (index >= playlist.length) {
            if (o.repeat) {
                index = 0;
            } else {
                stop();
                return;
            }
        }
        if (sound && sound.playState === 1 || forcePlay === true) {
            play(index);
        } else {
            load(index);
        }
    }

    function onFinish() {
        if (o.autoAdvance) {
            next(true);
        } else {
            stop();
        }
    }

    function setDownload(index) {
        $download.toggleClass('jplayer-download-disabled', !o.playlist[index].download);
        if (o.playlist[index].download) {
            $download.html('<a href="' + o.playlist[index].url + '"></a>');
        } else {
            $download.empty();
        }
    }

    function setTitle(index) {
        $titleArtist.html(o.playlist[index].artist);
        $titleName.html(o.playlist[index].name);
    }

    function setPosition(percent) {
        if (!sound) {
            return false;
        }
        var duration = sound.loaded ? sound.duration : sound.durationEstimate,
            soundOffset = duration * percent / 100;
        sound.setPosition(soundOffset);
        if (!positionHandled) {
            var handleOffset = percent / 100 * 10000;
            $positionBar.slider('option', 'value', handleOffset);
        }
    }

    function updatePosition() {
        if (!sound || positionHandled) {
            return false;
        }
        var duration = sound.loaded ? sound.duration : sound.durationEstimate,
            handleOffset = sound.position / duration * 10000
        $positionBar.slider('option', 'value', handleOffset);
    }

    function updateLoaded() {
        if (!sound) {
            return false;
        }
        var loadedPercent = sound.bytesLoaded / sound.bytesTotal * 100;
        $loadedBar.css('width', loadedPercent + '%');
    }

    function setTimePosition(percent) {
        if (!sound) {
            return false;
        }
        var duration = sound.loaded ? sound.duration : sound.durationEstimate,
            soundPosition = duration * percent / 100,
            time = formatTime(soundPosition);
        $timePosition.html(time);
    }

    function setTimeDuration(duration) {
        if (!sound) {
            return false;
        }
        var time = formatTime(duration);
        $timeDuration.html(time);
    }

    function updateTimePosition() {
        if (!sound || positionHandled) {
            return false;
        }
        var time = formatTime(sound.position);
        $timePosition.html(time);
    }

    function updateTimeDuration() {
        if (!sound) {
            return false;
        }
        var duration = sound.loaded ? sound.duration : sound.durationEstimate,
            time = formatTime(duration);
        $timeDuration.html(time);
    }

    function toggleMute(state) {
        if (state === true) {
            unmute();
        } else if (state === false) {
            mute();
        } else if (muted) {
            unmute();
        } else {
            mute();
        }
    }

    function mute() {
        if (sound) {
            sound.mute();
        }
        $mute.addClass('jplayer-muted');
        $volumeBar.slider('option', 'value', 0);
        muted = true;
    }

    function unmute() {
        if (sound) {
            sound.unmute();
        }
        $mute.removeClass('jplayer-muted');
        $volumeBar.slider('option', 'value', currentVolume);
        muted = false;
    }

    function setVolume(volume) {
        if (volume > 0) {
            unmute();
        }
        if (sound) {
            sound.setVolume(volume);
        }
        $volumeBar.slider('option', 'value', volume);
        currentVolume = volume;
    }

    function formatTime(ms) {
        var s = Math.floor(ms / 1000);
        return Math.floor(s / 60) + ':' + padNumber(s % 60, 2);
    }

    function padNumber(num, length) {
        var str = '' + num;
        while (str.length < length) {
            str = '0' + str;
        }
        return str;
    }

    return interface;
};
})(jQuery);



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
                params = $.extend({}, param1);                
            }
        }
        if (param2) {
            params = $.extend({}, param2);
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
            xhr = $.get(o.href, o.data, function(data){
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
            o.beforeShowLoading(el, o);
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
            o.beforeShowWindow(el, o);
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


/* covers library
----------------------------------------------- */
(function( $ ) {
    $.fn.coversLibrary = function(o) {
        var options = o,
            $coversLibrary = $('<div class="covers-library-wrap"><div class="covers-library"><div class="covers-list"></div><a class="ok" href="#"></a><a class="cancel" href="#"></a></div></div>'),
            $coversList = $coversLibrary.find('.covers-list'),
            $coversLibraryOverlay = $('<div class="covers-library-overlay"></div>');

        return this.each(function() {
            $(this).click(function() {

                // overlay
                $coversLibraryOverlay.appendTo($('body')).click(function() {
                    $coversLibraryOverlay.remove();
                    $coversLibrary.remove();
                });

                // cancel
                $coversLibrary.find('.cancel').click(function(e) {
                    e.preventDefault();
                    $coversLibraryOverlay.remove();
                    $coversLibrary.remove();
                });

                // ok
                $coversLibrary.find('.ok').click(function(e) {
                    e.preventDefault();
                    $coversLibraryOverlay.remove();
                    $coversLibrary.remove();
                    options.target.attr('rel', $coversList.find('.major').attr('rel'));
                    if (options.target.parent().parent().hasClass('poster-input')) {
                        options.target.attr('src', $coversList.find('.major').attr('src').replace('img/10_', 'img/8_'));
                    } else {
                        options.target.attr('src', $coversList.find('.major').attr('src'));
                    };
                });

                // filling library with previews
                $coversList.empty();
                $.each(options.JSON, function(index, value) {
                    var $cover = $('<img />').attr('src', value.url).attr('rel', value.id).click(function() {
                        if (!$cover.hasClass('major')) {
                            $coversList.find('.major').removeClass('major');
                            $cover.addClass('major');
                        };
                    });

                    if(value.major == 1) {
                        $cover.addClass('major');
                    };

                    $coversList.append($cover)
                });
                $coversLibrary.appendTo($('body')).css({
                    'margin': '-150px 0 0 -' + Math.ceil($coversLibrary.width() / 2) + 'px'
                });
            });
        });
    };
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
        text: lang.confirm,
        showClose: false,
        okOnEnter: true,
        cancelOnEsc: true
    };
    $(function(){
        init();
    });
})(jQuery);




/* ADMIN
----------------------------------------------- */
/* teasersAdmin
----------------------------------------------- */
(function($){
$.fn.teasersAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $uploadTeaser = $('#teasers-admin-teaser', $form),
            $teasersList = $('.list', $form).sortable({
                items: 'li:not(.brand)'
            });

        function addTeaser(id, link, active, url, brand, date_start, date_end) {
            var $teaser = $teasersList.find(brand == '1' ? '.hidden.brand' : '.hidden:not(.brand)').clone().removeClass('hidden').insertBefore($teasersList.find('.hidden').eq(0));
            if (id) {
                $teaser.data('id', id);
            };
            $teaser.find('.teaser-image').attr('src', url);
            if(brand !== '1'){
                if(link){
                    $teaser.find('.teaser-url').val(link);
                }
                $teaser.find('.teaser-hidden').attr('checked', active == 1 ? false : true);
                $teaser.find('.remove-link').click(function() {
                    var deletedTeaser = {};
                    deletedTeaser.id = $teaser.data('id') ? $teaser.data('id') : null;
                    deletedTeaser.url = $teaser.find('.teaser-image').attr('src');

                    teasers.deleted.push(deletedTeaser);
                    $teaser.remove();
                });
            } else {
                if(link){
                    $teaser.find('.teaser-url').text(link).attr('href', link);
                }
                if(date_start){
                    $teaser.find('.date-start').text(date_start);
                }
                if(date_end){
                    $teaser.find('.date-end').text(date_end);
                }
            }
        };


        $form.submit(function(event) {
            event.preventDefault();

            teasers.teaser = [];
            $teasersList.find('li:not(.hidden):not(.brand)').each(function(i) {
                var $teaser = $(this);

                teasers.teaser[i] = {};
                teasers.teaser[i].id = $teaser.data('id') ? $teaser.data('id') : null;
                teasers.teaser[i].link = $teaser.find('.teaser-url').val();
                teasers.teaser[i].active = $teaser.find('.teaser-hidden').attr('checked') ? 0 : 1;
                teasers.teaser[i].url = $teaser.find('.teaser-image').attr('src');
            });
            $.popup.showOverlay();
            $.popup.showLoading();

            $.post(
                $form.attr('action'),
                'data=' + JSON.stringify(teasers),
                function(data) {
                    teasers = $.parseJSON(data);

                    if (teasers.error) {
                        $.alert({
                            content: teasers.status
                        });
                        return;
                    };

                    init();
                    $.popup.close();
                }
            );
        });


        function init() {
            $teasersList.find('li:not(.hidden)').remove();
            teasers.deleted = [];

            if (teasers.teaser && teasers.teaser.length > 0) {
                $.each(teasers.teaser, function(i, item) {
                    addTeaser(item.id, item.link, item.active, item.url, item.brand, item.date_start, item.date_end);
                });
            };
        };


        (function() {
            init();

            $uploadTeaser.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': encodeURIComponent('/file/uploadimage/?w=980&h=220'),
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $uploadTeaser.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response)

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [980, 220],
                            ratio: 4.45,
                            size: 11,
                            complete: function(data) {
                                addTeaser(null, null, 1, data.src);
                                $.popup.close();
                            }
                        });
                    };
                }
            });
        }());




        /*(function(){
            var $field = $('.teaser-field', $form),
                $fileInput = $('.input-file input', $field),
                name = $fileInput.attr('name'),
                uploadURL = $('input[name="' + name + '_upload"]', $field).val(),
                cropURL = $('input[name="' + name + '_crop"]', $field).val(),
                size = $('input[name="' + name + '_size"]', $field).val(),
                min = $('input[name="' + name + '_min"]', $field).val().split(','),
                ratio = min[0] / min[1];
            $fileInput.on('change', upload);
            function upload() {
                $form.upload({
                    url: uploadURL,
                    data: {name: name, min: min},
                    complete: function(data){
                        $form.reset();
                        var index = list.getLastIndex() + 1;
                        $.image.crop({
                            url: cropURL,
                            src: data.src,
                            min: min,
                            ratio: ratio,
                            data: {size: size, index: index},
                            complete: function(data){
                                list.add($(data.content));
                                $.popup.close();
                            }
                        });
                    }
                });
            }
        })();
        var list = (function(){
            var $list = $('.list', $root),
                $items = $('li', $list);
            $items.each(function(){
                init($(this));
            });
            function init($item) {
                $('label.placeholder', $item).placeholder();
                $('.hide-input input', $item).on('click', function(){
                    toggle($item, this.checked);
                });
                $('.remove-link span', $item).on('click', function(){
                    remove($item);
                });
            }
            function toggle($item, hidden) {
                $item.toggleClass('hidden', hidden);
            }
            function add($item) {
                $list.show().append($item.hide().fadeIn(o.speed));
                $items = $('li', $list);
                init($item);
            }
            function remove($item) {
                $.confirm({
                    content: lang.teasersAdminRemoveConfirm,
                    ok: function(){
                        $.popup.close();
                        if ($items.length > 1) {
                            $item.fadeOut(o.speed, function(){
                                $item.remove();
                                $items = $('li', $list);
                            });
                        } else {
                            $list.fadeOut(o.speed, function(){
                                $item.remove();
                                $items = $();
                            });
                        }
                    }
                });
            }
            function getLastIndex() {
                var lastIndex = 0;
                $('.href-input input', $list).each(function(){
                    var index = parseInt(this.name.substr(5));
                    if (index > lastIndex) {
                        lastIndex = index;
                    }
                });
                return lastIndex;
            }
            return {add: add, getLastIndex: getLastIndex}
        })();*/
    });
};
})(jQuery);


(function($){
    $.fn.clubCards = function(){
        return this.each(function(){
            var $root = $(this);
            $root.on('click', '.controls .i-add a', function(e){
                e.preventDefault();
                var $li = $(this).closest('.clubcards-li');
                $.popup({
                    src: '#card-edit-popup-src',
                    afterShowWindow: function(){
                        $('.popup-window').clubCardEditPopup();
                    }
                });
            });

            $root.on('click', '.controls .i-edit a', function(e){
                e.preventDefault();
                var $li = $(this).closest('.clubcards-li');
                $.popup({
                    src: '#card-edit-popup-src',
                    afterShowWindow: function(){
                        $('.popup-window').clubCardEditPopup();
                    }
                });
            });

        });
    };

    $.fn.clubCardEditPopup = function(){
        return this.each(function(){
            var $popup = $(this);
            $popup.find('.user-select-field select').ikSelectNano();
            $popup.find('.ik_select').bind('click', function(e){
                e.stopPropagation();
            });
            $popup.bind('click', function(){
                if($('.ik_select_block').length){
                    $(document).trigger('click.ikSelect');
                }                            
            });                                
        });
    }

})(jQuery);


(function($){
    $.fn.clubCardEdit = function(){
        return this.each(function(){

            var $root = $(this),
                $form = $('form', $root),
                $firstname = $('input[name=firstname]', $root),
                $lastname = $('input[name=lastname]', $root),
                $gender = $('input[name=gender]', $root),
                $birthDateYear = $('select[name=birthdate_year]', $root),
                $birthDateMonth = $('select[name=birthdate_month]', $root),
                $birthDateDay = $('select[name=birthdate_day]', $root),
                $phone = $('input[name=phone]', $root),
                $uploadCover = $('#upload-photo', $root),
                $cover = $('.cover-input .img img', $root),
                $removeCover = $('.cover-input .remove-link', $root);

            function init() {
                if (clubCard.card.firstname) {
                    $firstname.val(clubCard.card.firstname);
                };

                if (clubCard.card.lastname) {
                    $lastname.val(clubCard.card.lastname);
                };

                if (clubCard.card.gender) {
                    $gender.filter('input[value='+clubCard.card.gender+']').prop('checked', true).change();
                };

                if (clubCard.card.birthdate_year) {
                    $birthDateYear.find('option[value='+clubCard.card.birthdate_year+']').prop('selected', true);
                    $birthDateYear.change();
                };

                if (clubCard.card.birthdate_month) {
                    $birthDateMonth.find('option[value='+clubCard.card.birthdate_month+']').prop('selected', true);
                    $birthDateMonth.change();
                };

                if (clubCard.card.birthdate_day) {
                    $birthDateDay.find('option[value='+clubCard.card.birthdate_day+']').prop('selected', true);
                    $birthDateDay.change();
                };

                if (clubCard.card.phone) {
                    $phone.val(clubCard.card.phone);
                };

                if (clubCard.card.url) {
                    $removeCover.show();
                    $cover.attr('src', clubCard.card.url);
                } else {
                    $cover.attr('src', '/img/reactor/profile/image-na.jpg');
                }

            };

            $uploadCover.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $uploadCover.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response)

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [220, 220],
                            ratio: 1,
                            size: 4,
                            complete: function(data) {
                                if(clubCard.card){                                    
                                    if ($cover.attr('src') != '/img/reactor/profile/image-na.jpg') {
                                        clubCard.card.url_deleted = $cover.attr('src');
                                    } else {
                                        clubCard.card.url_new = true;
                                    };
                                }
                                $cover.attr('src', data.src);
                                $removeCover.show();
                                $.popup.close();
                            }
                        });
                    };
                }
            });
            
            $removeCover.click(function() {
                if(clubCard.card){
                    clubCard.card.url_deleted = $cover.attr('src');
                }
                $cover.attr('src', '/img/reactor/profile/image-na.jpg');
                $removeCover.hide();
            });

            $form.submit(function(e) {
                e.preventDefault();

                $.popup();
                $.popup.showLoading();

                clubCard.card.firstname = $firstname.val();
                clubCard.card.lastname = $lastname.val();
                clubCard.card.gender = $gender.val();
                clubCard.card.birdthdate_year = birthdate_year.val();
                clubCard.card.birthdate_month = birthdate_month.val();
                clubCard.card.birthdate_day = birthdate_day.val();
                clubCard.card.phone = phone.val();

                if ($cover.attr('src') == '/img/reactor/profile/image-na.jpg') {
                    clubCard.card.url = null;
                } else {
                    clubCard.card.url = $cover.attr('src');
                };



                $.post(
                    $form.attr('action'),
                    'data=' + JSON.stringify(clubCard),
                    function(data) {
                        clubCard = $.parseJSON(data);

                        if (clubCard.errorid) {
                            $.alert({
                                content: clubCard.errormessage
                            });
                            return;
                        } else if (clubCard.status) {
                            $.alert({
                                content: clubCard.status
                            });
                        } else {
                            $.popup.close();
                        };

                        init();
                    }
                );
            });

            if(clubCard.card){
                init();
            }

        });
    };
})(jQuery);

/* contactsAdmin
 ----------------------------------------------- */
(function($){
    $.fn.userProfile = function(){
        return this.each(function(){
            var $root = $(this),
                $form = $('form', $root),
                $name = $('.visible-name', $root),
                $description = $('.user-description', $root),
                $cover = $('.cover-input .img img', $root),
                $uploadCover = $('#upload-user-avatar', $root),
                $removeCover = $('.cover-input .remove-link', $root),
                $socialProfilesList = $('.jlist', $form).jlist();


            function addSocialLink(id, url, active) {
                var $socilaLink = $socialProfilesList.find('.placeholder').clone().removeClass('placeholder').insertBefore('.placeholder');

                $socilaLink.data('id', id);

                if (url) {
                    $socilaLink.find('.input-text input').val(url);
                };

                $socilaLink.find('.remove-link').click(function() {
                    $socilaLink.remove();
                });
            };


            function init() {
                $socialProfilesList.find('li:not(.placeholder)').remove();

                if (userProfile.user.displayname) {
                    $name.val(userProfile.user.displayname)
                };

                if (userProfile.user.preview_text) {
                    $description.html(userProfile.user.preview_text);
                };

                if (userProfile.user.url) {
                    $removeCover.show();
                    $cover.attr('src', userProfile.user.url);
                } else {
                    $cover.attr('src', '/img/reactor/profile/image-na.jpg');
                }

                if (userProfile.user.links) {
                    $.each(userProfile.user.links, function(i, item) {
                        addSocialLink(item.id, item.url, item.active);
                    });
                };

            };


            $uploadCover.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $uploadCover.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response)

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [220, 220],
                            ratio: 1,
                            size: 4,
                            complete: function(data) {
                                if ($cover.attr('src') != '/img/reactor/profile/image-na.jpg') {
                                    userProfile.user.url_deleted = $cover.attr('src');
                                } else {
                                    userProfile.user.url_new = true;
                                };
                                $cover.attr('src', data.src);
                                $removeCover.show();
                                $.popup.close();
                            }
                        });
                    };
                }
            });


            $removeCover.click(function() {
                userProfile.user.url_deleted = $cover.attr('src');
                $cover.attr('src', '/img/reactor/profile/image-na.jpg');
                $removeCover.hide();
            });

            $form.submit(function(e) {
                e.preventDefault();

                $.popup();
                $.popup.showLoading();

                userProfile.user.displayname = $name.val();
                userProfile.user.preview_text = $description.val();

                if ($cover.attr('src') == '/img/reactor/profile/image-na.jpg') {
                    userProfile.user.url = null;
                } else {
                    userProfile.user.url =$cover.attr('src');
                };

                userProfile.user.links = [];

                $socialProfilesList.find('li:not(.placeholder)').each(function(i) {
                    var $socialLink = $(this),
                        socialLink = {};

                    socialLink.id = $socialLink.data('id') ? $socialLink.data('id') : null;
                    socialLink.url = encodeURIComponent(($socialLink.find('.input-text input').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
                    userProfile.user.links.push(socialLink);
                });


                $.post(
                    $form.attr('action'),
                    'data=' + JSON.stringify(userProfile),
                    function(data) {
                        userProfile = $.parseJSON(data);

                        if (userProfile.errorid) {
                            $.alert({
                                content: userProfile.errormessage
                            });
                            return;
                        } else if (userProfile.status) {
                            $.alert({
                                content: userProfile.status
                            });
                        } else {
                            $.popup.close();
                        };

                        init();
                    }
                );
            });


            init();
        });
    };
})(jQuery);


/* contactsAdmin
----------------------------------------------- */
(function($){
$.fn.contactsAdmin = function(){
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $contactsList = $('.jlist', $form).jlist();


        function addContact(id, name, email, phone) {
            var $contact = $contactsList.find('.placeholder').clone().removeClass('placeholder').insertBefore('.placeholder');

            $contact.data('id', id);

            if (name) {
                $contact.find('.name').val(name);
            };

            if (email) {
                $contact.find('.email').val(email);
            };

            if (phone) {
                $contact.find('.phone').val(phone);
            };

            $contact.find('.remove-link').click(function() {
                $contact.remove();
            });
        };


        $form.submit(function(e) {
            e.preventDefault();

            contacts.contact = [];

            $contactsList.find('li:not(.placeholder)').each(function(i) {
                var $contact = $(this);

                contacts.contact[i] = {};
                contacts.contact[i].id = $contact.data('id') ? $contact.data('id') : null;
                contacts.contact[i].name = encodeURIComponent(($contact.find('.name').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
                contacts.contact[i].email = encodeURIComponent(($contact.find('.email').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
                contacts.contact[i].phone = encodeURIComponent(($contact.find('.phone').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
            });

            $.popup();
            $.popup.showLoading();

            $.post(
                $form.attr('action'),
                'data=' + JSON.stringify(contacts),
                function(data) {
                    contacts = $.parseJSON(data);

                    if (contacts.errorid) {
                        $.alert({
                            content: contacts.errormessage
                        });
                        return;
                    } else if (contacts.status) {
                        $.alert({
                            content: contacts.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
        });


        function init() {
            $contactsList.find('li:not(.placeholder)').remove();

            if (contacts.contact) {
                $.each(contacts.contact, function(i, item) {
                    addContact(item.id, item.name, item.email, item.phone);
                });
            };

        };

        init();
    });
};
})(jQuery);


(function($){
//style scrollbars (for select box):
$.fn.doNanoScroll = function(){
    return this.each(function(){
        var $el = $(this),
                $ik_inner = $el.closest('.ik_select_list_inner');
        if($ik_inner.css('overflow') == 'auto'){
            if($el.data('hasnanoscroll') !== true){
                $el.wrap('<div class="nano"><div class="content">');
                $el.data('hasnanoscroll', true);
            }
            $el.closest('.nano').nanoScroller();
        } else {
            if($el.data('hasnanoscroll') == true){
                $el.closest('.nano').nanoScroller({stop: true});    
            }           
        }
    });
};
$.fn.ikSelectNano = function(o){

    return this.each(function(){
        $(this).ikSelect(o ? o : {
            autoWidth: false,
            ddFullWidth: false,
            ddMaxHeight: 200,
            skipFirst: true
        }).bind('ikshow', function(){
            $('.ik_select_list_inner > ul').doNanoScroll();
        });
    });
};
})(jQuery);

/* eventAdmin
----------------------------------------------- */
(function($){
$.fn.eventAdmin = function(){
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $useTemplate = $('.use-template button', $form),
            $date = $('.date-input', $form),
            $dateInput = $('#event-admin-date', $form),
            $uploadAvatar = $('#event-admin-avatar', $form),
            $avatarInput = $('.avatar-input .img img', $form),
            $uploadPoster = $('#event-admin-poster', $form),
            $posterInput = $('.poster-input .img img', $form),
            $nameInput = $('#event-admin-title', $form),
            $descriptionInput = $('#event-admin-descr', $form),
            $allListRows = $('.jlist:not(.brands-list .jlist)', $form).jlist(),
            $socialLinksList = $('.links ul', $form),
            $artistsLinksList = $('.guests ul', $form),
            $supportLinksList = $('.artists ul', $form),
            $brandsOfferEnable = $('.brands .brand-offer', $form),
            $brandsFilter = $('.brands .brands-filter-radios', $form),
            $brandsList = $('.brands .brands-list'),
            $brandsListRows = $('.brands-list .jlist', $form).jlist({selects: true, ikselect: true, sortable: false}),
            $editAvatar = $('.avatar-input .select-link', $form),
            $editPoster = $('.poster-input .select-link', $form),
            $removeAvatar = $('.avatar-input .remove-link', $form),
            $removePoster = $('.poster-input .remove-link', $form);

        $allListRows = $allListRows.add($brandsListRows);

        $form.submit(function(event) {
            event.preventDefault();
            $.popup();
            $.popup.showLoading();

            eventInner.event.name = encodeURIComponent(($nameInput.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
            eventInner.event.detail_text = encodeURIComponent(($descriptionInput.wysiwyg('getContent') + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\t/g,''));
            eventInner.event.date_start = $dateInput.val();

            eventInner.artist = [];
            $artistsLinksList.find('li:not(.placeholder)').each(function(i) {
                var $artist = $(this),
                    headlineArtist = {}

                headlineArtist.id = $artist.data('id') ? $artist.data('id') : null;
                headlineArtist.name = encodeURIComponent(($artist.find('.name-input input').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
                headlineArtist.comment = encodeURIComponent(($artist.find('.descr-input input').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
                headlineArtist.support = 0;
                eventInner.artist.push(headlineArtist);
            });

            $supportLinksList.find('li:not(.placeholder)').each(function(i) {
                var $support = $(this),
                    supportArtist = {};

                supportArtist.id = $support.data('id') ? $support.data('id') : null;
                supportArtist.name = encodeURIComponent(($support.find('input').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
                supportArtist.comment = null;
                supportArtist.support = 1;
                eventInner.artist.push(supportArtist);
            });

            eventInner.social = [];
            $socialLinksList.find('li:not(.placeholder)').each(function(i) {
                var $link = $(this),
                    socialLink = {};

                socialLink.id = $link.data('id') ? $link.data('id') : null;
                socialLink.url = encodeURIComponent(($link.find('input').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
                eventInner.social.push(socialLink);
            });

            if ($avatarInput.attr('rel')) {
                eventInner.event.avatarid = $avatarInput.attr('rel');
                eventInner.event.avatar = $avatarInput.attr('src');
                $avatarInput.removeAttr('rel');
            };

            if ($posterInput.attr('rel')) {
                eventInner.event.posterid = $posterInput.attr('rel');
                eventInner.event.poster = $posterInput.attr('src');
                $posterInput.removeAttr('rel');
            };

            eventInner.event.brandOfferType = $brandsOfferEnable.prop('checked') ? 1 : 0;
            if(eventInner.event.brandOfferType > 0){
                if($brandsFilter.find('input:checked').val() == 2){
                    eventInner.event.brandOfferType = 2;
                    eventInner.event.brands = [];
                    $brandsList.find('.jlist > li:not(.placeholder)').each(function(i){
                        eventInner.event.brands.push($(this).find('select').val());
                    });
                }
            } else {
                eventInner.event.brandOfferType = 0;
            }

            if(eventInner.event.brandOfferType == 2 && !eventInner.event.brands.length){
                delete eventInner.event.brands;
                eventInner.event.brandOfferType = 0;
            }

            $brandsList.find('select').each(function(){
                var $select = $(this);
                if($select.data('plugin_ikSelect')){
                    $select.ikSelectNano('detach').removeData('plugin_ikSelect').removeClass('ik_select_opened');    
                }                
            });

            $.post(
                $form.attr('action'),
                'data=' + JSON.stringify(eventInner),
                function(data) {
                    eventInner = $.parseJSON(data);
                    if (eventInner.error) {
                        $.alert({
                            content: eventInner.status
                        });
                        return;
                    };

                    if (eventInner.new) {
                        document.location.href = '/admin/event/' + eventInner.new;
                    };

                    init();
                    $.popup.close();
                }
            );
        });

        $brandsOfferEnable.bind('change', function(){
            if($(this).prop('checked')){
                $brandsFilter.show();
                if(!$brandsFilter.find('input:checked').length){
                    $brandsFilter.find('input[value=1]').prop('checked', true).change();
                }
                if($brandsFilter.find('input:checked').val() == '2'){
                    $brandsList.show();
                    var $bSelect = $brandsList.find('select');
                    if($bSelect.length == 1 && !$bSelect.data('plugin_ikSelect') && eventInner.event.brandOfferType < 2){
                      $bSelect.ikSelectNano();
                    }
                }
            } else {
                $brandsList.hide();
                $brandsFilter.hide();
            }
        });

        $brandsFilter.find('input').bind('change', function(){
            if($(this).val() == '2'){
                $brandsList.show();
                var $bSelect = $brandsList.find('select');
                if($bSelect.length == 1 && !$bSelect.data('plugin_ikSelect') && (eventInner.event.brandOfferType < 2 || eventInner.event.brandOfferType === undefined || $bSelect.hasClass('cleared'))){
                    $bSelect.removeClass('cleared').ikSelectNano();
                }
            } else {
                if($brandsList.find('.jlist>li').length > 1){
                    $brandsList.find('.jlist>li:not(.placeholder)').remove();    
                }
                var $placeholderSelect = $brandsList.find('.placeholder select');
                if($placeholderSelect.data('plugin_ikSelect')){
                    $placeholderSelect.ikSelectNano('detach').removeData('plugin_ikSelect').removeClass('ik_select_opened').addClass('cleared');
                }
                $placeholderSelect.find('option').prop('disabled', false);
                $brandsList.hide();
            }
        });
        
        if(brandlist.length){
            var $bSelect = $brandsList.find('select');
            for(var b in brandlist){
                $bSelect.append('<option value="'+brandlist[b].id+'">'+brandlist[b].name+'</option>');
            }
        }

        function init() {
            if (eventInner.event) {
                eventInner.event.deleted = {};
                $allListRows.find('li:not(.placeholder)').remove();

                $nameInput.val(eventInner.event.name ? eventInner.event.name : '');
                $descriptionInput.wysiwyg('setContent', eventInner.event.detail_text ? eventInner.event.detail_text : '');
                $dateInput.val(eventInner.event.date_start);
                if (eventInner.event.dayinweek < 6) {
                    $date.removeClass('date-input-weekend');
                };
                $date.find('.day').html(eventInner.event.dayinmonth);
                $date.find('.month').html(lang.months[eventInner.event.month - 1][1]);
                $date.find('.weekday').html(lang.weekdays[eventInner.event.dayinweek == 1 ? 6 : parseInt(eventInner.event.dayinweek) - 2]);
                $avatarInput.attr('src', eventInner.event.avatarid ? eventInner.event.avatar : defaultAvatar);
                $posterInput.attr('src', eventInner.event.posterid ? eventInner.event.poster : defaultPoster);

                if (!eventInner.event.avatarid) {
                    $removeAvatar.hide();
                };

                if (!eventInner.event.posterid) {
                    $removePoster.hide();
                };

                if (eventInner.artist) {
                    $.each(eventInner.artist, function(i, item) {
                        if (item.support == 0) {
                            var $artist = $artistsLinksList.find('.placeholder').clone().removeClass('placeholder').insertBefore($artistsLinksList.find('.placeholder'));
                            $artist.data('id', item.id);
                            $artist.find('.name-input input').val(item.name);
                            $artist.find('.descr-input input').val(item.comment);
                            $artist.find('.remove-link').click(function() {
                                $artist.fadeOut('fast', function() { $artist.remove(); });
                            });

                        } else {
                            var $support = $supportLinksList.find('.placeholder').clone().removeClass('placeholder').insertBefore($supportLinksList.find('.placeholder'));
                            $support.data('id', item.id);
                            $support.find('input').val(item.name);
                            $support.find('.remove-link').click(function() {
                                $support.fadeOut('fast', function() { $support.remove(); });
                            });
                        };
                    });
                };

                if (eventInner.social) {
                    $.each(eventInner.social, function(i, item) {
                        var $link = $socialLinksList.find('.placeholder').clone().removeClass('placeholder').insertBefore($socialLinksList.find('.placeholder'));
                        $link.data('id', item.id);
                        $link.find('input').val(item.url);
                        $link.find('.remove-link').click(function() {
                            $link.fadeOut('fast', function() { $link.remove(); });
                        });
                    });
                };


                if(eventInner.event.brandOfferType > 0){
                    $brandsOfferEnable.prop('checked', true);
                    $brandsOfferEnable.change();
                    if(eventInner.event.brandOfferType == 2 ){
                        $brandsFilter.find('input[value=2]').prop('checked', true).change();
                        if(eventInner.event.brands){
                            $.each(eventInner.event.brands, function(i, item) {
                                var $brand = $brandsList.find('.placeholder').clone().removeClass('placeholder').insertBefore($brandsList.find('.placeholder'));
                                $brand.data('id', item);                                
                                $brand.find('select').val(item).change();
//                                $brand.find('select').ikSelectNano('disable');
                                $brandsList.find('.placeholder').find('option[value='+item+']').prop('disabled', true);
                                $brand.find('.remove-link').click(function() {
                                    var id = $(this).closest('li').find('select').val();
                                    $brand.fadeOut('fast', function() { $brand.remove(); });
                                    $brandsList.find('option[value='+id+']').prop('disabled', false);
                                    $brandsList.find('select').ikSelectNano('reset');
                                });
                            });
                            $brandsList.find('select').ikSelectNano();
                            $brandsList.find('li:not(.placeholder)').find('select').ikSelectNano('disable');

                        }
                    } else {
                        $brandsFilter.find('input[value=1]').prop('checked', true).change();
                    }
                } else {
                    $brandsOfferEnable.prop('checked', false);
                    $brandsOfferEnable.change();
                }

            } else {
                eventInner.event = {};
                eventInner.event.deleted = {};

                var cT = new Date(),
                    cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
                    cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
                    cYear = cT.getFullYear();

                $dateInput.val(cDay + '.' + cMonth + '.' + cYear);
                $date.find('.day').html(cDay);
                $date.find('.month').html(lang.months[cT.getMonth()][1]);
                $date.find('.weekday').html(lang.weekdays[cT.getDay() - 1]);

                if (cT.getDay() < 5) {
                    $date.removeClass('date-input-weekend');
                };

                $avatarInput.attr('src', defaultAvatar);
                $posterInput.attr('src', defaultPoster);

                $('.remove-button').hide();
                $removeAvatar.hide();
                $removePoster.hide();
            };
        };

        (function() {
            $descriptionInput.wysiwyg({
                css: '/css/club/jwysiwyg.css',
                initialContent: '<p></p>',
                rmMsWordMarkup: true,
                rmUnwantedBr: true,
                i18n: false,
                rmFormat: {
                    rmMsWordMarkup: true
                },
                removeHeadings: true,
                rmUnwantedBr: true,
                removeFormat: true,
                controls: {
                    insertOrderedList: { visible : false },
                    insertUnorderedList: { visible : false },
                    insertHorizontalRule: { visible : false },
                    subscript: { visible : false },
                    superscript: { visible : false },
                    indent: { visible : false },
                    outdent: { visible : false },
                    unLink: { visible : false },
                    insertTable: { visible : false },
                    justifyFull: { visible : false },
                    h1: { visible : false },
                    h2: { visible : false },
                    h3: { visible : false },
                    code: { visible : false },
                    undo: { visible : false },
                    redo: { visible : false },
                    insertImage: { visible : false },
                    createLink: { visible : true },
                    unLink: { visible : true },
                    html: { visible : true }
                },
                events: {
                    paste: function() {
                        var iframe_textarea = $(this).find('body');

                        setTimeout(function() {
                            var html = iframe_textarea.html();

                            html = html.replace(/<(\/)*(\\?xml:|span|p|style|font|del|ins|st1:|[ovwxp]:)(.*?)>/gi, '');
                            html = html.replace(/(class|style|type|start)="(.*?)"/gi, '');
                            html = html.replace( /\s*mso-[^:]+:[^;"]+;?/gi, '' ) ;
                            html = html.replace(/<\s*(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "<$1$3");
                            html = html.replace( /<(\w[^>]*) onmouseover="([^\"]*)"([^>]*)/gi, "<$1$3") ;
                            html = html.replace( /<(\w[^>]*) onmouseout="([^\"]*)"([^>]*)/gi, "<$1$3") ;
                            html = html.replace(/<script(.*?)script>/gi, '');
                            html = html.replace(/<!--(.*?)-->/gi, '');
                            html = html.replace(/<(.*?)>/gi, '');
                            html = html.replace(/<(.*?)\/>/gi, '');
                            html = html.replace(/<\/?(span)[^>]*>/gi, '');
                            html = html.replace(/<\/?(span)[^>]*>/gi, '');
                            html = html.replace( /<\/?(img|font|style|p|div|v:\w+)[^>]*>/gi, '');
                            html = html.replace( /\s*style="\s*"/gi, '' ) ;
                            html = html.replace( /<SPAN\s*[^>]*>\s*&nbsp;\s*<\/SPAN>/gi, '&nbsp;' ) ;
                            html = html.replace( /<SPAN\s*[^>]*><\/SPAN>/gi, '' ) ;

                            iframe_textarea.html(html);
                        }, 100);
                    }
                }
            });


            $descriptionInput.find('body').bind('paste',function(e){
                var rte = $(this);
                _activeRTEData = $(rte).html();
                beginLen = $.trim($(rte).html()).length;

                setTimeout(function(){
                    var text = $(rte).html();
                    var newLen = $.trim(text).length;

                    //identify the first char that changed to determine caret location
                    caret = 0;

                    for(i=0;i < newLen; i++){
                        if(_activeRTEData[i] != text[i]){
                            caret = i-1;
                            break;
                        }
                    }

                    var origText = text.slice(0,caret);
                    var newText = text.slice(caret, newLen - beginLen + caret + 4);
                    var tailText = text.slice(newLen - beginLen + caret + 4, newLen);

                    var newText = newText.replace(/(.*(?:endif-->))|([ ]?<[^>]*>[ ]?)|(&nbsp;)|([^}]*})/g,'');

                    newText = newText.replace(/[·]/g,'');

                    $(rte).html(origText + newText + tailText);
                    $(rte).contents().last().focus();
                },100);
            });




            $useTemplate.confirm({
                content: (function() {
                    var confirmPopupContent = '';

                    for (i = 0; i < 5; i++) {
                        confirmPopupContent += '<div class="template"><a href="#">Удалить шаблон</a><img src="http://i.imgur.com/Zv0Sn.jpg" /><span>Название шаблона</span></div>';
                    };

                    return confirmPopupContent;
                } ())/*,
                ok: function() {
                    eventInner.event.delete = true;

                    $.post(
                        $form.attr('action'),
                        {data: JSON.stringify(eventInner)},
                        function(data) {
                            eventInner = $.parseJSON(data);

                            if (eventInner.error) {
                                $.alert({
                                    content: eventInner.status
                                });
                                return;
                            };

                            if (eventInner.reload) {
                                document.location.href= '/events/';
                            };
                        }
                    );
                    $.popup.close();
                }*/
            });

            $('.remove-button').confirm({
                content: lang.eventAdminRemoveConfirm,
                ok: function() {
                    eventInner.event.delete = true;
                    $.post(
                        $form.attr('action'),
                        {data: JSON.stringify(eventInner)},
                        function(data) {
                            eventInner = $.parseJSON(data);

                            if (eventInner.error) {
                                $.alert({
                                    content: eventInner.status
                                });
                                return;
                            };

                            if (eventInner.reload) {
                                document.location.href= '/events/';
                            };
                        }
                    );
                    $.popup.close();
                }
            });

            $editAvatar.coversLibrary({
                JSON: avatarPreviews,
                target: $avatarInput
            });

            $editPoster.coversLibrary({
                JSON: posterPreviews,
                target: $posterInput
            });

            $removeAvatar.click(function() {
                $avatarInput.attr('src', defaultAvatar);
                if (eventInner.event.avatarid) {
                    eventInner.event.deleted.avatarid = eventInner.event.avatarid;
                    eventInner.event.deleted.avatar = eventInner.event.avatar;
                    eventInner.event.avatar = null;
                    eventInner.event.avatarid = null;
                };
                $removeAvatar.hide();
            });

            $removePoster.click(function() {
                $posterInput.attr('src', defaultPoster);
                if (eventInner.event.posterid) {
                    eventInner.event.deleted.posterid = eventInner.event.posterid;
                    eventInner.event.deleted.poster = eventInner.event.poster;
                    eventInner.event.poster = null;
                    eventInner.event.posterid = null;
                };
                $removePoster.hide();
            });

            $uploadAvatar.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $uploadAvatar.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response)

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [100, 100],
                            ratio: 1,
                            size: 2,
                            complete: function(data) {
                                if (eventInner.event.avatarid) {
                                    eventInner.event.deleted.avatarid = eventInner.event.avatarid;
                                    eventInner.event.deleted.avatar = eventInner.event.avatar;
                                    eventInner.event.avatarid = null;
                                };
                                eventInner.event.avatar = data.src;
                                $avatarInput.attr('src', data.src);
                                $removeAvatar.show();
                                $.popup.close();
                            }
                        });
                    };
                }
            });

            $uploadPoster.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $uploadPoster.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response)

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [220, 310],
                            ratio: 0.7,
                            size: 8,
                            complete: function(data) {
                                if (eventInner.event.posterid) {
                                    eventInner.event.deleted.posterid = eventInner.event.posterid;
                                    eventInner.event.deleted.poster = eventInner.event.poster;
                                    eventInner.event.posterid = null;
                                };
                                eventInner.event.poster = data.src;
                                $posterInput.attr('src', data.src);
                                $removePoster.show();
                                $.popup.close();
                            }
                        });
                    };
                }
            });


            $('.date-input', $root).date();

            init();
        }());
    });
};
})(jQuery);



/* videoAdmin
----------------------------------------------- */
(function($){
$.fn.videoAdmin = function() {
    return this.each(function() {
        var $root = $(this),
            $form = $('form', $root),
            $date = $('#video-admin-date', $form),
            $dateVisible = $('.date-input', $form).date(),
            $title = $('#video-admin-title', $form),
            $link = $('#video-admin-url', $form),
            $cover = $('.preview-input .img img', $form),
            $isHidden = $('#video-admin-hide', $form),
            $removeVideo = $('.submit .remove-link', $form),
            $removeCover = $('.preview-input .remove-link', $form),
            $editCover = $('.preview-input .edit-link', $form),
            $uploadCover = $('#video-admin-preview', $form),
            $uploadWrap = $('.upload-field', $form);


        $form.submit(function(event) {
            event.preventDefault();
            $.popup();
            $.popup.showLoading();

            video.video.name = encodeURIComponent(($title.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            video.video.url = encodeURIComponent((video.video.url + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));

            if ($cover.attr('rel')) {
                video.video.previewid = $cover.attr('rel');
                $cover.removeAttr('rel');
            };
            video.video.preview = $cover.attr('src') == defaultCover ? null : $cover.attr('src');

            video.video.active = $isHidden.attr('checked') ? 0 : 1;
            video.video.date_start = $date.val();

            $.post(
                $form.attr('action'),
                'data=' + JSON.stringify(video),
                function(data) {
                    video = $.parseJSON(data);

                    if (video.error) {
                        $.alert({
                            content: video.status
                        });
                        return;
                    };

                    if (video.new) {
                        document.location.href= '/admin/video/' + video.new;
                    };

                    init();
                    $.popup.close();
                }
            );
        });


        function init() {
            $title.val('');
            $link.val('');

            if (video.video) {
                $title.val(video.video.name);
                $link.val(video.video.url);
                $date.val(video.video.date_start);

                if (video.video.dayinweek < 6) {
                    $dateVisible.removeClass('date-input-weekend');
                };

                $dateVisible.find('.day').html(video.video.dayinmonth);
                $dateVisible.find('.month').html(lang.months[video.video.month - 1][1]);
                $dateVisible.find('.year').html(video.video.year);

                if (video.video.previewid) {
                    $cover.attr('src', video.video.preview);
                    $removeCover.show();
                } else {
                    $cover.attr('src', defaultCover);
                    $removeCover.hide();
                };

                $isHidden.attr('checked', video.video.active == 1 ? false : true);
                $uploadWrap.remove();
            } else {
                video.video = {};
                video.video.deleted = {};

                var cT = new Date(),
                    cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
                    cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
                    cYear = cT.getFullYear(),
                    cDayOfWeek = cT.getDay();

                $date.val(cDay + '.' + cMonth + '.' + cYear);
                $dateVisible.find('.day').html(cDay);
                $dateVisible.find('.month').html(lang.months[cT.getMonth()][1]);
                $dateVisible.find('.year').html(cYear);

                if (cDayOfWeek < 5) {
                    $dateVisible.removeClass('date-input-weekend');
                };

                $cover.attr('src', defaultCover);
                $removeCover.hide();
                $removeVideo.hide();
            };
        };


        (function(){
            $('.youtube, .vimeo', $form).off().click(function() {
                if ($(this).hasClass('youtube')) {
                    var socialId = 227;
                } else {
                    var socialId = 232;
                };

                $.confirm({
                    'content': '<i class="label-video">' + langVideoLink + '</i><input class="input-video" type="text" />',
                    'ok': function() {
                        var videoUrl = encodeURIComponent(($('.input-video').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));

                        $.popup.hideWindow();
                        $.popup.showLoading();

                        $.post(
                            '/file/getsinglevideo/',
                            'url=' + videoUrl + '&socialid=' + socialId,
                            function(response) {
                                response = $.parseJSON(response);

                                if (response.error) {
                                    $.alert({
                                        content: response.status
                                    });
                                    return;

                                } else {
                                    $title.val(response.name);
                                    $date.val(response.date);
                                    $dateVisible.find('.day').html(response.date.split('.')[0]);
                                    $dateVisible.find('.month').html(lang.months[response.date.split('.')[1] - 1][1]);
                                    $dateVisible.find('.year').html(response.date.split('.')[2]);

                                    if (video.video.previewid) {
                                        if (!video.video.deleted) {
                                            video.video.deleted = {};
                                        };
                                        video.video.deleted.previewid = video.video.previewid;
                                        video.video.deleted.preview = video.video.preview;
                                        video.video.previewid = null
                                    };
                                    video.video.url =  videoUrl;
                                    video.video.preview = response.url;
                                    video.video.socialid = response.socialid;

                                    $cover.attr('src', response.url);
                                    $removeCover.show();
                                };

                                $uploadWrap.slideUp('fast', function() {
                                    $uploadWrap.remove();
                                });
                                $.popup.close();
                            }
                        );
                    }
                });
            });


            $removeVideo.click(function() {
                $.confirm({
                    text: lang.videoAdminVideoRemoveConfirm,
                    ok: function() {
                        video.video.delete = true;

                        $.post(
                            $form.attr('action'),
                            {data: JSON.stringify(video)},
                            function(data) {
                                video = $.parseJSON(data);

                                if (video.error) {
                                    $.alert({
                                        content: video.status
                                    });
                                    return;
                                };

                                if (video.reload) {
                                    document.location.href= '/video/';
                                };
                            }
                        );
                        $.popup.close();
                    }
                });
            });

            $editCover.coversLibrary({
                JSON: videoCovers,
                target: $cover
            });

            $removeCover.click(function() {
                if (video.video.previewid) {
                    if (!video.video.deleted) {
                        video.video.deleted = {};
                    };
                    video.video.deleted.previewid = video.video.previewid;
                    video.video.deleted.preview = video.video.preview;
                    video.video.previewid = null
                };
                video.video.preview =  null;
                $cover.attr('src', defaultCover);
                $removeCover.hide();
            });


            $uploadCover.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $uploadCover.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response);

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [220, 100],
                            ratio: 2.2,
                            size: 1,
                            complete: function(data) {
                                if (video.video.previewid) {
                                    if (!video.video.deleted) {
                                        video.video.deleted = {};
                                    };
                                    video.video.deleted.previewid = video.video.previewid;
                                    video.video.deleted.preview = video.video.preview;
                                    video.video.previewid = null
                                };
                                video.video.preview =  data.src;
                                $cover.attr('src', data.src);
                                $removeCover.show();
                                $.popup.close();
                            }
                        });
                    };
                }
            });


            init();
        }());
    });
};
})(jQuery);

window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

(function($){
$.fn.checkUploadLimit = function(){
    return this.each(function(o){
        var $el = $(this),
            $uploadifyObject = $('#'+$el.attr('id')+'Uploader'),
            $hdderror = $('#hdderror'),
            limitExceeded = $hdderror.length ? true : false;
        if(!$uploadifyObject.length){
            return;
        }
        if(limitExceeded === true){
            var $fakeUploadButton = $('<div class="fake-upload-button">').insertAfter($uploadifyObject),
                hddtotal = $hdderror.data('hddtotal'),
                hddlimit = $hdderror.data('hddlimit');

            $fakeUploadButton.css({
                'position': $uploadifyObject.css('position'),
                'height': '35px',
                'width': $uploadifyObject.attr('width') + 'px',
                'left': $uploadifyObject.css('left'),
                'top': $uploadifyObject.css('top'),
                'z-index': $uploadifyObject.css('z-index'),
                'cursor': 'pointer'
            });
            $uploadifyObject.hide();
            $fakeUploadButton.bind('click', function(){
                $.alert({
                    text: lang.uploadLimitExceeded + ': ' + hddtotal + ' ' + lang.uploadLimitFrom + ' ' + hddlimit + '',
                    ok: function() {
                        $.popup.close();
                    }
                });
            });
        }
    });
};
})(jQuery);

/* trackAdmin
----------------------------------------------- */
(function($){
$.fn.trackAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $uploadWrap = $('.upload-wrap', $form),
            $mp3Input = $('#track-admin-track', $form),
            $coverInput = $('#track-admin-cover', $form),
            $date = $('#music-admin-date', $form),
            $dateVisible = $('.date-input', $form).date(),
            $isTrackHidden = $('#track-admin-hide', $form),
            $trackCover = $('.cover-input .img img', $form),
            $trackName = $('#track-admin-title', $form),
            $removeTrack = $('.submit .remove-link', $form),
            $removeCover = $('.cover-input .remove-link', $form);

        (function() {
            $removeTrack.click(function() {
                $.confirm({
                    text: lang.trackAdminTrackRemoveConfirm,
                    ok: function() {
                        track.track.delete = true;

                        $.post(
                            $form.attr('action'),
                            {data: JSON.stringify(track)},
                            function(data) {
                                track = $.parseJSON(data);

                                if (track.error) {
                                    $.alert({
                                        content: track.status
                                    });
                                    return;
                                };

                                if (track.reload) {
                                    document.location.href= '/music/';
                                };
                            }
                        );
                        $.popup.close();
                    }
                });
            });

            $removeCover.click(function() {
                if (track.track.coverid) {
                    if (!track.track.deleted) {
                        track.track.deleted = {};
                    };
                    track.track.deleted.coverid = track.track.coverid;
                    track.track.deleted.cover = track.track.cover;
                    track.track.coverid = null
                };
                track.track.cover =  null;
                $trackCover.attr('src', defaultCover);
                $removeCover.hide();
            });

            $mp3Input.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.mp3',
                'fileDesc': '.mp3',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 180,
                'onSWFReady': function(){
                    $mp3Input.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response);

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        track.track.mp3 = response.src;
                        $uploadWrap.slideUp('fast', function() {
                            $uploadWrap.remove();
                        });
                    };
                }
            });

            $coverInput.uploadify({
                'multi': false,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $coverInput.checkUploadLimit();
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response)

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else {
                        $.image.crop({
                            url: '/file/crop/',
                            src: response.src,
                            min: [220, 220],
                            ratio: 1,
                            size: 4,
                            complete: function(data) {
                                if (track.track.coverid) {
                                    if (!track.track.deleted) {
                                        track.track.deleted = {};
                                    };
                                    track.track.deleted.coverid = track.track.coverid;
                                    track.track.deleted.cover = track.track.cover;
                                    track.track.coverid = null
                                };
                                track.track.cover =  data.src;
                                $trackCover.attr('src', data.src);
                                $removeCover.show();
                                $.popup.close();
                            }
                        });
                    };
                }
            });
        }());


        $form.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            track.track.name = encodeURIComponent(($trackName.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            track.track.active = $isTrackHidden.attr('checked') ? 0 : 1;
            track.track.date_start = $date.val();

            $.popup();
            $.popup.showLoading();

            $.post(
                $form.attr('action'),
                'data=' + JSON.stringify(track),
                function(data) {
                    track = $.parseJSON(data);

                    if (track.error) {
                        $.alert({
                            content: track.status
                        });
                        return;
                    };

                    if (track.new) {
                        document.location.href= '/admin/music/' + track.new;
                    };

                    init();
                    $.popup.close();
                }
            );
        });


        function init() {
            if (track.track) {
                if (track.track.coverid) {
                    $trackCover.attr('src', track.track.cover);
                    $removeCover.show();
                } else {
                    $trackCover.attr('src', defaultCover);
                    $removeCover.hide();
                };

                $trackName.val(track.track.name);
                $removeTrack.show();
                $uploadWrap.remove();

                track.track.active == 0 ? $isTrackHidden.attr('checked', true) : $isTrackHidden.attr('checked', false);

                $date.val(track.track.date_start);

                if (track.track.dayinweek < 6) {
                    $dateVisible.removeClass('date-input-weekend');
                };

                $dateVisible.find('.day').html(track.track.dayinmonth);
                $dateVisible.find('.month').html(lang.months[track.track.month - 1][1]);
                $dateVisible.find('.year').html(track.track.year);

            } else {
                track.track = {};
                $trackCover.attr('src', defaultCover);
                $trackName.val('');
                $removeTrack.hide();
                $removeCover.hide();


                var cT = new Date(),
                    cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
                    cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
                    cYear = cT.getFullYear(),
                    cDayOfWeek = cT.getDay();

                $date.val(cDay + '.' + cMonth + '.' + cYear);
                $dateVisible.find('.day').html(cDay);
                $dateVisible.find('.month').html(lang.months[cT.getMonth()][1]);
                $dateVisible.find('.year').html(cYear);

                if (cDayOfWeek < 5) {
                    $dateVisible.removeClass('date-input-weekend');
                };

                $('.soundcloud', $form).off().click(function() {
                    $.confirm({
                        'content': '<i class="label-soundcloud">' + langSoundcloudTrackProfileLink + '</i><input class="input-soundcloud" type="text" />',
                        'ok': function() {
                            var soundcloudUrl = encodeURIComponent(($('.input-soundcloud').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));

                            $.popup.hideWindow();
                            $.popup.showLoading();

                            $.post(
                                '/file/getstream/',
                                'url=' + soundcloudUrl + '&socialid=234' ,
                                function(response) {
                                    response = $.parseJSON(response);

                                    if (response.error) {
                                        $.alert({
                                            content: response.status
                                        });
                                        return;

                                    } else {
                                        $trackName.val(response.title);
                                        track.track.socialid = 234;
                                        track.track.stream = response.stream;

                                        if (response.cover) {
                                            track.track.cover =  response.cover;
                                            $trackCover.attr('src', response.cover);
                                            $removeCover.show();
                                        };
                                    };

                                    $uploadWrap.slideUp('fast', function() {
                                        $uploadWrap.remove();
                                    });
                                    $.popup.close();
                                }
                            );
                        }
                    });
                });

            };
        };

        init();
    });
};
})(jQuery);



/* basicAdmin
----------------------------------------------- */
(function($){
$.fn.basicAdmin = function(){
    return this.each(function(){
        var $root = $(this),
            $reccountTitle = $('#title-admin-title', $root),
            $reccountMetaTitle = $('#title-admin-meta-title', $root),
            $reccountMetaKeywords = $('#title-admin-meta-keywords', $root),
            $reccountMetaDescription = $('#title-admin-meta-description', $root),
            $reccountNameForm = $('.title-admin form', $root);

        $reccountNameForm.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountName.name = encodeURIComponent(($reccountTitle.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            reccountName.metatitle = encodeURIComponent(($reccountMetaTitle.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            reccountName.metakeywords = encodeURIComponent(($reccountMetaKeywords.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            reccountName.metadescription = encodeURIComponent(($reccountMetaDescription.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));

            $.post(
                $reccountNameForm.attr('action'),
                'data=' + JSON.stringify(reccountName),
                function(data) {
                    reccountName = $.parseJSON(data);

                    if (reccountName.errorid) {
                        $.alert({
                            content: reccountName.errormessage
                        });
                        return;
                    };

                    if (reccountName.status) {
                        $.alert({
                            content: reccountName.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
            return false;
        });

        function init() {
            if (reccountName.name) {
                $reccountTitle.val(reccountName.name.name);
                $reccountMetaTitle.val(reccountName.name.metatitle);
                $reccountMetaKeywords.val(reccountName.name.metakeywords);
                $reccountMetaDescription.val(reccountName.name.metadescription);
            };
        };

        init();
        
        (function(){
            var $form = $('.state-admin form', $form),
                $actionInput = $('input[name="action"]'),
                $button = $('.button');
            $form.form({
                reset: false,
                beforeSubmit: function(submitHandler){
                    $.confirm({
                        content: $actionInput.val() > 0 ? lang.basicAdminTurnOnConfirm : lang.basicAdminTurnOffConfirm,
                        ok: function(){
                            submitHandler();
                        }
                    });
                },
                complete: function(data){
                    if (data.state > 0) {
                        $actionInput.val(0);
                        $button.addClass('button-off').removeClass('button-on');
                    } else {
                        $actionInput.val(1);
                        $button.addClass('button-on').removeClass('button-off');
                    }
                }
            });
        })();
    });
};
})(jQuery);



/* linksAdmin
----------------------------------------------- */
(function($){
$.fn.linksAdmin = function(){
    return this.each(function(){
        var $root = $(this),
            $reccountLinksForm = $('form', $root),
            $reccountLinksList = $('.jlist', $root).jlist({max: 6});

        function addReccountSocialLink(id, socialid, url) {
            var $socialLink = $reccountLinksList.find('.placeholder').clone().removeClass('placeholder').insertBefore($reccountLinksList.find('.placeholder'));

            $socialLink.data('id', id);
            $socialLink.data('socialid', socialid);

            if (socialid == 227 || socialid == 232 || socialid == 234) {

                switch (socialid) {
                    case '227':
                        var buttonText = langCopyVideo;
                        break;
                    case '232':
                        var buttonText = langCopyVideo;
                        break;
                    case '234':
                        var buttonText = langCopyMusic;
                        break;
                };

                setSocialLinkSync($socialLink, socialid, buttonText);
            };

            $socialLink.find('.link-admin-link').val(url);
            $socialLink.find('.remove-link :first-child').click(function() {
                $socialLink.hide('fast').remove();
            });
        };


        function setSocialLinkSync($link, id, buttonText) {
            $link.find('.link-admin-link').addClass('with-button');

            $('<span>' + buttonText + '</span>').addClass('sync-' + id).insertAfter($link.find('.input-text')).click(function() {
                $.popup();
                $.popup.showLoading();

                $.post(
                    '/file/checksocialprofile/',
                    'url=' + $link.find('.link-admin-link').val() + '&socialid=' + id,
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
                                    'url=' + $link.find('.link-admin-link').val() + '&socialid=' + id + '&count=' + response.count,
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


        $reccountLinksForm.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountSocialLinks.social = [];

            $reccountLinksList.find('li:not(.placeholder)').each(function(i) {
                var $socialLink = $(this);

                reccountSocialLinks.social[i] = {};

                if ($socialLink.data('id') && !isNaN($socialLink.data('id'))) {
                    reccountSocialLinks.social[i].id = $socialLink.data('id')
                };
                reccountSocialLinks.social[i].url =  encodeURIComponent(($socialLink.find('.link-admin-link').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            });

            $.post(
                $reccountLinksForm.attr('action'),
                'data=' + JSON.stringify(reccountSocialLinks),
                function(data) {
                    reccountSocialLinks = $.parseJSON(data);

                    if (reccountSocialLinks.errorid) {
                        $.alert({
                            content: reccountSocialLinks.errormessage
                        });
                        return;
                    };

                    if (reccountSocialLinks.status) {
                        $.alert({
                            content: reccountSocialLinks.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
            return false;
        });

        function init() {
            $reccountLinksList.find('li:not(.placeholder)').remove();

            if (reccountSocialLinks.social) {
                $.each(reccountSocialLinks.social, function(i, item) {
                    addReccountSocialLink(item.id, item.socialid, item.url);
                });
            };
        };

        init();
    });
};
})(jQuery);



/* URLAdmin
----------------------------------------------- */
(function($){
$.fn.URLAdmin = function(){
    return this.each(function(){
        var $root = $(this),
            $reccountUrl = $('#url-admin-url', $root),
            $reccountUrlForm = $('.url-admin form');

        $reccountUrlForm.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            if (!reccountUrl.domainlist) {
                reccountUrl.domainlist = [];
                reccountUrl.domainlist[0] = {};
            };

            reccountUrl.domainlist[0].url = encodeURIComponent(($reccountUrl.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));

            $.post(
                $reccountUrlForm.attr('action'),
                'data=' + JSON.stringify(reccountUrl),
                function(data) {
                    reccountUrl = $.parseJSON(data);

                    if (reccountUrl.errorid) {
                        $.alert({
                            content: reccountUrl.errormessage
                        });
                        return;
                    };

                    if (reccountUrl.status) {
                        $.alert({
                            content: reccountUrl.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
            return false;
        });

        function init() {
            if (reccountUrl.domainlist) {
                $reccountUrl.val(reccountUrl.domainlist[0].url);
            };
        };

        init();
    });
};
})(jQuery);


//serialize form data into JSON:
(function($){
$.fn.serializeJSON = function() {
    var json = {};
    jQuery.map($(this).serializeArray(), function(n, i){
        json[n['name']] = n['value'];
    });
    return json;
};
})(jQuery);



(function($){
$.fn.uploadWidget = function(){
    return this.each(function(){
        var $el = $(this),
                $attach = $el.find('.button-attach'),
                $label = $el.find('.filename'),
                $labelHtml = $label.html(),
                $inputClone = $el.find('.file-input').clone(),
                $remove = $el.find('.remove'),
                $form = $el.closest('form'),
                $fileurl = $form.find('input[name=fileurl]').eq(0),
                $filename = $form.find('input[name=filename]').eq(0),
                $deletefile = $('<input>').attr({
                    type: 'hidden',
                    name: 'deletefile',
                    value: $fileurl.val()
                }),
                hasFile = false,
                hasDeleteFile = false;


        function getNiceName(pathname){
            var maxlen = 35,
                    valArray = pathname.split('\\'),
                filename = valArray[valArray.length-1];
            if(filename.length >= maxlen+3) filename = filename.substr(0,maxlen-13)+'...'+filename.substr(filename.length-10, 10);
            return filename;
        }
        if($fileurl.length && $fileurl.val() !== '' && $filename.length && $filename.val() !== ''){
            $label.html('<a href="' + $fileurl.val() + '" target="_blank">' + getNiceName($filename.val()) + '</a>' + '<a class="ir remove" href="#"></a>');
            hasFile = true;
        }
        $el.on('change', '.file-input', function(){
            $label.html(getNiceName($(this).val()) + '<a class="ir remove" href="#"></a>');
            if(hasFile === true && hasDeleteFile !== true){
                $deletefile.appendTo($el);
                hasDeleteFile = false;
            }
        });
        $el.on('click', '.button-attach', function(e){
            e.preventDefault();
            $el.find('.file-input').click();
        });
        $el.on('click', '.remove', function(e){
            e.preventDefault();
            $el.find('.file-input').replaceWith($inputClone.clone());
            $label.html($labelHtml);
            if(hasFile === true && hasDeleteFile !== true){
                $deletefile.appendTo($el);
                hasDeleteFile = true;
            }
        });
    });
}
})(jQuery);

/* recardAdmin
----------------------------------------------- */
(function($){
$.fn.recardAdmin = function(){
    return this.each(function(){
        var $root = $(this);

        getRecardAfterShow = function(){
            var $el = $('.popup-new-card').eq(0),
                $form = $el.find('form').eq(0);

            if($form.hasClass('disabled')){
                $form.find('input, textarea, select').prop('disabled', true);
            }

/*            $('#file').change(function() {
                $('#file').each(function() {
                    var name = this.value;
                    reWin = /.*\\(.*)/;
                    var fileTitle = name.replace(reWin, "$1");
                    reUnix = /.*\/(.*)/;
                    fileTitle = fileTitle.replace(reUnix, "$1");
                    $('.filename').html(fileTitle);
                });
            });
*/
            $el.find('.upload.widget').uploadWidget();
            $('.date-input').date();


            $form.submit(function(e){
                e.preventDefault();
                $form.ajaxSubmit({
                    dataType: 'json',
                    success: function(response, status, xhr, $form){
                        $.popup.close();
                        window.location.reload();
                    }
                });
                return false;
            });
        }

        $('.create-card').popup({
            href: '/admin/getrecard/',
            afterShowWindow: getRecardAfterShow
        });
        
        $root.find('a.edit-recard').popup({
            beforeShowLoading: function(el, o){
                if($(el).closest('.item').hasClass('unread')){
                    o.data = {status: 2};
                }
            },
            afterShowWindow: getRecardAfterShow,
            beforeClose: function(el){
                $(el).closest('.item').removeClass('unread');
                updateNotificationsCounter();
            }
        });

    });
};
})(jQuery);


/* requestsAdmin
----------------------------------------------- */
(function($){
$.fn.requestsAdmin = function(){
    return this.each(function(){
        var $root = $(this),
            $items = $root.find('.item');

        $root.find('.c.confirm a').bind('click', function(e){
            e.preventDefault();
            var $a = $(this),
                $item = $a.closest('.item'),
                action = $a.hasClass('confirm') ? 1 : 2,
                requestid = $item.data('id'),
                requesttype = $item.data('type');

            $.confirm({
                text: lang.confirm,
                ok: function(){
                    $.popup.close();
                    $.ajax({
                        type: 'GET',
                        url: '/admin/updaterequest/',
                        data: {
                            action: action,
                            requestid: requestid,
                            requesttype: requesttype
                        },
                        success: function(response){
                            var data = $.parseJSON(response);
                            if(!data || !data.url){
                                window.location.reload();
                            } else {
                                $.confirm({
                                    text: data.status,
                                    ok: function(){
                                        location.replace(data.url); 
                                    },
                                    cancel: function(){
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }                
            });
        });

        $root.find('a.request-type').popup({
            beforeShowLoading: function(el, o){
                if($(el).closest('.item').hasClass('unread')){
                    o.data = {status: 2};
                }
            },
            beforeClose: function(el){
                $(el).closest('.item').removeClass('unread');
                updateNotificationsCounter();
            }
        });

        $root.find('a.report').popup({
            afterShowWindow: function(){
                $('.popup-window .upload.widget').uploadWidget();
                var $form = $('.popup-window form');
                $form.submit(function(e){
                    e.preventDefault();
                    $form.ajaxSubmit({
                        dataType: 'json',
                        success: function(response, status, xhr, $form){
                            $.popup.close();
                            window.location.reload();
                        }
                    });
                    return false;
                });
            }
        });
        
        $(document).on('submit', '.popup-report-inner form', function(e){
            e.preventDefault();
            var $form = $(this);
            $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serializeJSON(),
                success: function(){
                    window.location.reload();
                }
            });
        });


    });
};
})(jQuery);




/* menuAdmin
----------------------------------------------- */
(function($){
$.fn.menuAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $reccountMenuItemsForm = $('form', $root),
            $reccountMenuItemsList = $('.jlist', $root).sortable({/*
                cancel: "li:first-child",
                stop:function(event, ui) {
                    //nothing to do for #f0 as you can't sort anything above it
                    var f5 = $("#f5");
                    var indf5 = $("#sortable li").index(f5);
                    //if f5 not in right position -> swap position
                    if(indf5 !== 5) {
                        if(indf5 > 5) {
                            f5.prev().insertAfter(f5); //move it up by one position
                        } else {
                            f5.next().insertBefore(f5); //move it down by one position
                        }
                    }
                }*/
            });

        $reccountMenuItemsList.find('.input-text input').bind('click.sortable mousedown.sortable',function(ev){

            ev.target.focus();

        });




        function addReccountMenuItem(id, itemid, name, menutypename, active, showbanner, homewidget, allwidget, code) {
            var $menuItem = $reccountMenuItemsList.find('.hidden').clone().removeClass('hidden').insertBefore($reccountMenuItemsList.find('.hidden'));

            $menuItem.data('id', id);
            $menuItem.data('itemid', itemid);
            $menuItem.find('.menu-admin-events-title').val(name);
            $menuItem.find('.menu-admin-menutype-name').html(menutypename);

            if (active == 0) {
                $menuItem.find('.menu-admin-events-hide').attr('checked', true);
            };

            if (showbanner == 1) {
                $menuItem.find('.menu-admin-events-banner').attr('checked', true);
            };

            if (homewidget == 1) {
                $menuItem.find('.menu-admin-events-home').attr('checked', true);
            };

            if (allwidget == 1) {
                $menuItem.find('.menu-admin-events-all').attr('checked', true);
            };

            if (code == "main") {
                $menuItem.find('.handle').remove();
                $menuItem.find('.hide-input').remove();
                $menuItem.find('.all-input').remove();
                $menuItem.find('.home-input').remove();
            };
        };


        $reccountMenuItemsForm.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountMenu.menu = [];

            $reccountMenuItemsList.find('li:not(.hidden)').each(function(i) {
                var $menuItem = $(this);

                reccountMenu.menu[i] = {};
                reccountMenu.menu[i].id = $menuItem.data('id');
                reccountMenu.menu[i].itemid = $menuItem.data('itemid');
                reccountMenu.menu[i].name = encodeURIComponent(($menuItem.find('.menu-admin-events-title').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
                reccountMenu.menu[i].active =  $menuItem.find('.menu-admin-events-hide').attr('checked') ? 0 : 1;
                reccountMenu.menu[i].showbanner =  $menuItem.find('.menu-admin-events-banner').attr('checked') ? 1 : 0;
                reccountMenu.menu[i].homewidget =  $menuItem.find('.menu-admin-events-home').attr('checked') ? 1 : 0;
                reccountMenu.menu[i].allwidget =  $menuItem.find('.menu-admin-events-all').attr('checked') ? 1 :0;
            });

            $.post(
                $reccountMenuItemsForm.attr('action'),
                'data=' + JSON.stringify(reccountMenu),
                function(data) {
                    reccountMenu = $.parseJSON(data);

                    if (reccountMenu.errorid) {
                        $.alert({
                            content: reccountMenu.errormessage
                        });
                        return;
                    };

                    if (reccountMenu.status) {
                        $.alert({
                            content: reccountMenu.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
            return false;
        });


        function init() {
            $reccountMenuItemsList.find('li:not(.hidden):not(.mainpage)').remove();

            if (reccountMenu.menu) {
                $.each(reccountMenu.menu, function(i, item) {
                    addReccountMenuItem(item.id, item.itemid, item.name, item.menutypename, item.active, item.showbanner, item.homewidget, item.allwidget, item.code);
                });
            };
        };

        init();


        /*(function(){
            var $inputs = $('input:checkbox', $root),
                $recommendedInputs = $inputs.filter('.recommended'),
                $notRecommendedInputs = $inputs.not('.recommended'),
                $recommendedLink = $('.recommended-link span', $root);
            $recommendedLink.on('click', set);
            $inputs.on('click', update);
            function set() {
                $recommendedInputs.prop('checked', true);
                $notRecommendedInputs.prop('checked', false);
                $recommendedLink.fadeOut(o.speed);
            }
            function update() {
                if ($notRecommendedInputs.filter(':checked').length || $recommendedInputs.filter(':checked').length < $recommendedInputs.length) {
                    $recommendedLink.fadeIn(o.speed);
                } else {
                    $recommendedLink.fadeOut(o.speed);
                }
            }
        })();*/
    });
};
})(jQuery);



/* galleryAdmin
----------------------------------------------- */
(function($){
$.fn.galleryAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function() {
        var $root = $(this),
            $form = $('form', $root),
            $galleryName = $('#video-admin-title', $form),
            $dateInput = $('.date-input .date-input-visible', $form),
            $hiddenDateInput = $('#video-admin-date', $form),
            $isHidden = $('#gallery-admin-hide', $form),
            $imageInput = $('#gallery-admin-image', $form),
            $photosList = $('.list', $form).sortable(),
            $removeGallery = $('.submit .remove-link', $form),
            filesToUploadCounter = 0,
            $saveButton = $('.submit .button').hide();


        $form.submit(function(event) {
            event.preventDefault();

            gallery.gallerytype.name = encodeURIComponent(($galleryName.val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, ''));
            gallery.gallerytype.date_start = $hiddenDateInput.val();
            gallery.gallerytype.active = $isHidden.attr('checked') ? 0 : 1;
            gallery.gallery = [];

            $photosList.find('.li:visible').each(function(i) {
                var $photo = $(this),
                    photo = {};

                photo.id = $photo.data('id') ? $photo.data('id') : null;
                photo.bigurl = $photo.data('bigurl') ? $photo.data('bigurl') : null;
                photo.url = $photo.find('img').attr('src');

                gallery.gallery.push(photo);
            });

            gallery.gallery.reverse();

            $.popup.showOverlay();
            $.popup.showLoading();

            $.post(
                $form.attr('action'),
                'data=' + JSON.stringify(gallery),
                function(data) {
                    gallery = $.parseJSON(data);

                    if (gallery.error) {
                        $.alert({
                            content: gallery.status
                        });
                        return;
                    };

                    if (gallery.new) {
                        document.location.href= '/admin/gallery/' + gallery.new;
                    };

                    init();
                    $.popup.close();
                }
            );
        });


        function addPhoto(id, bigurl, url) {
            var $photo = $photosList.find('.hidden').clone().removeClass('hidden').insertAfter($photosList.find('.hidden'));

            if (id) ($photo.data('id', id));
            if (bigurl) ($photo.data('bigurl', bigurl));
            $photo.find('img').attr('src', url);

            $photo.find('.remove-link').click(function() {
                var deletedPhoto = {};
                deletedPhoto.id = $photo.data('id') ? $photo.data('id') : null;
                deletedPhoto.bigurl = $photo.data('bigurl');
                deletedPhoto.url = $photo.find('img').attr('src');

                gallery.deleted.push(deletedPhoto);
                $photo.remove();
            });
        };


        function init() {
            $galleryName.val('');
            $photosList.find('.li:not(.hidden)').remove();

            if (gallery.gallerytype) {
                $galleryName.val(gallery.gallerytype.name);
                $dateInput.html(gallery.gallerytype.date_start);
                $hiddenDateInput.val(gallery.gallerytype.date_start);

                $isHidden.attr('checked', gallery.gallerytype.active == 0 ? true : false);

                if (gallery.gallery) {
                    $saveButton.show();
                    $.each(gallery.gallery, function(i, item) {
                        addPhoto(item.id, item.bigurl, item.url);
                    });
                } else {
                    gallery.gallery = [];
                };

                $removeGallery.show();

            } else {
                $saveButton.hide();
                gallery.gallerytype = {};
                gallery.gallery = [];

                var cT = new Date(),
                    cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
                    cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
                    cYear = cT.getFullYear();

                $dateInput.html(cDay + '.' + cMonth + '.' + cYear);
                $hiddenDateInput.val(cDay + '.' + cMonth + '.' + cYear);

                $removeGallery.hide();
            };

            gallery.deleted = [];
        };

        (function() {
            $imageInput.uploadify({
                'multi': true,
                'uploader': '/uploadify/uploadify.swf',
                'script': '/file/uploadimage/',
                'folder': '/uploads/temp',
                'auto': true,
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
                'fileDesc': 'Images',
                'wmode': 'transparent',
                'hideButton': true,
                'width': 350,
                'onSWFReady': function(){
                    $imageInput.checkUploadLimit();
                },
                'onSelectOnce' : function(event,data) {
                     filesToUploadCounter = data.fileCount;

                    if (filesToUploadCounter > 1) {
                        $imageInput.uploadifySettings('script', '/file/uploadmimage/');
                    } else {
                        $imageInput.uploadifySettings('script', '/file/uploadimage/');
                    };
                },
                'onComplete': function(event, queueID, fileObj, response, data) {
                    response = $.parseJSON(response);

                    $saveButton.show();

                    if (response.error) {
                        $.alert({text: response.status});
                        return;

                    } else if (filesToUploadCounter > 1) {
                        addPhoto(null, response.bigurl, response.url);

                    } else {
                        $.image.crop({
                            url: '/file/gallerycrop/',
                            src: response.src,
                            min: [220, 100],
                            ratio: 2.2,
                            size: 1,
                            complete: function(data) {
                                addPhoto(null, data.bigurl, data.url);
                                $.popup.close();
                            }
                        });
                    };
                }
            });

            $removeGallery.click(function() {
                $.confirm({
                    text: lang.galleryAdminGalleryRemoveConfirm,
                    ok: function() {
                        gallery.gallerytype.delete = true;

                        $.post(
                            $form.attr('action'),
                            {data: JSON.stringify(gallery)},
                            function(data) {
                                gallery = $.parseJSON(data);

                                if (gallery.error) {
                                    $.alert({
                                        content: gallery.status
                                    });
                                    return;
                                };

                                if (gallery.reload) {
                                    document.location.href= '/gallery/';
                                };
                            }
                        );
                        $.popup.close();
                    }
                });
            });


            $hiddenDateInput.datepicker({
                duration: 100,
                prevText: '',
                nextText: '',
                onSelect: function(dateText, inst) {
                    $dateInput.html($hiddenDateInput.val());
                }
            });

            $dateInput.on('click', function() {
                $hiddenDateInput.datepicker('show');
            });

            init();
        }());
    });
};
})(jQuery);



/* avatarAdmin
----------------------------------------------- */
(function($){
$.fn.avatarAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $avatarsList = $('.avatars', $root),
            $fileInput = $('#avatar-admin-image', $root),
            deletedAvatarsCounter = 0;


        $fileInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadimage/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc': 'Images',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 365,
            'onSWFReady': function(){
                $fileInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response)

                if (response.error) {
                    $.alert({text: response.status});
                    return;

                } else {
                    $.image.crop({
                        url: '/file/crop/',
                        src: response.src,
                        min: [100, 100],
                        ratio: 1,
                        size: 2,
                        complete: function(data){
                            var croppedAvatar = data;

                            reccountAvatars.cover = [];
                            reccountAvatars.cover[0] = {};
                            reccountAvatars.cover[0].url = croppedAvatar.src;

                            $.post(
                                $form.attr('action'),
                                {data: JSON.stringify(reccountAvatars)},
                                function(data) {
                                    reccountAvatars = $.parseJSON(data);

                                    if (reccountAvatars.errorid) {
                                        $.alert({
                                            content: reccountAvatars.errormessage
                                        });
                                        return;
                                    };

                                    if (reccountAvatars.status) {
                                        $.alert({
                                            content: reccountAvatars.status
                                        });
                                    } else {
                                        $.popup.close();
                                    };

                                    init();
                                }
                            );
                        }
                    });
                };
            }
        });


        function addAvatar(id, major, url) {
            var $avatar = $avatarsList.find('.hidden').clone().removeClass('hidden').insertBefore($avatarsList.find('.hidden'));

            $avatar.data('id', id);
            $avatar.find('img').attr('src', url).click(function() {
                $avatarsList.find('.major').removeClass('major');
                $avatar.addClass('major');
            });

            if (major == 1) {
                $avatar.addClass('major')
            };

            $avatar.find('.remove-link').click(function() {
                if (id) {
                    if (!reccountAvatars.deleted) {
                        reccountAvatars.deleted = [];
                    };
                    reccountAvatars.deleted[deletedAvatarsCounter] = {};
                    reccountAvatars.deleted[deletedAvatarsCounter].id = id;
                    reccountAvatars.deleted[deletedAvatarsCounter].major = major;
                    reccountAvatars.deleted[deletedAvatarsCounter].url = url;
                    deletedAvatarsCounter++;
                };

                $avatar.fadeOut('fast', function() {
                    $avatar.remove();
                });
            });
        };


        $form.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountAvatars.cover = [];

            $avatarsList.find('.li:not(.hidden)').each(function(i) {
                var $avatar = $(this);

                reccountAvatars.cover[i] = {};
                reccountAvatars.cover[i].id = $avatar.data('id');
                reccountAvatars.cover[i].major = $avatar.hasClass('major') ? 1 : 0;
                reccountAvatars.cover[i].url = $avatar.find('img').attr('src');
            });

            $.post(
                $form.attr('action'),
                {data: JSON.stringify(reccountAvatars)},
                function(data) {
                    reccountAvatars = $.parseJSON(data);

                    if (reccountAvatars.errorid) {
                        $.alert({
                            content: reccountAvatars.errormessage
                        });
                        return;
                    };

                    if (reccountAvatars.status) {
                        $.alert({
                            content: reccountAvatars.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
        });


        function init() {
            $avatarsList.find('.li:not(.hidden)').remove();

            if (reccountAvatars.cover) {
                $.each(reccountAvatars.cover, function(i, item) {
                    addAvatar(item.id, item.major, item.url);
                });
            };
        };

        init();
    });
};
})(jQuery);



/* posterAdmin
----------------------------------------------- */
(function($){
$.fn.posterAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $postersList = $('.posters', $root),
            $fileInput = $('#poster-admin-image', $root),
            deletedPostersCounter = 0;


        $fileInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadimage/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc': 'Images',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 350,
            'onSWFReady': function(){
                $fileInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response)

                if (response.error) {
                    $.alert({text: response.status});
                    return;

                } else {
                    $.image.crop({
                        url: '/file/crop/',
                        src: response.src,
                        min: [100, 140],
                        ratio: 0.71,
                        size: 10,
                        complete: function(data){
                            var croppedPoster = data;

                            reccountPosters.poster = [];
                            reccountPosters.poster[0] = {};
                            reccountPosters.poster[0].url = croppedPoster.src;

                            $.post(
                                $form.attr('action'),
                                {data: JSON.stringify(reccountPosters)},
                                function(data) {
                                    reccountPosters = $.parseJSON(data);

                                    if (reccountPosters.errorid) {
                                        $.alert({
                                            content: reccountPosters.errormessage
                                        });
                                        return;
                                    };

                                    if (reccountPosters.status) {
                                        $.alert({
                                            content: reccountPosters.status
                                        });
                                    } else {
                                        $.popup.close();
                                    };

                                    init();
                                }
                            );
                        }
                    });
                };
            }
        });


        function addPoster(id, major, url) {
            var $poster = $postersList.find('.hidden').clone().removeClass('hidden').insertBefore($postersList.find('.hidden'));

            $poster.data('id', id);
            $poster.find('img').attr('src', url).click(function() {
                $postersList.find('.major').removeClass('major');
                $poster.addClass('major');
            });

            if (major == 1) {
                $poster.addClass('major')
            };

            $poster.find('.remove-link').click(function() {
                if (id) {
                    if (!reccountPosters.deleted) {
                        reccountPosters.deleted = [];
                    };
                    reccountPosters.deleted[deletedPostersCounter] = {};
                    reccountPosters.deleted[deletedPostersCounter].id = id;
                    reccountPosters.deleted[deletedPostersCounter].major = major;
                    reccountPosters.deleted[deletedPostersCounter].url = url;
                    deletedPostersCounter++;
                };

                $poster.fadeOut('fast', function() {
                    $poster.remove();
                });
            });
        };


        $form.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountPosters.poster = [];

            $postersList.find('.li:not(.hidden)').each(function(i) {
                var $poster = $(this);

                reccountPosters.poster[i] = {};
                reccountPosters.poster[i].id = $poster.data('id');
                reccountPosters.poster[i].major = $poster.hasClass('major') ? 1 : 0;
                reccountPosters.poster[i].url = $poster.find('img').attr('src');
            });

            $.post(
                $form.attr('action'),
                {data: JSON.stringify(reccountPosters)},
                function(data) {
                    reccountPosters = $.parseJSON(data);

                    if (reccountPosters.errorid) {
                        $.alert({
                            content: reccountPosters.errormessage
                        });
                        return;
                    };

                    if (reccountPosters.status) {
                        $.alert({
                            content: reccountPosters.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
        });


        function init() {
            $postersList.find('.li:not(.hidden)').remove();

            if (reccountPosters.poster) {
                $.each(reccountPosters.poster, function(i, item) {
                    addPoster(item.id, item.major, item.url);
                });
            };
        };

        init();
    });
};
})(jQuery);



/* previewAdmin
----------------------------------------------- */
(function($){
$.fn.previewAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function() {
        var $root = $(this),
            $form = $('form', $root),
            $previewsList = $('.previews', $root),
            $fileInput = $('#preview-admin-image', $root),
            deletedPreviewsCounter = 0;


        $fileInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadimage/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc': 'Images',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 350,
            'onSWFReady': function(){
                $fileInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response)

                if (response.error) {
                    $.alert({text: response.status});
                    return;

                } else {
                    $.image.crop({
                        url: '/file/crop/',
                        src: response.src,
                        min: [220, 100],
                        ratio: 2.2,
                        size: 1,
                        complete: function(data){
                            var croppedPreview = data;

                            reccountVideoPreviews.videopreview = [];
                            reccountVideoPreviews.videopreview[0] = {};
                            reccountVideoPreviews.videopreview[0].url = croppedPreview.src;

                            $.post(
                                $form.attr('action'),
                                {data: JSON.stringify(reccountVideoPreviews)},
                                function(data) {
                                    reccountVideoPreviews = $.parseJSON(data);

                                    if (reccountVideoPreviews.errorid) {
                                        $.alert({
                                            content: reccountVideoPreviews.errormessage
                                        });
                                        return;
                                    };

                                    if (reccountVideoPreviews.status) {
                                        $.alert({
                                            content: reccountVideoPreviews.status
                                        });
                                    } else {
                                        $.popup.close();
                                    };

                                    init();
                                }
                            );
                        }
                    });
                };
            }
        });


        function addPreview(id, major, url) {
            var $preview = $previewsList.find('.hidden').clone().removeClass('hidden').insertBefore($previewsList.find('.hidden'));

            $preview.data('id', id);
            $preview.find('img').attr('src', url).click(function() {
                $previewsList.find('.major').removeClass('major');
                $preview.addClass('major');
            });

            if (major == 1) {
                $preview.addClass('major')
            };

            $preview.find('.remove-link').click(function() {
                if (id) {
                    if (!reccountVideoPreviews.deleted) {
                        reccountVideoPreviews.deleted = [];
                    };
                    reccountVideoPreviews.deleted[deletedPreviewsCounter] = {};
                    reccountVideoPreviews.deleted[deletedPreviewsCounter].id = id;
                    reccountVideoPreviews.deleted[deletedPreviewsCounter].major = major;
                    reccountVideoPreviews.deleted[deletedPreviewsCounter].url = url;
                    deletedPreviewsCounter++;
                };

                $preview.fadeOut('fast', function() {
                    $preview.remove();
                });
            });
        };


        $form.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountVideoPreviews.videopreview = [];

            $previewsList.find('.li:not(.hidden)').each(function(i) {
                var $preview = $(this);

                reccountVideoPreviews.videopreview[i] = {};
                reccountVideoPreviews.videopreview[i].id = $preview.data('id');
                reccountVideoPreviews.videopreview[i].major = $preview.hasClass('major') ? 1 : 0;
                reccountVideoPreviews.videopreview[i].url = $preview.find('img').attr('src');
            });

            $.post(
                $form.attr('action'),
                {data: JSON.stringify(reccountVideoPreviews)},
                function(data) {
                    reccountVideoPreviews = $.parseJSON(data);

                    if (reccountVideoPreviews.errorid) {
                        $.alert({
                            content: reccountVideoPreviews.errormessage
                        });
                        return;
                    };

                    if (reccountVideoPreviews.status) {
                        $.alert({
                            content: reccountVideoPreviews.status
                        });
                    } else {
                        $.popup.close();
                    };

                    init();
                }
            );
        });


        function init() {
            $previewsList.find('.li:not(.hidden)').remove();

            if (reccountVideoPreviews.videopreview) {
                $.each(reccountVideoPreviews.videopreview, function(i, item) {
                    addPreview(item.id, item.major, item.url);
                });
            };
        };

        init();
    });
};
})(jQuery);



/* colorAdmin
----------------------------------------------- */
(function($){
$.fn.colorAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $reccountColorForm = $('form', $root);

        $('.picker', $root).ColorPicker({
            flat: true,
            color: reccountColor.color ? reccountColor.color : 'FF0000'
        });

        $reccountColorForm.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountColor.color = $('.colorpicker_hex input', $root).val();

            $.post(
                $reccountColorForm.attr('action'),
                {data: JSON.stringify(reccountColor)},
                function(data) {
                    reccountColor = $.parseJSON(data);

                    if (reccountColor.errorid) {
                        $.alert({
                            content: reccountColor.errormessage
                        });
                        return;
                    };

                    if (reccountColor.status) {
                        $.alert({
                            content: reccountColor.status
                        });
                    } else {
                        $.popup.close();
                    };

                    $('.picker', $root).ColorPickerSetColor(reccountColor.color);
                }
            );

            return false;
        });
    });
};
})(jQuery);



/* designAdmin
----------------------------------------------- */
(function($){
$.fn.designAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function() {
        var $root = $(this),
            $form = $('form', $root),
            $patternInput = $('#design-admin-pattern', $root),
            $bgInput = $('#design-admin-background', $root),
            $bannerInput = $('#design-admin-header', $root),
            $faviconInput = $('#design-admin-favicon', $root),
            $marginInput = $('#design-admin-margin', $root),
            $mock = $('.mock', $root);


        $patternInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadimage/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc': '.jpg, .jpeg, .gif, .png',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 305,
            'onSWFReady': function(){
                $patternInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response);
                if (response.error) {
                    $.alert({text: response.status});
                    return;
                } else {
                    if (reccountDesignOptions.pattern) {
                        if (!reccountDesignOptions.deleted) {
                            reccountDesignOptions.deleted = {};
                        };
                        reccountDesignOptions.deleted.pattern = reccountDesignOptions.pattern;
                    };
                    reccountDesignOptions.pattern = {};
                    reccountDesignOptions.pattern.id = null;
                    reccountDesignOptions.pattern.url = response.src;
                    toggleDeleteButton('pattern', 'pattern');
                };
            }
        });


        $bgInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadimage/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc': '.jpg, .jpeg, .gif, .png',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 375,
            'onSWFReady': function(){
                $bgInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response);
                if (response.error) {
                    $.alert({text: response.status});
                    return;
                } else {
                    if (reccountDesignOptions.bg) {
                        if (!reccountDesignOptions.deleted) {
                            reccountDesignOptions.deleted = {};
                        };
                        reccountDesignOptions.deleted.bg = reccountDesignOptions.bg;

                    };
                    reccountDesignOptions.bg = {};
                    reccountDesignOptions.bg.id = null;
                    reccountDesignOptions.bg.url = response.src;
                    toggleDeleteButton('bg', 'background');
                };
            }
        });


        $bannerInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadfile/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.swf',
            'fileDesc': 'swf',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 405,
            'onSWFReady': function(){
                $bannerInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response);
                if (response.error) {
                    $.alert({text: response.status});
                    return;
                } else {
                    if (reccountDesignOptions.banner) {
                        if (!reccountDesignOptions.deleted) {
                            reccountDesignOptions.deleted = {};
                        };
                        reccountDesignOptions.deleted.banner = reccountDesignOptions.banner;
                    };
                    reccountDesignOptions.banner = {};
                    reccountDesignOptions.banner.id = null;
                    reccountDesignOptions.banner.url = response.src;
                    toggleDeleteButton('banner', 'header');
                };
            }
        });


        $faviconInput.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadfavicon/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc': 'Images',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 330,
            'onSWFReady': function(){
                $faviconInput.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                response = $.parseJSON(response);
                if (response.error) {
                    $.alert({text: response.status});
                    return;
                } else {
                    if (reccountDesignOptions.favicon) {
                        if (!reccountDesignOptions.deleted) {
                            reccountDesignOptions.deleted = {};
                        };
                        reccountDesignOptions.deleted.favicon = reccountDesignOptions.favicon;
                    };
                    reccountDesignOptions.favicon = {};
                    reccountDesignOptions.favicon.id = null;
                    reccountDesignOptions.favicon.url = response.src;
                    toggleDeleteButton('favicon', 'favicon');
                };
            }
        });

        $form.submit(function(e) {
            e.preventDefault();
            $.popup();
            $.popup.showLoading();

            reccountDesignOptions.margin = parseInt($marginInput.val());

            $.post(
                $form.attr('action'),
                {data: JSON.stringify(reccountDesignOptions)},
                function(data) {
                    reccountDesignOptions = $.parseJSON(data);
                    if (reccountDesignOptions.error) {
                        $.alert({content: reccountDesignOptions.status});
                        return;
                    } else {
                        init();
                        $.popup.close();
                    };
                }
            );
        });


        function toggleDeleteButton(jsonName, buttonParentClassName) {
            var $button = $('.' + buttonParentClassName + '-field').find('.remove-link').show().click(function() {
                $button.hide();
                if (!reccountDesignOptions.deleted) {
                    reccountDesignOptions.deleted = {};
                };
                reccountDesignOptions.deleted[jsonName] = $.extend({}, reccountDesignOptions[jsonName]);
                //reccountDesignOptions[jsonName] = null;
            });
        };


        function init() {
            $('.field', $root).each(function(){
                var $row = $(this),
                    name = $('input:file, input:text', $row).attr('name'),
                    $block = $('.i-' + name, $mock);
                $row.hoverToggle({el: $block});
            });

            reccountDesignOptions.pattern ? toggleDeleteButton('pattern', 'pattern') : 0;
            reccountDesignOptions.bg ? toggleDeleteButton('bg', 'background') : 0;
            reccountDesignOptions.banner ? toggleDeleteButton('banner', 'header') : 0;
            reccountDesignOptions.favicon ? toggleDeleteButton('favicon', 'favicon') : 0;
            $marginInput.val(reccountDesignOptions.margin ? reccountDesignOptions.margin : '0');
        };

        init();
    });
};
})(jQuery);




/* anketaAdmin
----------------------------------------------- */
(function($){
$.fn.anketaAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function() {
        var $root = $(this),
            $form = $('form', $root),
            brandIdName = 'brandid',
            $brands = $('.brands', $form),
            $brandsList = $('.jlist', $brands).jlist({
                sortable: false,
                disableStored: true,
                itemAfterInit: function(){
                    var $item = this;
                    $item.find('input').autocomplete({
                        source: '/ajax/findbrand/',
                        position: {
                            offset: '0 5'
                        },
                        select: function(event, ui){
                            var $input = $(event.target),
                                inputName = $input.attr('name'),
                                id = ui.item.id;
                            if(inputName.indexOf('[') !== -1){
                                var idInputName = brandIdName + inputName.substr(inputName.indexOf('['));
                                if($brandsList.find('input[name="'+idInputName+'"]').length){
                                    $brandsList.find('input[name="'+idInputName+'"]').val(id);
                                } else {
                                    $brandsList.append($('<input type="hidden" name="'+idInputName+'" value="'+id+'">'));
                                }
                            }
                            
                        }
                    });
                },
                itemAfterRemove: function(){
                    var inputName = this + '';
                    if(inputName.indexOf('[') !== -1){
                        var idInputName = brandIdName + inputName.substr(inputName.indexOf('['));
                        $brandsList.find('input[name="'+idInputName+'"]').remove();
                    }
                }
            });
        
        $form.submit(function(){
            $brands.find('input[disabled]').prop('disabled', false);
            return true;
        });

        function init() {

        };

        init();
    });
};
})(jQuery);


/* designAdmin
----------------------------------------------- */
(function($){
$.fn.logoAdmin = function(o){
    o = $.extend({
        speed: 100
    }, o || {});
    return this.each(function() {
        var $root = $(this),
            $form = $('form', $root),
            $logoUploader = $('#logo-admin-image', $root),
            $logo = $('.cover img', $root),
            $deleteLogo = $('.cover .remove-link', $root),
            $deleteLogoArchive = $('.image-field .remove-link', $root),
            isImage;


        $logoUploader.uploadify({
            'multi': false,
            'uploader': '/uploadify/uploadify.swf',
            'script': '/file/uploadimage/',
            'folder': '/uploads/temp',
            'auto': true,
            'fileDesc': 'Image or archive',
            'wmode': 'transparent',
            'hideButton': true,
            'width': 305,
            'onSWFReady': function(){
                $logoUploader.checkUploadLimit();
            },
            'onComplete': function(event, queueID, fileObj, response, data) {
                console.log(response)
                response = $.parseJSON(response);
                if (response.error) {
                    $.alert({text: response.status});

                } else {
                    $deleteLogo.hide();
                    $deleteLogoArchive.hide();

                    if (checkIsImage(response.extension)) {
                        $logo.show().attr('src', response.src);
                        $deleteLogo.show();

                    } else {
                        $deleteLogoArchive.show();
                    };

                    if (!reccountLogo.clublogo) {
                        reccountLogo.clublogo = {};
                    } else {
                        reccountLogo.deleted = reccountLogo.clublogo.url;
                    };

                    reccountLogo.clublogo.url = response.src;
                };
            }
        });


        $form.submit(function(e) {
            e.preventDefault();

            $.popup();
            $.popup.showLoading();

            $.post(
                $form.attr('action'),
                {data: JSON.stringify(reccountLogo)},
                function(data) {
                    reccountLogo = $.parseJSON(data);
                    if (reccountLogo.error) {
                        $.alert({
                            content: reccountLogo.status
                        });
                        return;
                    } else {
                        init();
                    };

                    $.popup.close();
                }
            );
        });


        function checkIsImage(extension) {
            switch (extension) {
                case 'jpg':
                    isImage = true;
                    break;
                case 'gif':
                    isImage = true;
                    break;
                case 'png':
                    isImage = true;
                    break;
                case 'zip':
                    isImage = false;
                    break;
                case 'rar':
                    isImage = false;
                    break;
            };

            return isImage;
        };


        $deleteLogo.click(function() {
            reccountLogo.clublogo.url = null;
            reccountLogo.deleted = $logo.attr('src');
            $logo.hide();
            $deleteLogo.hide();
        });


        $deleteLogoArchive.click(function() {
            reccountLogo.clublogo.url = null;
            reccountLogo.deleted = reccountLogo.clublogo.url;
            $deleteLogoArchive.hide();
        });


        function init() {
            if (reccountLogo.clublogo) {
                if (checkIsImage(reccountLogo.clublogo.extension)) {
                    $logo.show().attr('src', reccountLogo.clublogo.url);
                    $deleteLogo.show();
                    $deleteLogoArchive.hide();

                } else {
                    $deleteLogoArchive.show();
                    $deleteLogo.hide();
                }
            } else {
                $deleteLogo.hide();
                $deleteLogoArchive.hide();
            };
        };

        init();
    });
};
})(jQuery);



/* UTILS
----------------------------------------------- */
/* upload
----------------------------------------------- */
(function($){
$.fn.upload = function(o){
    o = $.extend({
        url: '',
        data: {},
        complete: function(){
            $.popup.close();
        }
    }, o || {});
    return this.each(function(){
        var $form = $(this),
            url = o.url || this.action,
            $fileInputs = $('input[type="file"]');
        $form.ajaxSubmit({
            url: url,
            data: o.data,
            dataType: 'json',
            beforeSerialize: function() {
                $fileInputs.not('[name="' + o.data.name + '"]').val('');
            },
            beforeSubmit: function(){
                $.popup();
                $.popup.showLoading();
            },
            success: function(data){
                $.popup.hideLoading();
                $fileInputs.filter('[name="' + o.data.name + '"]').val('');
                $form.trigger('afterReset');
                if (data.error) {
                    $.alert({text: data.status});
                    return;
                }
                o.complete(data);
            }
        });
    });
};
})(jQuery);



/* image
----------------------------------------------- */
(function($){
$.fn.image = function(o){
    return this.each(function(){
        $.image(this, o);
    });
};
$.image = function(root, o){
    o = $.extend({
        speed: 100,
        removeConfirm: lang.confirm
    }, o || {});
    var $root = $(root),
        $form = $root.closest('form'),

        $fileInput = $('input[type="file"]', $root),
        name = $fileInput.attr('name'),
        defaultClass = name + '-input-default',

        uploadURL = $('input[name="' + name + '_upload"]', $root).val(),
        cropURL = $('input[name="' + name + '_crop"]', $root).val(),
        selectURL = $('input[name="' + name + '_select"]', $root).val(),

        size = $('input[name="' + name + '_size"]', $root).val(),
        min = $('input[name="' + name + '_min"]', $root).val().split(','),
        ratio = min[0] / min[1],

        $IDInput = $('input[name="' + name + '_id"]', $root),
        $currentIDInput = $('input[name="' + name + '_current_id"]', $root),

        defaultSRC = $('input[name="' + name + '_default"]', $root).val(),
        $newSRCInput = $('input[name="' + name + '_new"]', $root),

        $img = $('.img img', $root),
        $selectLink = $('.select-link', $root),
        $uploadLink = $('.upload-link', $root),
        $removeLink = $('.remove-link', $root),
        $controls = $selectLink.add($uploadLink).add($removeLink);

    $root.hoverToggle({el: $controls});
    $selectLink.on('click', select);
    $fileInput.on('change', upload);
    $removeLink.on('click', remove);

    function select() {
        $.popup();
        $.popup.showLoading();
        $.getJSON(selectURL, function(data) {
            var $content = $(data.content),
                $IDInputs = $('input[name="id"]', $content),
                $SRCInputs = $('input[name="src"]', $content);
            $content.imageSelect();
            $.popup.hideLoading();
            $.confirm({
                content: $content,
                ok: function(){
                    $img.attr('src', $SRCInputs.fieldValue()[0]);
                    $root.removeClass(defaultClass);
                    $IDInput.val($IDInputs.fieldValue()[0]);
                    $newSRCInput.val('');
                    $.popup.close();
                }
            });
        });
    }

    function upload() {
        $form.upload({
            url: uploadURL,
            data: {name: name, min: min},
            complete: function(data){
                $.image.crop({
                    url: cropURL,
                    src: data.src,
                    min: min,
                    ratio: ratio,
                    data: {size: size},
                    complete: function(data){
                        $img.attr('src', data.src);
                        $root.removeClass(defaultClass);
                        $IDInput.val('');
                        $newSRCInput.val(data.src);
                        $.popup.close();
                    }
                });
            }
        });
    }

    function remove() {
        $.confirm({
            text: o.removeConfirm,
            ok: function(){
                $img.attr('src', defaultSRC);
                $root.addClass(defaultClass);
                $IDInput.val('');
                $newSRCInput.val('');
                $.popup.close();
            }
        });
    }
};
$.image.crop = function(o){
    o = $.extend({
        url: '',
        src: '',
        min: [0, 0],
        ratio: 0,
        size: 0,
        data: {},
        complete: function(){
            $.popup.close();
        }
    }, o || {});
    var img = new Image();
    img.onload = function(){
        var zoom = 1,
            min = o.min,
            imgWidth = img.width,
            imgHeight = img.height,
            maxImgWidth = document.documentElement.clientWidth - 200,
            maxImgHeight = document.documentElement.clientHeight - 255;
        if (imgWidth > maxImgWidth || imgHeight > maxImgHeight) {
            if (maxImgWidth / imgWidth < maxImgHeight / imgHeight) {
                zoom = maxImgWidth / imgWidth;
            } else {
                zoom = maxImgHeight / imgHeight;
            }
            min[0] = Math.floor(min[0] * zoom);
            min[1] = Math.floor(min[1] * zoom);
            imgWidth = Math.floor(img.width * zoom);
            imgHeight = Math.floor(img.height * zoom);
        }
        img.width = imgWidth;
        img.height = imgHeight;
        var $img = $(img),
            x = 0,
            y = 0,
            x2 = imgWidth,
            y2 = imgHeight;
        if (o.ratio) {
            var width = imgWidth,
                height = imgHeight;
            if (height * o.ratio > width) {
                height = Math.floor(width / o.ratio);
                y = Math.floor(imgHeight / 2 - height / 2);
                y2 = y + height;
            } else {
                width = Math.floor(height * o.ratio);
                x = Math.floor(imgWidth / 2 - width / 2);
                x2 = x + width;
            }
        }
        var area = [x, y, x2 - x, y2 - y];
        $img.Jcrop({
            aspectRatio: o.ratio,
            minSize: min,
            setSelect: [x, y, x2, y2],
            onSelect: function(c) {
                area = {
                    x: c.x,
                    y: c.y,
                    width: c.w,
                    height: c.h
                }
            }
        }, function() {
            area = {
                x: 0,
                y: 0,
                width: img.width,
                height: img.height
            };
        });
        $.confirm({
            content: $img,
            ok: function(){
                $.popup.hideWindow();
                $.popup.showLoading();

                for (i in area) {
                    area[i] = Math.floor(area[i] / zoom);
                };

                var data = {
                    src: o.src,
                    size: o.size,
                    x: area.x,
                    y: area.y,
                    width: area.width,
                    height: area.height
                };

                $.post(o.url, 'data=' + JSON.stringify(data), function(data) {
                    if (data.error) {
                        $.alert({text: data.status});
                        return;
                    }
                    o.complete(data);
                }, 'json');

            }
        });
    };
    img.src = o.src;
};
})(jQuery);



/* imageSelect
----------------------------------------------- */
$.fn.imageSelect = function(){
    var $root = $(this),
        $items = $('.li', $root),
        $SRCInputs = $('input[name="src"]', $root),
        currentIndex = $items.index($items.filter('.act'));
    $('input[name="id"]', $root).each(function(index){
        $(this).on('click', function(){
            select(index);
        });
    });
    function select(index) {
        if (index == currentIndex) {
            return;
        }
        $items.removeClass('act').eq(index).addClass('act');
        if ($SRCInputs.length) {
            $SRCInputs[index].checked = true;
        }
        currentIndex = index;
    }
};



/* jlist
----------------------------------------------- */
(function($){
$.fn.jlist = function(o){
    o = $.extend({
        speed: 100,
        max: 0,
        fields: true,
        sortable: true,
        selects: false,
        ikselect: false
    }, o || {});
    return this.each(function(){
        var $list = $(this),
            $items = $list.children().filter('li');
        if(o.sortable){
            $list.sortable({stack: $items, handle: '.handle'});
        }
        if (!o.fields) {
            return;
        }
        var indexOffset = $((o.selects?'select':'input[type="text"]'), $items).eq(0).attr('name').indexOf('[') + 1;
        $items.each(function(){
            init($(this));
        });
        function init($item) {
            var $textInputs = $((o.selects?'select':'input[type="text"]'), $item),
                $removeLink = $('.remove-link span', $item);
            $item.on('focusin', function(){
                $item.removeClass('placeholder');
            }).on('focusout', function(){
                var value = '';
                $textInputs.each(function(){
                    value += this.value.trim();
                });
                if (!value || o.selects && value == 0) {
                    $item.addClass('placeholder').appendTo($list);
                } else if(o.disableStored){
                    $item.addClass('disabled').find('input[type="text"]').prop('disabled', true);
                }

            });
            $textInputs.on('keyup paste change', function(){
                var value = '';
                $textInputs.each(function(){
                    value += this.value.trim();
                });
                if (!o.selects && value !== '' || o.selects && value !== '0') {
                    add();
                } else {
                    remove();
                }
            });
            $removeLink.on('click', function(){
                remove($item);
            });
            if(typeof o.itemAfterInit == 'function'){
                o.itemAfterInit.call($item);
            }
        }
        function add() {
            if ((o.max && $items.length >= o.max) || $items.filter('.placeholder').length) {
                return;
            }
            var $last = $items.last();
            if(o.ikselect && $last.find('select').data('plugin_ikSelect')){
                $last.find('select').ikSelectNano('detach');
            }
            var $item = $last.clone(),
                index = getLastIndex() + 1;
            if(o.ikselect){
                $last.find('select').removeData('plugin_ikSelect').removeClass('ik_select_opened').ikSelectNano();
            }            
            $item.addClass('placeholder');
            if(o.selects){
                var $lastSelect = $last.find('select'),
                    lastVal = $lastSelect.val(),
                    $itemSelect = $item.find('select');
                
                if(o.ikselect){
                    $lastSelect.ikSelectNano('disable').blur();
                    //debugger;
                    $itemSelect.removeClass('ik_select_opened').ikSelectNano();
                } else {
                    $lastSelect.prop('disabled', true).blur();    
                }
                if(lastVal > 0){
                    if(o.ikselect){
                        $itemSelect.ikSelect('disable_options', [''+lastVal]);
                    } else {
                        $item.find('option[value='+lastVal+']').prop('disabled', true);
                    }
                    
                }
                $itemSelect.selectedIndex = 0;
            } else {
                $('input[type="text"]', $item).val('');
            }
            $((o.selects?'select':'input[type="text"]'), $item).each(function(){
                var $input = $(this),
                    name = $input.attr('name');
                name = name.substring(0, name.indexOf('[') + 1) + index + ']';                
                $input.attr('name', name);
                //console.log(name);
            });
            $list.append($item.hide().fadeIn(o.speed, function(){ if(o.selects){ $itemSelect.ikSelectNano('redraw'); } }));

            $items = $list.children().filter('li');
            init($item);
        }
        function remove($item) {
            if (!$item) {
                var $item = $items.filter('.placeholder');
            } else {
                var itemVal = $item.val(),
                    itemInputName = $item.find('input').attr('name'); 
            }
            if ($items.length > 1 && ((o.max && $items.length < o.max) || $items.filter('.placeholder').length)) {
                $item.fadeOut(o.speed, function(){
                    $item.remove();
                    $items = $list.children().filter('li');
                    if(o.selects && itemVal){
                        $items.find('option[value='+itemVal+']').prop('disabled', false);
                    }
                });
            } else {
                $item.addClass('placeholder');
                if(o.selects){
                    $('select', $item).selectedIndex = 0;
                } else {
                    $('.input-text input', $item).val('');
                }
            }
            if(typeof o.itemAfterRemove == 'function'){
                o.itemAfterRemove.call(itemInputName);
            }
        }
        function getLastIndex() {
            var lastIndex = 0;
            $((o.selects?'select:eq(0)':'input[type="text"]:eq(0)'), $items).each(function(){
                var index = parseInt(this.name.substr(indexOffset)) || 0;
                if (index > lastIndex) {
                    lastIndex = index;
                }
            });
            return lastIndex;
        }
    });
};
})(jQuery);



/* date
----------------------------------------------- */
(function($){
$.fn.date = function(o){
    o = $.extend({
        speed: 100,
        weekendClass: 'date-input-weekend'
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $day = $('.day', $root),
            $month = $('.month', $root),
            $year = $('.year', $root),
            $weekday = $('.weekday', $root),
            $dateInput = $('input', $root),
            $form = $root.closest('form');

        if($form.hasClass('disabled')){
            return;
        }

        $dateInput.datepicker({
            duration: 100,
            prevText: '',
            nextText: '',
            onSelect: function(dateText, inst) {
                var weekdayIndex = $dateInput.datepicker('getDate').getUTCDay(),
                    isWeekend = weekdayIndex > 3 && weekdayIndex < 6;
                $day.html(inst.currentDay);
                $month.html(lang.months[inst.currentMonth][1]);
                $year.html(inst.currentYear);
                $weekday.html(lang.weekdays[weekdayIndex]);
                $root.toggleClass(o.weekendClass, isWeekend);
            }
        });
        $root.on('click', function(){
            $dateInput.datepicker('show');
        });
    });
};
})(jQuery);



/* hoverToggle
----------------------------------------------- */
(function($){
$.fn.hoverToggle = function(o){
    o = $.extend({
        speed: 100,
        display: 'block'
    }, o || {});

    var $el = $(o.el),
        hidden = true;

    $el.css({'opacity': 0, 'display': o.display});

    return this.each(function(){
        $(this).hover(show, hide);

        function show() {
            if (hidden) {
                $el.css({'opacity': 0, 'display': o.display});
            }
            hidden = false;
            $el.stop(true).animate({'opacity': 1}, {queue: false, duration: o.speed});
        }

        function hide() {
            $el.stop(true).animate({'opacity': 0}, {queue: false, duration: o.speed, complete: function(){
                $el.hide();
                hidden = true;
            }});
        }
    });
};
})(jQuery);


function updateNotificationsCounter(){
    var $newCounter = $('.layout-top .user-links .notifications-link .new'),
        $recardCounter = $('.layout-top .user-links .recard .new'),
        $newText = $newCounter.find('.text'),
        $recardText = $recardCounter.find('.text');
    $.ajax({
        url: '/ajax/getunreadnotices',
        dataType: 'json',
        success: function(data){
            if(!data) return;
            var newCount = parseInt(data.notice),
                recardCount = parseInt(data.recard);
            if(newCount > 0){
                $newCounter.css('display', 'inline-block');
                $newText.text('+'+newCount);
            } else {
                $newCounter.css('display', 'none');
            }
            if(recardCount > 0){
                $recardCounter.css('display', 'inline-block');
                $recardText.text('+'+recardCount);
            } else {
                $recardCounter.css('display', 'none');
            }
        }
    });
}


(function($){
$.fn.trackBannerDisplay = function(){
    return this.each(function(){
        $(this).find('.jflow-li.brand').one('showBanner', function(){
            var $el = $(this),
                id = $el.attr('rel'),
                token = $el.data('token');
            if(id && token){
                $.ajax({
                    type: 'get',
                    url: '/ajax/bannerdisplay/',
                    data: {
                        id: id,
                        token: token
                    }
                });
            }
        }).find('a').bind('click', function(){
            var $el = $(this).closest('.jflow-li'),
                id = $el.attr('rel'),
                token = $el.data('token');
            if(id && token){
                $.ajax({
                    type: 'get',
                    url: '/ajax/bannerclick/',
                    data: {
                        id: id,
                        token: token
                    }
                });
            }
        });
    });
};
})(jQuery);

window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};


/* DOM Ready
----------------------------------------------- */
$(function(){
    // High
    if (typeof playerData != 'undefined') {
        $('.layout-content').addClass('layout-content-player');
        $('.player').player({
            repeat: false,
            autoLoad: false,
            autoPlay: playerData.autoPlay,
            playlist: playerData.playlist,
            height: 64
        });
    }
    $('label.placeholder').placeholder();
    $('.select select').jselect();
    updateNotificationsCounter();

    // Low
    $('.input-file').inputFile();
    $('.news-feed').newsFeed();
    $('.user-form-register').registration();
    $('.user-form-edit').registrationInfoEdit();
    $('.auth form').authForm({link: '.auth-popup-link', src: '#auth-popup-src'});
    $('.widget').widget();
    $('.widget-share, .post-share').share();
    $('.teasers').trackBannerDisplay().jflow();
    $('.events').events();
    $('.galleries').galleries();
    $('.videos').videos();
    $('.tracks').tracks();
    $('.place').place();
    $('.contacts').contacts();
    $('.comments').comments();
    $('.post-rate').rate();
    $('a.help-link, .help-link a').popup();
    $('.gallery .li a').fancybox({
        margin: 105,
        padding: 0,
        speedIn: 100,
        speedOut: 100,
        changeSpeed: 100,
        changeFade: 100,
        overlayColor: '#000',
        overlayOpacity: .7,
        centerOnScroll: true
    });

    $('.basic-admin').basicAdmin();
    $('.menu-admin').menuAdmin();
    $('.links-admin').linksAdmin();
    $('.url-admin').URLAdmin();
    $('.requests-admin').requestsAdmin();
    $('.recard-admin').recardAdmin();
    $('.anketa-admin').anketaAdmin();

    //galleryAdmin was here
    $('.avatar-admin').avatarAdmin();
    $('.poster-admin').posterAdmin();
    $('.preview-admin').previewAdmin();
    $('.color-admin').colorAdmin();
    $('.design-admin').designAdmin();
    $('.logo-admin').logoAdmin();

    $('.user-profile-edit').userProfile();
    $('.club-card-edit').clubCardEdit();
    $('.clubcards').clubCards();

    //$('.teasers-admin').teasersAdmin();
    $('.contacts-admin').contactsAdmin();
    //eventAdmin plugin was here
    $('.video-admin').videoAdmin();
    $('.track-admin').trackAdmin();

    if ($('.tooltip-inside').length) {
        $('.tooltip-inside').tooltip({
            'opacity': 1,
            'animation_distance': 10,
            'arrow_height': 6,
            'arrow_left_offset': 46
        });
    };

    if ($('.big-tooltip-inside').length) {
        $('.big-tooltip-inside').tooltip({
            'opacity': 1,
            'animation_distance': 10,
            'arrow_height': 6,
            'arrow_left_offset': 81
        });
    };
});
