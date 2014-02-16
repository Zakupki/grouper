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
      <h2><a href="/gallery/"><?=$this->view->pagename;?></a></h2>
      <? if(!$this->view->teaser){?>
	  <div class="i-pointer"></div>
	  <?}?>
    </div>
  </div>
  <?=$this->view->teaser;?>
  <div class="widget-content"><div class="widget-content-wrap">
   <div class="galleries">
    <?
    $cnt=0;
    foreach($this->view->gallery as $gallery){?>
      <div class="li">
        <div class="image">
          <a href="/gallery/<?=$gallery['id'];?>/"><img src="<?=$gallery['preview'];?>" alt="<?=$event['name'];?>" /></a>
          <i class="i-frame"></i>
          <?
          if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0){
          ?>
          <span class="controls">
            <i class="i-add"><a href="/admin/gallery/"></a></i>
            <i class="i-edit"><a href="/admin/gallery/<?=$gallery['id'];?>/"></a></i>
          </span>
          <?}?>
        </div>
        <div class="date"><?=tools::GetDate($gallery['date_start'],$this->registry->langid);?></div>
        <h3><a href="/gallery/<?=$gallery['id'];?>/"><?=$gallery['name'];?></a></h3>
       <ul class="links">
          <li class="comments-link"><a href="/gallery/<?=$gallery['id']?>/"><span class="sep">&bull;</span> <?=$this->view->comments[$gallery['itemid']]['comnum'];?> <span class="new"><?=($this->view->comments[$gallery['itemid']]['comvisnum'])?'('.$this->view->comments[$gallery['itemid']]['comvisnum'].' новых)':'';?></span><i class="i"></i></a></li>
          <li class="likes-link"><a href="/gallery/<?=$gallery['id']?>/"><span class="sep">&bull;</span> <?=tools::int($this->view->rate[$gallery['itemid']]);?><i class="i"></i></a></li>
        </ul>
      </div>
     <?
     $cnt++;
     if($cnt==4){
        echo '<div class="br"></div>';
        $cnt=0;
     }
     }?>
        <? if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && count($this->view->gallery)<1) { ?>
          <a class="add-some-toppad" href="/admin/gallery/"></a>
        <?}?>
   </div>
  </div></div>
  <div class="widget-content-bot"></div>
  <!--div class="widget-footer">
    <div class="widget-more-link">
      <form action="_galleries_more.php" method="post">
        <span>загрузить ещё<i class="i-loading"></i></span>
      </form>
    </div>
  </div-->
</div>
<?=$this->view->widgets;?>