<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->
	
<!-- content (begin) -->
<div class="g-content">
    <div class="b-video">
        <div class="upload-field">
            <span class="youtube"></span>
            <span class="vimeo"></span>
            <span class="upload-label"><?=$this->registry->trans['add'];?> <?=strtolower($this->registry->trans['video']);?></span>
        </div>

        <ul class="b-items">
            <li class="hidden">
                <img width="220" height="100" >
                <a href="#" class="delete"></a>
                <a href="#" class="edit"></a>
                <span class="title"></span>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save-videos"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->


<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup">
    <span class="label-name"><?=$this->registry->trans['title'];?></span>
    <input type="text" class="video-name" />

    <span class="label-link"><?=$this->registry->trans['videolink'];?> (http://www.youtube.com/...)</span>
    <input type="text" class="video-link" />

    <div class="cover">
        <img style="width:220px; height:100px;" />
        <input id="videocover_upload" name="videocover_upload" style="display:none;" type="file" />
        <a href="#" class="select" style="left:230px"><?=$this->registry->trans['uploadcover'];?></a>
        <a href="#" class="library" style="left:230px; bottom:-2px"><?=$this->registry->trans['coverlib'];?></a>
        <a href="#" class="delete" style="bottom:3px"></a>
    </div>

    <div class="b-button-set">
        <button class="save"><?=$this->registry->trans['save'];?></button>
        <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
    </div>
</div>


<div id="covers-library" style="display:none;">
    <div class="covers">
        <?
            foreach($this->view->coverlist as $cover) {
                echo '<img rel="'.$cover['id'].'" width="220" height="100" src="'.$cover['url'].'"/>';
            }
        ?>
    </div>
    <ul class="pager"></ul>
    <a class="ok" href="#"></a>
    <a class="cancel" href="#"></a>
</div>

<script type="text/javascript">
$().ready(function() {
    var addVideoButton = $('.add-video-button'),
        addBlock = $('#adding-popup'),
        addBlockOverlay = $('.g-overlay-superblack'),
        addBlockBorderOverlay = $('.g-overlay-border'),
        videosContainer = $('.b-items').sortable(),
        saveButton = $('.save-videos'),
        videoList = $.parseJSON('<?=$this->view->videos;?>'),
        defaultCoverUrl = '<?=$this->view->defaultpreview;?>';


    // Uploadify
    $('#videocover_upload').uploadify({
        'uploader'          : '/uploadify/uploadify.swf',
        'script'            : '/file/uploadimage/',
        'cancelImg'         : '/uploadify/cancel.png',
        'folder'            : '/uploads/temp',
        'fileExt'           : '*.jpg;*.jpeg;*.gif;*.png',
        'fileDesc'          : 'Image Files',
        'auto'              : true,
        'wmode'             : 'transparent',
        'hideButton'        : true,
        'width'             : 140,
        'onComplete'        : function(event, queueID, fileObj, response, data) {
            initCrop(response, 1);
        }
    });



    $('.youtube, .vimeo').off().click(function() {
        if ($(this).hasClass('youtube')) {
            var socialId = 227;
        } else {
            var socialId = 232;
        };

        $.confirm({
            'content': '<i class="label-video"><?=$this->registry->trans['videolink'];?></i><input class="input-video" type="text" />',
            'ok': function() {
                var videoUrl = encodeURIComponent(($('.input-video').val() + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0'));

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

                            addVideo(
                                null,
                                response.name,
                                $('.input-video').val(),
                                response.url,
                                null
                            );

                            saveButton.show();

                            //packJsonAndSend();
                            //response.socialid
                        };

                        $.popup.close();
                    }
                );
            }
        });
    });



    function addVideo(id, name, url, preview, previewid, itemid) {
        var videoItem = videosContainer.find('.hidden').clone().removeClass('hidden').prependTo(videosContainer);

        if (id) {
            videoItem.data('id', id);
        };
        if (itemid) {
            videoItem.data('itemid', itemid);
        };
        videoItem.find('.title').html(name);
        videoItem.data('url', url);

        videoItem.find('img').attr('rel', previewid);
        preview ? videoItem.find('img').attr('src', preview) : videoItem.find('img').attr('src', defaultCoverUrl);

        videoItem.find('.delete').click(function(event) {
            event.preventDefault();

            if (id) {
                videoList.deleted ? 0 : videoList.deleted = {};
                videoList.deleted[id] = {};
                videoList.deleted[id].id = id;
                videoList.deleted[id].itemid = itemid;
            };

            videoItem.remove();
        });

        videoItem.find('.edit').click(function(event) {
            event.preventDefault();
            editVideo(videoItem);
        });
    };


    function editVideo(videoItem) {
        addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');

        addBlockOverlay.height($(document).height()).show();
        addBlockBorderOverlay.css({
           'width': addBlock.outerWidth() + 30 + 'px',
           'height': addBlock.outerHeight() + 30 + 'px',
           'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
        }).show();
        addBlock.show();

        addBlock.find('.video-name').val(videoItem.find('.title').html());
        addBlock.find('.video-link').val(videoItem.data('url'));
        addBlock.find('.cover img').attr('src', videoItem.find('img').attr('src'));
        addBlock.find('.cover img').attr('rel', videoItem.find('img').attr('rel'));

        if (videoItem.find('img').attr('src') == defaultCoverUrl) {
            addBlock.find('.cover .delete').hide();
        } else {
            addBlock.find('.cover .delete').show();
        };

        // Delete
        addBlock.find('.cover .delete').unbind().click(function(event) {
            event.preventDefault();
            
            addBlock.find('.cover img').attr('src', defaultCoverUrl);
            addBlock.find('.cover').attr('rel', '');
            addBlock.find('.cover .delete').hide();
        });
        
        // Library
        addBlock.find('.library').unbind().click(function(event) {
            event.preventDefault();
            coversLibraryInit();
        });

        
        // Save
        addBlock.find('.save').unbind().click(function() {
            videoItem.find('.title').html(addBlock.find('.video-name').val());
            videoItem.data('url', addBlock.find('.video-link').val());
            videoItem.find('img').attr('src', addBlock.find('.cover img').attr('src'));
            videoItem.find('img').attr('rel', addBlock.find('.cover img').attr('rel'));

            packJsonAndSend();
            addBlock.hide();
            addBlockOverlay.hide();
            addBlockBorderOverlay.hide();
        });
        
        // Cancel
        addBlock.find('.cancel').unbind().click(function() {
            addBlock.hide();
            addBlockOverlay.hide();
            addBlockBorderOverlay.hide();
        });
    };


    function init() {
        videosContainer.find('li:visible').remove();
        
        if (videoList.videos) {
            saveButton.show();
            
            $.each(videoList.videos, function(i, item) {
                addVideo(item.id, item.name, item.url, item.preview, item.previewid, item.itemid);
            });

        } else {
            saveButton.hide();
        };

    };



    function packJsonAndSend() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        videoList.videos = []

        videosContainer.find('li:visible').each(function(i) {
            videoList.videos[i] = {};

            if($(this).data('id')) {
                videoList.videos[i].id = $(this).data('id');
                videoList.videos[i].itemid = $(this).data('itemid');
            };

            videoList.videos[i].name = secureString($(this).find('.title').html());
            videoList.videos[i].url = secureString($(this).data('url'));
            videoList.videos[i].preview = $(this).find('img').attr('src');
            videoList.videos[i].previewid = $(this).find('img').attr('rel') != defaultCoverUrl ? $(this).find('img').attr('rel') : null;
        });

        videoList.videos.reverse();

        $.ajax({
            type: 'POST',
            url: '/admin/updatevideo/',
            data: 'data=' + $.toJSON(videoList),
            success: function(response) {
                videoList = $.parseJSON(response);
                videoList.errorid ? errorPopup(videoList.errormessage) : init();
                
                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    };


    $('.save-videos').click(function() { packJsonAndSend(); });


    init();
});
</script>