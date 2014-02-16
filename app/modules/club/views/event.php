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

    <div class="event">
      <div class="<?=($this->view->eventinner['dayinweek']==6 || $this->view->eventinner['dayinweek']==7)?'date-weekend ':'';?>date">
            <div class="day"><?=$this->view->eventinner['dayinmonth'];?></div>
            <div class="month"><?=tools::GetMonth($this->view->eventinner['month'],$this->registry->langid);?></div>
            <div class="weekday"><?=tools::GetDayOfWeek($this->view->eventinner['dayinweek'],$this->registry->langid);?></div>
            <div class="i"></div>
      </div>
      <div class="poster">
      <? if($this->view->eventinner['poster']){ ?>
        <img src="<?=$this->view->eventinner['poster'];?>" alt="<?=$this->view->eventinner['name'];?>" />
      <? } else { ?>
        <img src="/img/club/event-admin/poster-default.jpg" alt="<?=$this->view->eventinner['name'];?>" />
      <? } ?>
      </div>
      <div class="descr">
        <? if($this->view->eventinner['name']){?>
        <h2><strong><?=$this->view->eventinner['name'];?></strong><i class="i"></i></h2>
        <?}
              $artistHTML=null;
              $supportHTML=null;
              if(is_array($this->view->artists)){
              foreach($this->view->artists as $artist){
                  if($artist['support'])
                  $supportHTML.='<li class="li"><h4>'.$artist['name'].'</h4><div class="i"></i></li>';
                  else
                  $artistHTML.='
                  <li>
                    <h3>'.$artist['name'].'</h3>
                    <div class="label">'.$artist['comment'].'</div>
                    <div class="i"><b></b></div>
                  </li>';
              }
              }
        if(strlen($artistHTML)>1){
        ?>
        <div class="guests<?=($this->view->eventinner['name'])?'':' without-event-name';?>">
          <ul>
            <?=$artistHTML;?>
          </ul>
        </div>
        <?}
        if(strlen($supportHTML)>1){
        ?>
        <div class="artists">
          <ul>
            <?=$supportHTML;?>
          </ul>
        </div>
        <?}
        if(strlen($this->view->eventinner['detail_text'])>0){?>
        <div class="text">
          <p><?=$this->view->eventinner['detail_text'];?></p>
        </div>
        <?}
        if(is_array($this->view->socials)){?>
        <ul class="links">
          <? foreach($this->view->socials as $social){
            $prottype='http://';
            if(strstr($social['url'],'https://')){
            $prottype='https://';
            $social['url']=str_replace('https://', '', $social['url']);
            }
            elseif(strstr($social['url'],'http://')){
            $social['url']=str_replace('http://', '', $social['url']);
            $prottype='http://';
            }
			if(!$social['img'])
			$social['img']='/img/reactor/release/links_link.png';
          ?>
          <li><a href="<?=$prottype;?><?=$social['url'];?>"><?=$social['url'];?><i class="i" style="background-image: url(<?=$social['img'];?>);"></i></a></li>
          <?}?>
          <!--<li><a href="#">http://r43.tish.ua<i class="i-reccount i"></i></a></li>-->
        </ul>
        <?}?>
      </div>
    </div>

    <div class="comments">
        <input name="comments_url" value="/comments/showevent/?id=<?=$this->view->eventinner['itemid'];?>" type="hidden" />
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
          url: '/comments/showevent/?id=<?=$this->view->eventinner['itemid'];?>',
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