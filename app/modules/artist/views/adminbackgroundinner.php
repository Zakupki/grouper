<!-- content (begin) -->
<div class="g-content">
    <div class="b-background-position">
        <img class="current-background" src="/img/artist/admin/example-bg-item.jpg" width="220" height="110" alt="Current background" />
        <div class="position">
            <label for="position-0"><input id="position-0" type="radio" name="bg-position"> Пропорционально растянуть</label>
            <label for="position-1"><input id="position-1" type="radio" name="bg-position"> Заместить</label>
            <label for="position-2"><input id="position-2" type="radio" name="bg-position"> По центру</label>
            <label for="position-3"><input id="position-3" type="radio" name="bg-position"> Прижать к верху</label>
            <label for="position-4"><input id="position-4" type="radio" name="bg-position"> Прижать к низу</label>
            <label for="position-5"><input id="position-5" type="radio" name="bg-position"> Прижать к правому краю</label>
            <label for="position-6"><input id="position-6" type="radio" name="bg-position"> Прижать к левому краю</label>
            <label for="position-7"><input id="position-7" type="radio" name="bg-position"> Прижать к левому верх. углу</label>
            <label for="position-8"><input id="position-8" type="radio" name="bg-position"> Прижать к правому верх. углу</label>
        </div><!--div class="dark-or-light">
            <label for="type-0"><input id="type-0" type="radio" name="dark-or-light"> Темный логотип на светлом фоне</label>
            <label for="type-1"><input id="type-1" type="radio" name="dark-or-light"> Светлый логотип на темном фоне</label>
        </div--><div class="categories">
            <label class="major" for="category-0"><input id="category-0" type="checkbox"> Основная</label>
            <?
                foreach($this->view->menu as $m)
                echo '<label for="category-'.$m['itemid'].'"><input id="category-'.$m['itemid'].'" type="checkbox"> '.$m['name'].'</label>';
            ?>
            </div>

        <div class="b-button-set">
            <button class="save-background-position">Сохранить</button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">         
    $(document).ready(function() {
        var background = $.parseJSON('<?=$this->view->background;?>');
        
        function init() {
            $('.current-background').attr('src', background.background.url);
            $('#position-' + background.background.position).attr('checked', 'checked');
            $('#type-' + background.background.type).attr('checked', 'checked');
            $('.categories input').removeAttr('checked');
            if (background.background.major === '1') {
                $('#category-0').attr('checked', 'checked');
            } else {
                $('#category-0').removeAttr('checked');
            };
            
            $.each(background.menuids, function(i, value) { 
                $('#category-' + value).attr('checked', 'checked');
            });
        };
        
        
        $('.save-background-position').click(function() {
            $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
            $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');
            
            background.background.position = $('.position input:checked').attr('id').match(/position-(\d+)/)[1];
            //background.background.type = $('.dark-or-light input:checked').attr('id').match(/type-(\d+)/)[1];
            if ($('#category-0').attr('checked') == 'checked') {
                background.background.major = 1;
            } else {
                background.background.major = 0;
            };
            
            background.menuids = {};
            $('.categories input:checked').each(function(index){
                background.menuids[index] = $(this).attr('id').match(/category-(\d+)/)[1];
            });

            $.ajax({
                type: "POST",
                url: "/design/updatebackgroundinner/",
                data: 'data=' + $.toJSON(background),
                success: function(msg) {
                    background = $.parseJSON(msg);

                    if (background.errorid  != undefined) {
                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                        errorPopup(background.errormessage);

                    } else {
                        init();
                        $('.g-loader').remove();
                        $('.g-overlay').remove();
                    };
                }
             });
             
        });
        
        init();
        
    });
</script>
