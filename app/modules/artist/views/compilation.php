<h2><?=$this->view->pagetitle;?><sup><?=$this->view->compilationcnt;?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <li class="release-item">
         <?
            $tcnt=1;
            $cnt=1;
            foreach($this->view->compilationlist as $track){
            if(!$track['mp3'] && $track['stream'])
			$track['mp3']=$track['stream'].tools::getStreamParam($track['socialid']);		
			?>
                <div class="release-item-wrap">
                <div class="cover">
                    <img width="40" height="40" src="<?=$track['cover'];?>" alt="Another strange picture" />
                    <span class="play"><?=$track['mp3'];?></span>
                    <span class="download_url">/file/getmp3/?f=<?=$track['mp3id'];?>&name=<?=$track['author'];?>-<?=$track['name'];?></span>
                </div>
                <div class="details">
                    <span class="download"><?=$track['download'];?></span>
                    <h4><span class="author"><?=$track['author'];?></span> &#151;</h4>
                    <h5><span class="title"><?=$track['name'];?></span></h5>
                    <p>
                        <? if($track['musictype']){?>
                        <i><?=$track['musictype'];?></i>
                        <?}?>
                        <i class="last"><?=Tools::GetDate($track['date_create']);?></i>
                    </p>
                </div>
            </div>
            <?
            if($cnt==2 && $tcnt<count($this->view->compilationlist)){
            $cnt=0;
            ?>
        </li>
        <li class="release-item">
            <?
            }
            $tcnt++;
            $cnt++;
            }?>
        </li>
    </ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;

    $('.b-slider .release-item-wrap').click(function() {
        $('.g-player-overlay').remove();
        $('.tp-time-holder').show();

        var trackToPlay = [{
            artist: $(this).find('.author').html(),
            title: $(this).find('.title').html(),
            url: $(this).find('.play').html(),
            download: $(this).find('.download').html(),
            download_url: $(this).find('.download_url').html().replace(/\&amp;/g,'&')
        }]

	    $('.g-player').thatplayer('playlist', trackToPlay, true);
    });
});
</script>