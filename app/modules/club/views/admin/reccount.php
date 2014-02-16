<div class="widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
     <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click"><?=$this->registry->trans['menu'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      <div class="menu-admin">
        <form action="/admin/updatemenu/" method="post">
          <div class="labels">
            <div class="label"><label><?=$this->registry->trans['displayas'];?>:</label></div>
          </div>
          <ul class="jlist">
              <li class="hidden">
                <div class="title-label label"><label class="menu-admin-menutype-name"></label></div>
                <div class="title-input input-text"><div class="r"><div class="l"><input name="title[<?=$menuitem['id'];?>]" class="menu-admin-events-title" value="" type="text" /></div></div></div>
                <div class="banner-input input-checkbox"><label><input name="banner[]" class="menu-admin-events-banner" value="1" type="checkbox" class="recommended" /><?=$this->registry->trans['showbanner'];?></label></div>
                <div class="home-input input-checkbox"><label><input name="home[]" class="menu-admin-events-home" value="1" type="checkbox" class="recommended" /><?=$this->registry->trans['widgetonhome'];?></label></div>
                <div class="all-input input-checkbox"><label><input name="all[]" class="menu-admin-events-all" value="1" type="checkbox" /><?=$this->registry->trans['widgetall'];?></label></div>
                <div class="hide-input input-checkbox"><label><input name="hide[]" class="menu-admin-events-hide" value="1" type="checkbox" /><?=$this->registry->trans['hide'];?></label></div>
                <div class="handle"></div>
              </li>
          </ul>
          <div class="submit">
            <div class="soon">
            	<? if($this->registry->langid==1){?>
				Блог, Партнеры, Резиденты <em>(скоро)</em>
				<? }elseif($this->registry->langid==2){?>
				Blog, Partners, Residents <em>(soon)</em>
				<?}?>
				</div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<div class="widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
     <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click"><?=$this->registry->trans['links'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      <div class="links-admin">
        <form action="/admin/updatesocial/" method="post">
          <div class="labels">
            <div class="label"><label><?=$this->registry->trans['socialprofiles'];?>:</label></div>
          </div>
          <ul class="jlist">
            <li class="placeholder">
              <div class="input-text"><div class="r"><div class="l"><input class="link-admin-link" name="href[0]" type="text" /></div></div></div>
              <div class="remove-link"><span><?=$this->registry->trans['deletelink'];?><i class="i"></i></span></div>
              <div class="handle"></div>
            </li>
          </ul>
          <div class="submit">
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<div class="widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
     <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click"><?=$this->registry->trans['main'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      <div class="basic-admin">
        <div class="title-admin">
          <form action="/admin/updatename/" method="post">
            <div class="title-field field">
              <div class="label"><label for="title-admin-title"><?=$this->registry->trans['placetitle'];?></label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="title" id="title-admin-title" type="text" class="required" /></div></div></div>
              <div class="notice">
                <? if($this->registry->langid==1){?>
        Убедительная просьба не писать название Вашего заведения заглавными буквами и не использовать символы.<br />Например: <em class="wrong">«MANTRA PARTY BAR»</em> и <em class="wrong">«M@}{TRA P@RTY B@R»</em> &mdash; не правильно и не красиво. Правильно &mdash; <em>Mantra Party Bar</em>
        <? }elseif($this->registry->langid==2){?>
        Do not write in capitals.
        <?}?>
        <i class="i"></i></div>
            </div>
            <div class="meta-title-field field">
              <div class="label"><label for="title-admin-meta-title">Meta Title</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="meta_title" id="title-admin-meta-title" type="text" /></div></div></div>
            </div>
            <div class="meta-keywords-field field">
              <div class="label"><label for="title-admin-meta-keywords">Meta Keywords</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="meta_keywords" id="title-admin-meta-keywords" type="text" /></div></div></div>
            </div>
            <div class="meta-description-field field">
              <div class="label"><label for="title-admin-meta-description">Meta Description</label></div>
              <textarea name="meta_description" id="title-admin-meta-description" type="text"></textarea>
            </div>
            <div class="submit">
              <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
            </div>
          </form>
        </div>

        <div class="state-admin">
          <form action="/admin/updatestate/" method="post">
            <input name="action" value="0" type="hidden" />
            <div class="button-off button">
              <button type="submit"></button>
              <label>Выключить реккаунт</label>
              <i class="i"></i>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<div class="widget-last widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
     <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click">URL</a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      <div class="url-admin">
        <form action="/admin/updateurl/" method="post">
          <div class="fields">
            <div class="url-field field">
              <div class="label"><label for="url-admin-url"><?=$this->registry->trans['yourdomain'];?>:</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="url" id="url-admin-url" type="text" /></div></div></div>
             </div>
            <div class="ip-field field">
              <div class="label"><label><?=$this->registry->trans['ourip'];?>:</label></div>
              <div class="input-text-readonly input-text"><div class="r"><div class="l"><span class="input"><?=$this->view->ip;?></span></div></div></div>
            </div>
         	
          </div>
          <div class="submit">
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
var reccountName = $.parseJSON('<?=$this->view->name;?>'),
    reccountMenu = $.parseJSON('<?=$this->view->menu;?>'),
    reccountSocialLinks = $.parseJSON('<?=$this->view->sociallist;?>'),
    reccountUrl = $.parseJSON('<?=$this->view->url;?>'),
    langCopyVideo = '<?=$this->registry->trans["copyvideo"];?>',
    langCopyMusic = '<?=$this->registry->trans["copymusic"];?>';
</script>