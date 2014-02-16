/* CONSTANTS
----------------------------------------------- */
var metaTags = document.getElementsByTagName('meta'),
    BASE = '';

for (var i = 0; i < metaTags.length; i++) {
    switch (metaTags[i].name) {
        case 'base':
            BASE = metaTags[i].content;
            break;
    }
}

Cufon.replace('.teaser .title', {fontFamily: 'Helios', color: '-linear-gradient(#fff, #999)', textShadow: '0 2px #000'});

ZeroClipboard.setMoviePath(BASE + 'swf/clipboard.swf');

soundManager.url = BASE + 'swf/';
soundManager.debugMode = false;
soundManager.flashVersion = 9;

var $tokenInput = $();
$(function(){
    $tokenInput = $('#token');
});



/* MISC
----------------------------------------------- */
/* jflow
----------------------------------------------- */
(function($){
$.fn.jflow = function(o){
    o = $.extend({
        speed: 'normal',
        easing: 'easeOutExpo',
        interval: 10000
    }, o);
    return this.each(function(){
        var $content = $('.jflow', this),
            $pager = $('.jflow-pager', this);
        if (!$content.length || !$pager.length) {
            return;
        }
        var $list = $('.jflow-list', $content),
            $items = $('.jflow-li', $content),
            $pages,
            contentWidth = $content.width(),
            scrollWidth = $content[0].scrollWidth,
            gap = parseInt($items.css('padding-left')),
            pagesTotal = Math.ceil((scrollWidth - gap) / contentWidth),
            t,
            currentIndex = 0,
            busy = false;
        if (scrollWidth - gap <= contentWidth) {
            return;
        }
        init();
        function next() {
            go(currentIndex + 1);
        }
        function delayNext() {
            t = setTimeout(next, o.interval);
        }
        function go(index) {
            if (busy || index == currentIndex) {
                return;
            }
            busy = true;
            clearTimeout(t);
            if (index < 0) {
                index = pagesTotal - 1;
            } else if (index >= pagesTotal) {
                index = 0;
            }
            $pages.removeClass('jflow-pi-act').eq(index).addClass('jflow-pi-act');
            var left = index * (contentWidth + gap);
            if (left > scrollWidth - contentWidth) {
                left = scrollWidth - contentWidth;
            }
            $content.animate({
                scrollLeft: left
            }, {
                queue: false,
                easing: o.easing,
                duration: o.speed,
                complete: function(){
                    currentIndex = index;
                    busy = false;
                    delayNext();
                }
            });
        }
        function init() {
            $content.css('overflow', 'hidden');
            var pagesHTML = '';
            for (i = 0; i < pagesTotal; i++) {
                pagesHTML += '<div class="jflow-pi"></div>';
            }
            $pages = $(pagesHTML);
            $pages.click(function(){
                go($pages.index(this));
            }).eq(currentIndex).addClass('jflow-pi-act');
            $pager.html($('<div class="jflow-pl-wrap" />').html($('<div class="jflow-pl" />').html($pages))).fadeIn(o.speed);
            delayNext();
        }
    });
};
})(jQuery);

/* jswap
----------------------------------------------- */
(function($){
$.fn.jswap = function(o){
    o = $.extend({
        speed: 'normal',
        easing: 'easeOutExpo',
        interval: 5000
    }, o);
    return this.each(function(){
        var $content = $('.jswap', this),
            $pager = $('.jswap-pager', this);
        if (!$content.length || !$pager.length) {
            return;
        }
        var $items = $('.jswap-li', $content),
            $pages,
            t,
            currentIndex = 0,
            busy = false;
        if ($items.length < 2) {
            return;
        }
        init();
        function next() {
            go(currentIndex + 1);
        }
        function delayNext() {
            t = setTimeout(next, o.interval);
        }
        function go(index) {
            if (busy || index == currentIndex) {
                return;
            }
            busy = true;
            clearTimeout(t);
            if (index >= $items.length) {
                index = 0;
            }
            $pages.removeClass('jswap-pi-act').eq(index).addClass('jswap-pi-act');
            $items.eq(currentIndex).css('z-index', 2).fadeOut(o.speed);
            $items.eq(index).css('z-index', 1).addClass('jswap-li-act').fadeIn(o.speed);
            $items.promise().done(function(){
                $items.eq(currentIndex).removeClass('jswap-li-act');
                currentIndex = index;
                busy = false;
                delayNext();
            });
        }
        function init() {
            var pagesHTML = '';
            for (i = 0; i < $items.length; i++) {
                pagesHTML += '<div class="jswap-pi"></div>';
            }
            $pages = $(pagesHTML);
            $pages.click(function(){
                go($pages.index(this));
            }).eq(currentIndex).addClass('jswap-pi-act');
            $pager.html($('<div class="jswap-pl-wrap" />').html($('<div class="jswap-pl" />').html($pages))).fadeIn(o.speed);
            $content.click(next);
            delayNext();
        }
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
    }, o);
    return this.each(function(){
        var $items = $('li', this),
            currentIndex = 0;
        setTimeout(function(){
            next();
        }, o.interval);
        function next() {
            show(currentIndex + 1);
        }
        function show(index) {
            if (index >= $items.length) {
                index = 0;
            }
            $items.eq(currentIndex).fadeOut(o.speed, function(){
                $items.eq(index).fadeIn(o.speed, function(){
                    currentIndex = index;
                    setTimeout(function(){
                        next();
                    }, o.interval);
                });
            });
        }
    });
};
})(jQuery);

/* teasers
----------------------------------------------- */
(function($){
$.fn.teasers = function(o){
    o = $.extend({
        speed: 100
    }, o);
    var $h1 = $('h1');
    return this.each(function(){
        var $root = $(this),
            $teasers = $('.teaser', $root),
            $titles = $('.title', $teasers),
            $items = $('.teaser-content', $root),
            changeH1 = $root.is('.teasers-h1'),
            currentID = $items.filter('.teaser-content-act').attr('id').substr(12);
        $teasers.each(function(index){
            var $teaser = $(this),
                $item = $items.eq(index);
            $teaser.data('$content', $item);
            $item.data('$teaser', $teaser);
        });
        $.address.bind('change', function(){
            if (location.hash.indexOf('#content') == 0) {
                var id = parseInt(location.hash.substr(8));
                show(id);
            }
        });
        function show(id) {
            if (!id || id == currentID || id < 1 || !$teasers.filter('#content-teaser' + id).length) {
                return;
            }
            $teasers.removeClass('teaser-act').filter('#content-teaser' + id).addClass('teaser-act');
            $root.height($root.height());
            $items.removeClass('teaser-content-act').filter('#content-item' + id).hide().addClass('teaser-content-act').fadeIn(o.speed);
            $root.height('');
            if (changeH1) {
                $h1.html($titles.filter('#content-title' + id).text());
            }
            currentID = id;
        }
    });
};
})(jQuery);

/* userURL
----------------------------------------------- */
(function($){
$.fn.userURL = function(buttonID, wrapID){
    return this.each(function(){
        var text = $('.input-text .input', this).text(),
            clipboard = new ZeroClipboard.Client();

        clipboard.setText(text);
        clipboard.glue(buttonID, wrapID);
    });
};
})(jQuery);

/* notifications
----------------------------------------------- */
(function($){
$.fn.notifications = function(){
    var $link = $('.user-links .link-notifications'),
        $total = $('.total', $link);
    return this.each(function(){
        var url = $('input[name="url"]', this).val();
        $('tr', this).each(function(){
            var $item = $(this),
                id = $('input[name="id"]', $item).val(),
                busy = false;
            $item.click(function(){
                toggle();
            });
            function toggle() {
                if (busy) {
                    return;
                }
                busy = true;
                $item.toggleClass('new');
                $.post(url, {token: $tokenInput.val()}, function(data){
                    $tokenInput.val(data.token);
                    if (data.error) {
                        $.alert({content: data.status});
                    } else {
                        if (data.total > 0) {
                            $link.addClass('link-notifications-new');
                            $total.html('(' + data.total + ')');
                        } else {
                            $link.removeClass('link-notifications-new');
                            $total.html('');
                        }
                    }
                    busy = false;
                }, 'json');
            }
        });
    });
};
})(jQuery);



/* POST
----------------------------------------------- */
/* photos
----------------------------------------------- */
(function($){
$.fn.photos = function(){
    return this.each(function(){
        var $root = $(this),
            $link = $('.link a', $root);
        $root.jswap();
        $link.popup({extraClass: 'popup-video'});
    });
};
})(jQuery);

/* quotes
----------------------------------------------- */
(function($){
var $body;

$(function(){
    $body = $('html, body');
});

$.fn.quotes = function(o){
    o = $.extend({
        speed: 'normal',
        easing: 'easeOutExpo',
        interval: 10000
    }, o);

    return this.each(function(){
        var $items = $('.quotes-ci', this),
            currentIndex = 0;

        $('.quotes-text a', this).click(function(e){
            e.preventDefault();
            var hash = $.urlParams(this.href).hash;
            $body.animate({scrollTop: $(hash).offset().top}, {queue: false, easing: o.easing, duration: o.speed});
        });

        if ($items.length < 2) {
            return;
        }
        
        setInterval(function(){
            go(currentIndex + 1);
        }, o.interval);
        
        function go(index) {
            if (index >= $items.length) {
                index = 0;
            }
            
            $items.css('z-index', 2).fadeOut(o.speed).eq(index).css('z-index', 1).fadeIn(o.speed);
            $items.promise().done(function(){
                currentIndex = index;
            });
        }
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
            $likeLink = $('.like-link:not(.auth-popup-link)', $root),
            $dislikeLink = $('.dislike-link:not(.auth-popup-link)', $root),
            url = $('input[name="url"]', $root).val(),
            totalRate = $('input[name="total_rate"]', $root).val(),
            currentRate = $('input[name="current_rate"]', $root).val(),
            itemID = $('input[name="itemid"]', $root).val(),
            busy = false;

        $likeLink.on('click', '.i', function(){
            like();
        });
    
        $dislikeLink.on('click', '.i', function(){
            dislike();
        });

        function like() {
            var rate = currentRate <= 0 ? 1 : 0;
            setRate(rate);
        }
    
        function dislike() {
            var rate = currentRate >= 0 ? -1 : 0;
            setRate(rate);
        }
    
        function setRate(rate) {
            if (busy) {
                return;
            }
            
            busy = true;
    
            $likeLink.toggleClass('act', rate > 0);
            $dislikeLink.toggleClass('act', rate < 0);
    
            $.post(url, {id: itemID, rate: rate, total_rate: totalRate, current_rate: currentRate, token: $tokenInput.val()}, function(data) {
                $tokenInput.val(data.token);
                var total = '(' + (data.total_rate > 0 ? '+' : '') + data.total_rate + ')';
                $total.html(total);
                totalRate = data.total_rate;
                currentRate = rate;
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
        speed: 150,
        easing: 'easeOutExpo'
    }, o);

    return this.each(function(){
        var $root = $(this),
            $links = $('.links', $root),
            url = $('input[name="url"]', $root).val(),
            itemID = $('input[name="itemid"]', $root).val(),
            visible = false,
            busy = false;
        
        $('.title', this).click(function(e){
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

            $.post(url, {id: itemID, service: service, token: $tokenInput.val()}, function(data){
                $tokenInput.val(data.token);
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
        $loading = $('.loading', $root),
        rootOffsetTop = $root.offset().top,
        commentsURL = $('input[name="comments_url"]', $tree).val(),
        $type,
        $typeAllLink,
        $typeProLink,
        $tree,
        $replyLinks,
        removeURL,
        quoteURL,
        unquoteURL,
        $add,
        $addLink,
        $formBox,
        $form,
        validator,
        itemID,
        $parentIDInput,
        $messageInput,
        busy = false;

    resize();
    $win.on('resize.comments scroll.comments', function(){
        resize();
    });

    function resize() {
        var scrollTop = window.scrollY || document.documentElement.scrollTop,
            clientHeight = document.documentElement.clientHeight;
        if (scrollTop + clientHeight >= rootOffsetTop) {
            $win.off('.comments');
            $loading.show();
            $.getJSON(commentsURL, {token: $tokenInput.val()}, function(data) {
                $tokenInput.val(data.token);
                $root.html($(data.content).hide().fadeIn(o.speed));
                init();
            });
        }
    }

    function init() {
        $type = $('.comments-type', $root);
        $typeAllLink = $('.all-link', $type);
        $typeProLink = $('.pro-link', $type);
        $tree = $('.comments-tree', $root);
        $replyLinks = $('.reply-link', $tree);
        removeURL = $('input[name="remove_url"]', $tree).val();
        quoteURL = $('input[name="quote_url"]', $tree).val();
        unquoteURL = $('input[name="unquote_url"]', $tree).val();
        $add = $('.comments-add', $root);
        $addLink = $('.add-link', $add);
        $formBox = $('.comments-form', $add);
        $form = $('form', $formBox);
        itemID = $('input[name="itemid"]', $form).val();
        $parentIDInput = $('input[name="parent_id"]', $form);
        $messageInput = $('textarea[name="message"]', $form);

// Misc
        $('.post-share', $root).share();
        $('.post-rate', $root).rate();
        $('a.help-link, .help-link a', $root).popup();
        $('label.placeholder', $form).placeholder();
        $('.auth-popup form').authForm({link: '.comments .auth-popup-link', src: '#auth-popup-src'});

// Comment Type
        $root.on('click', '.comments-type:not(.comments-type-disabled) .all-link', function(){
            showAllComments();
        });
        $root.on('click', '.comments-type:not(.comments-type-disabled) .pro-link', function(){
            showProComments();
        });
    
// Expand
        $tree.on('click', '.expand-link .i', function(){
            expand(this);
        });
        $tree.on('click', '.remove-link .i', function(){
            var el = this;
            $.confirm({
                content: o.removeConfirm,
                yes: function(){
                    removeComment(el);
                }
            });        
        });
    
// Comment Actions
        $tree.on('click', '.quote-link:not(.quote-link-act) .i', function(){
            quoteComment(this);
        });
        $tree.on('click', '.quote-link-act .i', function(){
            unquoteComment(this);
        });
        $tree.on('click', '.reply-link span', function(){
            showReplyForm(this);
        });
    
// Add Comment
        $add.on('click', '.add-link span', function(){
            showAddForm();
        });
    
// Message Form
        validator = $form.validate({
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
                    data: {token: $tokenInput.val()},
                    dataType: 'json',
                    beforeSubmit: function(){
                        $.popup();
                        $.popup.showLoading();
                    },
                    success: function(data){
                        $tokenInput.val(data.token);
                        validator.resetForm();
                        $form.trigger('afterReset');
                        if (data.error) {
                            $.alert({content: data.status});
                            return;
                        }
                        addComment(data);
                        $.popup.close();
                    }
                });
            }
        });
    }

    function showAllComments() {
        $typeAllLink.addClass('all-link-act');
        $typeProLink.removeClass('pro-link-act');
        filter($tree);
        function filter($parent) {
            $parent.children('.ti').each(function(){
                var $comment = $(this);
                $comment.show();
                if (!$comment.is('.collapsed')) {
                    filter($comment);
                }
            });
        }
        $('.ti', $tree).removeClass('ti-last').each(function(){
            $(this).children('.ti:last').addClass('ti-last');
        });
        $tree.toggleClass('comments-tree-empty', $tree.children('.ti:visible').length <= 0).children('.ti:last').addClass('ti-last');
    }

    function showProComments() {
        $typeAllLink.removeClass('all-link-act');
        $typeProLink.addClass('pro-link-act');
        filter($tree);
        function filter($parent) {
            $parent.children('.ti').each(function(){
                var $comment = $(this);
                if ($comment.children('.content').is('.content-pro')) {
                    filter($comment);
                } else {
                    $comment.hide();
                }
            });
        }
        $('.ti:visible', $tree).each(function(){
            var $comment = $(this);
            if (!$comment.children('.ti:visible').length) {
                $comment.children('.content').removeClass('content-has-reply');
            }
            $comment.children('.ti:visible:last').addClass('ti-last');
        });
        $tree.toggleClass('comments-tree-empty', $tree.children('.ti:visible').length < 1).children('.ti:visible:last').addClass('ti-last');
    }

    function expand(el) {
        $(el).closest('.ti').removeClass('ti-collapsed');
    }

    function initComment($comment) {
        var $replyLink = $('.reply-link', $comment);
        $replyLinks = $replyLinks.add($replyLink);
    }

    function addComment(data) {
        var $parentComment = $formBox.closest('.ti'),
            $parentContent = $formBox.closest('.content'),
            $comment = $(data.content);
        resetForm();
        initComment($comment);
        $type.removeClass('comments-type-disabled');
        $tree.removeClass('comments-tree-empty');
        if ($parentComment.length) {
            $parentComment.children('.ti:last').removeClass('ti-last');
            $parentComment.append($comment.hide().fadeIn(o.speed));
            $parentContent.addClass('content-has-reply');
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
        $.confirm.hideWindow();
        $.confirm.showLoading();
        var $comment = $(el).closest('.ti'),
            $content = $(el).closest('.content'),
            id = $comment.attr('id').substr(7),
            userID = $comment.children('input[name="userid"]').val();

        $.post(removeURL, {id: id, userid: userID, token: $tokenInput.val()}, function(data) {
            $tokenInput.val(data.token);
            resetForm();
            if (data.error) {
                $.alert({
                    content: data.status
                });
            } else {
                $.confirm.close();
                $comment.children('.branch').addClass('branch-removed');
                $content.html(data.content).addClass('content-removed');
            }
        }, 'json');
    }

    function quoteComment(el) {
        $.popup();
        $.popup.showLoading();
        var id = $(el).closest('.ti').attr('id').substr(7);
        $.post(quoteURL, {id: id, itemid: itemID, token: $tokenInput.val()}, function(data) {
            $tokenInput.val(data.token);
            resetForm();
            $.alert({
                content: data.status,
                afterClose: function(){
                    if (!data.error) {
                        location.reload(true);
                    }
                }
            });
        }, 'json');
    }

    function unquoteComment(el) {
        $.popup();
        $.popup.showLoading();
        var id = $(el).closest('.ti').attr('id').substr(7);
        $.post(unquoteURL, {id: id, itemid: itemID, token: $tokenInput.val()}, function(data) {
            $tokenInput.val(data.token);
            resetForm();
            $.alert({
                content: data.status,
                afterClose: function(){
                    if (!data.error) {
                        location.reload(true);
                    }
                }
            });
        }, 'json');
    }

    function showReplyForm(el) {
        var $replyLink = $(el).closest('.reply-link'),
            $oldParent = $formBox.parent(),
            parentID = $replyLink.closest('.ti').attr('id').substr(7);
        $oldParent.height($oldParent.height());
        $formBox.hide();
        $addLink.show();
        validator.resetForm();
        $form.trigger('afterReset');
        $parentIDInput.val(parentID);
        $replyLinks.show();
        $replyLink.hide().after($formBox.fadeIn(o.speed));
        $oldParent.height('');
        $messageInput.focus();
    }

    function showAddForm() {
        var $oldParent = $formBox.parent();
        $oldParent.height($oldParent.height());
        $formBox.hide();
        $replyLinks.show();
        validator.resetForm();
        $form.trigger('afterReset');
        $parentIDInput.val(0);
        $addLink.hide().after($formBox.fadeIn(o.speed));
        $oldParent.height('');
        $messageInput.focus();
    }

    function resetForm() {
        var $oldParent = $formBox.parent();
        if ($oldParent.is($add)) {
            validator.resetForm();
            $form.trigger('afterReset');
            $parentIDInput.val(0);
        } else {
            $oldParent.height($oldParent.height());
            $formBox.hide();
            $replyLinks.show();
            validator.resetForm();
            $form.trigger('afterReset');
            $parentIDInput.val(0);
            $addLink.hide().after($formBox.fadeIn(o.speed));
            $oldParent.height('');
        }
    }
};

$.comments.defaults = {
    speed: 150,
    easing: 'easeOutExpo',
    removeConfirm: 'Вы уверены, что хотите удалить комментарий?'
};
})(jQuery);



/* PLAYER
----------------------------------------------- */
/* player
----------------------------------------------- */
(function($){
$.fn.player = function(o){
    o = $.extend({
        speed: 150,
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
            $refs = $(o.refs),
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
        }).bind('play', function(el, index){
            $refs.removeClass('act').eq(index).addClass('act');
        });

        $refs.click(function(){
            var index = $refs.index(this);
            play(index);
        });
        
        function play(index) {
            jplayer.play(index);
        }

        setPosition(root, o.marginBottom);

        $(window).bind('resize scroll', function(){
            setPosition(root, o.marginBottom);
        });
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
        speed: 150,
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
        positionHandled = false;

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
        } else {
            $title.hide();
            setTitle(o.index);
            $title.fadeIn(o.speed);
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
            if (sound.sID === 'sound' + index) {
                return false;
            } else {
                $time.hide();
                $positionHandle.hide();
                sound.destruct();
            }
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

    return {
        play: function(index) {
            play(index);
        }
    };
};
})(jQuery);



/* INPUTS
----------------------------------------------- */
/* enabled
----------------------------------------------- */
(function($){
$.fn.enabled = function(){
    return this.each(function(){
        var $input = $(this),
            type = $input.prop('type');

        $input.removeProp('disabled');

        if (type == 'text') {
            $input.closest('.input-text').removeClass('input-text-disabled');
        } else if (type == 'checkbox') {
            $input.closest('.input-checkbox').removeClass('input-checkbox-disabled');
        } else if (type == 'radio') {
            $input.closest('.input-radio').removeClass('input-radio-disabled');
        } else if (type == 'select-one' || type == 'select-multiple') {
            $input.closest('.select').removeClass('select-disabled');
        } else if (type == 'textarea') {
            $input.closest('.textarea').removeClass('textarea-disabled');
        } else if (type == 'button' || type == 'submit') {
            $input.closest('.button').removeClass('button-disabled');
        }
    });
};
})(jQuery);

/* disabled
----------------------------------------------- */
(function($){
$.fn.disabled = function(){
    return this.each(function(){
        var $input = $(this),
            type = $input.prop('type');

        $input.prop('disabled', true);

        if (type == 'text') {
            $input.closest('.input-text').addClass('input-text-disabled');
        } else if (type == 'checkbox') {
            $input.closest('.input-checkbox').addClass('input-checkbox-disabled');
        } else if (type == 'radio') {
            $input.closest('.input-radio').addClass('input-radio-disabled');
        } else if (type == 'select-one' || type == 'select-multiple') {
            $input.closest('.select').addClass('select-disabled');
        } else if (type == 'textarea') {
            $input.closest('.textarea').addClass('textarea-disabled');
        } else if (type == 'button' || type == 'submit') {
            $input.closest('.button').addClass('button-disabled');
        }
    });
};
})(jQuery);

/* placeholder
----------------------------------------------- */
(function($){
$.fn.placeholder = function(className){
    className = className || 'placeholder';

    return this.each(function(){
        var $label = $(this),
            $input = $('#' + $label.attr('for')),
            $form = $input.closest('form'),
            placeholder = $label.text();

        $input.data('placeholder', placeholder);

        init();

        $input.focus(function(){
            if ($input.val() == placeholder) {
                $input.val('').removeClass(className);
            }
        }).blur(function(){
            if ($input.val() == '') {
                $input.val(placeholder).addClass(className);
            }
        });
        
        $form.reset(function(){
            init();
        });

        function init() {
            if ($input.val() == '' || $input.val() == placeholder) {
                $input.val(placeholder).addClass(className);
            } else {
                $input.removeClass(className);
            }
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
            $options = $select.find('option'),
         
            $jselect = $('<div class="jselect"><div class="jselect-title"><div class="jselect-title-r"><div class="jselect-title-l"><div class="jselect-title-text"></div></div></div></div><div class="jselect-list"><div class="jselect-list-top-r"><div class="jselect-list-top-l"></div></div><div class="jselect-list-r"><div class="jselect-list-l"><div class="jselect-list-wrap"><div class="jselect-list-content"></div></div></div></div><div class="jselect-list-bot-r"><div class="jselect-list-bot-l"></div></div></div><div class="jselect-arr"></div></div>'),
            $title = $jselect.find('.jselect-title'),
            $titleText = $jselect.find('.jselect-title-text'),
            $list = $jselect.find('.jselect-list'),
            $listContent = $jselect.find('.jselect-list-content'),
            $arr = $jselect.find('.jselect-arr'),
            $items = $();

        $titleText.text($options.eq(this.selectedIndex).text());

        $options.each(function(index){
            if ($(this).is('.placeholder')) {
                return;
            }
            
            var $item = $('<div />', {
                'class': 'jselect-li',
                'html': this.innerHTML || '&nbsp;',
                'click': function(){
                    set(index);
                    hide();
                }
            });
            
            $items = $items.add($item);
        });

        $listContent.html($items);

        $jselect.width($select.outerWidth()).bind('selectstart', function(e){
            e.preventDefault();
        });

        $select.hide().after($jselect);

        $jselects = $('.jselect');

        $title.add($arr).add($select).click(function(e){
            e.stopPropagation();
            show();
        });

        $list.click(function(e){
            e.stopPropagation();
        });

        $document.click(function(){
            hide();
        });

        function show() {
            hide();
            $jselect.addClass('jselect-expanded');
        }

        function hide() {
            $jselects.removeClass('jselect-expanded');
        }

        function set(index) {
            $select[0].selectedIndex = index;
            $select.triggerHandler('change');
            $titleText.text($options.eq(index).text());
        }
    });
};
})(jQuery);

/* selectNote
----------------------------------------------- */
(function($){
$.fn.selectNote = function(o){
    o = $.extend({
        speed: 150
    }, o);

    return this.each(function(){
        var $select = $(this),
            selectID = $select.attr('id'),
            $notes = $('[id^="' + selectID + '-note"]');

        $select.change(function(){
            $notes.hide().filter('#' + selectID + '-note' + $select.val()).fadeIn(o.speed);
        });
    });
};
})(jQuery);

/* inputFile
----------------------------------------------- */
(function($){
$.fn.inputFile = function(o){
    o = $.extend({
        speed: 150
    }, o);

    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form'),
            $pick = $('.pick', $root),
            $browseLink = $('.browse-link', $root),
            $input = $('.input input', $root),
            $info = $('.info', $root),
            $name = $('.name', $root),
            $clearLink = $('.clear-link', $root);

        $input.change(function(){
            var path = $input.val();
            $name.text(path.substr(path.lastIndexOf('\\') + 1));
            $pick.addClass('hidden').stop(true, true);
            $info.hide().removeClass('hidden').fadeIn(o.speed);
        }).hover(
            function(){
                $browseLink.mouseenter().addClass('browse-link-hover');
            },
            function(){
                $browseLink.mouseleave().removeClass('browse-link-hover');
            }
        );

        $clearLink.click(function(){
            clear();
        });
        
        $form.reset(function(){
            reset();
        });

        function clear() {
            $input.val('');
            $name.empty();
            $info.addClass('hidden').stop(true, true);
            $pick.hide().removeClass('hidden').fadeIn(o.speed);
        }

        function reset() {
            $info.addClass('hidden');
            $pick.removeClass('hidden');
        }
    });
};
})(jQuery);





/* inputInt
----------------------------------------------- */
(function($){
var cmdKey = false,
    modKey = false;
$.fn.inputInt = function(o){
    o = $.extend({
        min: null,
        max: null,
        complete: function(){}
    }, o || {});
    return this.each(function(){
        $(this).on('keydown', function(e){
            if (e.which == 17 || e.which == 91) {
                cmdKey = true;
            };
            if (e.which == 16 || e.which == 18) {
                modKey = true;
            };
            if (!cmdKey && (
                ( modKey && ( e.which >= 48 && e.which <= 57 ) ) ||
                ( e.which >= 65 && e.which <= 90 ) ||
                ( e.which >= 106 && e.which <= 111 ) ||
                ( e.which >= 186 && e.which <= 188 ) ||
                ( modKey && e.which == 189 ) ||
                ( e.which >= 190 && e.which <= 191 ) ||
                ( e.which >= 219 && e.which <= 222 ) )
            ) {
                e.preventDefault();
            }
        }).on('keyup', function(e){
            var intValue = parseInt(this.value, 10) || 0;
            if (e.which == 17 || e.which == 91) {
                cmdKey = false;
            } else if (e.which == 16 || e.which == 18) {
                modKey = false;
            } else if (this.value && this.value != '-' && this.value != intValue.toString(10) && ( e.which < 35 || e.which > 39 ) ) {
                this.value = intValue;
            }
            if (o.max != null && intValue > o.max) {
                this.value = o.max;
            } else if (o.min != null && intValue < o.min) {
                this.value = o.min;
            }
            o.complete(this.value);
        }).on('paste', function(e){
            var input = this;
            setTimeout(function() {
                var intValue = parseInt(input.value, 10) || 0;
                input.value = intValue;
            }, 100);
        });
    });
};
})(jQuery);




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
        submitHandler = o.submitHandler || function(){
            if (o.confirmText) {
                $.confirm({
                    content: o.confirmText,
                    yes: function(){
                        submit();
                    }
                });        
            } else {
                submit();
            }
        },
        validator = $form.validate({
            highlight: function(el){
                $(el).closest('.field').addClass('field-error');
            },
            unhighlight: function(el){
                $(el).closest('.field').removeClass('field-error');
            },
            errorPlacement: function(){},
            rules: o.rules,
            submitHandler: submitHandler
        });

    function submit() {
        $('input, button, select, textarea', $form).blur();
        if (o.ajax) {
            $form.ajaxSubmit({
                data: {token: $tokenInput.val()},
                dataType: 'json',
                beforeSubmit: function(){
                    $.popup();
                    $.popup.showLoading();
                },
                success: function(data){
                    $tokenInput.val(data.token);
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
            form.submit();
        }
    }
};
$.form.defaults = {
    ajax: true,
    reset: true,
    reload: false,
    confirmText: '',
    rules: {},
    complete: function(){}
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
            $retrievePassword.html('Назад к логину');
            $form.attr('action', '/user/retrieve/');
            $form.find('.login-block').hide(10, function() {
                $form.find('.password-block').show();
            });
        }, function(event) {
            event.preventDefault();
            isRetrieve = false;
            $retrievePassword.html('Забыли пароль?');
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
                    data: {token: $tokenInput.val()},
                    dataType: 'json',
                    success: function(data){
                        $tokenInput.val(data.token);
                        if (isRetrieve) {
                            if (data.error) {
                                $status.html(data.status).fadeIn(o.speed);
                            } else {
                                $status.hide();
                                $.alert({content: data.status});
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

/* soonForm
----------------------------------------------- */
(function($){
$.fn.soonForm = function(o){
    o = $.extend({
        link: ''
    }, o);

    return this.each(function(){
        var $form = $(this),
            $emailInput = $('input[name="email"]', $form);

        $(o.link).popup({
            src: o.src,
            beforeShowWindow: function(){
                $emailInput.focus();
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
            submitHandler: function(){
                $('input, button, select, textarea', $form).blur();
                $form.ajaxSubmit({
                    data: {token: $tokenInput.val()},
                    dataType: 'json',
                    beforeSubmit: function(){
                        $.popup.hideWindow();
                        $.popup.showLoading();
                    },
                    success: function(data){
                        $tokenInput.val(data.token);
                        validator.resetForm();
                        $form.trigger('afterReset');
                        $.alert({
                            content: data.status
                        });
                    }
                });
            }
        });
    });
};
})(jQuery);

/* userForm
----------------------------------------------- */
(function($){
$.fn.userForm = function(){
    return this.each(function(){
        var $form = $(this),
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
                    data: {token: $tokenInput.val()},
                    dataType: 'json',
                    beforeSubmit: function(){
                        $.popup();
                        $.popup.showLoading();
                    },
                    success: function(data){
                        $tokenInput.val(data.token);
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

        $('.facebook .unlink', $form).click(function() {
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
        });
    });
};
})(jQuery);

/* profileForm
----------------------------------------------- */
(function($){
$.fn.profileForm = function(o){
    o = $.extend({
        speed: 150
    }, o);

    return this.each(function(){
        var $form = $(this);

        image();
        info();
        refs();

        function image() {
            var $image = $('.image', $form),
                naClass = 'image-na',
                $imgHolder = $('.img', $image),
                $removeLink = $('.remove', $image),
                removeConfirm = $('.confirm', $removeLink).html(),
                $imageInput = $('input[name="image"]', $image),
                $imageNewInput = $('input[name="image_new"]', $image),
                $imageRemovedInput = $('input[name="image_removed"]', $image),
                size = $('input[name="image_size"]', $image).val(),
                cropURL = $('input[name="image_crop"]', $image).val(),
                uploadURL = $('input[name="image_upload"]', $image).val();
   
            $removeLink.click(remove);
            $imageInput.change(upload);

            function remove() {
                $.confirm({
                    content: removeConfirm,
                    yes: function(){
                        $.confirm.close();
                        $image.addClass(naClass);
                        $imageNewInput.val('');
                        $imageRemovedInput.val(1);
                        $imgHolder.empty();
                    }
                });
            }
    
            function upload() {
                var $img = $('<img src="" alt="" />'),
                    src = '',
                    area = [];

                $('input, button, select, textarea', $form).blur();
                $form.ajaxSubmit({
                    url: uploadURL,
                    data: {token: $tokenInput.val()},
                    dataType: 'json',
                    beforeSubmit: function(){
                        $.confirm({
                            content: $img,
                            extraClass: 'popup-crop',
                            showWindow: function(){
                                $.confirm.showLoading();
                            },
                            yes: function(){
                                crop();
                            }
                        });
                    },
                    success: function(data){
                        $tokenInput.val(data.token);
                        $form.reset();
                        if (data.error) {
                            $.alert({
                                content: data.status
                            });
                        } else {
                            src = data.src;
                            edit();
                        }
                    }
                });
    
                function edit() {
                    var img = new Image();
            
                    img.onload = function(){
                        $img.attr('src', img.src).attr('width', img.width).attr('height', img.height);

                        var x, y, x2, y2;
            
                        if (img.width >= img.height) {
                            x = (img.width - img.height) / 2;
                            y = 0;
                            x2 = ((img.width - img.height) / 2) + img.height;
                            y2 = img.height;
                        } else {
                            x = 0;
                            y = (img.height - img.width) / 2;
                            x2 = img.width;
                            y2 = ((img.height - img.width) / 2) + img.width;
                        }
                        
                        x = Math.floor(x);
                        y = Math.floor(y);
                        x2 = Math.floor(x2);
                        y2 = Math.floor(y2);
                        
                        area = [x, y, x2 - x, y2 - y];
            
                        $img.Jcrop({
                            aspectRatio: 1,
                            minSize: [220, 220],
                            setSelect: [x, y, x2, y2],
                            onSelect: function(c){
                                area = [c.x, c.y, c.w, c.h];
                            }
                        });
            
                        $.confirm.hideLoading();
                        $.confirm.showWindow();
                    };

                    img.src = src;
                }

                function crop() {
                    $.confirm.hideWindow();
                    $.confirm.showLoading();
                    $.post(cropURL, {src: src, area: area, size: size, token: $tokenInput.val()}, function(data) {
                        $tokenInput.val(data.token);
                        if (data.error) {
                            $.alert({
                                content: data.status
                            });
                        } else {
                            $.confirm.close();
                            $imgHolder.html('<img src="' + data.src + '" alt="" />');
                            $imageNewInput.val(data.src);
                            $image.removeClass(naClass);
                        }
                    }, 'json');
                }
            }
        }


        function info() {
            var $content = $('.content', $form),
                $useReccountInfoInput = $('input[name="use_reccount_info"]', $form),
                $userInfo = $('.user-info', $form),
                $reccountInfo = $('.reccount-info', $form);

            $useReccountInfoInput.click(toggle);

            function toggle() {
                $content.height($content.height());

                if (this.checked) {
                    $userInfo.addClass('hidden');
                    $reccountInfo.hide().removeClass('hidden').fadeIn(o.speed);
                } else {
                    $reccountInfo.addClass('hidden');
                    $userInfo.hide().removeClass('hidden').fadeIn(o.speed);
                }
    
                $content.height('');
            }
        }


        function refs() {
            var $list = $('.refs', $form),
                $items,
                $URLInputs,
                $IDInputs,
                $hideChecks,
                $hideLabels,
                $removeLinks,
                $addLink = $('.ref-add-link span', $form),
                busyRemove = false;

            init();

            $list.sortable({stack: $items, handle: '.drag'});
            $URLInputs.bind('change keyup paste', urlChange);
            $hideChecks.click(visibilityChange);
            $removeLinks.click(remove);
            $addLink.click(add);

            function init() {
                $items = $('li', $list);
                $URLInputs = $('.url input[type="text"]', $list);
                $IDInputs = $('.url input[type="hidden"]', $list);
                $hideChecks = $('.hide input', $list);
                $hideLabels = $('.hide label', $list);
                $removeLinks = $('.remove span', $list);
            }

            function urlChange() {
                var $item = $(this).closest('li'),
                    $hide = $('.hide', $item),
                    $remove = $('.remove', $item);

                if (!$.trim(this.value)) {
                    $hide.find('input').prop('checked', false).triggerHandler('click');
                    if ($items.length < 2) {
                        $hide.addClass('hidden');
                        $remove.addClass('hidden');
                    }
                } else {
                    $hide.removeClass('hidden');
                    $remove.removeClass('hidden');
                }
            }

            function visibilityChange() {
                $(this).closest('li').toggleClass('ref-hidden', this.checked);
            }

            function remove() {
                if ($items.length < 2) {
                    $URLInputs.attr({
                        'name': 'ref[0]',
                        'value': ''
                    });
                    $IDInputs.attr({
                        'name': 'ref_id[0]',
                        'value': ''
                    });
                    $hideChecks.attr({
                        'id': 'profileRefHide0',
                        'name': 'ref_hide[0]',
                        'checked': false
                    }).triggerHandler('click');
                    $hideChecks.closest('.hide').addClass('hidden');
                    $hideLabels.attr('for', 'profileRefHide0');
                    $removeLinks.closest('.remove').addClass('hidden');
                } else {
                    if (busyRemove) {
                        return;
                    }
                    
                    busyRemove = true;

                    var $item = $(this).closest('li');

                    $item.fadeOut(o.speed, function(){
                        $item.remove();

                        init();
                        
                        busyRemove = false;
                    });
                }
            }

            function add() {
                $hideChecks.closest('.hide').removeClass('hidden');
                $removeLinks.closest('.remove').removeClass('hidden');

                var $item = $items.eq(0).clone(true),
                    $URLInput = $('.url input[type="text"]', $item),
                    $IDInput = $('.url input[type="hidden"]', $item),
                    $hideCheck = $('.hide input', $item),
                    $hideLabel = $('.hide label', $item),
                    nextIndex = getNextIndex();

                $URLInput.attr({
                    'name': 'ref[' + nextIndex + ']',
                    'value': ''
                });
                $IDInput.attr({
                    'name': 'ref_id[' + nextIndex + ']',
                    'value': ''
                });
                $hideCheck.attr({
                    'id': 'profileRefHide' + nextIndex,
                    'name': 'ref_hide[' + nextIndex + ']',
                    'checked': false
                }).triggerHandler('click');
                $hideLabel.attr('for', 'profileRefHide' + nextIndex);

                $list.append($item.hide().fadeIn(o.speed));

                init();

                function getNextIndex() {
                    var lastIndex = 0;
                    
                    $URLInputs.each(function(){
                        var index = parseInt(this.name.substr(4));
                        if (index > lastIndex) {
                            lastIndex = index;
                        }
                    });
                    
                    return lastIndex + 1;
                }
            }
        }
    });
};
})(jQuery);

/* settings
----------------------------------------------- */
(function($){
$.fn.settings = function(o){
    o = $.extend({
        speed: 100,
        easing: 'easeOutExpo'
    }, o);
    return this.each(function(){
        var $root = $(this);
        initToggle();
        initBuy();
        initFree();
        initAdd();
        initKind();
        initTransfer();
        function initToggle() {
            var $toggle = $('.toggle', $root);
            if (!$toggle.length) {
                return;
            }
            var $content = $('.content', $root),
                hidden = !$content.is(':visible'),
                busy = false;
            $toggle.on('click', toggle);
            function toggle() {
                if (hidden) {
                    show();
                } else {
                    hide();
                }
            }
            function show() {
                if (busy) {
                    return;
                }
                busy = true;
                $toggle.addClass('toggle-expanded');
                $content.slideDown(o.speed, o.easing, function(){
                    hidden = false;
                    busy = false;
                });
            }
            function hide() {
                if (busy) {
                    return;
                }
                busy = true;
                $toggle.removeClass('toggle-expanded');
                $content.slideUp(o.speed, o.easing, function(){
                    hidden = true;
                    busy = false;
                });
            }
        }
        function initBuy() {
            var $form = $root.closest('form');
            if (!$root.is('.settings-buy') || !$form.length) {
                return;
            }
            var balanceURL = $('input[name="balance_url"]', $form).val(),
                depositURL = $('input[name="deposit_url"]', $form).val(),
                periodMax = parseInt($('input[name="period_max"]', $form).val()) || 0,
                periodCurrent = parseFloat($('input[name="period_current"]', $form).val()) || 0,
                quotaMax = parseInt($('input[name="quota_max"]', $form).val()) || 0,
                quotaCurrent = parseFloat($('input[name="quota_current"]', $form).val()) || 0,
                price = parseFloat($('input[name="price"]', $form).val()) || 0,
                $finalCostInput = $('input[name="final_cost"]', $form),
                finalCost = parseInt($finalCostInput.val()) || 0,
                discount = parseInt($('input[name="discount"]', $form).val()) || 0,
                $periodInput = $('input[name="period"]', $form),
                $quotaInput = $('input[name="quota"]', $form),
                $cost = $('.cost', $form),
                $fullCost = $('.full span', $cost),
                $finalCost = $('.final span', $cost);
            $form.form({
                submitHandler: function(){
                    $form.ajaxSubmit({
                        url: balanceURL,
                        dataType: 'json',
                        data: {token: $tokenInput.val()},
                        success: function(data){
                            if (data.error) {
                                $.alert({content: data.status});
                            } else {
                                if (data.balance < finalCost) {
                                    $.confirm({
                                        content: data.status,
                                        yes: function(){
                                            $.popup.close();
                                            location.href = depositURL;
                                        }
                                    });
                                } else {
                                    $form[0].submit();
                                }
                            }
                        }
                    });
                }
            });
            $periodInput.inputInt({max: periodMax, complete: calc});
            $quotaInput.inputInt({max: quotaMax, complete: calc});
            calc();
            function calc() {
                var period = parseInt($periodInput[0].value) || 0,
                    quota = parseInt($quotaInput[0].value) || 0,
                    fullCost = Math.floor( ( quota + quotaCurrent ) * ( period + periodCurrent ) * price );
                finalCost = Math.floor( fullCost - fullCost * discount / 100 );
                $fullCost.html(fullCost);
                $finalCost.html(finalCost);
                if (fullCost) {
                    $cost.fadeIn(o.speed);
                } else {
                    $cost.fadeOut(o.speed);
                }
                $finalCostInput.val(finalCost);
            }
        }
        function initFree() {
            if (!$root.is('.settings-free')) {
                return;
            }
            var $form = $root.closest('form'),
                freeURL = $('input[name="free_url"]', $form).val();
            $('button[type="submit"]', $root).on('click', function(){
                $form.attr('action', freeURL);
                $form[0].submit();
            });
        }
        function initAdd() {
            var $form = $root.closest('form');
            if (!$root.is('.settings-add') || !$form.length) {
                return;
            }
            var balanceURL = $('input[name="balance_url"]', $form).val(),
                depositURL = $('input[name="deposit_url"]', $form).val(),
                periodMax = parseInt($('input[name="period_max"]', $form).val()) || 0,
                periodCurrent = parseFloat($('input[name="period_current"]', $form).val()) || 0,
                quotaMax = parseInt($('input[name="quota_max"]', $form).val()) || 0,
                quotaCurrent = parseFloat($('input[name="quota_current"]', $form).val()) || 0,
                price = parseFloat($('input[name="price"]', $form).val()) || 0,
                $finalCostInput = $('input[name="final_cost"]', $form),
                finalCost = parseInt($finalCostInput.val()) || 0,
                discount = parseInt($('input[name="discount"]', $form).val()) || 0,
                $periodInput = $('input[name="period"]', $form),
                $quotaInput = $('input[name="quota"]', $form),
                $cost = $('.cost', $form),
                $fullCost = $('.full span', $cost),
                $finalCost = $('.final span', $cost);
            $form.form({
                rules: {
                    period: {
                        min: function(el) {
                            if ($quotaInput.val() > 0) {
                                return 0;
                            } else {
                                return 1;
                            }
                        }
                    },
                    quota: {
                        min: function(el) {
                            if ($periodInput.val() > 0) {
                                return 0;
                            } else {
                                return 1;
                            }
                        }
                    }
                },
                submitHandler: function(){
                    $form.ajaxSubmit({
                        url: balanceURL,
                        dataType: 'json',
                        data: {token: $tokenInput.val()},
                        success: function(data){
                            if (data.error) {
                                $.alert({content: data.status});
                            } else {
                                if (data.balance < finalCost) {
                                    $.confirm({
                                        content: data.status,
                                        yes: function(){
                                            $.popup.close();
                                            location.href = depositURL;
                                        }
                                    });
                                } else {
                                    $form[0].submit();
                                }
                            }
                        }
                    });
                }
            });
            $periodInput.inputInt({max: periodMax, complete: calc});
            $quotaInput.inputInt({max: quotaMax, complete: calc});
            calc();
            function calc() {
                var period = parseInt($periodInput[0].value) || 0,
                    quota = parseInt($quotaInput[0].value) || 0,
                    fullCost = Math.floor( ( quota + quotaCurrent ) * period * price + quota * periodCurrent * price );
                finalCost = Math.floor( fullCost - fullCost * discount / 100 );
                $fullCost.html(fullCost);
                $finalCost.html(finalCost);
                if (fullCost) {
                    $cost.fadeIn(o.speed);
                } else {
                    $cost.fadeOut(o.speed);
                }
                $finalCostInput.val(finalCost);
            }
        }
        function initKind() {
            $('.fieldset-kind', $root).each(function(){
                var $kind = $(this),
                    $form = $('form', $kind),
                    $inputs = $('input:radio', $kind),
                    $teaser = $kind.closest('.teaser-content').data('$teaser'),
                    $titles = $('.title-kind', $teaser),
                    $icons = $('.i-kind', $teaser),
                    currentIndex = $inputs.index($inputs.filter(':checked'));
                $form.form({reset: false});
                $inputs.each(function(index){
                    $(this).on('click', function(){
                        change(index);
                    });
                });
                function change(index) {
                    $titles.eq(currentIndex).add($icons.eq(currentIndex)).fadeOut(o.speed, function(){
                        $titles.eq(index).add($icons.eq(index)).fadeIn(o.speed);
                    });
                    currentIndex = index;
                }
            });
        }
        function initTransfer() {
            $('.fieldset-transfer', $root).each(function(){
                var $transfer = $(this),
                    submitOptions = {
                        confirmText: lang.transferConfirm
                    };
                if ($transfer.is('.fieldset-transfer-cancel')) {
                    submitOptions.confirmText = lang.transferCancelConfirm;
                    submitOptions.ajax = false;
                }
                $('form', $transfer).form(submitOptions);
            });
        }
    });
};
})(jQuery);



/* POPUPS
----------------------------------------------- */
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
                params = $.extend({}, param1);
            }
        }

        if (param2) {
            params = $.extend({}, param2);
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

        $doc.bind('keydown.popup', function(e){
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

        $doc.bind('keydown.alert', function(e){
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

    $.alert.ok = function(callback){
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
        $confirm = $('<div class="confirm-popup"><div class="confirm-popup-content"></div><div class="confirm-popup-no"><i class="i"></i></div><div class="confirm-popup-yes"><i class="i"></i></div></div>'),
        $content = $('.confirm-popup-content', $confirm),
        $yes = $('.confirm-popup-yes', $confirm),
        $no = $('.confirm-popup-no', $confirm);

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

        $doc.bind('keydown.confirm', function(e){
            if (e.which == 13 && o.yesOnEnter) {
                yes();
            }

            if (e.which == 27 && o.noOnEsc) {
                no();
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

    function yes() {
        if (o.yes) {
            o.yes(el);
        } else {
            $.confirm.yes();
        }
    }

    function no() {
        if (o.no) {
            o.no(el);
        } else {
            $.confirm.no();
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

    $.confirm.yes = function(callback){
        close();
    };

    $.confirm.no = function(callback){
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
        $yes.click(yes).bind('selectstart', function(e){
            e.preventDefault();
        });

        $no.click(no).bind('selectstart', function(e){
            e.preventDefault();
        });
    };

    $.confirm.defaults = {
        speed: 150,
        content: 'Продолжить?',
        extraClass: '',
        noOnEsc: true,
        yesOnEnter: true,
        closeOnEsc: true,
        closeOnOverlay: false
    };

    $(function(){
        $.confirm.init();
    });
})(jQuery);



/* UTILS
----------------------------------------------- */
/* urlParams
----------------------------------------------- */
(function($){
$.fn.urlParams = function(params){
    return this.each(function(){
        this.href = $.urlParams(this.href, params).url;
    });
};


$.urlParams = function(url, params){
    var path = '',
        query = '',
        queryPos = url.indexOf('?'),
        hash = '',
        hashPos = url.indexOf('#'),
        vars = {};
    
    path = queryPos > -1 ? url.substring(0, queryPos) : url;
    query = queryPos > -1 ? ( hashPos > -1 ? url.substring(queryPos, hashPos) : url.substr(queryPos) ) : '';
    hash = hashPos > -1 ? url.substr(hashPos) : '';
    query.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
        vars[key] = value;
    });


    if (typeof params == 'object') {
        if (typeof params.path == 'string') {
            path = params.path;
        }
    
        if (typeof params.query == 'string') {
            query = params.query;
            vars = {};
            query.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
                vars[key] = value;
            });
        }

        if (typeof params.vars == 'object') {
            $.extend(vars, params.vars);
            query = '?';
            var sep = '';
            for (key in vars) {
                query += sep + key + '=' + vars[key];
                sep = '&';
            }
        }

        if (typeof params.hash == 'string') {
            hash = params.hash;
        }
        
        url = path + query + hash;
    }

    return {path: path, query: query, hash: hash, vars: vars, url: url}
};
})(jQuery);


/* deposit
----------------------------------------------- */
(function($){
$.fn.deposit = function(o){
    o = $.extend({
        speed: 100
    }, o);
    return this.each(function(){
        var $root = $(this),
            $buyForm = $('.buy-form', $root),
            $codeForm = $('.code-form', $root),
            $discount = $('.discount', $root),
            $discountVal = $('span', $discount);
        $buyForm.form({ajax: false});
        $('input[name="sum"]', $buyForm).inputInt();
        $codeForm.form({
            ajax: true,
            complete: function(data){
                if (data.discount > 0) {
                    $discountVal.html(data.discount + '%');
                    $discount.fadeIn(o.speed);
                } else {
                    $discount.hide();
                }
            }
        });
    });
};
})(jQuery);




/* INIT
----------------------------------------------- */
$(function(){
    /* hi */
    $('.teasers').teasers();
    $('select').jselect();
    $('label.placeholder').placeholder();
    $('.releases').jflow();
    $('.photos').photos();
    if (typeof playlist != 'undefined') {
        $('.layout-content').addClass('layout-content-player');
        $('.player').player({
            refs: '.post-extra .media li',
            repeat: false,
            playlist: playlist,
            height: 64,
            marginBottom: 40
        });
    }

    /* forms */
    $('.feedback-form form').form();
    $('.feedback-form .field-subject select').selectNote();
    $('.support-form form').form({reload: true});
    $('.support-form .field-subject select').selectNote();
    $('.user-form form').userForm();
    $('.profile-form form').profileForm();
    if ($('.profile-form-activated').length) {
        $.alert({content: lang.accountActivated});
    }
    $('.profile .message-form form').form();
    $('.deposit').deposit();
    $('.settings').settings();
    $('.news-feed').newsFeed();
    $('.quotes').quotes();
    $('.share, .post-share').share();
    $('.post-rate').rate();
    $('a.help-link, .help-link a').popup();
    $('.user-url').userURL('userURLCopy', 'userURLCopyWrap');
    $('.input-file').inputFile();
    $('.comments').comments();
    $('.notifications').notifications();
    $('.demo-links a').popup({extraClass: 'popup-video'});
    $('.auth-popup form').authForm({link: '.auth-popup-link', src: '#auth-popup-src'});
    $('.soon-popup form').soonForm({link: '.soon-popup-link', src: '#soon-popup-src'});
    $('.faq a').popup({extraClass: 'popup-video'});
});