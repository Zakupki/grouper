<h1><?
	if($this->view->newslist['news'][0]['tagname']){
	echo 'Новости по тэгу: '.$this->view->newslist['news'][0]['tagname'];
	}
	else{
	if($this->view->registry->routername=='newslatest' || $this->view->registry->routername=='newslatestinner' ||  $this->view->registry->routername=='newslatest2'){
	$urlsuf='latest/';
	echo $this->registry->trans['latest'].' ';
	}
	elseif($this->view->registry->routername=='newsservice') 
	echo 'Служебные ';
	else
	echo $this->registry->trans['recommended'].' ';
	?><?=strtolower($this->registry->trans['news']);?>
	<?}?>
	</h1>


<div class="news-wrap">

  <div class="news">

    <div class="list">

      
      <?
	  $cnt=1;
	  $tlcnt=0;
	  if(is_array($this->view->newslist['news']))
	  foreach($this->view->newslist['news'] as $news){?>
      <div class="li">
        <?
		$show_image=false;
		if($cnt==1 && $this->view->newslist['news'][$tlcnt+1]['url'])
	  	{
	  		$show_image=true;
	  	}
		elseif($cnt==2 && $this->view->newslist['news'][$tlcnt-1]['url']){
			$show_image=true;
		}
		if($show_image || $news['url']){?>
		<div class="image">
		<?}?>
        	<?
			if($news['url']){
			?>
			<a href="/new/<?=$urlsuf;?><?=$news['itemid'];?>/">
        		<img src="<?=$news['url2'];?>" alt="" width="220" height="100" /><img src="<?=$news['url'];?>" alt="" width="220" height="100" class="hidden" />
			</a>
			<?
			}
		if($show_image || $news['url']){
		?>
		</div>
		<?}?>
		
		<?
			if($news['domain'])
			$news['siteurl']='http://'.$news['domain'];
			else
			$news['siteurl']='http://r'.$news['siteid'].'.'.str_replace('www.','',$_SERVER['HTTP_HOST']).'/';
			?>
		
		<div class="author">
          <div class="user"><a href="<?=$news['siteurl'];?>"><?=$news['sitename'];?><i class="i-dj"></i></a></div>
          <div class="date"><?=tools::GetDate($news['date_start'],$this->registry->langid);?></div>
        </div>
        <h3><a href="/new/<?=$urlsuf;?><?=$news['itemid'];?>/"><?=$news['name'];?></a></h3>
        <div class="text">
          <p>
				<?
				if(strlen($news['preview_text'])>139){
				$news['preview_text']=mb_substr(strip_tags($news['preview_text']), 0, 136, 'UTF-8')."...";}
				echo $news['preview_text'];
				?>
				
		  </p>
        </div>
        <div class="links">
          <? if(!$this->view->newslist['rate'][$news['itemid']])
		  $this->view->newslist['rate'][$news['itemid']]=0;
		  ?>
          <div class="link"><a href="/new/<?=$urlsuf;?><?=$news['itemid'];?>/"><em>&bull;</em> <?=$this->view->newslist['rate'][$news['itemid']];?><i class="i-likes"></i></a></div>
          <div class="link"><a href="/new/<?=$urlsuf;?><?=$news['itemid'];?>/"><em>&bull;</em> <?=$this->view->newslist['comments'][$news['itemid']]['comnum'];?> 
		  	<? 
			if(!$news['date_visit'] && tools::int($_SESSION['User']['id'])>0 && $this->view->newslist['comments'][$news['itemid']]['comnum']>0)
			$this->view->newslist['comments'][$news['itemid']]['comvisnum']=$this->view->newslist['comments'][$news['itemid']]['comnum'];
			if($this->view->newslist['comments'][$news['itemid']]['comvisnum']>0) { ?>
			<span class="new">(<?=$this->view->newslist['comments'][$news['itemid']]['comvisnum'];?> <?=tools::newend($this->view->newslist['comments'][$news['itemid']]['comvisnum'],$this->registry->langid);?>)</span>
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
	  $tlcnt++;
	  }?>
	  

    </div>

	<?=$this->view->pager;?>
    <!--<div class="pager">
      <div class="hr"><i></i></div>
      <ul>
        <li class="prev"><a href="#"><i class="i"></i></a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li>3</li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">8</a></li>
        <li><a href="#">9</a></li>
        <li class="last"><a href="#">10</a></li>
        <li class="next"><a href="#"><i class="i"></i></a></li>
      </ul>
    </div>-->

  </div>


  <?=$this->view->banner;?>

</div>


<!--
        <?
		  $cnt=0;
		  foreach($this->view->newslist as $news){
		  if($cnt==2){
		  $cnt=0;
		  echo '<div class="br"></div>';	
		  }
		  ?>
		  <div class="li">
  
            <div class="img"><a href="/new/<?=$news['itemid'];?>/"><img src="/img/reactor/content/news1.gif" alt="news1" width="220" height="100" /></a></div>
  
            <div class="author">
              <div class="user"><a href="/users/<?=$news['userid'];?>/"><?=$news['login'];?><i class="i"></i><i class="i-pro"></i></a></div>
              <div class="date"><?=tools::GetDate($news['date_start']);?></div>
            </div>
  
            <h3><?=$news['name'];?></h3>
  
            <div class="text">
              <p><?=$news['preview_text'];?></p>
            </div>
  
            <div class="links">
              <div class="link"><a href="#">&bull; 23<i class="i-likes"></i></a></div>
              <div class="link"><a href="#">&bull; 23 <span class="new">(3 новых)</span><i class="i-comments"></i></a></div>
            </div>
  
          </div>
		  <?
		  $cnt++;
		  }?>
-->