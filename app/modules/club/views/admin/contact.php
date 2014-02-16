<div class="widget-last widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><?=$this->registry->trans['contacts'];?></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="contacts-admin">
        <form action="/admin/updatecontacts/" method="post">
          <div class="labels">
            <div class="title-label label"><label><?=$this->registry->trans['contactname'];?></label></div>
            <div class="email-label label"><label>E-mail</label></div>
            <div class="phone-label label"><label><?=$this->registry->trans['phone'];?></label></div>
          </div>
          <ul class="jlist">
            <li class="placeholder">
              <div class="title-input input-text"><div class="r"><div class="l"><input class="name" name="title" type="text" /></div></div></div>
              <div class="email-input input-text"><div class="r"><div class="l"><input class="email" name="email" type="text" /></div></div></div>
              <div class="phone-input input-text"><div class="r"><div class="l"><input class="phone" name="phone" type="text" /></div></div></div>
              <div class="remove-link"><span><?=$this->registry->trans['delcontact'];?><i class="i"></i></span></div>
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

<script type="text/javascript">
    var contacts = $.parseJSON('<?=$this->view->contact;?>')
</script>