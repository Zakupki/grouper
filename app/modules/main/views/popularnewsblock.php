
<div class="news-popular">
   
    <ul>
     <?
	  $cnt=1;
	  if(is_array($this->view->newslist['news']))
	  foreach($this->view->newslist['news'] as $news){?>
      
	  <li<?=($cnt==count($this->view->newslist['news']))?' class="last"':'';?>>
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
        <h3><a href="/new/<?=$news['itemid'];?>/"><?=$news['name'];?></a></h3>
        <div class="text">
          <p>
          		<?
				if(strlen($news['preview_text'])>119){
				$news['preview_text']=mb_substr(strip_tags($news['preview_text']), 0, 116, 'UTF-8')."...";}
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
			<span class="new">(<?=$this->view->newslist['comments'][$news['itemid']]['comvisnum'];?> <?=tools::newend($this->view->newslist['comments'][$news['itemid']]['comvisnum'],$this->registry->langid);?>)</span>
			<? } ?>
			<i class="i-comments"></i></a>
		</div>
        </div>
      </li>
	  <?
	  $cnt++;
	  }?>
    </ul>
  
    <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
  </div>