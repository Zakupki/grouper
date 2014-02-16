<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<div class="g-content">
    <div class="b-edit-radioshow">
        <a class="add-radioshow" href="#"><?=$this->registry->trans['add'];?> <?=strtolower($this->registry->trans['radioshow']);?></a>

        <ul class="radioshows">
            <li class="hidden">
                <div class="radioshow-cover">
                    <a href="#"><img width="100" height="100" /></a>
                </div>
                <div class="draggable-area"></div>
                <div class="description">
                    <h3><a  class="name" href="#"></a> <sup></sup></h3>
                    <a class="station"></a>
                    <i class="time"></i>
                    <ul class="techlinks">
                        <li>
                            <label><input class="active" id="" type="checkbox" /><?=$this->registry->trans['hide'];?></label>
                        </li>
                        <li><a href="#" class="delete"><?=$this->registry->trans['delete'];?></a></li>
                        <li><a class="edit" href="#"><?=$this->registry->trans['edit'];?></a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save-radioshows"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>


<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup">
    <div class="captions"><span> <?=$this->registry->trans['title'];?></span><span><?=$this->registry->trans['station'];?></span><span><?=$this->registry->trans['stationlink'];?></span><span><?=$this->registry->trans['duration'];?></span></div>

    <div class="text-inputs" style="margin: -8px 0 0">
        <input class="name" type="text" value="" /><input class="station" type="text" value="" /><input class="link" type="text" value="" /><input class="time" type="text" value="" />
    </div>

    <div class="cover">
            <img src="" />
            <input id="radioshow_upload" name="radioshow_upload" style="display:none;" type="file" />
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
        var radioshows = $.parseJSON('<?=$this->view->radioshow;?>'),
            defaultCoverUrl = '<?=$this->view->defaultcover;?>',
            radioshowsContainer = $('.b-edit-radioshow .radioshows').sortable(),
            addBlock = $('#adding-popup'),
            addBlockOverlay = $('.g-overlay-superblack'),
            addBlockBorderOverlay = $('.g-overlay-border'),
            saveButton = $('.save-radioshows');


        
        $('.add-radioshow').click(function(event) {
            event.preventDefault();
            initEdit();
        });


        
        $('#radioshow_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadimage/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'auto'                          : true,
            'fileExt'                       : '*.jpeg;*.jpg;*.gif;*.png',
            'fileDesc'                  : 'Image Files',
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 140,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                initCrop(response, 2);
            }
        });


        function addRadioshow(id, counter, name, active, station, time, url, link, coverid) {
            var item = radioshowsContainer.find('li.hidden').clone().removeClass('hidden').prependTo('.radioshows');

            if (id) {
                item.attr('id', id);
                item.find('.name').attr('href', '/admin/radioshow/' + id);
                item.find('.radioshow-cover a').attr('href', '/admin/radioshow/' + id);
                item.find('h3 sup').html(counter);
            };

            name ? item.find('.name').html(name) : 0;
            time ? item.find('.time').html(time) : 0;
            station ? item.find('.station').html(station) : 0;
            link ? item.find('.station').attr('href', link) : 0;

            active == '0' ? item.find('.active').attr('checked', 'checked') : 0;

            coverid ? item.find('.radioshow-cover img').attr('rel', coverid) : item.find('.radioshow-cover img').attr('rel', '');
            url ? item.find('.radioshow-cover img').attr('src', url) : item.find('.radioshow-cover img').attr('src', defaultCoverUrl);

            
            item.find('.delete').click(function(event) {
                event.preventDefault();
                
                if (id) {
                    radioshows.deleted ? 0 : radioshows.deleted = {};
                    radioshows.deleted[id] = {};
                    radioshows.deleted[id].id = id;
                };
                
                item.remove()
            });
            
            item.find('.edit').click(function(event) {
                event.preventDefault();
                initEdit(item);
            });
        };



        function initEdit(item) {
            addBlock.find('.cover img').attr('rel', '');
            addBlock.find('.cover img').attr('src', defaultCoverUrl);
            addBlock.find('input:text').val('');

            addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');

            addBlockOverlay.height($(document).height()).show();
            addBlockBorderOverlay.css({
               'width': addBlock.outerWidth() + 30 + 'px',
               'height': addBlock.outerHeight() + 30 + 'px',
               'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
            }).show();
            addBlock.show();

            if (item) {
                addBlock.find('.name').attr('value', item.find('.name').html());
                addBlock.find('.time').attr('value', item.find('.time').html());
                addBlock.find('.cover img').attr('src', item.find('.radioshow-cover img').attr('src'));
                addBlock.find('.cover img').attr('rel', item.find('.radioshow-cover img').attr('rel'));

                item.find('.radioshow-cover img').attr('src') == defaultCoverUrl ? addBlock.find('.delete').hide() : 0;

                addBlock.find('.station').val(item.find('.station').html());
                addBlock.find('.link').val(item.find('.station').attr('href'));
            };


            addBlock.find('.save').unbind().click(function() {
                if (item) {
                    item.find('.name').html(addBlock.find('.name').val());
                    item.find('.time').html(addBlock.find('.time').val());
                    item.find('.radioshow-cover img').attr('rel', addBlock.find('.cover img').attr('rel'));
                    item.find('.radioshow-cover img').attr('src', addBlock.find('.cover img').attr('src'));

                    item.find('.station').html(addBlock.find('.station').val());
                    addBlock.find('.link').val() != '' ? item.find('.station').attr('href', addBlock.find('.link').val()) : item.find('.station').removeAttr('href');
                    
                } else {
                    addRadioshow(
                        null,
                        0,
                        addBlock.find('.name').val() != '' ? addBlock.find('.name').val() : null,
                        1,
                        addBlock.find('.station').val() != '' ? addBlock.find('.station').val() : null,
                        addBlock.find('.time').val(),
                        addBlock.find('.cover img').attr('src'),
                        addBlock.find('.link').val() != '' ? addBlock.find('.link').val() : null,
                        addBlock.find('.cover img').attr('rel') ? addBlock.find('.cover img').attr('rel') : ''
                    );
                };

                packJsonAndSend();

                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
                addBlock.hide();
            });


            addBlock.find('.library').click(function() {
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

            
            addBlock.find('.cancel').click(function() {
                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
                addBlock.hide();
            });
        };



        function packJsonAndSend() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            radioshows.radioshow = [];

            $('.radioshows > li:visible').each(function(i) {
                radioshows.radioshow[i] = {};
                radioshows.radioshow[i].id = $(this).attr('id');
                radioshows.radioshow[i].name =  secureString($(this).find('.name').html());
                radioshows.radioshow[i].active = $(this).find('.active').attr('checked') ? 0 : 1;
                radioshows.radioshow[i].station = secureString($(this).find('.station').html());
                radioshows.radioshow[i].link = $(this).find('.station').attr('href') ? secureString($(this).find('.station').attr('href')) :null;
                radioshows.radioshow[i].time = secureString($(this).find('.time').html());
                radioshows.radioshow[i].coverid = $(this).find('.radioshow-cover img').attr('rel');
                radioshows.radioshow[i].url = $(this).find('.radioshow-cover img').attr('src') != defaultCoverUrl ? $(this).find('.radioshow-cover img').attr('src') : null;
            });

            radioshows.radioshow.reverse();

            $.ajax({
                type: 'POST',
                url: '/admin/updateradioshow/',
                data: 'data=' + $.toJSON(radioshows),
                success: function(response){
                    radioshows = $.parseJSON(response);
                    radioshows.errorid ? errorPopup(radioshows.errormessage) : init();

                    $('.g-loader').remove();
                    $('.g-overlay').remove();
                }
             });
        };

        
        
        saveButton.click(function() { packJsonAndSend() });


        
        function init() {
            $('.radioshows > li:visible').remove();
            
            if (radioshows.radioshow) {
                saveButton.show();
                
                $.each(radioshows.radioshow, function(i, item) {
                    addRadioshow(item.id, item.cnt, item.name, item.active, item.station, item.time, item.url, item.link, item.coverid);
                });
            } else {
                saveButton.hide();
            };
        };



        init();
    });
</script>