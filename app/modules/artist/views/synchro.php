<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-synchro-facebook">
        <? if($this->view->tracknum){?>
            <i>Facebook iframe code:</i>
            <textarea class="b-facebook-iframe"><iframe width="808" height="<?=$this->view->tracknum*62+479;?>" scrolling="yes" frameborder="no" src="http://<?=$_SERVER['HTTP_HOST'];?>/facebook/"></iframe></textarea>
            <input id="b-copy-code" type="button" value="<?=$this->registry->trans['copytoclipb'];?>" />
        <?}else{?>
            У вас нет треков в плейлисте.
        <?}?>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
$().ready(function() {
    var clip = new ZeroClipboard.Client();

    clip.setHandCursor(true);
    clip.setText($('.b-facebook-iframe').val());
    clip.addEventListener('complete', function() {
        $('<span>Код скопирован в буфер обмена</span>').addClass('alert').insertAfter('#b-copy-code').fadeIn('fast').delay(800).fadeOut('slow', function() {
            $(this).remove();
        });
    });
    clip.glue('b-copy-code');
});
</script>
