<!-- content (begin) -->
<div class="g-content">
    <div class="b-url-settings">
            <i class="caption-url">
                <?=$this->registry->trans['domainurl'];?>
                <!--img src="/img/artist/admin/icon-question-mark.png" width="15" height="15" alt="Help" /-->
            </i>
            <i class="caption-ip">
                <?=$this->registry->trans['ourip'];?>
                <!--img src="/img/artist/admin/icon-question-mark.png" width="15" height="15" alt="Help" /-->
            </i>
            
            <input type="text" class="url" value="" /><input type="text" class="ip-adress" disabled="disabled" value="<?=$this->view->ip;?>" />
            
            <div class="b-button-set">
                <? if($this->Session['Site']['languageid']){?>
                <i class="alert">После того, как Вы внесете в вышестоящее поле свой домен, а в админ-панели своего домена укажете наш IP-адрес, должно пройти до 24 часов, чтобы ваш сайт заработал</i>
                <?}?>
                <button class="save"><?=$this->registry->trans['save'];?></button>
            </div>
        </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
$().ready(function() {
    var url = $.parseJSON('<?=$this->view->url;?>');
    
    $('.b-url-settings .save').click(function() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        url.domainlist = {};
        url.domainlist[0] = {};
        url.domainlist[0].url = $('.url').val();
        
        $.ajax({
            type: 'POST',
            url: '/reccount/updateurl/',
            data: 'data=' + $.toJSON(url),
            success: function(response){
                url = $.parseJSON(response);
                url.errorid ? errorPopup(url.errormessage) : $('.url').val(url.domainlist[0].url);
                
                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    });

    if (url.domainlist) {
        $('.url').val(url.domainlist[0].url);
    };
});
</script>