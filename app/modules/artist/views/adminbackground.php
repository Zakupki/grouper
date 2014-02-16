<!-- content (begin) -->
<div class="g-content">
    <div class="b-backgrounds">
        <div class="upload-background">
            <div class="upload-button"><?=$this->registry->trans['uploadnewbg'];?> (*.jpeg, *.jpg, *.gif, *.png, 1500x900)</div>
            <input id="bg_upload" name="bg_upload" style="display:none;" type="file" />
        </div>

        <ul class="b-backgrounds"></ul>

        <div class="b-button-set">
            <button class="save-backgrounds"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup" style="width:630px; margin-left: -335px;">
    <?
		$menunum=ceil(count($this->view->menu)/3);
        $cnt=1;
		echo '<div class="b-category-column">';
		foreach($this->view->menu as $m){
        	
			echo '<label for="'.$m['itemid'].'"><input id="'.$m['itemid'].'" type="checkbox"> '.$m['name'].'</label>';
			if($menunum==$cnt){
			$cnt=0;
			echo '</div>
				  <div class="b-category-column">';
			}
			$cnt++;
		}
		echo '</div>';
    ?>
    <div class="b-button-set">
        <button class="save"><?=$this->registry->trans['save'];?></button>
        <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
    </div>
</div>

<script type="text/javascript">         
    $(document).ready(function() {
        var backgrounds = $.parseJSON('<?=$this->view->background;?>'),
            addBlock = $('#adding-popup'),
            addBlockOverlay = $('.g-overlay-superblack'),
            addBlockBorderOverlay = $('.g-overlay-border'),
            backgroundItemsBlock = $('.b-backgrounds .b-backgrounds'),
            saveButton = $('.save-backgrounds');

        
        $('#bg_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadbackground/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'auto'                          : true,
            'fileExt'                       : '*.jpeg;*.jpg;*.gif;*.png',
            'fileDesc'                  : 'Image Files',
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 325,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                    addBg(null, response);
                    saveButton.show();
                }
        });


        function addBg(id, url, major, compare) {
            var backgroundItem = $('<li><img /></li>').prependTo(backgroundItemsBlock);

            backgroundItem.find('img').attr('src', url);

            if (id) {
                backgroundItem.data('id', id).data('compare', compare).append($('<a href="#"></a>').addClass('edit').click(function(event) {
                    event.preventDefault();
                    editBackground(backgroundItem);
                    
                })).append($('<a></a>').addClass('delete').click(function(event) {
                    event.preventDefault();
    
                    !backgrounds.deleted ? backgrounds.deleted = {} : 0;
                    backgrounds.deleted[id] = {};
                    backgrounds.deleted[id]['id'] = id;
                    backgrounds.deleted[id]['url'] = backgroundItem.find('img').attr('src');

                    backgroundItem.remove();
                }))

                major == 1 ? backgroundItem.data('major', 1).append($('<div></div>').addClass('current')).find('.delete').hide() : backgroundItem.data('major', 0);

                backgroundItem.find('img').click(function() {
                    if (backgroundItem.data('major') == 0) {
                        backgroundItemsBlock.find('li').data('major', 0).find('.delete').show();
                        backgroundItemsBlock.find('li .current').remove();

                        backgroundItem.append($('<div></div>').addClass('current')).data('major', 1).find('.delete').hide();
                    };
                });
                
            } else {
                backgroundItem.attr('rel', 'new');
                packJsonAndSend();
            };
        };


        function editBackground(item) {
            var menuCategories;
            
            addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');
            addBlock.find('input').removeAttr('checked');
            
            $.ajax({
                type: 'POST',
                url: '/design/menubg/',
                data: 'id=' + item.data('id'),
                success: function(response) {
                    menuCategories = $.parseJSON(response);

                    if (menuCategories.menubg) {
                        $.each(menuCategories.menubg, function(i, item) {
                            addBlock.find('#' + item.menuid).attr('checked', 'checked');
                        });
                    };

                    addBlock.find('input').click(function() {
                       if (!$(this).attr('checked')) {
                           menuCategories.deleted ? 0 : menuCategories.deleted = {};

                           var categoryId = $(this).attr('id');

                           if (!menuCategories.deleted[categoryId]) {
                               menuCategories.deleted[categoryId] = {};
                               menuCategories.deleted[categoryId].menuid = categoryId;
                               menuCategories.deleted[categoryId].bgid = item.data('id');
                           };
                       };
                    });
                    
                    addBlockOverlay.show();
                    addBlockBorderOverlay.css({
                       'width': addBlock.outerWidth() + 30 + 'px',
                       'height': addBlock.outerHeight() + 30 + 'px',
                       'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
                    }).show();
                    addBlock.show();
                }
             });


             // Save
            addBlock.find('.save').unbind().click(function() {
                menuCategories.menubg = {};

                addBlock.find('input:checked').each(function() {
                    var categoryId = $(this).attr('id');

                    menuCategories.menubg[categoryId] = {};
                    menuCategories.menubg[categoryId].menuid = categoryId;
                    menuCategories.menubg[categoryId].bgid = item.data('id');
                });
                
                $.ajax({
                    type: 'POST',
                    url: '/design/updatebackgroundinner/',
                    data: 'data=' + $.toJSON(menuCategories),
                    success: function(response) {
                        addBlock.hide();
                        addBlockOverlay.hide();
                        addBlockBorderOverlay.hide();
                    }
                 });
            });

            
            // Cancel
            addBlock.find('.cancel').unbind().click(function() {
                addBlock.hide();
                addBlockOverlay.hide();
                addBlockBorderOverlay.hide();
            });
        };


        function packJsonAndSend() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            backgrounds.background = {};

            if (backgroundItemsBlock.find('li[rel=new]').length > 0) {
                backgroundItemsBlock.find('li').each(function(i) {
                    backgrounds.background[i] = {};
                    backgrounds.background[i]['id'] = $(this).data('id');
                    backgrounds.background[i]['url'] = $(this).find('img').attr('src');
                    backgrounds.background[i]['compare'] = $(this).data('compare');
                    backgrounds.background[i]['major'] = ($(this).data('major') >= 0) ? 0 : 1;
                });

            } else {
                backgroundItemsBlock.find('li').each(function(i) {
                    backgrounds.background[i] = {};
                    backgrounds.background[i]['id'] = $(this).data('id');
                    backgrounds.background[i]['url'] = $(this).find('img').attr('src');
                    backgrounds.background[i]['compare'] = $(this).data('compare');
                    backgrounds.background[i]['major'] = $(this).data('major');
                });
            };

            $.ajax({
                type: 'POST',
                url: '/design/updatebackground/',
                data: 'data=' + $.toJSON(backgrounds),
                success: function(response) {
                    backgrounds = $.parseJSON(response);
                    backgrounds.errorid ? errorPopup(backgrounds.errormessage) : init();

                    $('.g-loader').remove();
                    $('.g-overlay').remove();
                }
             });
        };

        saveButton.click(function() {
            packJsonAndSend();
        });


        function init() {
            if (backgrounds.background) {
                saveButton.show();
                backgroundItemsBlock.empty();

                $.each(backgrounds.background, function(i, item) {
                    addBg(item.id, item.url, item.major, item.compare);
                });
                
            } else {
                saveButton.hide();
            };
        };
        
        init();
    });
</script>