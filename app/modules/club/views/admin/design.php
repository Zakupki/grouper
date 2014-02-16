<div class="widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
     <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click"><?=$this->registry->trans['decor'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="design-admin">
        <form action="/admin/updatedesign/" method="post">
          <div class="fields">
            <div class="mock">
              <i class="i-window i"></i>
              <i class="i-pattern i"></i>
              <i class="i-background i"></i>
              <i class="i-header i"></i>
              <i class="i-margin i"></i>
              <i class="i-frame i"></i>
            </div>
            <div class="input-fields fields">
				<div class="pattern-field field">
                    <input name="pattern" id="design-admin-pattern" type="file" />
                    <?=$this->registry->trans['uploadpattern'];?> (<strong>pattern</strong> *.jpg <?=$this->registry->trans['or'];?> *.gif)
                    <div class="remove-link"><span><?=$this->registry->trans['deletepattern'];?><i class="i"></i></span></div>
                </div>

                <div class="background-field field">
                    <input name="background" id="design-admin-background" type="file" />
                    <?=$this->registry->trans['uploadbg'];?> (<strong>background</strong> *.png, *.jpg <?=$this->registry->trans['or'];?> *.gif)
                    <div class="remove-link"><span><?=$this->registry->trans['deletebg'];?><i class="i"></i></span></div>
                </div>

                <div class="header-field field">
                    <input name="header" id="design-admin-header" type="file" />
                   <?=$this->registry->trans['uploadflashhd'];?> (<strong>flash-header</strong> *.swf)
                    <div class="remove-link"><span><?=$this->registry->trans['deleteflashhd'];?><i class="i"></i></span></div>
                </div>

                <div class="favicon-field field">
                    <input name="favicon" id="design-admin-favicon" type="file" />
                    <?=$this->registry->trans['uploadfavicon'];?> (<strong>favicon</strong> *.jpg, *.gif <?=$this->registry->trans['or'];?> *.png)
                    <div class="remove-link"><span><?=$this->registry->trans['deletefavicon'];?><i class="i"></i></span></div>
                </div>

                <div class="margin-field field">
                    <div class="input-text"><div class="r"><div class="l"><input name="margin" id="design-admin-margin" value="" type="text"></div></div></div>
                    <div class="label"><label for="design-admin-margin">
                    <? if($this->registry->langid==1){
						echo 'пикс. растояние от верха, до блока с содержанием (не более 600)';
					}elseif($this->registry->langid==2){
						echo 'Pixels from head to content block(no more then 600)';
					}?>
					</label></div>
                </div>

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

<div class="widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click"><?=$this->registry->trans['color'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="color-admin">
        <form action="/admin/updatecolor/" method="post">
          <div class="picker"></div>
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
      <h2><a class="no-click"><?=$this->registry->trans['avatar'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="avatar-admin">
        <form action="/admin/updatecover/" method="post">
          <div class="image-field field">
              <input name="image" id="avatar-admin-image" type="file" />
             <?=$this->registry->trans['uploadava'];?> (*.jpg  <?=$this->registry->trans['or'];?> *.gif)
          </div>
          <div class="avatars">
              <div class="li hidden">
                  <img src="" width="100" height="100" alt="" />
                  <span class="remove-link"><i class="i"></i></span>
              </div>
          </div>
          <div class="submit">
            <div class="notice">
            	<? if($this->registry->langid==1){
				echo 'Если Вы часто используете одни и те же картинки,<br />мы Вам рекомендуем использовать эту библиотеку';
				}else{
				echo 'Upload images that you often use';
				}?>
				<i class="i"></i></div>
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
      <h2><a class="no-click"> <?=$this->registry->trans['poster'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      
      <div class="poster-admin">
        <form action="/admin/updateposter/" method="post">
          <div class="image-field field">
            <input name="image" id="poster-admin-image" type="file" />
             <?=$this->registry->trans['uploadposter'];?> (*.jpg  <?=$this->registry->trans['or'];?> *.gif)
          </div>
          <div class="posters">
            <div class="li hidden">
              <img src="" width="100" height="140" alt="" />
              <span class="remove-link"><i class="i"></i></span>
            </div>
          </div>
          <div class="submit">
            <div class="notice">
				<? if($this->registry->langid==1){
				echo 'Если Вы часто используете одни и те же картинки,<br />мы Вам рекомендуем использовать эту библиотеку';
				}else{
				echo 'Upload images that you often use';
				}?>
			<i class="i"></i></div>
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
      <h2><a class="no-click"><?=$this->registry->trans['preview'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">
      
      <div class="preview-admin">
        <form action="/admin/updatevideopreview/" method="post">
          <div class="image-field field">
              <input name="image" id="preview-admin-image" type="file" />
              <?=$this->registry->trans['uploadpreview'];?> (*.jpg <?=$this->registry->trans['or'];?> *.gif)
          </div>

          <div class="previews">
              <div class="li hidden">
                <img src="" width="220" height="100" alt="" />
                <span class="remove-link"><i class="i"></i></span>
              </div>
          </div>

          <div class="submit">
            <div class="notice">
				<? if($this->registry->langid==1){
				echo 'Если Вы часто используете одни и те же картинки,<br />мы Вам рекомендуем использовать эту библиотеку';
				}else{
				echo 'Upload images that you often use';
				}?>
			<i class="i"></i></div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>

        </form>
      </div>
      
    </div>
  </div>
  <div class="widget-content-bot"></div>
</div>

<!--div class="widget-last widget-admin widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><a class="no-click"><?=$this->registry->trans['logo'];?></a></h2>
    </div>
  </div>
  <div class="widget-content-no-footer widget-content">
    <div class="widget-content-wrap">

      <div class="logo-admin">
        <form action="/admin/updateclublogo/" method="post">
          <div class="cover">
              <img alt="" />
              <span class="remove-link"><i class="i"></i></span>
          </div>

          <div class="image-field field">
              <input name="image" id="logo-admin-image" type="file" />
              <?=$this->registry->trans['uploadlogo'];?> (*.jpg, *.gif)
              <div class="remove-link"><span><?=$this->registry->trans['deletearchive'];?><i class="i"></i></span></div>
          </div>

          <div class="logo-notice">
          	<? if($this->registry->langid==1){
			echo 'Логотип вашего заведения должен быть на фоне с кодом <b>#e6e6e6</b>. Если Вы не в состоянии или Вам просто лень выполнить данную просьбу, загрузите архив (*.zip или *.rar) с логотипом и наш дизайнер круто сделают всю работу за Вас ! ;)'; 
			}elseif($this->registry->langid==2){
			echo "The background of your logo must be <b>#e6e6e6</b>. If you can't do it yourself, please upload it in an archive and our designer will do it for you.";
			}?>
			<i class="i"></i></div>

          <div class="submit">
            <div class="notice">
            	<? if($this->registry->langid==1){
				echo 'Данный логотип используется только на портале ReParty';
				}elseif($this->registry->langid==2){
				echo 'This logo is only used on ReParty';	
				}?>
				<i class="i"></i></div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="widget-content-bot"></div>
</div-->

<script type="text/javascript">
    var reccountDesignOptions = $.parseJSON('<?=$this->view->designoptions;?>'),
        reccountColor = $.parseJSON('<?=$this->view->color;?>'),
        reccountAvatars = $.parseJSON('<?=$this->view->cover;?>');
        reccountPosters = $.parseJSON('<?=$this->view->poster;?>');
        reccountVideoPreviews = $.parseJSON('<?=$this->view->videopreview;?>'),
        reccountLogo = $.parseJSON('<?=$this->view->clublogo;?>');
</script>