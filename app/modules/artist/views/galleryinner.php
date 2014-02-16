<a class="b-backlink" href="/gallery/"><h2 class="white"><?=$this->view->pagetitle;?><sup><?=$this->view->gallerycnt;?></sup></h2></a>
<h3><?=$this->view->gallerytitle;?><sup><?=count($this->view->gallery);?></sup></h3>
<div class="b-container">
    <div class="b-gallery-inner">
        <? foreach($this->view->gallery as $gallery){
        if(!$gallery['srcurl'])	
		$gallery['srcurl']=$gallery['url'];
		?><a href="<?=$gallery['srcurl'];?>" rel="group" style="display:none;"><img width="220" height="100" src="<?=$gallery['url'];?>" alt="" /></a><?}?>
    </div>
</div>
<div class="b-rager"></div>

<script type="text/javascript">
$(function() {
    $('.g-content').delay(100).animate({height: '260px'}, 0, function() {

        var contentContainer = $(this),
            imageItems = $('.b-gallery-inner a'),
            imagesTotal = imageItems.length,
            maxRows = Math.floor(($('body').height() - 360) / 120),
            imagesInRow = Math.ceil((contentContainer.width() + 20) / 240),
            rowsToShow,
            pagerRequired;


        if (imagesTotal > (imagesInRow * maxRows)) {
            rowsToShow = maxRows;
            pagerRequired = true;

        } else {
            rowsToShow = Math.ceil(imagesTotal / imagesInRow);
            pagerRequired = false;
        };
        

        contentContainer.animate({height: rowsToShow * 120 + 140}, 500, function() {
            
            if (pagerRequired) {
                var pagerBlock = contentContainer.find('.b-rager'),
                    pagesTotal = Math.ceil(Math.ceil(imagesTotal / imagesInRow) / maxRows),
                    imagesToShow = imageItems.slice(0, maxRows * imagesInRow).fadeIn(500);

                for (var i = 0; i < pagesTotal; i++) {
                    var pagerLink = $('<a href="#"></a>').appendTo(pagerBlock);

                    if (i == 0) {
                        pagerLink.addClass('active');
                    };

                    pagerLink.click(function(event) {
                        event.preventDefault();

                        var pageIndex = $(this).index(),
                            sliceStart = pageIndex * maxRows * imagesInRow,
                            sliceEnd = (pageIndex + 1) * maxRows * imagesInRow;

                        imagesToShow.hide();
                        imagesToShow = imageItems.slice(sliceStart, sliceEnd).fadeIn(500);
                        
                        pagerBlock.find('a.active').removeClass('active');
                        $(this).addClass('active');
                    });
                };

            } else {
                imageItems.fadeIn(500);
            };


            imageItems.fancybox({
                padding : 0,
                nextEffect: 'fade',
                prevEffect:  'fade'
            });
        });


        $('.b-backlink').click(function(event) {
            event.preventDefault();
            $.history.load($(this).attr('href'));
        });
    });

});
</script>