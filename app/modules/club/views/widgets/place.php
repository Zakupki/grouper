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
      <h2><a href="/place/"><?=$this->view->widgetname;?></a></h2>
      <div class="i-pointer"></div>
    </div>
  </div>
  <?=$this->view->teaser;?>
  <div class="widget-content"><div class="widget-content-wrap">
    <div class="place">
        <div class="gallery-link">
            <? if($this->view->place['gallerytypeid']){?>
			<div class="image"><a href="/gallery/<?=$this->view->place['gallerytypeid'];?>/"><img src="<?=$this->view->place['preview'];?>" alt="<?=$this->view->place['gallerytypename'];?>" /></a><i class="i-frame"></i></div>
            <div class="date"><?=tools::GetDate($this->view->place['date_start']);?></div>
            <h3><a href="/gallery/<?=$this->view->place['gallerytypeid'];?>/"><?=$this->view->place['gallerytypename'];?></a></h3>
            <!--<ul class="links">
              <li class="comments-link"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
              <li class="likes-link"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
            </ul>-->
			<?}?>
		  <? if($this->view->place['videourl']){?>
          <div class="b-video">
            <div class="image">
                <a href="/<?=$this->view->place['videourl'];?>"><img src="<?=$this->view->place['videopreview'];?>" alt="<?=$this->view->place['videoname'];?>" /></a>
                <i class="i-frame"></i>
                <div class="controls">
                    <i class="i-play"><a href="#videos<?=$this->view->place['id']?>" rel="videos-play" target="_blank"></a></i>
                </div>
            </div>
            <div class="date"><?=tools::GetDate($this->view->place['videodate']);?></div>
            <h3><a href="<?=$this->view->place['videourl'];?>"><?=$this->view->place['videoname'];?></a></h3>
            <div class="code" id="videos<?=$this->view->place['id']?>">
                <? if($this->view->place['videosocialid']==227 || $this->view->place['videosocialid']==343 || $this->view->place['videosocialid']==342){
                    $youid=tools::youtube_id_from_url($this->view->place['videourl']);
                    ?>
                    <object width="640" height="390">
                        <param name="movie" value="https://www.youtube.com/v/<?=$youid;?>?version=3&autoplay=1"></param>
                        <param name="allowScriptAccess" value="always"></param>
                        <embed src="https://www.youtube.com/v/<?=$youid;?>?version=3&autoplay=1" type="application/x-shockwave-flash" allowscriptaccess="always" width="640" height="390"></embed>
                    </object>

                <? } elseif($this->view->place['videosocialid']==232) {
                    $vimeoid=tools::vimeo_id_from_url($this->view->place['videourl']);
                    ?>
                    <object width="640" height="390">
                        <param name="allowfullscreen" value="true" />
                        <param name="allowscriptaccess" value="always" />
                        <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeoid;?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=<?=$this->registry->sitedata['color'];?>&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" />
                        <embed src="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeoid;?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=<?=$this->registry->sitedata['color'];?>&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="390"></embed>
                    </object>
                <? } ?>
            </div>
          </div>
		  <?}?>
        </div>
      <div class="descr">
        <? if($this->view->place['slogan']){?>
        <h2><a href="/place/"><strong><?=$this->view->place['slogan'];?></strong><i class="i"></i></a></h2>
        <?}?>
        <? if($this->view->place['address']){?>
        <div class="location"><a href="<?=$this->view->place['maplink'];?>" target="_blank"><?=$this->view->place['address'];?><i class="i"></i></a></div>
        <?}?>
        <? if($this->view->place['about']){?>
        <div class="text">
          <p>
            <?
            if(strlen($this->view->place['about'])>270){
            $this->view->place['about']=mb_substr(strip_tags($this->view->place['about']), 0, 267, 'UTF-8')."...";}
            echo $this->view->place['about'];?>
          </p>
        </div>
        <?}else{?>
		<div style="height:80px;"></div>
		<?}?>
      </div>
      <?
      if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0){
      ?>
      <div class="controls">
        <i class="i-edit"><a href="/admin/place/"></a></i>
      </div>
      <?}?>
    </div>
  </div></div>
  <div class="widget-content-bot"></div>
  <div class="widget-footer">
    <div class="widget-more-link"><a href="/place/"><span><?=$this->registry->trans['readmore'];?></span></a></div>
  </div>
</div>