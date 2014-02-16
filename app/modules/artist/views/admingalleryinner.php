<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-gallery-inner">
        <div class="upload">
            <div class="upload-button"><?=$this->registry->trans['addtogal'];?> <b><?=$this->view->releasetype['name'];?></b> (*.jpeg, *.jpg, *.gif, *.png)</div>
            <input id="item_upload" name="item_upload" style="display:none;" type="file" />
        </div>

        <ul class="b-items">
            <li class="hidden">
                <img width="220" height="100" />
                <a class="delete" href="#"></a>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<div class="g-overlay-superblack" style="display:none;"></div>

<script type="text/javascript">
$().ready(function() {
    var imagesList = $.parseJSON('<?=$this->view->gallery;?>'),
        itemsBlock = $('.b-items').sortable(),
        cropOverlay = $('.g-overlay-superblack'),
        saveButton = $('.b-gallery-inner .b-button-set .save'),
        galleryTypeId = <?=$this->view->gallerytypeid;?>,
        userId = <?=$this->view->userid;?>,
        filesToUploadCounter = 0;

    
    // Uploadify
    $('#item_upload').uploadify({
        'uploader'                   : '/uploadify/uploadify.swf',
        'script'                        : '/file/uploadimage/',
        'cancelImg'                 : '/uploadify/cancel.png',
        'folder'                        : '/uploads/temp',
        'fileExt'                       : '*.jpg;*.jpeg;*.gif;*.png',
        'fileDesc'                  : 'Image Files',
        'auto'                          : true,
        'multi'                         : true,
        'simUploadLimit'    : 1,
        'wmode'                      : 'transparent',
        'hideButton'                : true,
        'width'                         : 395,
         'onSelectOnce' : function(event,data) {
             filesToUploadCounter = data.fileCount;

            if (filesToUploadCounter > 1) {
                $('#item_upload').uploadifySettings('script', '/file/uploadmimage/?id=' + galleryTypeId + '&userid=' + userId);
            } else {
                $('#item_upload').uploadifySettings('script', '/file/uploadimage/');
            };
        },
        'onComplete'         : function(event, queueID, fileObj, response, data) {
            if (filesToUploadCounter == 1) {
                initGalleryCrop(response, 1);
                
            } else {
                var newPreview =  $.parseJSON(response);
                addPhoto(newPreview.id, galleryTypeId, newPreview.url, newPreview.bigurl);
                saveButton.show();
            };
        }
    });


    function addPhoto(id, gallerytypeid, url, bigurl) {
        var photo = itemsBlock.find('li.hidden').clone().removeClass('hidden').prependTo(itemsBlock);

        id ? photo.data('id', id) : 0;
        gallerytypeid ? photo.data('gallerytypeid', gallerytypeid) : 0;
        photo.find('img').attr('src', url);
        photo.data('bigurl', bigurl);

        photo.find('.delete').click(function(event) {
            event.preventDefault();

            if (id) {
                imagesList.deleted ? 0 : imagesList.deleted = {};
                imagesList.deleted[id] = {};
                imagesList.deleted[id].id = id;
                imagesList.deleted[id].gallerytypeid = gallerytypeid;
                imagesList.deleted[id].url = url;
            };

            photo.remove();
        });
    };



    function initGalleryCrop(imageUrl, type) {
        var cropBlock = $('<div></div>').addClass('g-crop').appendTo('body').hide(),
            cropTarget = $('<img />').attr('src', imageUrl).appendTo(cropBlock),
            cropJson = {},
            scale = 1,
            maxImgWidth = document.documentElement.clientWidth - 150,
            maxImgHeight = document.documentElement.clientHeight - 150;

            if (type == 1) {
                var cropHeight = 100,
                    cropWidth = 220,
                    cropRatio = 2.2;

            } else if (type == 2) {
                var cropHeight = 220,
                    cropWidth = 220,
                    cropRatio = 1;
            } else {
                var cropHeight = 220,
                    cropWidth = 580,
                    cropRatio = 2.64;
            };


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
                setSelect: [cropWidth, cropHeight, 0, 0],
                minSize: [cropWidth, cropHeight],
                onChange: function (c) {
                    cropJson.url = imageUrl;
                    cropJson.x = c.x;
                    cropJson.y = c.y;
                    cropJson.width = c.w;
                    cropJson.height = c.h;
                    cropJson.size = type;
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
                    '/file/gallerycrop/',
                    'data=' + $.toJSON(cropJson),
                    function(croppedImage) {
                        var newPreview =  $.parseJSON(croppedImage);
                        addPhoto(null, galleryTypeId, newPreview.url, newPreview.bigurl);
                        cropBlock.remove();
                        cropOverlay.hide();
                        packJsonAndSend();
                    }
                );
            });

            // Cancel crop
            $('<a href="#"></a>').addClass('cancel').appendTo(cropBlock).click(function(event) {
                event.preventDefault();
                cropBlock.remove();
                cropOverlay.hide();
            });
        });
    };


    function packJsonAndSend() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        imagesList.gallery = [];

        itemsBlock.find('li:visible').each(function(i) {
            imagesList.gallery[i] = {};
            
            $(this).data('id') ? imagesList.gallery[i].id = $(this).data('id') : 0;
            imagesList.gallery[i].gallerytypeid = galleryTypeId;
            imagesList.gallery[i].url = $(this).find('img').attr('src');
            imagesList.gallery[i].bigurl = $(this).data('bigurl');
        });

        imagesList.gallery.reverse();

        $.ajax({
            type: 'POST',
            url: '/admin/updategalleryinner/',
            data: 'data=' + $.toJSON(imagesList),
            success: function(response) {
                imagesList = $.parseJSON(response);
                imagesList.errorid ? errorPopup(imagesList.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    };


    saveButton.click(function() { packJsonAndSend() });


    function init() {
        itemsBlock.find('li:visible').remove();
        
        if (imagesList.gallery) {
            saveButton.show();

            $.each(imagesList.gallery, function(i, item) {
                addPhoto(item.id, item.gallerytypeid, item.url, item.bigurl);
            });

        } else {
            saveButton.hide();
        };
    };


    init();
});
</script>