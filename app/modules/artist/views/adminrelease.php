<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->
	
<!-- content (begin) -->
<div class="g-content">
    <div class="b-edit-releases">
        <span class="beatport"></span><a class="add-button" href="#"><?=$this->registry->trans['addrelease'];?></a>
        
        <ul class="releases">
            <li class="hidden">
                <div class="radioshow-cover">
                    <a><img width="100" height="100" /></a>
                </div>
                <div class="draggable-area"></div>
                <div class="description">
                    <h3><span></span> - <a><i></i></a> <sup></sup></h3>
                    <span class="remixes"><span>Remixes: </span> </span>
                    <ul class="infolinks">
                        <li class="style"></li>
                        <li class="date"></li>
                        <li class="label"></li>
                    </ul>
                    <ul class="techlinks">
                        <li>
                            <label>
                                <input class="active" id="" type="checkbox" /><?=$this->registry->trans['hide'];?>
                            </label>
                        </li>
                        <li><a href="#" class="delete"><?=$this->registry->trans['delete'];?></a></li>
                        <li><a class="edit" href="#"><?=$this->registry->trans['edit'];?></a></li>
                    </ul>
                </div>
            </li>
        </ul>
        
        <div class="b-button-set">
            <button class="save-releases"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->


<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup">
    <span class="label-author"><?=$this->registry->trans['author'];?></span><span class="label-name"><?=$this->registry->trans['title'];?></span><span class="label-label">Label</span>

    <div>
        <input class="author" type="text" /><input class="name" type="text" /><input class="label" type="text" />

        <div class="date">
            <a href="#" class="picker"><?=$this->registry->trans['date'];?></a>
            <input type="text" class="datepicker with-bg" value="" readonly="readonly" />
        </div>
    </div>

    <span class="label-stores">
    	<? if($this->Session->Site['languageid']==1){?>
    	Ссылки на интернет-магазины с этим релизом (url)
    	<?}else{?>
    		Online-stores links
    	<?}?>
    </span>
    <input class="store store-one" type="text" /><input class="store store-two" type="text" /><input class="store store-three" type="text" /><input class="store store-four" type="text" />

    <div class="cover">
            <img src="" />
            <input id="release_upload" name="release_upload" style="display:none;" type="file" />
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
         var releases = $.parseJSON('<?=$this->view->release;?>'),
            defaultCoverUrl = '<?=$this->view->defaultcover;?>',
            releasesList = $('.b-edit-releases .releases').sortable(),
            addBlock = $('#adding-popup'),
            addBlockOverlay = $('.g-overlay-superblack'),
            addBlockBorderOverlay = $('.g-overlay-border'),
            saveAllReleases = $('.save-releases');

        
        // Uploadify
        $('#release_upload').uploadify({
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


        $('.beatport').click(function() {
            $.confirm({
                'content': '<i class="label-soundcloud"><?=$this->registry->trans['beatportlink'];?></i><input class="input-soundcloud" type="text" />',
                'ok': function() {
                    var beatportUrl = encodeURIComponent(($('.input-soundcloud').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0'));

                    $.popup.hideWindow();
                    $.popup.showLoading();

                    $.post(
                        '/file/checksocialfolder/',
                        'url=' + beatportUrl + '&socialid=198' ,
                        function(response) {
                            response = $.parseJSON(response);

                            if (response.error) {
                                $.alert({
                                    content: response.status
                                });
                                return;

                            } else {
                                $.popup.close();
                                $.confirm({
                                    text: response.status,
                                    ok: function() {
                                        $.popup.hideWindow();
                                        $.popup.showLoading();

                                        $.post(
                                            '/file/getsocialfolder/',
                                            'url=' + beatportUrl + '&socialid=198',
                                            function(response) {
                                                response = $.parseJSON(response);

                                                if (response.error) {
                                                    $.alert({
                                                        content: response.status
                                                    });
                                                    return;
                                                };

                                                $.alert({
                                                    content: response.status,
                                                    ok: function() {
                                                        $.popup.close();
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                        );
                                    }
                                });
                            };
                        }
                    );
                }
            });
        })


        $('.add-button').click(function(event) {
            event.preventDefault();
            editRelease();
        });
        
        
        // Calendar
        function calendarInit() {
            $('.datepicker').datepicker({
                dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                firstDay:1,
                dateFormat: 'dd.mm.yy'
            });
            $('.picker').click (function(event) {
                event.preventDefault;
                $('.datepicker').datepicker('show');
            });
        };

        
        function addRelease(id, cnt, name, active, author, date_start, label, coverid, url, musictypes, remix, compare, compare2) {
            var item = $('.releases .hidden').clone().removeClass('hidden').insertBefore('.releases > li:first-child');

            item.data('id', id);
            item.find('h3 a').attr('href', '/admin/release/' + id);
            item.find('.radioshow-cover a').attr('href', '/admin/release/' + id);
            item.data('compare', compare);
            item.data('compare2', compare2);
            item.find('sup').html(cnt);
            item.find('.date').html(date_start);

            name ? item.find('h3 i').html(name) : 0;
            author ? item.find('h3 span').html(author) : 0;
            active == '0' ? item.find('.active').attr('checked', 'checked') : 0;
            coverid ? item.find('.radioshow-cover img').attr('rel', coverid) : 0;
            url ? item.find('.radioshow-cover img').attr('src', url) : 0;

            if (label) {
                item.find('.label').html(label);
            } else {
                item.find('.label').hide();
            };

            if (musictypes) {
                item.find('.style').html(musictypes);
            } else {
                item.find('.style').remove();
            };

            if (remix) {
                item.find('.remixes span').after(remix);
            } else {
                item.find('.remixes').hide();
            };
            
            item.find('.edit').click(function(event) {
                event.preventDefault();
                editRelease(item);
            });

            item.find('.delete').click(function(event) {
                event.preventDefault();

                releases.deleted ? 0 : releases.deleted = {};
                releases.deleted[id] = {};
                releases.deleted[id]['id'] = id;

                item.remove();
            });
        };





        function editRelease(item) {
            addBlock.find('.cover .delete').unbind().click(function(event) {
                event.preventDefault();
                addBlock.find('.cover img').attr('src', defaultCoverUrl).attr('rel', '');
                $(this).hide();
            }).hide();

            addBlock.find('input').val('');
            addBlock.find('.store').removeData();
            addBlock.find('.cover img').attr('src', defaultCoverUrl).attr('rel', '');
            
            calendarInit();
            
            addBlock.find('.library').click(function(event) {
                event.preventDefault();
                
                var rel = addBlock.find('.cover img').attr('rel') ? addBlock.find('.cover img').attr('rel') : '';
                    src = addBlock.find('.cover img').attr('src');

                coversLibraryInit(rel, src);
            });

            addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');
            addBlockOverlay.height($(document).height()).show();
            addBlockBorderOverlay.css({
               'width': addBlock.outerWidth() + 30 + 'px',
               'height': addBlock.outerHeight() + 30 + 'px',
               'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
            }).show();
            addBlock.show();

            var itemLinks = {};

            $.ajax({
                type: "POST",
                url: "/admin/getreleaselinks/",
                data: item ? 'id=' + item.data('id') : null,
                success: function(links) {

                    itemLinks = $.parseJSON(links);

                    if (itemLinks.links) {
                        $.each(itemLinks.links, function(i, link) {

                            var linkInput = addBlock.find('.store:eq(' + i + ')');

                            linkInput.val(link.url);
                            linkInput.data('id', link.id);
                            linkInput.data('socialid', link.socialid);
                            linkInput.data('releasetypeid', link.releasetypeid);
                            linkInput.data('compare', link.compare);
                        });
                    };
                }
             });
            
            if (item) {
                addBlock.find('.author').val(item.find('h3 span').html());
                addBlock.find('.name').val(item.find('h3 i').html());
                addBlock.find('.label').val(item.find('.label').html());
                addBlock.find('.date .datepicker').val(item.find('.date').html());
                addBlock.find('.cover img').attr('rel', item.find('.radioshow-cover img').attr('rel'));
                addBlock.find('.cover img').attr('src', item.find('.radioshow-cover img').attr('src'));


                item.find('.radioshow-cover img').attr('rel') != defaultCoverUrl ? addBlock.find('.cover .delete').show() : 0;
                
            } else {
                
                var cT = new Date();
                addBlock.find('.date .datepicker').val((String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate()) + '.' + (cT.getMonth() + 1) + '.' + cT.getFullYear());
                
            };

            
            addBlock.find('.cancel').unbind().click(function() {
                addBlock.hide();
                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
            });


            addBlock.find('.save').unbind().click(function() {
                if (item) {
                    item.data('id') ? itemLinks.id = item.data('id') : 0;
                    item.data('compare') ? itemLinks.compare = item.data('compare') : 0;
                    item.data('compare2') ? itemLinks.compare2 = item.data('compare2') : 0;

                } else {
                    itemLinks.sort = releasesList.find('li:visible').length;
                }

                itemLinks.author = secureString(addBlock.find('.author').val());
                itemLinks.name = secureString(addBlock.find('.name').val());
                itemLinks.label = secureString(addBlock.find('.label').val());
                itemLinks.date_start = addBlock.find('.date .datepicker').val();
                itemLinks.url = addBlock.find('.cover img').attr('src') != defaultCoverUrl ? addBlock.find('.cover img').attr('src') : null;
                itemLinks.coverid = addBlock.find('.cover img').attr('rel');
                
                itemLinks.links = {};
                addBlock.find('.store').each(function(i) {
                    if ($(this).val() != '') {
                        itemLinks.links[i] = {};
                        itemLinks.links[i].url = secureString($(this).val());
                        itemLinks.links[i].id = $(this).data('id');
                        itemLinks.links[i].socialid = $(this).data('socialid');
                        itemLinks.links[i].releasetypeid = $(this).data('releasetypeid');
                        itemLinks.links[i].compare = secureString($(this).data('compare'));
                    };
                });

                $.ajax({
                    type: 'POST',
                    url: '/admin/updatereleasetypeinner/',
                    data: 'data=' + $.toJSON(itemLinks),
                    success: function(response) {
                        releases = $.parseJSON(response);
                        releases.errorid ? errorPopup(response.errormessage) : init();

                        addBlockOverlay.hide();
                        addBlockBorderOverlay.hide();
                        addBlock.hide();
                    }
                });
            });
        };
        
        
        function packJsonAndSend() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            releases.release = [];

            releasesList.find('li:visible').each(function(i) {
                releases.release[i] = {};
                releases.release[i].id = $(this).data('id');
                releases.release[i].compare = $(this).data('compare');
                releases.release[i].active = $(this).find('.active').attr('checked') ? 0 : 1;
            });

            releases.release.reverse();

            $.ajax({
                type: 'POST',
                url: '/admin/updatereleasetype/',
                data: 'data=' + $.toJSON(releases),
                success: function(response) {
                    releases = $.parseJSON(response);
                    releases.errorid ? errorPopup(releases.errormessage) : init();

                    $('.g-loader').remove();
                    $('.g-overlay').remove();
                }
             });
        };


         function init() {
            releasesList.find('li:visible').remove();

            if (releases.release) {
                saveAllReleases.show();

                $.each(releases.release, function(i, item) {
                    addRelease(item.id, item.cnt, item.name, item.active, item.author, item.date_start, item.label, item.coverid, item.url, item.musictypes, item.remix, item.compare, item.compare2, item.majorcover);
                });
                
            } else {
                saveAllReleases.hide();
            }
        };


        saveAllReleases.click(function() { packJsonAndSend(); });

        
        init();
    });
</script>