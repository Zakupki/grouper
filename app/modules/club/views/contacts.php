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
      <h2><a href="/contacts/"><?=$this->view->pagename;?></a></h2>
      <? if(!$this->view->teaser){?>
	  <div class="i-pointer"></div>
	  <?}?>
    </div>
  </div>
  <?=$this->view->teaser;?>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      <? if($this->view->contacts){?>
        <table class="contacts">
      <tr class="first">
          <?
          $tdcnt=0;
          $tableclassArr=array(0=>' class="first"',3=>' class="first"');
          foreach($this->view->contacts as $contact){
          if($tdcnt==4){
          $tdcnt=0;
          echo '
          </tr>
          <tr>';
          }
          ?>
        <td<?=$tableclassArr[$tdcnt];?>>
            <div class="wrap">
                <div class="person"><?=$contact['name'];?><i class="i"></i></div>
                <div class="email"><a href="#"><?=$contact['email'];?></a></div>
                <div class="phone"><?=$contact['phone'];?></div>
                <?
                if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0){
                ?>
                <div class="controls">
                  <i class="i-add"><a href="/admin/contact/"></a></i>
                  <i class="i-edit"><a href="/admin/contact/"></a></i>
                </div>
                <?}?>
            </div>
        </td>
        <?
        $tdcnt++;
        }?>
      </tr>
      </table>
      <? }
      if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && count($this->view->contacts)<1) { ?>
          <a class="add-some" href="/admin/contact/"></a>
      <? } ?>
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>