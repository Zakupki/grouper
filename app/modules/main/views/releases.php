<h1>
	<?
	if($this->view->registry->routername=='releaseslatest' || $this->view->registry->routername=='releaseslatestinner' ||  $this->view->registry->routername=='releaseslatest2'){
	$urlsuf='latest/';
	echo $this->registry->trans['latest'].' ';
	}
	else 
	echo $this->registry->trans['recommended'].' ';
	?><?=strtolower($this->registry->trans['releases']);?>
</h1>

<div class="releases">

  <div class="list">
	<?
	$cnt=0;
	  if(is_array($this->view->releasetype['releasetype']))
	  foreach($this->view->releasetype['releasetype'] as $releasetype){?>
	  <div class="jflow-li li">
        <div class="album">
          <a href="/release/<?=$urlsuf;?><?=$releasetype['id'];?>/">
            <span class="image">
              <img src="<?=$releasetype['url2'];?>" alt="" />
              <img src="<?=$releasetype['url'];?>" alt="" class="hidden" />
      			  <?if($releasetype['fresh']){?>
                	<i class="i-new"></i>
      			  <?}?>
            </span>
            <span class="title"><span class="artist"><?=$releasetype['author'];?>&nbsp;<span class="sep">&ndash;</span>&nbsp;</span><span class="name"><?=$releasetype['name'];?></span></span>
          </a>
        </div>
        	<?
			if(is_array($this->view->releasetype['releasedata'][$releasetype['itemid']]['remixes'])){
			usort($this->view->releasetype['releasedata'][$releasetype['itemid']]['remixes'], 'tools::sortDesc');
		    foreach($this->view->releasetype['releasedata'][$releasetype['itemid']]['remixes'] as $rem)
			$remixes[$releasetype['itemid']][]=$rem['name'];
			if(count($remixes[$releasetype['itemid']])>0){
			?>
				<div class="remixes"><strong>Remixes:</strong> 
					<?
					if(count($remixes[$releasetype['itemid']])>3){
					$remixes[$releasetype['itemid']]=array_slice($remixes[$releasetype['itemid']],-3);
					}
					echo implode(', ',$remixes[$releasetype['itemid']]);
					
					?>
				</div>
        	<?
			}
			}
			if(is_array($this->view->releasetype['releasedata'][$releasetype['itemid']]['musictype'])){
			usort($this->view->releasetype['releasedata'][$releasetype['itemid']]['musictype'], 'tools::sortDesc');
		    foreach($this->view->releasetype['releasedata'][$releasetype['itemid']]['musictype'] as $mtype)
			$musictype[$releasetype['itemid']][]=$mtype['name'];
			if(count($musictype[$releasetype['itemid']])>0){
			?>
				<div class="style">
					<?=implode(', ',$musictype[$releasetype['itemid']]);?>
				</div>
        	<?
			}
			}
			?>
        <div class="label"><?=$releasetype['label'];?></div>
        <div class="date"><?=tools::GetDate($releasetype['date_start'],$this->registry->langid);?></div>
        <div class="links">
        	<? if(!$this->view->releasetype['rate'][$releasetype['itemid']])
		  $this->view->releasetype['rate'][$releasetype['itemid']]=0;
		  ?>
          <div class="link"><a href="/release/<?=$urlsuf;?><?=$releasetype['id'];?>/"><em>&bull;</em> <?=$this->view->releasetype['rate'][$releasetype['itemid']];?><i class="i-likes"></i></a></div>
          <div class="link"><a href="/release/<?=$urlsuf;?><?=$releasetype['id'];?>/"><em>&bull;</em> <?=$this->view->releasetype['comments'][$releasetype['itemid']]['comnum'];?>
		  	<?
			if(!$releasetype['date_visit'] && tools::int($_SESSION['User']['id'])>0 && $this->view->releasetype['comments'][$releasetype['itemid']]['comnum']>0)
			$this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum']=$this->view->releasetype['comments'][$releasetype['itemid']]['comnum'];
			if($this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum']>0) { 
			?>
			<span class="new">(<?=$this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum'];?> <?=tools::newend($this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum'],$this->registry->langid);?>)</span>
			<?}?>
		  <i class="i-comments"></i></a></div>
        </div>
      </div>
	<?
	$cnt++;
	if($cnt==4){
		echo '<div class="br"></div>';
		$cnt=0;
	}
	
	}?>
	
  </div>
  <?=$this->view->pager;?>
</div>