<!-- content (begin) -->
<div class="g-content">
    <div class="b-favicon">
        <div class="upload-wrap">
            <div class="upload-button"><?=$this->registry->trans['uploadfavicon'];?> (*.ico, *.jpeg, *.jpg, *.gif, *.png)</div>
            <input id="favicon_upload" name="favicon_upload" style="display:none;" type="file" />
        </div>
    </div>
</div>
<!-- content (end)-->

<style type="text/css">#favicon_uploadQueue { display:none; }</style>
<script type="text/javascript">         
    $(document).ready(function() {
        var favicon = $.parseJSON('<?=$this->view->fav;?>');
        
        $('#favicon_upload').uploadify({
            'uploader'                   : '/uploadify/uploadify.swf',
            'script'                        : '/file/uploadfavicon/',
            'cancelImg'                 : '/uploadify/cancel.png',
            'folder'                        : '/uploads/temp',
            'auto'                          : true,
            'fileExt'                       : '*.ico;*.jpeg;*.jpg;*.gif;*.png',
            'fileDesc'                  : 'Image Files and Icons',
            'wmode'                      : 'transparent',
            'hideButton'                : true,
            'width'                         : 385,
            'onComplete'         : function(event, queueID, fileObj, response, data) {
                
                if (favicon.favicon.id) {
                    favicon.deleted = {};
                    favicon.deleted.id = favicon.favicon.id ;
                    favicon.deleted.url = favicon.favicon.url;
                };
                
                favicon.favicon.id = '';
                favicon.favicon.url = response;

                $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
                $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

                $.ajax({
                    type: 'POST',
                    url: '/design/updatefavicon/',
                    data: 'data=' + $.toJSON(favicon),
                    success: function(response) {
                        favicon = $.parseJSON(response);
                        favicon.errorid ? errorPopup(favicon.errormessage) : 0;

                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    }
                 });
            }
        });
    });
</script>