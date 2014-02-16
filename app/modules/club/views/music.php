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
      <h2><a href="/music/"><?=$this->view->pagename;?></a></h2>
      <? if(!$this->view->teaser){?>
	  <div class="i-pointer"></div>
	  <?}?>
    </div>
  </div>
  <?=$this->view->teaser;?>
  <div class="widget-content">
    <div class="widget-content-wrap">
    <div class="tracks">
      <? $cnt=0;
        foreach($this->view->tracks as $track) {
        if(!$track['mp3'] && $track['stream'])
		$track['mp3']=$track['stream'].tools::getStreamParam($track['socialid']);
		?>
        <div class="li">
          <div class="image">
            <input name="artist" value="<?=$_SESSION['Site']['name'];?>" type="hidden" />
            <input name="name" value="<?=$track['name'];?>" type="hidden" />
            <input name="url" value="<?=$track['mp3'];?>" type="hidden" />
            <input name="download" value="0" type="hidden" />
            <img src="<?=$track['cover'];?>" alt="<?=$track['name'];?>" />
            <i class="i-frame"></i>
              <span class="controls<? if (tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0) { ?> controls-admin<? } ?>">
                <? if (tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0) { ?>
                  <i class="i-add"><a href="/admin/music/"></a></i>
                  <i class="i-edit"><a href="/admin/music/<?=$track['id'];?>/"></a></i>
                <? } ?>
                <i class="i-play"></i>
                <i class="i-download"><a href="<?=$track['mp3'];?>"></a></i>
              </span>
          </div>
          <div class="date"><?=tools::GetDate($track['date_start'],$this->registry->langid);?></div>
          <h3><a href="#"><?=$track['name'];?></a></h3>
        </div>
      <?
      $cnt++;
      if($cnt==4){
        $cnt=0;
        echo '<div class="br"></div>';
      }
      } ?>
      <?
      if($_SESSION['User']['id']==$_SESSION['Site']['userid'] && count($this->view->tracks)<1) {
      ?>
        <a class="add-some-toppad" href="/admin/music/"></a>
      <?}?>
    </div>
    </div>
  </div>
  <div class="widget-content-bot"></div>
 <!--div class="widget-footer">
    <div class="widget-more-link">
      <form action="_releases_more.php" method="post">
        <span>загрузить ещё<i class="i-loading"></i></span>
      </form>
    </div>
  </div-->
</div>
<?=$this->view->widgets;?>