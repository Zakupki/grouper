<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->
	
<!-- content (begin) -->
<div class="g-content">
    <div class="b-edit-release">
        <a class="soundcloud" href="#"></a>
        <div class="upload">
            <div class="upload-button"><?=$this->registry->trans['uploadtrack'];?> <b><?=$this->view->releasetype['name'];?></b> (*.mp3)</div>
            <input id="item_upload" name="item_upload" style="display:none;" type="file" />
        </div>

        <ul class="b-items">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a><div class="separator"></div><a href="#" class="edit-item">Редактировать</a><div class="draggable-area"></div>
                </div>

                <img class="preview" src="" width="40" height="40" /><div class="description">
                    <div class="title">
                        <span class="author"></span> -
                        <span class="name"></span>
                        (<span class="remix"></span>)
                    </div>
                    <span class="style" style="background:none;"></span>
                </div>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save-release no-margin"><?=$this->registry->trans['save'];?></button>
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
        <label><input class="download" type="checkbox" /> <?=$this->registry->trans['downloadable'];?></label><label><input class="cut" type="checkbox" /> Promo-cut</label><label><label><input class="playlist" type="checkbox" /> <?=$this->registry->trans['addtoplay'];?></label>
    </div>

    <div class="cover">
            <img src="" />
            <input id="cover_upload" name="cover_upload" style="display:none;" type="file" />
            <a href="#" class="select"><?=$this->registry->trans['uploadcover'];?></a>
            <a href="#" class="library"><?=$this->registry->trans['coverlib'];?></a>
            <a href="#" class="delete"></a>
    </div>

    <div class="b-button-set">
        <button class="save"><?=$this->registry->trans['save'];?></button>
        <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
    </div>
</div>


<div id ="covers-library" style="display:none;">
    <div class="covers">
        <?
            foreach($this->view->coverlist as $cover) {
                echo '<img rel="'.$cover['id'].'" width="100" height="100" src="'.$cover['url'].'"/>';
            }
        ?>
    </div>
    <ul class="pager"></ul>
    <a class="ok" href="#"></a>
    <a class="cancel" href="#"></a>
</div>

<script type="text/javascript">
    $().ready(function() {
        var release = $.parseJSON('<?=$this->view->tracklist;?>'),
            itemsBlock = $('.b-items').sortable(),
            defaultCoverUrl = '<?=$this->view->defaultcover;?>',
            addBlock = $('#adding-popup'),
            addBlockOverlay = $('.g-overlay-superblack'),
            addBlockBorderOverlay = $('.g-overlay-border'),
            saveButton = $('.save-release');
        

        addBlock.find('.style').autocomplete({
            source: '/ajax/musicstyle/',
            minLength: 3,
            position: { offset: '0 -4' }
        });


        // Track upload
        $('#item_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadmp3/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'fileExt'                       : '*.mp3',
            'fileDesc'                  : 'mp3',
            'auto'                          : true,
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 185,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                editTrack(response)
            }
        });


        
        // Cover upload
        $('#cover_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadimage/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'fileExt'                       : '*.jpg;*.jpeg;*.gif;*.png',
            'fileDesc'                  : 'Image Files',
            'auto'                          : true,
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 140,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                initCrop(response, 2);
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
                                addRelease(null, null, response.title, 1, null, 'Original mix', 0, 0, 0, response.musictype, response.cover, null, null, response.socialid, response.stream);
                            };

                            $.popup.close();
                        }
                    );
                }
            });
        });


        
        function addRelease(id, fileid, name, active, author, remix, promocut, download, inplaylist, musictype, cover, coverid, mp3, socialid, stream) {
            var releaseTrack = itemsBlock.find('li.hidden').clone().removeClass('hidden').prependTo(itemsBlock);

            releaseTrack.data('id', id);
            
            if (fileid) {
                releaseTrack.data('fileid', fileid);
            };

            if (mp3) {
                releaseTrack.data('mp3', mp3);
            };

            if (socialid) {
                releaseTrack.data('socialid', socialid);
            };

            if (stream) {
                releaseTrack.data('stream', stream);
            };

            releaseTrack.find('.name').html(name);
            releaseTrack.find('.author').html(author);
            releaseTrack.find('.remix').html(remix);
            releaseTrack.find('.style').html(musictype);
            releaseTrack.data('promocut', promocut);
            releaseTrack.data('download', download);

            if (inplaylist) {
                releaseTrack.data('inplaylist', inplaylist);
            };

            cover ? releaseTrack.find('.preview').attr('src', cover) : releaseTrack.find('.preview').attr('src', defaultCoverUrl);

            if (coverid) {
                releaseTrack.find('.preview').attr('rel', coverid);
            };

            if (active == '0') {
                releaseTrack.find('.hide-item').attr('checked', 'checked');
            };

            releaseTrack.find('.delete-item').click(function(event) {
                event.preventDefault();

                if (id) {
                    release.deleted ? 0 : release.deleted = {};
                    release.deleted[id] = {};
                    release.deleted[id]['id'] = id;
                    release.deleted[id]['fileid'] = fileid;
                };

                releaseTrack.remove();
            });

            releaseTrack.find('.edit-item').click(function(event) {
                event.preventDefault();
                editTrack('', releaseTrack);
            });
        };

        function editTrack(mp3, track) {
            addBlock.find('.author').val('<?=$this->view->author;?>');
            addBlock.find('.name').val('');
            addBlock.find('.remix').val('Original mix');
            addBlock.find('.style').val('');

            addBlock.find('.cover img').attr('rel', '');
            addBlock.find('.cover img').attr('src', defaultCoverUrl);
            addBlock.find('.delete').hide();

            addBlock.find('.options input').removeAttr('checked');

            addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');

            addBlockOverlay.height($(document).height()).show();
            addBlockBorderOverlay.css({
               'width': addBlock.outerWidth() + 30 + 'px',
               'height': addBlock.outerHeight() + 30 + 'px',
               'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
            }).show();
            addBlock.show();

            if (track) {
                addBlock.find('.author').val(track.find('.author').html());
                addBlock.find('.name').val(track.find('.name').html());
                addBlock.find('.remix').val(track.find('.remix').html());
                addBlock.find('.style').val(track.find('.style').html());

                track.data('promocut') == '1' ? addBlock.find('.cut').attr('checked', 'checked') : 0;
                track.data('download') == '1' ? addBlock.find('.download').attr('checked', 'checked') : 0;
                track.data('inplaylist') ? addBlock.find('.playlist').attr('checked', 'checked') : addBlock.find('.playlist').removeAttr('checked');

                addBlock.find('.style').val(track.find('.style').html());
                

                if (track.find('.preview').attr('src') && track.find('.preview').attr('src') != defaultCoverUrl) {
                    addBlock.find('.cover img').attr('src', track.find('.preview').attr('src'));

                    if (track.find('.preview').attr('rel') && track.find('.preview').attr('rel') != '') {
                        addBlock.find('.cover img').attr('rel', track.find('.preview').attr('rel'));
                    };

                    addBlock.find('.delete').show();
                };
            };

            addBlock.find('.cancel').unbind().click(function(event) {
                event.preventDefault();
                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
                addBlock.hide();
            });

             addBlock.find('.library').unbind().click(function(event) {
                event.preventDefault();
                 
                 var rel = addBlock.find('.cover img').attr('rel') ? addBlock.find('.cover img').attr('rel') : '';
                    src = addBlock.find('.cover img').attr('src');

                coversLibraryInit(rel, src);
             });

            addBlock.find('.delete').unbind().click(function(event) {
                event.preventDefault();
                addBlock.find('.cover img').attr('rel', '');
                addBlock.find('.cover img').attr('src', defaultCoverUrl);
                $(this).hide();
             });

            addBlock.find('.save').unbind().click(function(event) {
                event.preventDefault();

                if (track) {
                    track.find('.author').html(addBlock.find('.author').val());
                    track.find('.name').html(addBlock.find('.name').val());
                    track.find('.remix').html(addBlock.find('.remix').val());
                    track.find('.style').html(addBlock.find('.style').val());

                    addBlock.find('.cut').attr('checked') ? track.data('promocut', '1') : track.data('promocut', '0');
                    addBlock.find('.download').attr('checked') ? track.data('download', '1') : track.data('download', '0');

                    if (addBlock.find('.playlist').attr('checked')) {
                        if (!track.data('inplaylist')) {
                            track.data('inplaylist', 'new');
                        };

                    } else {
                        if (track.data('inplaylist')) {

                            release.delplay ? 0 : release.delplay = {};
                            release.delplay[track.data('inplaylist')] = track.data('inplaylist');

                            track.data('inplaylist', null);
                        } else {
                            track.data('inplaylist', null);
                        }
                    };

                    track.find('.preview').attr('src', addBlock.find('.cover img').attr('src'));
                    track.find('.preview').attr('rel', addBlock.find('.cover img').attr('rel'));

                } else {
                    addRelease(
                        '',
                        null,
                        addBlock.find('.name').val(),
                        1,
                        addBlock.find('.author').val(),
                        addBlock.find('.remix').val(),
                        addBlock.find('.cut').attr('checked') ? 1 : 0,
                        addBlock.find('.download').attr('checked') ? 1 : 0,
                        addBlock.find('.playlist').attr('checked') ? 'new' : null,
                        addBlock.find('.style').val(),
                        addBlock.find('.cover img').attr('src'),
                        addBlock.find('.cover img').attr('rel'),
                        mp3
                    );
                };

                packJsonAndSend();

                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
                addBlock.hide();
            });
        };




        
         function packJsonAndSend() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            release.tracks = [];

            itemsBlock.find('li:visible').each(function(i) {
                release.tracks[i] = {};

                release.tracks[i].id = $(this).data('id');

                if ($(this).data('fileid')) {
                    release.tracks[i].fileid = $(this).data('fileid');
                };

                if ($(this).data('mp3')) {
                    release.tracks[i].url = $(this).data('mp3');
                };

                if ($(this).data('stream')) {
                    release.tracks[i].stream = $(this).data('stream');
                };

                if ($(this).data('socialid')) {
                    release.tracks[i].socialid = $(this).data('socialid');
                };

                release.tracks[i].releasetypeid = release.typeid;
                release.tracks[i].name = secureString($(this).find('.name').html());
                release.tracks[i].author = secureString($(this).find('.author').html());
                release.tracks[i].remix = secureString($(this).find('.remix').html());
                release.tracks[i].musictype = secureString($(this).find('.style').html());
                release.tracks[i].download = $(this).data('download');
                release.tracks[i].promocut = $(this).data('promocut');
                release.tracks[i].inplaylist = $(this).data('inplaylist') ? $(this).data('inplaylist') : null;
                release.tracks[i].active = $(this).find('.hide-item').attr('checked') ? 0 : 1;
                release.tracks[i].coverid = $(this).find('.preview').attr('rel') ? $(this).find('.preview').attr('rel') : null;
                release.tracks[i].cover = $(this).find('.preview').attr('src') == defaultCoverUrl ? '' : $(this).find('.preview').attr('src');
            });

             release.tracks.reverse();
             
            $.ajax({
                type: 'POST',
                url: '/admin/updatetracks/',
                data: 'data=' + $.toJSON(release),
                success: function(response) {
                    release = $.parseJSON(response);
                    release.errorid ? errorPopup(release.errormessage) : init();

                    $('.g-loader').remove();
                    $('.g-overlay').remove();
                }
             });
         };


        saveButton.click(function() {
            packJsonAndSend();
        });


        
        function init() {
            itemsBlock.find('li:visible').remove();

            if (release.tracks) {
                saveButton.show();

                $.each(release.tracks, function(i, item) {
                    addRelease(item.id, item.fileid, item.name, item.active, item.author, item.remix, item.promocut, item.download, item.inplaylist, item.musictype, item.cover, item.coverid);
                });

            } else {
                saveButton.hide();
            };
        };

        init();
    });
</script>