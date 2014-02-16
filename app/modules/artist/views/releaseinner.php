<a class="b-backlink" href="/release/"><h2 class="white"><?=$this->view->pagetitle;?><sup><?=$this->view->cnt['cnt'];?></sup></h2></a>
<h3><?=$this->view->releasetitle;?><sup><?=count($this->view->release);?></sup></h3>
<? if(is_array($this->view->shops)){?>
<div class="stores-links">
	<?
	foreach($this->view->shops as $shop){
		if(!$shop['image'])
		$shop['image']='/img/reactor/release/links_link.png';
	?>
	<a href="<?=$shop['url'];?>" target="_blank" style="background-image:url(<?=$shop['image'];?>)"></a>
	<?}?>
</div>
<?}?>
<div class="b-container">
    <ul class="b-slider">
        <li class="release-item">
            <?
            $tcnt=1;
            $cnt=1;
            foreach($this->view->release as $release){
            if(!$release['mp3id'] && $release['stream']){
			$release['mp3']=$release['stream'].tools::getStreamParam($release['socialid']);	
			}
			?>
			<? if(strlen($release['remix'])>0 && strtolower(trim($release['remix']))!=='original mix')
					$release['remix']=' ('.$release['remix'].')';
					else
					$release['remix']='';
					?>
            <div class="release-item-wrap">
                <div class="cover">
                    <img width="40" height="40" src="<?=$release['url'];?>" alt="Another strange picture" />
                    <span class="play"><?=$release['mp3'];?></span>
					<span class="download_url">/file/getmp3/?f=<?=$release['mp3id'];?>&name=<?=$release['author'];?> - <?=$release['releasename'];?><?=$release['remix'];?></span>
                </div>
			
                <div class="details">
                    <span class="download"><?=$release['download'];?></span>
                    <h4><span class="author"><?=$release['author'];?></span> &#151;</h4>
                    
					<h5><span class="title"><?=$release['releasename'];?><?=$release['remix'];?></span>
					<? if($release['promocut']){?>
					<span class="promocut"></span>
					<?}?>
					</h5>
                    <p>
                        <? if(count($this->view->releasemusic[$release['id']])>0){?>
                        <i><?=implode(',',$this->view->releasemusic[$release['id']]);?></i>
                        <?}?>
                        <i><?=Tools::GetDate($release['date_create']);?></i> <i class="label"><?=$release['label'];?></i>
					</p>
                </div>
            </div>
            <?
            if($cnt==2 && $tcnt<count($this->view->release)){
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
$(function(){
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
    
    $('.b-backlink').click(function(event) {
        event.preventDefault();
        $.history.load($(this).attr('href'));
    });

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