<div class="releases-home releases">
  <div class="jflow">
    <div class="jflow-list list">
      <?
	 
	  if(is_array($this->view->releasetype['releasetype']))
	  foreach($this->view->releasetype['releasetype'] as $releasetype){?>
	  <div class="jflow-li li">
        <div class="album">
          <a href="/release/<?=$releasetype['id'];?>/">
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
			usort($this->view->releasetype['releasedata'][$releasetype['itemid']]['remixes'], 'tools::sortDesc');
		    foreach($this->view->releasetype['releasedata'][$releasetype['itemid']]['remixes'] as $rem)
			$remixes[$releasetype['itemid']][]=$rem['name'];
			if(count($remixes[$releasetype['itemid']])>0){
			?>
				<div class="remixes"><strong>Remixes:</strong> 
					<?=implode(',',$remixes[$releasetype['itemid']]);?>
				</div>
        	<?
			}
			usort($this->view->releasetype['releasedata'][$releasetype['itemid']]['musictype'], 'tools::sortDesc');
		    foreach($this->view->releasetype['releasedata'][$releasetype['itemid']]['musictype'] as $mtype)
			$musictype[$releasetype['itemid']][]=$mtype['name'];
			if(count($musictype[$releasetype['itemid']])>0){
			?>
				<div class="style">
					<?=implode(',',$musictype[$releasetype['itemid']]);?>
				</div>
        	<?
			}
			?>
        <div class="label"><?=$releasetype['label'];?></div>
        <div class="date"><?=tools::GetDate($releasetype['date_start']);?></div>
        <div class="links">
        	<? if(!$this->view->releasetype['rate'][$releasetype['itemid']])
		  $this->view->releasetype['rate'][$releasetype['itemid']]=0;
		  ?>
          <div class="link"><a href="/release/<?=$releasetype['id'];?>/"><em>&bull;</em> <?=$this->view->releasetype['rate'][$releasetype['itemid']];?><i class="i-likes"></i></a></div>
          <div class="link"><a href="/release/<?=$releasetype['id'];?>/"><em>&bull;</em> <?=$this->view->releasetype['comments'][$releasetype['itemid']]['comnum'];?>
		  	<?
			if(!$releasetype['date_visit'] && tools::int($_SESSION['User']['id'])>0 && $this->view->releasetype['comments'][$releasetype['itemid']]['comnum']>0)
			$this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum']=$this->view->releasetype['comments'][$releasetype['itemid']]['comnum'];
			if($this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum']>0) { 
			?>
			<span class="new">(<?=$this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum'];?> <?=tools::newend($this->view->releasetype['comments'][$releasetype['itemid']]['comvisnum']);?>)</span>
			<?}?>
		  <i class="i-comments"></i></a></div>
        </div>
      </div>
	  <?}?>
    </div>
  </div>
  <div class="jflow-pager"></div>
</div>


<div class="news-wrap">

  <div class="news">

    <div class="list">

      

      <?
	  $cnt=1;
	  if(is_array($this->view->newslist['news']))
	  foreach($this->view->newslist['news'] as $news){?>
      <div class="li">
        <div class="image">
        	<?
			if($news['url']){
			?>
			<a href="/new/<?=$news['itemid'];?>/">
        		<img src="<?=$news['url2'];?>" alt="" width="220" height="100" /><img src="<?=$news['url'];?>" alt="" width="220" height="100" class="hidden" />
			</a>
			<?
			}
			?>
		</div>
        <div class="author">
          <div class="user"><a href="/users/<?=$news['login'];?>/"><?=$news['displayname'];?><i class="i"></i><i class="i-pro"></i></a></div>
          <div class="date"><?=tools::GetDate($news['date_create']);?> <em>&bull;</em> <?=tools::GetTime($news['date_create']);?></div>
        </div>
        <h3><a href="/new/<?=$news['itemid'];?>/"><?=$news['name'];?></a></h3>
        <div class="text">
          <p>
				<?
				if(strlen($news['preview_text'])>60){
				$news['preview_text']=substr(strip_tags($news['preview_text']), 0, 57)."...";}
				echo $news['preview_text'];
				?>
				
		  </p>
        </div>
        <div class="links">
          <? if(!$this->view->newslist['rate'][$news['itemid']])
		  $this->view->newslist['rate'][$news['itemid']]=0;
		  ?>
          <div class="link"><a href="/new/<?=$news['itemid'];?>/"><em>&bull;</em> <?=$this->view->newslist['rate'][$news['itemid']];?><i class="i-likes"></i></a></div>
          <div class="link"><a href="/new/<?=$news['itemid'];?>/"><em>&bull;</em> <?=$this->view->newslist['comments'][$news['itemid']]['comnum'];?> 
		  	<? 
			if(!$news['date_visit'] && tools::int($_SESSION['User']['id'])>0 && $this->view->newslist['comments'][$news['itemid']]['comnum']>0)
			$this->view->newslist['comments'][$news['itemid']]['comvisnum']=$this->view->newslist['comments'][$news['itemid']]['comnum'];
			if($this->view->newslist['comments'][$news['itemid']]['comvisnum']>0) { ?>
			<span class="new">(<?=$this->view->newslist['comments'][$news['itemid']]['comvisnum'];?> <?=tools::newend($this->view->newslist['comments'][$news['itemid']]['comvisnum']);?>)</span>
			<? } ?>
			<i class="i-comments"></i></a>
		</div>
        </div>
      </div>
	  <?
	  if($cnt==2){
	  	$cnt=1;
		echo '<div class="br"></div>';
	  }
	  else	  
	  $cnt++;
	  }?>
	  
    </div>

    <div class="pager">
      <div class="hr"><i></i></div>
      <div class="all"><a href="/news/">Все новости</a></div>
    </div>

  </div>

  <div class="side-bn"><a href="#"><img src="/_temp/side-bn.jpg" alt="" width="160" height="600" /></a></div>

</div>