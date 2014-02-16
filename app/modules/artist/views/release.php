<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->releasetype['releasetype']);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <?
        $newArr=array(1=>' class="new"',2=>'');
        foreach($this->view->releasetype['releasetype'] as $type){
        ?>
        <li class="releases-item">
            <a class="release-inner" href="/release/<?=$type['id'];?>/"><img src="<?=$type['url'];?>" width="100" height="100" alt="<?=$type['name'];?>" /></a>
            <div class="details">
                <a class="release-inner" href="/release/<?=$type['id'];?>/">
                    <h4><?=$type['author'];?> &#151;&nbsp;</h4><h5>
                    	<?
						if(strlen($type['name'])>35)
               			 $type['name']=mb_substr($type['name'], 0, 32, 'UTF-8')."...";
						?>
                    	<?=$type['name'];?> 
					<sup <?=$newArr[$type['fresh']];?>><?=count($this->view->releasetype['releasedata'][$type['itemid']]['data']);?></sup></h5>
                </a>
				<?
				if(is_array($this->view->releasetype['releasedata'][$type['itemid']]['remixes'])){
				usort($this->view->releasetype['releasedata'][$type['itemid']]['remixes'], 'tools::sortDesc');
			    foreach($this->view->releasetype['releasedata'][$type['itemid']]['remixes'] as $rem)
				$remixes[$type['itemid']][]=$rem['name'];
				if(count($remixes[$type['itemid']])>0){
				$remixes[$type['itemid']]=strip_tags(implode(', ',$remixes[$type['itemid']]));
                if(strlen($remixes[$type['itemid']])>40)
                $remixes[$type['itemid']]=mb_substr($remixes[$type['itemid']], 0, 37, 'UTF-8')."...";
                ?>
                <p><span>Remixes:</span> <em><?=$remixes[$type['itemid']];?></em></p>
				<?
				}
				}?>
				<p>
					<?
					if(is_array($this->view->releasetype['releasedata'][$type['itemid']]['musictype'])){
					usort($this->view->releasetype['releasedata'][$type['itemid']]['musictype'], 'tools::sortDesc');
				    $mtc=0;
					foreach($this->view->releasetype['releasedata'][$type['itemid']]['musictype'] as $mtype){
						$musictype[$type['itemid']][]=$mtype['name'];
						$mtc++;
						if($mtc==2)
						break;
					}
					if(count($musictype[$type['itemid']])>0){
					?>
					<i><?=implode(',',$musictype[$type['itemid']]);?></i>
					<?
					}
					}?>
					<i><?=Tools::GetDate($type['date_start']);?></i> <i class="label"><?=$type['label'];?></i></p>
                <div class="links">
                	<?
					if(is_array($this->view->releasetype['url'][$type['id']]))
					foreach($this->view->releasetype['url'][$type['id']] as $link){
					if(!$link['image'])
					$link['image']='/img/reactor/release/links_link.png';
					?>
                    <a href="<?=$link['url'];?>" target="_blank" style="background-image:url(<?=$link['image'];?>)"></a>
                	<?}?>
				</div>
            </div>
        </li>
        <? } ?>
    </ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
    
    $('.releases-item .release-inner').click(function(event) {
        event.preventDefault();
        $.history.load($(this).attr('href'));
    });
});
</script>