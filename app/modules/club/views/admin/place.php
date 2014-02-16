<div class="widgets-content">
    <div class="widget-last widget-admin widget">
      <div class="widget-header">
        <a class="home" href="/"></a>
        <span class="menu"><?=$this->registry->trans['menu'];?></span>
        <div class="widget-m1">
          <?=$this->view->mainmenu;?>
        </div>
        <div class="widget-title">
          <h2><a href="/place/"><?=$this->registry->trans['place'];?></a></h2>
        </div>
      </div>
      <div class="widget-content-no-footer widget-content">
        <div class="widget-content-wrap">

          <div class="place-admin">
            <form action="/admin/updateplace/" method="post">
                <input type="hidden" name="id" value="<?=$this->view->place['id'];?>"/>
              <div class="fields">
                <div class="gallery-field field">
                  <div class="label"><label for="place-admin-gallery"><?=$this->registry->trans['linkedgal'];?></label></div>
                  <div class="select">
                    <select name="gallery" id="place-admin-gallery">
                      <option></option>
                      <? foreach($this->view->gallerytype as $gallery){?>
                      <option<?=($gallery['id']==$this->view->place['gallerytypeid'])?' selected="selected"':'';?> value="<?=$gallery['id'];?>"><?=$gallery['name'];?></option>
                      <?}?>
                    </select>
                  </div>
                  <div class="notice">
                  	<? if($this->registry->langid==1){?>
					Мы рекомендуем создать галерею<br />с интерьером Вашего заведения и<br />показать ее в данном разделе.
					<?}elseif($this->registry->langid==2){?>
					We reccomend you to create interior gallery and link it here.
					<?}?>
					<i class="i"></i></div>
                </div>
                <div class="title-field field">
                  <div class="label"><label for="place-admin-title"><?=$this->registry->trans['title'];?></label></div>
                  <div class="input-text"><div class="r"><div class="l"><input name="slogan" value="<?=$this->view->place['slogan'];?>" id="place-admin-title" type="text" class="required" /></div></div></div>
                </div>
              </div>
              <div class="address-field field">
                <div class="label"><label for="place-admin-address"><?=$this->registry->trans['address'];?></label></div>
                <div class="input-text"><div class="r"><div class="l"><input name="address" value="<?=$this->view->place['address'];?>" id="place-admin-address" type="text" /></div></div></div>
              </div>
              <div class="fields">
                <div class="video-field field">
                  <div class="label"><label for="place-admin-video"><?=$this->registry->trans['linkedvid'];?></label></div>
                  <div class="select">
                    <select name="video" id="place-admin-video">
                      <option></option>
                      <? foreach($this->view->videos as $video){?>
                      <option<?=($video['id']==$this->view->place['videoid'])?' selected="selected"':'';?> value="<?=$video['id'];?>"><?=$video['name'];?></option>
                      <?}?>
                    </select>
                  </div>
                </div>
                <div class="location-field field">
                  <div class="label"><label for="place-admin-location"><?=$this->registry->trans['maplink'];?></label></div>
                  <div class="input-text"><div class="r"><div class="l"><input name="maplink" value="<?=$this->view->place['maplink'];?>" id="place-admin-location" type="text" /></div></div></div>
                </div>
              </div>
              <div class="text-field field">
                <div class="label"><label for="place-admin-text"><?=$this->registry->trans['descr'];?></label></div>
                <div class="textarea"><textarea name="about" id="place-admin-text" cols="" rows="" class="required"><?=$this->view->place['about'];?></textarea><div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div></div>
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
</div>

<script type="text/javascript">
(function($) {
    $(document).ready(function() {
        $('#place-admin-text').wysiwyg({
            css: '/css/club/jwysiwyg.css',
            initialContent: '<p></p>',
            rmMsWordMarkup: true,
            rmUnwantedBr: true,
            i18n: false,
            rmFormat: {
                rmMsWordMarkup: true
            },
            removeHeadings: true,
            rmUnwantedBr: true,
            removeFormat: true,
            controls: {
                insertOrderedList: { visible : false },
                insertUnorderedList: { visible : false },
                insertHorizontalRule: { visible : false },
                subscript: { visible : false },
                superscript: { visible : false },
                indent: { visible : false },
                outdent: { visible : false },
                unLink: { visible : false },
                insertTable: { visible : false },
                justifyFull: { visible : false },
                h1: { visible : false },
                h2: { visible : false },
                h3: { visible : false },
                code: { visible : false },
                undo: { visible : false },
                redo: { visible : false },
                insertImage: { visible : false },
                createLink: { visible : true },
                unLink: { visible : true },
                html: { visible : true }
            },
            events: {
                paste: function() {
                    var iframe_textarea = $(this).find('body');

                    setTimeout(function() {
                        var html = iframe_textarea.html();

                        html = html.replace(/<(\/)*(\\?xml:|span|p|style|font|del|ins|st1:|[ovwxp]:)(.*?)>/gi, '');
                        html = html.replace(/(class|style|type|start)="(.*?)"/gi, '');
                        html = html.replace( /\s*mso-[^:]+:[^;"]+;?/gi, '' ) ;
                        html = html.replace(/<\s*(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "<$1$3");
                        html = html.replace( /<(\w[^>]*) onmouseover="([^\"]*)"([^>]*)/gi, "<$1$3") ;
                        html = html.replace( /<(\w[^>]*) onmouseout="([^\"]*)"([^>]*)/gi, "<$1$3") ;
                        html = html.replace(/<script(.*?)script>/gi, '');
                        html = html.replace(/<!--(.*?)-->/gi, '');
                        html = html.replace(/<(.*?)>/gi, '');
                        html = html.replace(/<(.*?)\/>/gi, '');
                        html = html.replace(/<\/?(span)[^>]*>/gi, '');
                        html = html.replace(/<\/?(span)[^>]*>/gi, '');
                        html = html.replace( /<\/?(img|font|style|p|div|v:\w+)[^>]*>/gi, '');
                        html = html.replace( /\s*style="\s*"/gi, '' ) ;
                        html = html.replace( /<SPAN\s*[^>]*>\s*&nbsp;\s*<\/SPAN>/gi, '&nbsp;' ) ;
                        html = html.replace( /<SPAN\s*[^>]*><\/SPAN>/gi, '' ) ;

                        iframe_textarea.html(html);
                    }, 100);
                }
            }
        });
    });
})(jQuery);
</script>