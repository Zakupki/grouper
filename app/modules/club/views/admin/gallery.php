<div class="widget-last widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a href="#"><?=$this->registry->trans['gallery'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="gallery-admin">
        <form action="/admin/updategallery/" method="post">
          <div class="image-field field">
            <input name="image" id="gallery-admin-image" type="file" />
            <?=$this->registry->trans['uploadimage'];?>
          </div>
          <div class="fields">
            <div class="date-field field">
              <div class="label"><label for="video-admin-date"><?=$this->registry->trans['date'];?></label></div>
              <div class="date-input-weekend date-input">
                <input name="date" id="video-admin-date" value="" type="hidden" />
                <!--span class="day"></span> <span class="month"></span> <span class="year"></span-->
                <span class="date-input-visible"></span>
              </div>
            </div>
            <div class="title-field field">
              <div class="label"><label for="video-admin-title"><?=$this->registry->trans['albumname'];?></label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="title" id="video-admin-title" type="text" /></div></div></div>
            </div>
          </div>
          <div class="list">
            <div class="li hidden">
              <div class="image">
                <div class="img"><img src="" alt="" /></div>
                <span class="remove-link"><i class="i"></i></span>
                <i class="i-frame"></i>
              </div>
            </div>
          </div>
          <div class="submit">
            <div class="input-hide input-checkbox"><input name="hide" id="gallery-admin-hide" value="1" type="checkbox" /><label for="gallery-admin-hide"><?=$this->registry->trans['hidealbum'];?></label></div>
            <div class="remove-link"><span><?=$this->registry->trans['delalbum'];?><i class="i"></i></span></div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    var gallery = $.parseJSON('<?=$this->view->gallery;?>')
    $('.gallery-admin').galleryAdmin();
</script>