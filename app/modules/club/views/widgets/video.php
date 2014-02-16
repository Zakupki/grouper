<div class="widget">
  <div class="widget-header">
    <div class="widget-share">
      <input name="url" value="_share.php" type="hidden" />
      <input name="item_id" value="648" type="hidden" />
      <div class="i"></div>
      <div class="links">
        <div class="r">
          <div class="l">
            <ul>
            <li class="link-twitter"><a href="http://twitter.com/home?status=<?=urlencode($_SESSION['Site']['name']);?>%20http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="twitter" target="_blank"><span class="total"><?=tools::getTwCount($_SERVER['HTTP_HOST']);?></span></a></li>
            <li class="link-facebook"><a href="http://facebook.com/sharer.php?u=<?=$_SERVER['HTTP_HOST'];?>" rel="facebook" target="_blank"><span class="total"><?=tools::getFbCount($_SERVER['HTTP_HOST']);?></span></a></li>
            <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="vkontakte" target="_blank"><span class="total"><?=tools::getVkCount($_SERVER['HTTP_HOST']);?></span></a></li>
          </ul>
          </div>
        </div>
      </div>
    </div>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a href="/video/"><?=$this->view->widgetname;?></a></h2>
      <div class="i-pointer"></div>
    </div>
  </div>
  <?=$this->view->teaser;?>
  <div class="widget-content"><div class="widget-content-wrap">
    <div class="videos">
      <? if ($this->view->video) {
        $cnt=0;
        foreach($this->view->video as $video) {
        if ($cnt < 4) { ?>
      <div class="li">
        <div class="image">
          <a href="#videos<?=$video['id']?>" rel="videos" target="_blank"><img src="<?=$video['preview'];?>" alt="<?=$video['name'];?>" /><!--<i class="i-popular"></i>--></a>
          <i class="i-frame"></i>
          <div class="controls">
            <? if (tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0) {?>
              <i class="i-add"><a href="/admin/video/"></a></i>
              <i class="i-edit"><a href="/admin/video/<?=$video['id'];?>"></a></i>
            <? } ?>
            <i class="i-play"><a href="#videos<?=$video['id']?>" rel="videos-play" target="_blank"></a></i>
          </div>
        </div>
        <div class="date"><?=tools::getDate($video['date_create'],$this->registry->langid);?></div>
        <h3><a href="/video/<?=$video['id']?>/"><?=$video['name'];?></a></h3>
        
		<ul class="links">
          <li class="comments-link"><a href="/video/<?=$video['id']?>/"><span class="sep">&bull;</span> <?=$this->view->comments[$video['itemid']]['comnum'];?> <span class="new"><?=($this->view->comments[$video['itemid']]['comvisnum'])?'('.$this->view->comments[$video['itemid']]['comvisnum'].' новых)':'';?></span><i class="i"></i></a></li>
          <li class="likes-link"><a href="/video/<?=$video['id']?>/"><span class="sep">&bull;</span> <?=tools::int($this->view->rate[$video['itemid']]);?><i class="i"></i></a></li>
        </ul>
		
          <div class="code" id="videos<?=$video['id']?>">
          	<?
			if($video['socialid']==227 || $video['socialid']==343 || $video['socialid']==342){
			$youid=tools::youtube_id_from_url(urldecode($video['url']));
			?>
			<object width="640" height="390">
	            <param name="movie" value="https://www.youtube.com/v/<?=$youid;?>?version=3&autoplay=1"></param>
	            <param name="allowScriptAccess" value="always"></param>
	            <embed src="https://www.youtube.com/v/<?=$youid;?>?version=3&autoplay=1" type="application/x-shockwave-flash" allowscriptaccess="always" width="640" height="390"></embed>
          	</object>
			<?}elseif($video['socialid']==232){
			$vimeoid=tools::vimeo_id_from_url(urldecode($video['url']));	
			?>
              <object width="640" height="390">
                  <param name="allowfullscreen" value="true" />
                  <param name="allowscriptaccess" value="always" />
                  <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeoid;?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=<?=$this->registry->sitedata['color'];?>&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" />
                  <embed src="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeoid;?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=<?=$this->registry->sitedata['color'];?>&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="390"></embed>
              </object>
		    <?}?>
			</div>
			
      </div>
      <?
      };
      $cnt++;
      };
      } 
	  if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && count($this->view->video)<1) {
      ?>
        <a class="add-some-toppad" href="/admin/video/"></a>
      <? }; ?>
    </div>
  </div></div>
  <div class="widget-footer">
    <div class="widget-more-link"><a href="/video/"><span><?=$this->registry->trans['allvideos'];?></span></a></div>
  </div>
</div>