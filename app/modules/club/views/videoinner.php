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
      <h2><a href="/events/"><?=$this->view->pagename;?></a></h2>
    </div>
  </div>
  <?=$this->view->teaser;?>

  <div class="widget-content-no-footer widget-content widget-nopadding"><div class="widget-content-wrap">

      <div class="video">
          <?
			if($this->view->videoinner['socialid']==227 || $this->view->videoinner['socialid']==343 || $this->view->videoinner['socialid']==342){
			$youid=tools::youtube_id_from_url(urldecode($this->view->videoinner['url']));
			?>
			<object width="940" height="529">
	            <param name="movie" value="https://www.youtube.com/v/<?=$youid;?>?version=3&autoplay=1"></param>
	            <param name="allowScriptAccess" value="always"></param>
	            <embed src="https://www.youtube.com/v/<?=$youid;?>?version=3&autoplay=1" type="application/x-shockwave-flash" allowscriptaccess="always" width="940" height="529"></embed>
          	</object>
			<?}elseif($this->view->videoinner['socialid']==232){
			$vimeoid=tools::vimeo_id_from_url(urldecode($this->view->videoinner['url']));	
			?>
              <object width="940" height="529">
                  <param name="allowfullscreen" value="true" />
                  <param name="allowscriptaccess" value="always" />
                  <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeoid;?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=<?=$this->registry->sitedata['color'];?>&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" />
                  <embed src="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeoid;?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=<?=$this->registry->sitedata['color'];?>&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="940" height="529"></embed>
              </object>
		    <?}?>
		  
		  
      </div>

    <div class="comments">
        <div class="loading"><i class="i"></i></div>
    </div>
  </div>
  <br/>
  </div>
  <!--<div class="widget-content-bot-dark widget-content-bot"></div>-->
   <div class="widget-footer-small"></div>

</div>
<?=$this->view->widgets;?>

<script type="text/javascript">
    $(function() {
        $.ajax({
          url: '/comments/showvideo/?id=<?=$this->view->videoinner['itemid'];?>',
          beforeSend: function() {
              $('.comments').html('<div class="comments-loading"><i></i></div>');
          },
          success: function(data){
              var contentData = $.parseJSON(data);
              $('.comments').html(contentData.content).comments();
              $('.post-rate').rate();
              $('.post-share').share();
              $('label.placeholder').placeholder();
              $('.auth form').authForm({link: '.auth-popup-link', src: '#auth-popup-src'});
          }
        });
    });
</script>