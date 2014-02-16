<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-gallery">
        <a class="add-gallery" href="#"><?=$this->registry->trans['addgallery'];?></a>

        <ul class="b-items">
            <li class="hidden">
                <div class="draggable-area"></div>
                <div class="gallery-cover">
                    <a><img  width="160" height="70" /></a>
                </div>

                <div class="description">
                    <a><h3></h3></a>
                    <i class="photos-counter"><span></span> <?=$this->registry->trans['photo'];?></i>
                </div>
                
                <div class="techlinks">
                    <span><label><input class="active" type="checkbox" /><?=$this->registry->trans['hide'];?></label></span>
                    <span><a href="#" class="delete"><?=$this->registry->trans['delete'];?></a></span>
                    <span><a class="edit" href="#"><?=$this->registry->trans['edit'];?></a></span>
                </div>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->


<div class="g-overlay-superblack" style="display:none;"></div>
<div class="g-overlay-border"></div>
<div id="adding-popup" style="margin-left: -240px; width:440px;">
    <span class="label-name"><?=$this->registry->trans['title'];?></span>
    <input type="text" class="name gallery-name" />

    <div class="b-button-set">
        <button class="save"><?=$this->registry->trans['save'];?></button>
        <button class="cancel"><?=$this->registry->trans['cancel'];?></button>
    </div>
</div>

<script type="text/javascript">
$().ready(function() {
    var galleriesList = $.parseJSON('<?=$this->view->gallery;?>'),
        defaultCoverUrl = '<?=$this->view->defaultpreview;?>',
        addGalleryButton = $('.b-gallery .add-gallery'),
        galeriesContainer = $('.b-gallery .b-items').sortable(),
        addBlock = $('#adding-popup'),
        addBlockOverlay = $('.g-overlay-superblack'),
        addBlockBorderOverlay = $('.g-overlay-border'),
        saveGalleriesButton = $('.b-gallery .b-button-set .save');

    
    addGalleryButton.click(function(event) {
        event.preventDefault();
        editGallery();
    })


    function addGallery(id, cnt, name, active, preview, itemid) {
        var releaseTrack = $('.b-items > li.hidden').clone().removeClass('hidden').insertBefore('.b-items > li:first-child');

        if (id) {
            releaseTrack.data('id', id);
            releaseTrack.find('.description a').attr('href', '/admin/gallery/' + id);
            releaseTrack.find('.gallery-cover a').attr('href', '/admin/gallery/' + id);
            releaseTrack.data('itemid', itemid);
        };

        cnt ? releaseTrack.find('.photos-counter span').html(cnt) : 0;
        name ? releaseTrack.find('h3').html(name) : 0;
        active == 0 ? releaseTrack.find('.active').attr('checked', 'checked') : 0;
        preview ? releaseTrack.find('.gallery-cover img').attr('src', preview) : releaseTrack.find('.gallery-cover img').attr('src', defaultCoverUrl);

        releaseTrack.find('.edit').click(function(event) {
            event.preventDefault();
            editGallery(releaseTrack);
        });

        releaseTrack.find('.delete').click(function(event) {
            event.preventDefault();

            if (id) {
                galleriesList.deleted ? 0 : galleriesList.deleted = {};
                galleriesList.deleted[id] = {};
                galleriesList.deleted[id].id = id;
                galleriesList.deleted[id].itemid = itemid;
            };

            releaseTrack.remove();
        });
    };


    function editGallery(track) {
        addBlock.find('.name').val('');
        addBlock.find('.cover img').attr('src', defaultCoverUrl);
        
        if (track) {
            addBlock.find('.name').val(track.find('h3').html());
            addBlock.find('.cover img').attr('src', track.find('.gallery-cover img').attr('src'));
        };

        addBlock.css('margin-top', '-' + (addBlock.outerHeight() / 2) + 'px');
        addBlockOverlay.height($(document).height()).show();
        addBlockBorderOverlay.css({
           'width': addBlock.outerWidth() + 30 + 'px',
           'height': addBlock.outerHeight() + 30 + 'px',
           'margin': -addBlock.outerHeight() / 2 - 15 + 'px 0 0 ' + (-addBlock.outerWidth() / 2 - 15) + 'px'
        }).show();
        addBlock.show();

        addBlock.find('.cancel').click(function(event) {
            event.preventDefault();
            addBlockOverlay.hide();
            addBlockBorderOverlay.hide();
            addBlock.hide();
        });

        addBlock.find('.save').unbind().click(function(event) {
            event.preventDefault();
            
            if (track) {
                track.find('h3').html(addBlock.find('.name').val());

            } else {
                addGallery(null, null, addBlock.find('.name').val(), 1, defaultCoverUrl);
            };

            packJsonAndSend();
            addBlockOverlay.hide();
            addBlockBorderOverlay.hide();
            addBlock.hide();
        });
    };


    function packJsonAndSend() {
        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        galleriesList.gallery = [];
        
        $('.b-items > li:visible').each(function(i) {
            galleriesList.gallery[i] = {};
            galleriesList.gallery[i].name = secureString($(this).find('h3').html());
            galleriesList.gallery[i].active = $(this).find('.active').attr('checked') ? 0 : 1;

            $(this).data('id') ? galleriesList.gallery[i].id = $(this).data('id') : 0;
        });

        galleriesList.gallery.reverse();


        $.ajax({
            type: 'POST',
            url: '/admin/updategallery/',
            data: 'data=' + $.toJSON(galleriesList),
            success: function(response) {
                galleriesList = $.parseJSON(response);
                galleriesList.errorid ? errorPopup(galleriesList.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    };

    
    function init() {
        $('.b-items :visible').remove();

        if (galleriesList.gallery) {
            saveGalleriesButton.show();
            
            $.each(galleriesList.gallery, function(i, item) {
                addGallery(item.id, item.cnt, item.name, item.active, item.preview, item.itemid);
            });

        } else {
            saveGalleriesButton.hide();
        };
    };

    
    saveGalleriesButton.click(function() { packJsonAndSend(); });


    init();
});
</script>