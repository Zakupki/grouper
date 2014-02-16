<!-- content (begin) -->
<div class="g-content">
    <div class="b-previews">
        <div class="upload-preview">
            <div class="upload-button"><?=$this->registry->trans['uploadpreview'];?> (*.jpeg, *.jpg, *.gif, *.png)</div>
            <input id="preview_upload" name="preview_upload" style="display:none;" type="file" />
        </div>

        <ul class="b-previews"></ul>

        <div class="b-button-set">
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
    $(document).ready(function() {
        var previews = $.parseJSON('<?=$this->view->preview;?>'),
            previewsContainer = $('.b-previews .b-previews'),
            saveButton = $('.save');
        
        $('#preview_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadimage/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'auto'                          : true,
            'fileExt'                       : '*.jpeg;*.jpg;*.gif;*.png',
            'fileDesc'                  : 'Image Files',
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 380,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                    initCrop(response, 1);
                }
            });



        function initCrop(imageUrl, type) {
            var overlayBlock = $('<div></div>').addClass('g-overlay').css({'height' : $(window).height(), 'width' : $(window).width()}).appendTo('body'),
                cropBlock = $('<div></div>').addClass('g-crop').appendTo('body').hide(),
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
                        '/file/crop/',
                        'data=' + $.toJSON(cropJson),
                        function(croppedImageUrl) {
                            addBg('', croppedImageUrl);
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






        function addBg(id, url, major) {
            var previewItem = $('<li></li>').append($('<img />').attr('src', url)).prependTo(previewsContainer);

            if (id) {
                previewItem.data('id', id).append(
                    $('<a></a>').addClass('delete').click(function(event) {
                        event.preventDefault();

                        previews.deleted ? 0 : previews.deleted = {};
                        previews.deleted[id] = {};
                        previews.deleted[id].id = previewItem.data('id');
                        previews.deleted[id].url = previewItem.find('img').attr('src');
                        previewItem.remove();
                    })
                );

                if (major == '1') {
                    previewItem.append($('<div></div>').addClass('current')).find('.delete').hide();
                };

                previewItem.click(function() {
                    previewsContainer.find('.current').remove();
                    previewsContainer.find('.delete').show();
                    $(this).find('.delete').hide();
                    $(this).append($('<div></div>').addClass('current'));
                });
                
            } else {
                packJsonAndSend();
            };
        };


        function packJsonAndSend() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

            previews.preview = [];

            previewsContainer.find('li').each(function(i) {
                previews.preview[i] = {};
                previews.preview[i]['id'] = $(this).data('id');
                previews.preview[i]['url'] = $(this).find('img').attr('src');
                previews.preview[i]['major'] = $(this).find('.current').length > 0 ? 1 : 0;
            });

            previews.preview.reverse();

            $.ajax({
                type: 'POST',
                url: '/design/updatepreview/',
                data: 'data=' + $.toJSON(previews),
                success: function(response) {
                    previews = $.parseJSON(response);
                    previews.errorid ? errorPopup(previews.errormessage) : 0;

                    init();

                    $('.g-loader').remove();
                    $('.g-overlay').remove();
                }
             });
        };


        saveButton.click(function() { packJsonAndSend() });

        function init() {
            previewsContainer.empty();
            
            if (previews.preview) {
                $.each(previews.preview, function(i, item) {
                    addBg(item.id, item.url, item.major);
                });
            };
        };
        
        init();
    });
</script>