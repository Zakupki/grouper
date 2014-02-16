<div class="widget-last widget">
  <div class="widget-header">
    <div class="widget-share">
      <input name="url" value="_share.php" type="hidden" />
      <input name="item_id" value="648" type="hidden" />
      <div class="i"></div>
      <div class="links">
        <div class="r">
          <div class="l">
            <ul>
              <li class="link-twitter"><a href="http://twitter.com/home?status=ATELIER%20http%3A%2F%2Fatelier.ua%2F" rel="twitter" target="_blank"><span class="total">12</span></a></li>
              <li class="link-facebook"><a href="http://facebook.com/sharer.php?t=ATELIER&amp;u=http%3A%2F%2Fatelier.ua%2F" rel="facebook" target="_blank"><span class="total">12</span></a></li>
              <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2Fatelier.ua%2F" rel="vkontakte" target="_blank"><span class="total">12</span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <span class="menu">Меню</span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a href="/contacts/"><?=$this->view->pagename;?></a></h2>
      <? if(!$this->view->teaser){?>
        <div class="i-pointer"></div>
      <?}?>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
        <div class="restore-password">
            <?=$this->view->text;?>
        </div>
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>