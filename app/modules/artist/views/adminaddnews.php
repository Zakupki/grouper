<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-news-add">
        <div class="b-news-text">
            <div class="lang">

                <i><?=$this->registry->trans['title'];?></i>
                <input class="title" type="text" />
                <div class="date">
                    <a href="#" class="picker"><?=$this->registry->trans['date'];?></a>
                    <input type="text" class="datepicker with-bg" value="00.00.0000" readonly="readonly" />
                </div>

                <i class="caption-text-before"><?=$this->registry->trans['text'];?> (<?=$this->registry->trans['beforeinc'];?>)</i>
                <textarea class="text-before"></textarea>

                <div class="incut-wrap">
                    <div class="incut">
                        <img src="/img/artist/admin/bg-incut-userpic.png" width="100" height="100" />
                        <span>Подобным образом оформляется Ваша публикация. Вы имеете возможность отмечать лучшие комментарии, которые попадают в “врез”. Если отмечено несколько комментариев, то они поочередно сменяют друг-друга. </span>
                        <a href="#">Super Star</a>
                    </div>
                    <i class="caption-text-after"><?=$this->registry->trans['text'];?> (<?=$this->registry->trans['afterinc'];?>)</i>
                    <textarea class="text-after"></textarea>
                </div>

                <label><input class="cut" type="checkbox" /><?=$this->registry->trans['incnews'];?></label>

                <i><?=$this->registry->trans['tags'];?> (<?=$this->registry->trans['withcomma'];?>)</i>
                <input class="tags" type="text" />

                <i><?=$this->registry->trans['videlink'];?> (http://www.youtube.com/...)</i>
                <input class="youtube" type="text" />
            </div>
        </div>


        <div class="b-news-photos">
                <div class="upload-news-image">
                    <div class="upload-button"><?=$this->registry->trans['uploadpicture'];?></div>
                    <input id="upload-news-image" name="cover_upload" style="display:none;" type="file" />
                </div>

                <ul class="b-photos">
                    <li class="hidden"><img class="image" width="220" height="100" /><a class="delete" href="#"></a></li>
                </ul>
        </div>

        
        <div class="b-news-tracks">
            <div class="upload-button"><?=$this->registry->trans['addtracktonews'];?></div>
            
            <div class="select-track">
                <div class="b-button-set">
                    <button class="save" style="padding: 9px 24px 11px 23px"><?=$this->registry->trans['add'];?></button>
                    <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
                </div>

                <select id="tracksList">
                    <? foreach($this->view->releaselist as $typekey=>$releasetype){ ?>
                        <option value="" disabled="disabled"><?=$releasetype['name'];?></option>
                        <? if (is_array($releasetype['releases']))
                            foreach($releasetype['releases'] as $release) { ?>
                                <option value="<?=$release['id'];?>" rel="6">&nbsp;&nbsp;<?=$release['name']?></option>
                            <? } ?>
                    <? } ?>
                </select>
            </div>

            <ul class="b-tracks">
                <li class="hidden">
                    <div class="options">
                        <a href="#" class="delete-item"><?=$this->registry->trans['deletefromnews'];?></a><div class="draggable-area"></div>
                    </div>

                    <img class="preview" src="" width="40" height="40" alt=""><div class="description">
                        <div class="title">
                            <span class="author"></span> -
                            <span class="name"></span>
                            (<span class="remix"></span>)
                        </div>
                        <span class="date"></span><i class="label"></i>
                    </div>
                </li>
            </ul>
        </div>

        <div class="b-button-set">
            <button class="save"><?=$this->registry->trans['save'];?></button>
            <label><input class="hide-item" type="checkbox" checked="checked"> <?=$this->registry->trans['hide'];?></label>
        </div>
    </div>
</div>
<!-- content (end)-->
        
<script type="text/javascript">
    $().ready(function() {
        var news = $.parseJSON('<?=$this->view->newsinner;?>'),
            imagesBlock  = $('.b-news-photos .b-photos').sortable(),
            tracksBlock  = $('.b-news-tracks .b-tracks').sortable(),
            uploadTrackButton = $('.b-news-tracks .upload-button'),
            selectTrackBlock = $('.b-news-tracks .select-track'),
            saveButton = $('.b-button-set .save'),
            firstTimeSaving = 0;

        
        $('#upload-news-image').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : encodeURIComponent('/file/uploadnewsimage/?w=580&h=220'),
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp/',
            'auto'                          : true,
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 260,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                console.log(response);

                var uploadedImage = $.parseJSON(response);

                if (uploadedImage.small) {
                    $.confirm({
                        text: uploadedImage.status,
                        ok: function() {
                            initNewsCrop(uploadedImage.url);
                            $.popup.close();
                        }
                    });

                } else {
                    initNewsCrop(uploadedImage.url);
                };
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

        // Adding image
        function addNewsImage(url, id, itemid) {
            var item = $('.b-photos > li.hidden').clone().removeClass('hidden').appendTo('.b-photos');

            item.data('id', id);
            item.data('itemid', itemid);
            item.find('.image').attr('src', url);
            item.find('.delete').click(function() {
                news.deleted ? 0 : news.deleted = {};
                news.deleted[id] = {};
                news.deleted[id].id = id;
                news.deleted[id].itemid = itemid;
                news.deleted[id].url = url;

                item.remove();
            });
        };


         // Adding track
        function addTrack(id, releaseTypeId, dataTypeId, linkId, name, author, remix, coverUrl, label, date) {
            var releaseTrack = $('.b-tracks > li.hidden').clone().removeClass('hidden').appendTo('.b-tracks');

            releaseTrack.data('id', id);
            releaseTrack.data('releaseTypeId', releaseTypeId);
            releaseTrack.data('dataTypeId', dataTypeId);
            releaseTrack.data('linkId', linkId);

            releaseTrack.find('.name').html(name);
            releaseTrack.find('.author').html(author);
            releaseTrack.find('.remix').html(remix);
            releaseTrack.find('.label').html(label);
            releaseTrack.find('.date').html(date);

            releaseTrack.find('.preview').attr('src', coverUrl);

            releaseTrack.find('.delete-item').click(function(event) {
                event.preventDefault();

                news.tracksdeleted ? 0 : news.tracksdeleted = {};
                news.tracksdeleted[id] = {};
                news.tracksdeleted[id].linkid = linkId;

                releaseTrack.remove();
            });
        };


        // Crop
        function initNewsCrop(imageUrl) {
            var overlayBlock = $('<div></div>').addClass('g-overlay').css({'height': $(window).height(), 'width': $(window).width()}).appendTo('body'),
                cropBlock = $('<div></div>').addClass('g-crop').appendTo('body').hide(),
                cropTarget = $('<img />').attr('src', imageUrl).appendTo(cropBlock),
                cropJson = {},
                scale = 1,
                maxImgWidth = document.documentElement.clientWidth - 150,
                maxImgHeight = document.documentElement.clientHeight - 150,
                cropHeight = 220,
                cropWidth = 580,
                cropRatio = 2.64;

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
                    setSelect: [cropWidth * scale, cropHeight * scale, 0, 0],
                    minSize: [cropWidth * scale, cropHeight * scale],
                    onChange: function (c) {
                        cropJson.url = imageUrl;
                        cropJson.x = c.x;
                        cropJson.y = c.y;
                        cropJson.width = c.w;
                        cropJson.height = c.h;
                        cropJson.size = 1;
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
                            addNewsImage(croppedImageUrl);
                            cropBlock.remove();
                            overlayBlock.remove();
                        }
                    );
                });

                // Cancel crop
                $('<a href="#"></a>').addClass('cancel').appendTo(cropBlock).click(function(event) {
                    event.preventDefault();
                    cropBlock.remove();
                    overlayBlock.remove();
                });
            });
        };

        
        // Incut onclick
        $('.cut').click(function() {
            var captionBefore = $('.caption-text-before'),
                incutWrap = $('.incut-wrap');

            if ($(this).attr('checked')) {
                captionBefore.find('span').html('Текст новости (до вреза)');
                incutWrap.slideDown();

            } else {
                captionBefore.find('span').html('Текст новости');
                incutWrap.slideUp();
            };
        });


        // Inputs validation
        function validateInputs() {
            var titleChecked = false,
                textareaChecked = false;

            titleChecked = $('.title').val() != '' ? true : false;
            textareaChecked = $('.text-before').wysiwyg('getContent') != '' ? true : false;

            if (titleChecked && textareaChecked) {
                saveButton.removeClass('disabled').removeAttr('disabled');
                return true;

            } else {
                saveButton.addClass('disabled').attr('disabled','disabled');
                return false;
            };
        };


        // Tracks adding
        uploadTrackButton.click(function() {
            $(this).hide();
            selectTrackBlock.show();
        });
        selectTrackBlock.find('.cancel').click(function() {
            selectTrackBlock.hide();
            uploadTrackButton.show();
        });
        selectTrackBlock.find('.save').click(function() {
            var trackId = $('#tracksList option:selected').val(),
                typeId = $('#tracksList option:selected').attr('rel');

            if (trackId != '') {
                var trackData = {};

                trackData.id = trackId;
                trackData.datatypeid = typeId;

                $('<div></div>').addClass('g-overlay').css({'height' : $(window).height(), 'width' : $(window).width()}).appendTo('body');
                $('<div></div>').addClass('g-loader').css({'top' : $(window).height() / 2 - 20, 'left' : $(window).width() / 2 - 20}).appendTo('body');

                $.ajax({
                    type: 'POST',
                    url: '/ajax/releaseinfo/',
                    data: 'data=' + $.toJSON(trackData),
                    success: function(response) {
                        newTrack = $.parseJSON(response);

                        addTrack(newTrack.id, newTrack.releasetypeid, newTrack.datatypeid, newTrack.linkid, newTrack.name, newTrack.author, newTrack.remix, newTrack.url, newTrack.label, newTrack.date_start)

                        selectTrackBlock.hide();
                        uploadTrackButton.show();
                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    }
                 });
            };
        });


        // Saving
        saveButton.click(function() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            if (1 /*validateInputs()*/) {
                news.news = {};

                $('.lang').each(function(i) {
                    news.news.id = $(this).data('id');
                    news.news.itemid = $(this).data('itemid');
                    news.news.date_start = $(this).find('.datepicker').val();
                    news.news.name = $(this).find('.title').val() ? secureString($(this).find('.title').val()) : '';
                    news.news.preview_text = secureString($(this).find('.text-before').wysiwyg('getContent'));

                    if ($(this).find('.cut').attr('checked')) {
                        news.news.incut = 1;
                        news.news.detail_text = secureString($(this).find('.text-after').wysiwyg('getContent'));
                    } else {
                        news.news.incut = 0;
                    };

                    news.news.tags = $(this).find('.tags').val() ? secureString($(this).find('.tags').val()) : '';

                    news.news.video = secureString($(this).find('.youtube').val());
                    news.news.active = $('.hide-item').attr('checked') ? 0 : 1;
                });

                news.images = {};
                $('.b-photos > li:visible').each(function(i) {
                    news.images[i] = {};
                    news.images[i].id = $(this).data('id');
                    news.images[i].itemid = $(this).data('itemid');
                    news.images[i].url = $(this).find('img').attr('src');
                });

                news.tracks = {};
                $('.b-tracks > li:visible').each(function(i) {
                    news.tracks[i] = {};
                    news.tracks[i].id = $(this).data('id');
                    news.tracks[i].itemid = news.itemid;
                    news.tracks[i].releasetypeid = $(this).data('releaseTypeId');
                    news.tracks[i].datatypeid = $(this).data('dataTypeId');

                    if ($(this).data('linkId')) {
                        news.tracks[i].linkid = $(this).data('linkId');
                    };
                });


                $.ajax({
                    type: 'POST',
                    url: '/admin/updatenewsinner/',
                    data: 'data=' + $.toJSON(news),
                    success: function (response) {
                        news = $.parseJSON(response);

                        if (news.errorid) {
                            errorPopup(news.errormessage);

                        } else {
                            firstTimeSaving == 1 ? document.location.href = '/admin/news/' + news.itemid : init();
                        };

                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    }
                 });
            };
        });
        

        // Init
        function init() {
            var datePicker = $('.datepicker');

            //$('.title').val('').unbind().keyup(function() { validateInputs(); });

            $('.b-photos > li:visible').remove();
            $('.b-b-tracks > li:visible').remove();
            $('.youtube').val('');

            var cT = new Date(),
                cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
                cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
                cYear = cT.getFullYear();

            datePicker.val(cDay + '.' + cMonth + '.' + cYear);

            
            if (news.itemid) {
                var langItem = $('.lang');

                langItem.find('.title').val(news.news.name);
                langItem.find('.text-before').wysiwyg('setContent', news.news.preview_text);
                langItem.find('.text-after').wysiwyg('setContent', news.news.detail_text);
                langItem.find('.tags').val(news.news.tags);

                if (news.news.incut == '1') {
                    langItem.find('.cut').attr('checked', 'checked');
                    langItem.find('.incut-wrap').slideDown();
                };

                langItem.data('id', news.news.id);
                langItem.data('itemid', news.news.itemid);

                if (news.news.date_start) {
                    datePicker.val(news.news.date_start);
                };

                if (news.news.video) {
                    langItem.find('.youtube').val(news.news.video)
                };

                if (news.images) {
                    $.each(news.images, function(i, item) {
                        addNewsImage(item.url, item.id, item.itemid);
                    });
                };
                
                if (news.tracks) {
                    $.each(news.tracks, function(i, item) {
                        addTrack(item.id, item.releasetypeid, item.datatypeid, item.linkid, item.name, item.author, item.remix, item.url, item.label, item.date_start)
                    });
                };

                news.news.active == '1' ? $('.hide-item').removeAttr('checked') : $('.hide-item').attr('checked', 'checked');

            } else {
                firstTimeSaving = 1;
            };


            datePicker.datepicker({
                firstDay:1,
                dateFormat: 'dd.mm.yy'
            });

            $('.date .picker').click(function(event) {
                event.preventDefault();
                datePicker.datepicker('show');
            });
        };
        
        
        init();
    });
</script>