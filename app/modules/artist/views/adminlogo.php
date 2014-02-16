<!-- content (begin) -->
<div class="g-content">
    <div class="b-logo-edit">
        <div class="upload-wrap">
            <input id="logo-upload" name="logo-upload" style="display:none;" type="file" />
            <a href="#" class="upload"><?=$this->registry->trans['upload'];?> <?=strtolower($this->registry->trans['logo']);?> (*.png)</a>
        </div>
        <i class="b-alert">
			<? if($this->Session->Site['languageid']==1){?>
				Не рекомендуем размещать логотип больший по размеру, чем отведенное для него место (380 х 240)
			<?}else{?>
				Uploading logo more then 380 х 240px is not recommended.
			<?}?>
		</i>

        <div class="b-position">
            <label for="position-left">
                <input id="position-left" name="position" type="radio" checked="checked" /><?=$this->registry->trans['logoleft'];?>
            </label>
            <label for="position-right">
                <input id="position-right" name="position" type="radio" /><?=$this->registry->trans['logoright'];?>
            </label>
        </div>

        <div class="b-logo-canvas">
            <div class="grid-left"></div>
            <div class="grid-right"></div>
            <img class="logo" src="" alt=""/>
            <img class="bg" src="<?=$this->view->pagebg;?>" alt=""/>
        </div>

        <div class="b-button-set">
            <a class="delete" href="#"><?=$this->registry->trans['delete'];?> <?=strtolower($this->registry->trans['logo']);?></a>
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<style type="text/css">#logo_uploadQueue { display:none; }</style>
<script type="text/javascript">
(function($) {
    $.fn.logoUploader = function(){
        return this.each(function(){

            var logo = $.parseJSON('<?=$this->view->logo;?>'),
                $canvas = $('.b-logo-canvas'),
                $logo = $canvas.find('.logo'),
                $gridLeft = $canvas.find('.grid-left'),
                $gridRight = $canvas.find('.grid-right'),
                $controlLeft = $('#position-left'),
                $controlRight = $('#position-right'),
                $buttonSet = $('.b-button-set'),
                $delete =  $buttonSet.find('.delete'),
                $save = $buttonSet.find('.save');


            $canvas.find('.bg').load(function() {
                var $bgImage = $(this);

                if ($bgImage.width() / $bgImage.height() > $canvas.width() / $canvas.height()) {
                    $bgImage.css({
                        'width': 'auto',
                        'height': '100%'
                    });

                } else {
                    $bgImage.css({
                        'width': '100%',
                        'height': 'auto'
                    });
                };

                $bgImage.hide().css({
                    'left': '50%',
                    'top': '50%',
                    'margin-left': -$bgImage.width() / 2 + 'px',
                    'margin-top': -$bgImage.height() / 2 + 'px'
                }).show();
            });


            $('#logo-upload').uploadify({
                'uploader'                   : '/uploadify/uploadify.swf',
                'script'                        : '/file/uploadlogo/',
                'cancelImg'                 : '/uploadify/cancel.png',
                'folder'                        : '/uploads/temp',
                'auto'                          : true,
                'fileExt'                       : '*.jpeg;*.jpg;*.gif;*.png',
                'fileDesc'                     : 'Image Files',
                'wmode'                      : 'transparent',
                'hideButton'                : true,
                'width'                         : 350,
                'onComplete'         : function(event, queueID, fileObj, response, data) {
                    $logo.show().attr('src', response).addClass('logo-image-left');
                    $controlLeft.attr('checked', true);
                    $gridLeft.show();
                    logo.logo ? logo.deleted = logo.logo.url : 0;
                    logo.logo = {};
                    logo.logo.url = response;
                    
                    $buttonSet.show();
                }
            });

            $controlLeft.click(function() {
                $gridLeft.show();
                $gridRight.hide();
                $logo.removeClass('logo-image-right').addClass('logo-image-left');
            });

            $controlRight.click(function() {
                $gridRight.show();
                $gridLeft.hide();
                $logo.removeClass('logo-image-left').addClass('logo-image-right');
            });

            $delete.click(function(event) {
                event.preventDefault();

                logo.deleted = logo.logo.url;
                logo.logo = null;

                $logo.hide().removeAttr('src');
            });


            $save.click(function() {
                $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
                $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

                logo.logo ? (logo.logo.position = $controlLeft.attr('checked') ? 0 : 1) : 0;

                $.ajax({
                    type: 'POST',
                    url: '/design/updatelogo/',
                    data: 'data=' + $.toJSON(logo),
                    success: function(response) {
                        logo = $.parseJSON(response);
                        logo.errorid ? errorPopup(logo.errormessage) : init();

                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    }
                 });
            });


            function init() {
                if (logo.logo) {
                    $gridLeft.hide();
                    $gridRight.hide();

                    $buttonSet.show();
                    $logo.attr('src', logo.logo.url);

                    if (logo.logo.position == '0') {
                        $gridLeft.show();
                        $controlLeft.attr('checked', true);
                        $logo.addClass('logo-image-left');

                    } else {
                        $gridRight.show();
                        $controlRight.attr('checked', true);
                        $logo.addClass('logo-image-right');
                    };

                } else {
                    $buttonSet.hide();
                    $logo.hide();
                };
            };


            init();
        });
    };
})(jQuery);

$().ready(function() {
    $('.b-logo-edit').logoUploader();
});
</script>