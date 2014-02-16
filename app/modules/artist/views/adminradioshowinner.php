<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<div class="g-content">
    <div class="b-radioshow-inner">
        <a class="soundcloud" href="#"></a>
        <div class="upload">
            <div class="upload-button"><?=$this->registry->trans['uploadradioep'];?> (*.mp3)</div>
            <input id="item_upload" name="item_upload" style="display:none;" type="file" />
        </div>
        
         <ul class="items">
                <li class="hidden">
                    <div class="options">
                        <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a><div class="separator"></div><a href="#" class="edit-item"><?=$this->registry->trans['edit'];?></a><div class="draggable-area"></div>
                    </div>
                    <img class="preview" src="" width="40" height="40" alt=""><div class="description">
                        <div class="title"><?=$this->view->sitename;?> &#151 <?=tools::tojs($this->view->radioshowtype['radioshowtypename']);?> #<span class="number"></span> <span class="comment-wrap">(<span class="comment"></span>)</span></div>
                        <i class="date"></i>
                    </div>
                </li>
         </ul>
        
        <div class="b-button-set">
            <button class="save save-all"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>


<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup">
    <div>
        <span class="label-number">№</span><span class="label-comment"><?=$this->registry->trans['shortcomment'];?></span>
    </div>
    <input class="number" type="text" />
    <input class="comment" type="text" />
    <div class="date">
        <a href="#" class="picker"><?=$this->registry->trans['date'];?></a>
        <input type="text" class="datepicker with-bg" value="" readonly="readonly" />
    </div>

    <div class="checkboxes">
        <label>
            <input type="checkbox" class="downloadable" /><?=$this->registry->trans['downloadable'];?>
        </label><label>
            <input type="checkbox" class="in-playlist" /><?=$this->registry->trans['addtoplay'];?>
            <!--a class="help" href="#"></a-->
        </label>
    </div>

    <div class="b-button-set">
        <button class="save"><?=$this->registry->trans['save'];?></button>
        <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
    </div>
</div>

<script type="text/javascript">
    $().ready(function() {
        var items = $.parseJSON('<?=$this->view->radioshowlist;?>'),
            itemsBlock = $('.b-radioshow-inner .items').sortable(),
            addBlock = $('#adding-popup'),
            addBlockOverlay = $('.g-overlay-superblack'),
            addBlockBorderOverlay = $('.g-overlay-border'),
            radioshowTypeId = <?=$this->view->radioshowtype['typeid'];?>,
            radioshowName = '<?=tools::tojs($this->view->radioshowtype['radioshowtypename']);?>',
            radioshowUrl = '<?=tools::tojs($this->view->radioshowtype['url']);?>',
            radioshowCoverId = <?=$this->view->radioshowtype['coverid'];?>,
            saveButton = $('.save-all');


        $('#item_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadmp3/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'auto'                          : true,
            'fileExt'                       : '*.mp3',
            'fileDesc'                  : 'mp3',
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 265,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                initEdit(null, response);
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
                                addItem(null, null, null, response.title, null, 1, response.date_create, 0, null, 0, response.stream, response.socialid);
                            };

                            $.popup.close();
                        }
                    );
                }
            });
        });
        
        
        function calendarInit() {
            $('.datepicker').datepicker({
                firstDay:1,
                dateFormat: 'dd.mm.yy'
            });
            $('.picker').click(function(event) {
                event.preventDefault;
                $('.datepicker').datepicker('show');
            });
        };

        
        // Adding item to list
        function addItem(id, fileid, typeid, name, number, active, date, download, file, inplaylist, stream, socialid) {
           var item = itemsBlock.find('.hidden').clone().removeClass('hidden').prependTo(itemsBlock);

            if (id) {
                item.attr('id', id).data('fileid', fileid);
            };

            if (socialid) {
                item.data('socialid', socialid);
            };

            if (stream) {
                item.data('stream', stream);
            };
            
            item.data('typeid', typeid).data('download', download).data('file', file);
            
            item.find('.number').html(number);
            item.find('.date').html(date);
            item.find('.preview').attr('src', radioshowUrl);

            active == '0' ? item.find('.hide-item').attr('checked', 'checked') : 0;
            name ? item.find('.comment').html(name) : item.find('.comment-wrap').hide();
            inplaylist ? item.data('inplaylist', inplaylist) : 0;
            
            item.find('.delete-item').click(function(event) {
                event.preventDefault();

                if (id) {
                    items.deleted ? 0 : items.deleted = {};
                    items.deleted[id] = {};
                    items.deleted[id].id = id;
                    items.deleted[id].file = item.data('file');
                    items.deleted[id].fileid = item.data('fileid');
                };
                
                item.remove();
            });
            
            item.find('.edit-item').click(function(event) {
                event.preventDefault();
                initEdit(item);
            });
        };
        
        
        // Editing block
        function initEdit(editableItem, mp3) {
            addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');

            var cT = new Date(),
                    cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
                    cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
                    cYear = cT.getFullYear();

            addBlock.find('.date .datepicker').val(cDay + '.' + cMonth + '.' + cYear);
            addBlock.find('.number').val('');
            addBlock.find('.comment').val('');
            addBlock.find('.checkboxes input').removeAttr('checked');

            if (editableItem) {
                addBlock.find('.number').val(editableItem.find('.number').html());
                addBlock.find('.comment').val(editableItem.find('.comment').html());
                addBlock.find('.date .datepicker').val(editableItem.find('.date').html());

                if (editableItem.data('download') == 1) {
                    addBlock.find('.downloadable').attr('checked', 'checked');
                };

                if (editableItem.data('inplaylist')) {
                    addBlock.find('.in-playlist').attr('checked', 'checked');
                } else {
                    addBlock.find('.in-playlist').removeAttr('checked');
                };
            };


            addBlockOverlay.height($(document).height()).show();
            addBlockBorderOverlay.css({
               'width': addBlock.outerWidth() + 30 + 'px',
               'height': addBlock.outerHeight() + 30 + 'px',
               'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
            }).show();
            addBlock.show();

            calendarInit();

            
            addBlock.find('.cancel').click(function(event) {
                event.preventDefault();
                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
                addBlock.hide();
            });
            
            addBlock.find('.save').unbind().click(function(event) {
                event.preventDefault();

                if (editableItem) {
                    
                    editableItem.find('.number').html(addBlock.find('.number').val());
                    editableItem.find('.comment').html(addBlock.find('.comment').val());
                    editableItem.find('.date').html(addBlock.find('.date .datepicker').val());
                    editableItem.data('download', addBlock.find('.downloadable').attr('checked')  ? 1 : 0 )

                    if (addBlock.find('.in-playlist').attr('checked')) {
                        editableItem.data('inplaylist') ? 0 : editableItem.data('inplaylist', 'new');

                    } else {
                        if (editableItem.data('inplaylist')) {
                            items.delplay ? 0 : items.delplay = {};
                            items.delplay[editableItem.data('inplaylist')] = editableItem.data('inplaylist');

                            editableItem.data('inplaylist', null);
                        } else {
                            editableItem.data('inplaylist', null);
                        }
                    };

                } else {
                    addItem(
                        null,
                        null,
                        radioshowTypeId,
                        addBlock.find('.comment').val(),
                        addBlock.find('.number').val(),
                        1,
                        addBlock.find('.date .datepicker').val(),
                        addBlock.find('.downloadable').attr('checked') ? 1 :0,
                        mp3,
                        addBlock.find('.in-playlist').attr('checked') ? 'new' : null
                    );
                };

                packJsonAndSend();

                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
                addBlock.hide();
            });
        };


        function packJsonAndSend() {
            var loaderOverlay = $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body'),
                loader = $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            items.radioshow = {};

            itemsBlock.find('li:visible').each(function(i) {
                items.radioshow[i] = {};

                if ($(this).data('stream')) {
                    items.radioshow[i].stream = $(this).data('stream');
                };

                if ($(this).data('socialid')) {
                    items.radioshow[i].socialid = $(this).data('socialid');
                };

                items.radioshow[i].id = $(this).attr('id');
                items.radioshow[i].fileid = $(this).data('fileid');
                items.radioshow[i].typeid = radioshowTypeId;
                items.radioshow[i].name = secureString($(this).find('.comment').html());
                items.radioshow[i].number = secureString($(this).find('.number').html());
                items.radioshow[i].active = $(this).find('.hide-item').attr('checked') ? 0 : 1;
                items.radioshow[i].show_date = secureString($(this).find('.date').html());
                items.radioshow[i].download = $(this).data('download');
                items.radioshow[i].file = secureString($(this).data('file'));
                items.radioshow[i].inplaylist = $(this).data('inplaylist') ? $(this).data('inplaylist') : null;
                items.radioshow[i].coverid = radioshowCoverId;
                items.radioshow[i].radioshowtypename = secureString(radioshowName);
            });

             // Sending JSON with AJAX
            $.ajax({
                type: 'POST',
                url: '/admin/updateradioshowinner/',
                data: 'data=' + $.toJSON(items),
                success: function(response){
                    items = $.parseJSON(response);
                    items.errorid ? errorPopup(items.errormessage) : init();

                    loader.remove();
                    loaderOverlay.remove();
                }
            });
        };


        // AJAX saving
        saveButton.click(function() { packJsonAndSend() });


        // Initialization
        function init() {
            itemsBlock.find('li:visible').remove();
            
            if(items.radioshow) {
                saveButton.show();

                $.each(items.radioshow, function(i, item) {
                    addItem(item.id, item.fileid, item.typeid, item.name, item.number, item.active, item.show_date, item.download, item.file, item.inplaylist);
                });
                
            } else {
                saveButton.hide();
            };
        };

        
        init();
    });
</script>