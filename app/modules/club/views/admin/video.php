<div class="widget-last widget-admin widget">
  <div class="widget-header">
      <a class="home" href="/"></a>
      <span class="menu"><?=$this->registry->trans['menu'];?></span>
      <div class="widget-m1">
        <?=$this->view->mainmenu;?>
      </div>
      <div class="widget-title">
      <h2><a href="#"><?=$this->registry->trans['video'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      <div class="video-admin">
        <form action="/admin/updatevideo/" method="post">
          <div class="fields">
            <div class="upload-field field">
                <span class="youtube"></span>
                <span class="vimeo"></span>
                <span class="upload-label"><?=$this->registry->trans['uploadvideo'];?></span>
            </div>
            <div class="date-field field">
              <div class="label"><label for="video-admin-date"><?=$this->registry->trans['date'];?></label></div>
              <div class="date-input-weekend date-input">
                <input name="date" id="video-admin-date" value="" type="hidden" />
                <span class="day"></span> <span class="month"></span> <span class="year"></span>
              </div>
            </div>
            <div class="title-field field">
              <div class="label"><label for="video-admin-title"><?=$this->registry->trans['title'];?></label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="title" id="video-admin-title" type="text" /></div></div></div>
            </div>
          </div>
          <div class="preview-field">
            <div class="label"><label for="video-admin-preview"><?=$this->registry->trans['cover'];?></label></div>
            <div class="preview-input-default preview-input">
              <span class="img"><img alt="" /></span>
              <span class="edit-link tooltip-inside">
                  <i class="i"></i>
                  <div class="tooltip_description"><?=$this->registry->trans['library'];?></div>
              </span>
              <span class="upload-link tooltip-inside">
                  <span><input name="preview" id="video-admin-preview" type="file" /></span><i class="i"></i>
                  <div class="tooltip_description"><?=$this->registry->trans['upload'];?></div>
              </span>
              <span class="remove-link"><i class="i"></i></span>
              <i class="i-frame"></i>
            </div>
          </div>
          <div class="submit">
            <div class="hide-input input-checkbox"><input name="hide" id="video-admin-hide" value="1" type="checkbox" /><label for="video-admin-hide"><?=$this->registry->trans['hidevideo'];?></label></div>
            <div class="remove-link"><span><?=$this->registry->trans['deletevideo'];?><i class="i"></i></span></div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    var video = $.parseJSON('<?=$this->view->videoinner;?>'),
        defaultCover = '<?=$this->view->defaultpreview;?>',
        videoCovers = $.parseJSON('<?=$this->view->previewlist;?>'),
        langVideoLink = '<?=$this->registry->trans["videolink"];?>';
</script>