<!-- content (begin) -->
<div class="g-content">
    <div class="b-color-picker">
        <div class="b-color-picker-holder"></div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
    var color = $.parseJSON('<?=$this->view->colorcode;?>');
    
    $('.b-color-picker-holder').ColorPicker({
        color: color.color,
        flat: true
    });
    
    $('.b-color-picker .submit').click(function() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');
        
        color.color = $('.colorpicker_hex input').val();
        
        $.ajax({
            type: 'POST',
            url: '/design/updatecolor/',
            data: 'data=' + $.toJSON(color),
            success: function(response){
                color = $.parseJSON(response);
                color.errorid ? errorPopup(color.errormessage) : $('.colorpicker_hex input').val(color.color);
                
                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    });
</script>