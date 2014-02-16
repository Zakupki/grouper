<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-edit-about">
        <i class="lang-caption"><?=$this->registry->trans['aboutartist'];?>:</i>
        <textarea class="about-text" name=""></textarea>
        <!--div class="alert-copy-paste">
            <i></i>Очистка от стилей. <span>Мы настоятельно рекомендуем использовать во всех случаях, когда Вы переносите текст через буфер обмена (copy-paste).</span> После того, как вы вставили текст, нужно его выделить и нажать на иконку “красный крестик”.
        </div-->
        <div class="b-button-set">
            <? if($this->Sessiom->Site['languageid']==1){?>
            <i class="b-alert">
            	Для качественного форматирования текста все абзацы будут исключены автоматически
            </i>
            <?}?>
            <button class="save-about"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<style type="text/css">
    .defaultSkin .mceButton {
        margin-left: 5px;
    }
    .defaultSkin a.mceButtonActive, .defaultSkin a.mceButtonSelected {
        border: none;
        background: none;
    }
</style>

<script type="text/javascript">
$().ready(function() {
    var aboutText = $.parseJSON('<?=$this->view->about;?>'),
        aboutContainer = $('.about-text'),
        saveButton = $('.save-about');

    aboutContainer.wysiwyg({
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

    function init() {
        if (aboutText.about) {
            aboutContainer.wysiwyg('setContent', aboutText.about ? aboutText.about : '');
        };
    };

       saveButton.click(function() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        aboutText.about = secureString(aboutContainer.wysiwyg('getContent'));

        $.ajax({
            type: 'POST',
            url: '/admin/updateabout/',
            data: 'data=' + $.toJSON(aboutText),
            success: function(response){
                aboutText = $.parseJSON(response);
                aboutText.errorid ? errorPopup(aboutText.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    });

    init();
});
</script>