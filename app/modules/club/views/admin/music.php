<div class="widget-last widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a href="/music/"><?=$this->registry->trans['music'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="track-admin">
        <form action="/admin/updatemusic/" method="post">
          <div class="upload-wrap">
              <a class="soundcloud"></a>
              <div class="track-field field">
                  <input name="track" id="track-admin-track" type="file" />
                  <?=$this->registry->trans['uploadtrack'];?> (*.mp3)
              </div>
          </div>

          <div class="fields">
            <div class="date-field field">
                <div class="label"><label for="music-admin-date"><?=$this->registry->trans['date'];?></label></div>
                <div class="date-input-weekend date-input">
                    <input name="date" id="music-admin-date" value="" type="hidden" />
                    <span class="day"></span> <span class="month"></span> <span class="year"></span>
                </div>
            </div>

            <div class="title-field field">
              <div class="label"><label for="track-admin-title"><?=$this->registry->trans['title'];?></label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="title" id="track-admin-title" type="text" /></div></div></div>
            </div>

            <div class="cover-field field">
              <div class="label"><label for="track-admin-cover"><?=$this->registry->trans['cover'];?></label></div>
              <div class="cover-input-default cover-input">
                <span class="img"><img src="" alt="" /></span>
                <span class="edit-link"><i class="i"></i></span>
                <span class="upload-link"><span><input name="cover" id="track-admin-cover" type="file" /></span><i class="i"></i></span>
                <span class="remove-link"><i class="i"></i></span>
                <i class="i-frame"></i>
              </div>
            </div>
          </div>

          <div class="submit">
            <div class="hide-input input-checkbox"><input name="hide" id="track-admin-hide" value="1" type="checkbox" /><label for="track-admin-hide"><?=$this->registry->trans['hidetrack'];?></label></div>
            <div class="remove-link"><span><?=$this->registry->trans["deletetrack"];?><i class="i"></i></span></div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    var track = $.parseJSON('<?=$this->view->trackinner;?>'),
        defaultCover = '<?=$this->view->defaultcover;?>',
        langSoundcloudTrackProfileLink = '<?=$this->registry->trans["soundcloudlink"];?>';
</script>