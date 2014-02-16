<!-- content (begin) -->
<div class="g-content">
    <div class="b-tracklist">
        <ul class="b-items">
            <li class="hidden">
                <div class="options">
                    <a href="#" class="delete-item"><?=$this->registry->trans['delplaylist'];?></a>
                    <div class="draggable-area"></div>
                </div>

                <img class="preview" src="" width="40" height="40" alt=""><div class="description">
                    <div class="title">
                        <span class="author"></span> -
                        <span class="name"></span>
                        <span class="remix"></span>
                    </div>
                    <span class="date"></span><span class="style"></span><i class="label"></i>
                </div>
            </li>
        </ul>

        <div class="b-button-set">
            <label><input type="checkbox" class="autoplay" /> Autoplay</label>
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
$().ready(function() {
    $('.b-items').sortable();

    var tracklist = $.parseJSON('<?=$this->view->tracks;?>'),
        autoplayCheckbox = $('.autoplay'),
        saveButton = $('.b-button-set .save');

    function addTrack(id, author, cover, date_start, label, name, remix, style) {
        var track = $('.b-items > li.hidden').clone().removeClass('hidden').appendTo('.b-items');

        track.data('id', id);
        author? track.find('.author').html(author) : track.find('.author').remove();
        name ? track.find('.name').html(name) : track.find('.name').remove();
        remix ? track.find('.remix').html('(' + remix + ')') : track.find('.remix').remove();
        date_start ? track.find('.date').html(date_start) : track.find('.date').remove();
        style ? track.find('.style').html(style) : track.find('.style').remove();
        label ? track.find('.label').html(label) : track.find('.label').remove();
        cover ? track.find('.preview').attr('src', cover) : 0;

        track.find('.delete-item').click(function(event) {
            event.preventDefault();

            tracklist.deleted ? 0 : tracklist.deleted = {};
            tracklist.deleted[id] = {};
            tracklist.deleted[id].id = id;
            track.remove();
        })
    };

    function packJsonAndSend() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        tracklist.tracks = {};
        tracklist.autoplay = autoplayCheckbox.attr('checked') ? 1 : 0;

        $('.b-items > li:visible').each(function(i) {
            tracklist.tracks[i] = {};
            tracklist.tracks[i].id = $(this).data('id');
        });

        $.ajax({
            type: 'POST',
            url: '/reccount/updatetracklist/',
            data: 'data=' + $.toJSON(tracklist),
            success: function(response) {
                tracklist = $.parseJSON(response);
                tracklist.errorid ? errorPopup(tracklist.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    };


    function init() {
        $('.b-items > li:visible').remove();

        if (tracklist.tracks) {
            saveButton.show()
            autoplayCheckbox.parent().show();

            tracklist.autoplay == 1 ? autoplayCheckbox.attr('checked', true) : autoplayCheckbox.removeAttr('checked');

            $.each(tracklist.tracks, function(i, item) {
                addTrack(item.id, item.author, item.cover, item.date_start, item.label, item.name, item.remix, item.style);
            });
            
        } else {
            saveButton.hide()
            autoplayCheckbox.parent().hide();
        }
    };

    saveButton.click(function() {
        packJsonAndSend();
    });

    init();
});
</script>