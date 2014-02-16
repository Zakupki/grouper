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
  <div class="widget-content-no-footer widget-content"><div class="widget-content-wrap">

    <div class="gallery">
      <div class="date"><?=tools::GetDate($this->view->galleryinner[0]['date_start'],$this->registry->langid);?></div>

      <div class="header" style="margin: -7px 0 16px;">
        <h1><?=$this->view->galleryinner[0]['name'];?></h1>
        <div class="i"></div>
      </div>

      <div class="list">
        <?
        $cnt=0;
        foreach($this->view->galleryinner as $gallery){?>
        <div class="li"><a href="<?=$gallery['srcurl'];?>" rel="gallery"><img src="<?=$gallery['url'];?>" alt="<?=$this->view->galleryinner[0]['name'];?>" /></a><i class="i-frame"></i></div>
        <?
        $cnt++;
        if($cnt==4 && $gallery != end($this->view->galleryinner)){
        echo '<div class="br"></div>';
        $cnt=0;
        }
        }?>
        <div class="br"></div>
      </div>
    </div>

    <div class="comments">
        <div class="loading"><i class="i"></i></div>
    </div>

  </div></div>
  <div class="widget-footer-small" style="height:30px;"></div>
  <!--div class="widget-content-bot-dark widget-content-bot"></div-->
</div>
<?=$this->view->widgets;?>

<script type="text/javascript">
    $(function() {
        $.ajax({
            url: '/comments/showgallery/?id=<?=$this->view->galleryinner[0]['itemid'];?>',
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