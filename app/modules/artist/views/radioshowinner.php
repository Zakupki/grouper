<a class="b-backlink" href="/radioshow/"><h2 class="white"><?=$this->view->pagetitle;?><sup><?=$this->view->radioshowtypecnt;?></sup></h2></a>
<h3><?=$this->view->radioshowtitle;?><sup><?=count($this->view->radioshowlist);?></sup></h3>
<div class="b-container">
    <ul class="b-slider">
        <li class="radioshow-item">
            <?
            $cnt=1;
            $tcnt=1;
            foreach($this->view->radioshowlist as $show){
            if(!$show['mp3id'] && $show['stream']){
			$show['mp3']=$show['stream'].tools::getStreamParam($show['socialid']);
			}
			?>
			<div class="radioshow-item-wrap">
                <div class="cover">
                    <img width="40" height="40" src="<?=$show['url'];?>" alt="Another strange picture" />
                    <span class="play"><?=$show['mp3'];?></span>
					<span class="download_url">/file/getmp3/?f=<?=$show['mp3id'];?>&name=<?=$this->view->sitename;?> - <?=$show['radioshowtypename'];?> #<?=$show['number'];?></span>
                </div>
                <div class="details">
                    <span class="download"><?=$show['download'];?></span>
                    <h4><span class="author"><?=$this->view->sitename;?></span> &#151; <span class="title"><?=$show['radioshowtypename'];?></span></h4>
                    <h5>#<b><?=$show['number'];?></b>
					<? if(strlen($show['name'])>0){?>
					    (<?=$show['name'];?>)
					<?}?>
					</h5>
                    <p><i class="last"><?=Tools::GetDate($show['show_date'])?></i></p>
                </div>
            </div>
         	<?
            if($cnt==2 && $tcnt<count($this->view->radioshowlist)){
            $cnt=0;
            ?>
            </li><li class="radioshow-item">
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
$(function(){
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
    
    $('.b-backlink').click(function(event) {
        event.preventDefault();
        $.history.load($(this).attr('href'));
    });

    $('.b-slider .radioshow-item-wrap').click(function() {
        $('.g-player-overlay').remove();
        $('.tp-time-holder').show();
        
        var trackToPlay = [{
            artist: $(this).find('.author').html(),
            title: $(this).find('.title').html() + ' #' + $(this).find('h5 >b').html(),
            url: $(this).find('.play').html(),
            download: $(this).find('.download').html(),
            download_url: $(this).find('.download_url').html().replace(/\&amp;/g,'&')
        }]

	    $('.g-player').thatplayer('playlist', trackToPlay, true);
    });
});
</script>