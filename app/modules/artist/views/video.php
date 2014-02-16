<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->video);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <li class="video-item">
            <?
            $tcnt=1;
            $cnt=1;
            foreach($this->view->video as $video){ ?><a href="<?=$video['url'];?>" class="<?if($video['socialid']==227 || $video['socialid']==343 || $video['socialid']==342){
                    echo 'youtube';
                }elseif($video['socialid']==232){
                    echo 'vimeo';
                };?>">
                <div class="image">
                    <img width="220" height="100" src="<?=$video['preview'];?>" alt="" />
                    <div class="play"></div>
                </div>
                <?=$video['name'];?>
            </a><?
                if($cnt==2 && $tcnt<count($this->view->video)){
                $cnt=0;
                ?>
                </li><li class="video-item">
                <?
                }
            $tcnt++;
            $cnt++;
            }
            ?>
        </li>
    </ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
    
    $('.video-item a').click(function(event) {
        event.preventDefault();

        var $videoLink = $(this);

        $('.g-player').thatplayer('pause');

        $('<div></div>').addClass('g-grid-overlay').css({'height' : $(window).height(), 'width' : $(window).width()}).appendTo('body').click(function() {
            $(this).remove();
            $('body > iframe').remove();
            $('.g-player').thatplayer('resume');
        });

        if ($videoLink.hasClass('vimeo')) {
            var vimeoRegexp = /vimeo.com\/(\d+)?/,
                vimeoCode = vimeoRegexp.exec($videoLink.attr('href'))[1];

            $('<iframe src="http://player.vimeo.com/video/' + vimeoCode + '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="640" height="362" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>').appendTo('body');

        } else {
            var youtubeRegexp = /v=(.*?)(\&|$)/,
                youtubeCode = youtubeRegexp.exec($videoLink.attr('href'))[1];

            $('<iframe width="630" height="472" src="http://www.youtube.com/embed/' + youtubeCode + '?autoplay=1" frameborder="0" allowfullscreen></iframe>').appendTo('body');
        };
    });
});
</script>