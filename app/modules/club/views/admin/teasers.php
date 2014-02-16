<div class="widget-last widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a href="#"><?=$this->registry->trans['banner'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="teasers-admin">
        <form action="/admin/updateteasers/" method="post">
          <div class="teaser-field field">
            <input name="teaser" id="teasers-admin-teaser" type="file" />
           <?=$this->registry->trans['uploadbanner'];?> (980х220 *.jpg)
          </div>
          <ul class="list">
            <li class="hidden">
              <div class="image"><img class="teaser-image" src="" alt="" /><i class="overlay"></i></div>
              <div class="edit">
                <div class="href-input input-text"><div class="r"><div class="l"><!--label>Ссылка (не обязательно)</label--><input name="href[1]" value="" type="text" class="teaser-url" /></div></div></div>
                <div class="hide-input input-checkbox"><label><input class="teaser-hidden" name="hide[1]" value="1" type="checkbox" checked="checked" /><?=$this->registry->trans['hidebanner'];?></label></div>
                <div class="remove-link"><span><?=$this->registry->trans['delbanner'];?><i class="i"></i></span></div>
              </div>
            </li>
            <li class="hidden brand">
              <div class="image"><img class="teaser-image" src="" alt="" /><i class="overlay"></i></div>
              <div class="edit">
                <div class="href-input input-text"><a class="teaser-url"></a></div>
                <div class="date-range">
                  <span class="date-start"></span> - <span class="date-end"></span>
                </div>
              </div>
            </li>
          </ul>
          <div class="submit">
            <div class="notice">
            	<? if($this->registry->langid==1){?>
				Если в Вашем штате нат дизайнера, то лучше не использовать баннеры ;)
				<?}else{?>
				Better not use it if you are not a designer ;)	
				<?}?>	
			<i class="i"></i></div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    var teasers = $.parseJSON('<?=$this->view->teaser;?>')
    $('.teasers-admin').teasersAdmin();
</script>