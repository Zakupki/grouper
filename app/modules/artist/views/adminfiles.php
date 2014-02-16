<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-downloads">
        
        <div class="b-add-file">
            <div class="upload">
                <div class="upload-button"><?=$this->registry->trans['uploadfile'];?> (*.doc, *.docx, *.pdf, *.zip, *.rar)</div>
                <input id="file_upload" name="file_upload" style="display:none;" type="file" />
            </div>
        </div>

        <ul class="b-files">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a><div class="draggable-area"></div>
                </div>
                <input class="filename" type="text" value="" /><div class="description">
                    <i class="date"></i><i class="attachment"></i>
                </div>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->


<script type="text/javascript">
$().ready(function() {
    var filesListContainer = $('.b-files').sortable(),
        saveButton =$('.b-button-set .save'),
        filesList = $.parseJSON('<?=$this->view->files;?>');


     // Uploadify
    $('#file_upload').uploadify({
        'uploader'                   : '/uploadify/uploadify.swf',
        'script'                        : '/file/uploadfiles/',
        'cancelImg'                 : '/uploadify/cancel.png',
        'folder'                        : '/uploads/temp',
        'fileExt'                       : '*.doc;*.docx;*.pdf;*.zip;*.rar;*.jpg;*.jpeg',
        'fileDesc'                  : 'Files',
        'auto'                          : true,
        'wmode'                      : 'transparent',
        'hideButton'                : true,
        'width'                         : 330,
        'onComplete'         : function(event, queueID, fileObj, response, data) {
            var responseJson = $.parseJSON(response);
            responseJson.error ? errorPopup(responseJson.error) : addFile(response);
        }
    });


    function addFile(response) {
        var newUploadedFile = filesListContainer.find('.hidden').clone().removeClass('hidden').prependTo(filesListContainer),
            fileDescription = $.parseJSON(response),
            fileDate = new Date();

        if (fileDescription.id) {
            newUploadedFile.data('id', fileDescription.id);
        };
        
        newUploadedFile.data('url', fileDescription.url);

        if(fileDescription.visible_name) {
            newUploadedFile.find('.filename').val(fileDescription.visible_name);
        } else {
            newUploadedFile.find('.filename').val(fileDescription.name);
        };
        
        newUploadedFile.find('.filename').css('background-image', 'url(/img/artist/admin/icon-filetype-' + fileDescription.extension + '.png)');

        if (fileDescription.date) {
            newUploadedFile.find('.date').html(fileDescription.date);
        } else {
            newUploadedFile.find('.date').html(fileDate.getDate() + '.' + (fileDate.getMonth()+1) + '.' + fileDate.getFullYear());
        };

        newUploadedFile.find('.attachment').html(fileDescription.name);

        (fileDescription.hidden == 1) ? newUploadedFile.find('.hide-item').attr('checked', 'checked'): false;

        newUploadedFile.find('.delete-item').click(function(event) {
            event.preventDefault();

            if (newUploadedFile.data('id')) {
                filesList.deleted ? 0 : filesList.deleted = {};
                filesList.deleted[fileDescription.id] = {};
                filesList.deleted[fileDescription.id].id = fileDescription.id;
                filesList.deleted[fileDescription.id].url =  fileDescription.url;
            };

            newUploadedFile.remove();
        });

        saveButton.show();
    };


    // Page init
    function init() {
        filesListContainer.find('li:visible').remove();
        
        if (filesList.files) {
            saveButton.show()

            $.each(filesList.files, function(i, item) {
                var packedItem = $.toJSON(item);
                addFile(packedItem);
            });
            
        } else {
             saveButton.hide();
        };
    };


    // Saving files list with JSON
    function saveFileList() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        filesList.files = [];

        filesListContainer.find('li:visible').each(function(i) {
            filesList.files[i] = {};
            filesList.files[i].id = $(this).data('id') ? $(this).data('id') : null;
            filesList.files[i].visible_name = secureString($(this).find('.filename').val());
            filesList.files[i].name = $(this).find('.attachment').html();
            filesList.files[i].url = $(this).data('url');
            filesList.files[i].hidden = $(this).find('.hide-item').attr('checked') ? 1 : 0;
        });

        filesList.files.reverse();

        $.ajax({
            type: 'POST',
            url: '/admin/updatefiles/',
            data: 'data=' + $.toJSON(filesList),
            success: function(response){
                filesList = $.parseJSON(response);
                filesList.errorid ? errorPopup(filesList.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    };

    saveButton.click(function() { saveFileList(); });

    init();
});
</script>