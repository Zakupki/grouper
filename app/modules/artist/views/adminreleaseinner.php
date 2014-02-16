<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->
	
<!-- content (begin) -->
<div class="g-content">
    <div class="b-edit-release">
        <a class="beatport" href="#"></a>
        <a class="soundcloud" href="#"></a>
        <div class="upload" style="margin:15px 0 0 90px;">
            <div class="upload-button"><?=$this->registry->trans['uploadtfor'];?> <b><?=$this->view->releasetype['name'];?></b> (*.mp3)</div>
            <input id="upload-track" name="upload-track" style="display:none;" type="file" />
        </div>

        <ul class="b-items">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a><div class="separator"></div><a href="#" class="edit-item"><?=$this->registry->trans['edit'];?></a><div class="draggable-area"></div>
                </div>

                <img class="preview" src="" width="40" height="40" alt=""><div class="description">
                    <div class="title">
                        <span class="author"></span> -
                        <span class="name"></span>
                        (<span class="remix"></span>)
                    </div>
                    <span class="date"></span><span class="style"></span><i class="label"></i>
                </div>
            </li>
        </ul>

        <button class="b-add-press-release"><?=$this->registry->trans['pressrelease'];?></button>

        <div class="b-press-release" style="display:none;">
            <label class="label"><?=$this->registry->trans['title'];?> <?=$this->registry->trans['for'];?> <b><?=$this->view->releasetype['name'];?></b></label>
            <input class="press-release-title"  type="text"/>

            <label class="label caption-text-before"><?=$this->registry->trans['text'];?> <?=$this->registry->trans['for'];?> <b><?=$this->view->releasetype['name'];?></b></label>

            <textarea class="text-before"></textarea>

            <div class="incut-wrap">
                <div class="incut">
                    <img src="/img/artist/admin/bg-incut-userpic.png" width="100" height="100" />
                    <span>Подобным образом оформляется Ваша публикация. Вы имеете возможность отмечать лучшие комментарии, которые попадают в “врез”. Если отмечено несколько комментариев, то они поочередно сменяют друг-друга. </span>
                    <a href="#">Super Star</a>
                </div>

                <textarea class="text-after"></textarea>
            </div>
            <!--div class="alert-copy-paste">
                <i></i>Очистка от стилей. <span>Мы настоятельно рекомендуем использовать во всех случаях, когда Вы переносите текст через буфер обмена (copy-paste).</span> После того, как вы вставили текст, нужно его выделить и нажать на иконку “красный крестик”.
            </div-->
            <label class="label-incut"><input class="cut" type="checkbox" checked="checked" /><?=$this->registry->trans['pressinc'];?></label>
            
            <div class="b-button-set">
                <button class="cancel-press-release"><?=$this->registry->trans['cancel'];?></button>
            </div>
        </div>

        <div class="b-button-set">
            <button class="save-release"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->


<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup">
    <span class="label-author"><?=$this->registry->trans['author'];?></span><span class="label-name"><?=$this->registry->trans['title'];?></span><span class="label-remix"><?=$this->registry->trans['remixer'];?></span><span class="label-style"><?=$this->registry->trans['style'];?> (Eng.)</span>

    <div>
        <input class="author" type="text" value="<?=$this->view->releasetype['author'];?>" /><input class="name" type="text" /><input class="remix" type="text" value="Original mix" /><input class="style" type="text" />
    </div>

    <div class="options">
        <label><input class="download" type="checkbox" /> <?=$this->registry->trans['downloadable'];?></label><label><input class="cut" type="checkbox" /> Promo-cut</label><label><input class="playlist" type="checkbox" /> <?=$this->registry->trans['addtoplay'];?></label>
    </div>

    <div class="b-button-set">
        <button class="save"><?=$this->registry->trans['save'];?></button>
        <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
    </div>
</div>

<script type="text/javascript">
    (function($){
        $.fn.releaseTracks = function(){
            return this.each(function(){

                var release = $.parseJSON('<?=$this->view->release;?>'),
                    releaseCover = '<?=$this->view->releasetype['url'];?>',
                    releaseCoverId = <?=$this->view->releasetype['coverid'];?>,
                    releaseDate = '<?=$this->view->releasetype['date_start'];?>',
                    releaseLabel = '<?=tools::tojs($this->view->releasetype['label']);?>',
                    $addTrack = $('#adding-popup'),
                    $addTrackOverlay = $('.g-overlay-superblack'),
                    $addBlockBorderOverlay = $('.g-overlay-border'),
                    $tracksContainer = $('.b-items').sortable(),
                    $addPressReleaseButton = $('.b-add-press-release'),
                    $addPressRelease = $('.b-press-release'),
                    $cancelPressReleaseButton = $('.cancel-press-release'),
                    $saveReleaseButton = $('.save-release');

                
                $addTrack.find('.style').autocomplete({
                    source: '/ajax/musicstyle/',
                    minLength: 3,
                    position: { offset: '0 -4' }
                });


                $('#upload-track').uploadify({
                    'uploader'                   : '/uploadify/uploadify.swf',
                    'script'                        : '/file/uploadmp3/',
                    'cancelImg'                 : '/uploadify/cancel.png',
                    'folder'                        : '/uploads/temp',
                    'fileExt'                       : '*.mp3',
                    'fileDesc'                  : 'mp3',
                    'auto'                          : true,
                    'wmode'                      : 'transparent',
                    'hideButton'                : true,
                    'width'                         : 360,
                    'onComplete'         : function(event, queueID, fileObj, response, data) {
                        editTrack(null, response)
                    }
                });

                
                $('.text-before, .text-after').wysiwyg({
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


                $('.soundcloud').click(function(event) {
                    event.preventDefault();

                    $.confirm({
                        'content': '<i class="label-soundcloud"><?=$this->registry->trans['soundcloudlink'];?></i><input class="input-soundcloud" type="text" />',
                        'ok': function() {
                            var soundcloudUrl = encodeURIComponent(($('.input-soundcloud').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0'));

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
                                        addTrack(null, null, response.title, 1, null, 'Original mix', 0, 0, 0, response.musictype, null, response.socialid, response.stream);
                                    };

                                    $.popup.close();
                                }
                            );
                        }
                    });
                });

                $('.beatport').click(function(event) {
                    event.preventDefault();

                    $.confirm({
                        'content': '<i class="label-soundcloud"><?=$this->registry->trans['beatportlink'];?></i><input class="input-soundcloud" type="text" />',
                        'ok': function() {
                            var beatportUrl = encodeURIComponent(($('.input-soundcloud').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0'));

                            $.popup.hideWindow();
                            $.popup.showLoading();

                            $.post(
                                    '/file/getstream/',
                                    'url=' + beatportUrl + '&socialid=198' ,
                                    function(response) {
                                        response = $.parseJSON(response);

                                        if (response.error) {
                                            $.alert({
                                                content: response.status
                                            });
                                            return;

                                        } else {
                                            addTrack(null, null, response.title, 1, response.author, 'Original mix', 0, 0, 0, response.musictype, null, response.socialid, response.stream);
                                        };

                                        $.popup.close();
                                    }
                            );
                        }
                    });
                });


                function addTrack(id, fileid, name, active, author, remix, promocut, download, inplaylist, musictype, compare, socialid, stream) {
                    var newTrack = $tracksContainer.find('.hidden').clone().removeClass('hidden').prependTo($tracksContainer);

                    newTrack.data('id', id);
                    newTrack.data('fileid', fileid);
                    newTrack.data('compare', compare);

                    if (socialid) {
                        newTrack.data('socialid', socialid);
                    };

                    if (stream) {
                        newTrack.data('stream', stream);
                    };

                    newTrack.find('.name').html(name);
                    newTrack.find('.author').html(author);
                    newTrack.find('.remix').html(remix);
                    newTrack.find('.label').html(releaseLabel);
                    newTrack.find('.date').html(releaseDate);
                    musictype ? newTrack.find('.style').html(musictype) : newTrack.find('.style').hide();
                    newTrack.find('.preview').attr('src', releaseCover);
                    newTrack.data('promocut', promocut);
                    newTrack.data('download', download);
                    
                    inplaylist ? newTrack.data('inplaylist', inplaylist) : newTrack.data('inplaylist', 0);
                    active == '0' ? newTrack.find('.hide-item').attr('checked', 'checked') : 0;

                    newTrack.find('.delete-item').click(function(event) {
                        event.preventDefault();

                        release.deleted ? 0 : release.deleted = {};
                        release.deleted[id] = {};
                        release.deleted[id]['id'] = id;
                        release.deleted[id]['fileid'] = fileid;

                        newTrack.remove();
                    });

                    newTrack.find('.edit-item').click(function(event) {
                        event.preventDefault();
                        editTrack(newTrack);
                    });

                    if (stream) {
                        editTrack(newTrack);
                    };
                };


                 function init() {
                     $tracksContainer.find(':visible').remove();

                    if (release.release) {
                        $addPressRelease.hide();
                        $saveReleaseButton.show();
                        $addPressReleaseButton.show();

                        $.each(release.release, function(i, item) {
                            addTrack(item.id, item.fileid, item.name, item.active, item.author, item.remix, item.promocut, item.download, item.inplaylist, item.musictype, item.compare);
                        });

                    } else {
                        $saveReleaseButton.hide();
                        $addPressRelease.hide();
                        $addPressReleaseButton.hide();
                    };


                    if (release.pressrelease) {
                        $addPressRelease.data('id', release.pressrelease.id);
                        $addPressRelease.data('itemid', release.pressrelease.itemid);
                        $addPressRelease.find('.press-release-title').val(release.pressrelease.name);
                        $addPressRelease.find('.text-before').val(release.pressrelease.preview_text);
                        $addPressRelease.find('.text-before').wysiwyg('setContent', release.pressrelease.preview_text);

                        if (release.pressrelease.incut == 1) {
                            $addPressRelease.find('.cut').attr('checked', 'checked');
                            $('.incut-wrap').show();
                            $addPressRelease.find('.text-after').wysiwyg('setContent', release.pressrelease.detail_text);
                        } else {
                            $('.incut-wrap').hide();
                        };
                    }
                };


                function editTrack(track, mp3) {
                    $addTrack.find('.author').val('<?=tools::tojs($this->view->releasetype['author']);?>');
                    $addTrack.find('.name').val('');
                    $addTrack.find('.remix').val('Original mix');
                    $addTrack.find('.style').val('');
                    $addTrack.find('.options input').removeAttr('checked');

                    var trackDesc = {};

                    $.ajax({
                        url: '/admin/getreleasetoken/',
                        success: function(response) {
                            trackDesc.token = response;

                            if (track) {
                                track.find('.author').html() != '' ? $addTrack.find('.author').val(track.find('.author').html()) : 0;
                                track.find('.name').html() != '' ? $addTrack.find('.name').val(track.find('.name').html()) : 0;
                                track.find('.remix').html() != '' ? $addTrack.find('.remix').val(track.find('.remix').html()) : 0;
                                track.find('.style').html() != '' ? $addTrack.find('.style').val(track.find('.style').html()) : 0;

                                track.data('download') != '0' ? $addTrack.find('.download').attr('checked', 'checked') : 0;
                                track.data('promocut') != '0' ? $addTrack.find('.cut').attr('checked', 'checked') : 0;
                                track.data('inplaylist') != '0' ? $addTrack.find('.playlist').attr('checked', 'checked') : 0;
                            };

                            $addTrack.css('margin-top', '-' + ($addTrack.outerHeight() / 2) + 'px');
                            $addTrackOverlay.height($(document).height()).show();
                            $addBlockBorderOverlay.css({
                               'width': $addTrack.outerWidth() + 30 + 'px',
                               'height': $addTrack.outerHeight() + 30 + 'px',
                               'margin': -$addTrack.outerHeight() / 2 - 15 + 'px 0 0 ' + (-$addTrack.outerWidth() / 2 - 15) + 'px'
                            }).show();
                            $addTrack.show();
                        }
                    });

                    $addTrack.find('.save').unbind().click(function(event) {
                        event.preventDefault();

                        trackDesc.itemid = release.itemid;
                        trackDesc.typeid = release.typeid;
                        trackDesc.author = secureString($addTrack.find('.author').val());
                        trackDesc.name = secureString($addTrack.find('.name').val());
                        trackDesc.remix = secureString($addTrack.find('.remix').val());
                        trackDesc.musictype = secureString($addTrack.find('.style').val());
                        trackDesc.download = $addTrack.find('.download').attr('checked') ? 1: 0;
                        trackDesc.promocut = $addTrack.find('.cut').attr('checked') ? 1: 0;
                        trackDesc.coverid = releaseCoverId;
                        trackDesc.label = releaseLabel;
                        trackDesc.date_start = releaseDate;

                        if (track) {
                            trackDesc.id = track.data('id');
                            trackDesc.fileid = track.data('fileid');
                            trackDesc.compare = track.data('compare');

                            if (track.data('socialid')) {
                                trackDesc.socialid = track.data('socialid');
                            };

                            if (track.data('stream')) {
                                trackDesc.stream = track.data('stream');
                                trackDesc.sort = $('.b-items > li:visible').length;
                            };
                            
                            if ($addTrack.find('.playlist').attr('checked')) {
                                if (track.data('inplaylist') > 0) {
                                    trackDesc.inplaylist = track.data('inplaylist');
                                } else {
                                    trackDesc.inplaylist = 'new';
                                };

                            } else {
                                if (track.data('inplaylist') > 0) {
                                    trackDesc.inplaylist = 0;
                                    trackDesc.delplay = track.data('inplaylist');
                                    
                                } else {
                                    trackDesc.inplaylist = 0;
                                };
                            };

                        } else {
                            trackDesc.mp3 = mp3;
                            trackDesc.sort = $('.b-items > li:visible').length;
                            trackDesc.inplaylist = $addTrack.find('.playlist').attr('checked') ? 'new' : 0;
                        };


                        $.ajax({
                            type: 'POST',
                            url: '/admin/updatereleaseinner/',
                            data: 'data=' + $.toJSON(trackDesc),
                            success: function(response) {
                                release = $.parseJSON(response);
                                
                                release.errorid ? errorPopup(release.errormessage) : init();

                                $('.g-loader').remove();
                                $('.g-overlay').remove();

                                $addTrackOverlay.hide();
                                $addBlockBorderOverlay.hide();
                                $addTrack.hide();
                            }
                        });
                    });


                    $addTrack.find('.cancel').unbind().click(function(event) {
                        event.preventDefault();
                        $addTrackOverlay.hide();
                        $addBlockBorderOverlay.hide();
                        $addTrack.hide();
                    });
                };
                

                function packJsonAndSend() {
                    $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
                    $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

                    release.release = [];

                    $tracksContainer.find('li:visible').each(function(i) {
                        release.release[i] = {};
                        release.release[i].id = $(this).data('id');
                        release.release[i].compare = $(this).data('compare');
                        release.release[i].active = $(this).find('.hide-item').attr('checked') ? 0 : 1;
                    });

                    release.release.reverse();

                    release.pressrelease = {};
                    release.pressrelease.id = $addPressRelease.data('id') ? $addPressRelease.data('id') : null;
                    release.pressrelease.itemid = $addPressRelease.data('itemid') ? $addPressRelease.data('itemid') : null;
                    release.pressrelease.name = $addPressRelease.find('.press-release-title').val() != '' ? secureString($addPressRelease.find('.press-release-title').val()) : null;
                    release.pressrelease.preview_text = secureString($addPressRelease.find('.text-before').wysiwyg('getContent'));

                    if ($addPressRelease.find('.cut').attr('checked')) {
                        release.pressrelease.incut = 1;
                        release.pressrelease.detail_text = secureString($addPressRelease.find('.text-after').wysiwyg('getContent'));
                        
                    } else {
                        release.pressrelease.incut = 0;
                        release.pressrelease.detail_text = null;
                    };

                    $.ajax({
                        type: 'POST',
                        url: '/admin/updaterelease/',
                        data: 'data=' + $.toJSON(release),
                        success: function(response) {
                            release = $.parseJSON(response);

                            release.errorid ? errorPopup(release.errormessage) : init();

                            $('.g-loader').remove();
                            $('.g-overlay').remove();
                        }
                    });
                };
                

                $addPressReleaseButton.click(function() {
                    $addPressReleaseButton.hide();
                    $addPressRelease.show();

                    $addPressRelease.find('.cut').unbind().click(function() {

                        if ($(this).attr('checked')) {
                            $('.incut-wrap').slideDown(100);

                        } else {
                            $addPressRelease.find('.text-before').val($addPressRelease.find('.text-before').val() + '\n' + $addPressRelease.find('.text-after').val());
                            $addPressRelease.find('.text-after').val('');
                            $('.incut-wrap').slideUp(100);
                        };
                    });
                });

                $cancelPressReleaseButton.click(function() {
                    $addPressRelease.hide();
                    $addPressReleaseButton.show();
                });

                $saveReleaseButton.click(function() {
                    packJsonAndSend();
                });

                
                init();
            });
        }
    })(jQuery);
    
    $().ready(function() {
        $('.b-edit-release').releaseTracks();
    });
</script>