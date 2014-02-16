<!-- content (begin) -->
<div class="g-content">
    <div class="b-languages">
        <i><?=$this->registry->trans['project'];?></i>
        <input class="project-title" type="text" value="" />

        <div class="b-button-set">
            <button class="save-langs"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
$().ready(function() {
    var reccountTitle = $.parseJSON('<?=$this->view->title;?>'),
        projectTitle = $('.project-title'),
        saveButton = $('.save-langs');

    function init() {
        reccountTitle.title? projectTitle.val(reccountTitle.title) : 0;
    };

    saveButton.click(function() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        reccountTitle.title = encodeURIComponent(projectTitle.val().replace(/\\(.?)\/(.?)\u003E(.?)/g, ''));

        $.ajax({
            type: 'POST',
            url: '/reccount/updatetitle/',
            data: 'data=' + $.toJSON(reccountTitle),
            success: function(response){
                reccountTitle = $.parseJSON(response);
                reccountTitle.errorid ? errorPopup(reccountTitle.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    });

    init();
});
</script>