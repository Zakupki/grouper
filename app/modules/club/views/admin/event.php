<div class="widgets-content">
  <div class="widget-last widget-admin widget">
    <div class="widget-header">
      <a class="home" href="/"></a>
      <span class="menu"><?=$this->registry->trans['menu'];?></span>
      <div class="widget-m1">
        <?=$this->view->mainmenu;?>
      </div>
      <div class="widget-title">
        <h2><a href="/events/"><?=$this->registry->trans['events'];?></a></h2>
      </div>
    </div>

    <div class="widget-content-no-footer widget-content">
      <div class="widget-content-wrap">

        <div class="event-admin">
          <form action="/admin/updateevent/" method="post">
            <div class="fields">
              <div class="sidebar">
                <div class="date-field field">
                  <div class="label"><label for="event-admin-date"><?=$this->registry->trans['date'];?></label></div>
                  <div class="date-input-weekend date date-input">
                    <input name="date" id="event-admin-date" value="" type="hidden" />
                    <span class="day"></span>
                    <span class="month"></span>
                    <span class="weekday"></span>
                    <i class="i-frame"></i>
                  </div>
                </div>
                <div class="avatar-field field">
                  <div class="label"><label for="event-admin-avatar"><?=$this->registry->trans['avatar'];?></label></div>
                  <div class="avatar-input-default avatar-input">
                    <span class="img"><img src="" alt="" /></span>
                    <span class="select-link tooltip-inside tooltiptop">
                        <i class="i"></i>
                        <div class="tooltip_description"><?=$this->registry->trans['library'];?></div>
                    </span>
                    <span class="upload-link tooltip-inside tooltiptop">
                        <span><input name="avatar" id="event-admin-avatar" type="file" /></span><i class="i"></i>
                        <div class="tooltip_description"><?=$this->registry->trans['upload'];?></div>
                    </span>
                    <span class="remove-link"><i class="i"></i></span>
                    <i class="i-frame"></i>
                  </div>
                </div>
                <div class="poster-field field">
                  <div class="label"><label for="event-admin-poster"><?=$this->registry->trans['poster'];?></label></div>
                  <div class="poster-input-default poster-input">
                    <span class="img"><img src="" alt="" /></span>
                    <span class="select-link tooltip-inside tooltiptop">
                        <i class="i"></i>
                        <div class="tooltip_description"><?=$this->registry->trans['library'];?></div>
                    </span>
                    <span class="upload-link tooltip-inside tooltiptop">
                        <span><input name="poster" id="event-admin-poster" type="file" /></span><i class="i"></i>
                        <div class="tooltip_description"><?=$this->registry->trans['upload'];?></div>
                    </span>
                    <span class="remove-link"><i class="i"></i></span>
                    <i class="i-frame"></i>
                  </div>
                </div>
              </div>
              <div class="descr">
                <!--div class="options">
                    <div class="button use-template"><div class="r"><div class="l"><button type="button">Применить шаблон</button></div></div></div>
                    <div class="inner">
                        <label class="without-border">
                            <i>Начало в</i>
                            <div class="name-input input-text"><div class="r"><div class="l"><input name="" type="text" maxlength="5" /></div></div></div>
                        </label><label><input type="radio" name="event-type" checked="checked" />Nightparty</label><label><input type="radio" name="event-type" />Dayparty</label><label><input type="radio" name="event-type" />Afterparty</label><label><input type="radio" name="event-type" />Концерт</label><label><input type="radio" name="event-type" />Шоу</label><label class="without-border"><input type="radio" name="event-type" />Детям</label>
                    </div>
                </div-->
                <div class="title-field field">
                  <div class="label"><label for="event-admin-title"><?=$this->registry->trans['eventname'];?></label></div>
                  <div class="input-text"><div class="r"><div class="l"><input name="title" id="event-admin-title" type="text" class="required" value="" /></div></div></div>
                </div>
                <div class="guests">
                  <h2><?=$this->registry->trans['mainlineup'];?>:</h2>
                  <div class="labels">
                    <div class="name-label label"><label><?=$this->registry->trans['artistname'];?> / <?=$this->registry->trans['eg'];?> <span class="sample">Richie Hawtin</span></label></div>
                    <div class="descr-label label"><label><?=$this->registry->trans['artistcomment'];?> / <?=$this->registry->trans['eg'];?> <span class="sample">Minus</span></label></div>
                  </div>
                  <ul class="jlist">
                    <li class="placeholder">
                      <div class="name-input input-text"><div class="r"><div class="l"><input name="" type="text" /></div></div></div>
                      <div class="descr-input input-text"><div class="r"><div class="l"><input name="" type="text" /></div></div></div>
                      <div class="remove-link"><span><?=$this->registry->trans['delname'];?><i class="i"></i></span></div>
                      <div class="handle"></div>
                    </li>
                  </ul>
                </div>
                <div class="artists">
                  <h2><?=$this->registry->trans['secondlineup'];?>:</h2>
                  <div class="labels">
                    <div class="label"><label><?=$this->registry->trans['artistname'];?> / <?=$this->registry->trans['eg'];?> <span class="sample">Richie Hawtin</span></label></div>
                  </div>
                  <ul class="jlist">
                    <li class="placeholder">
                      <div class="input-text"><div class="r"><div class="l"><input name="" type="text" /></div></div></div>
                      <div class="remove-link"><span><?=$this->registry->trans['delname'];?><i class="i"></i></span></div>
                      <div class="handle"></div>
                    </li>
                  </ul>
                </div>
                <div class="details">
                  <h2><?=$this->registry->trans['eventinfo'];?>:</h2>
                  <div class="descr-field">
                    <div class="label"><label for="event-admin-descr"><?=$this->registry->trans['descr'];?></label></div>
                    <div class="textarea"><textarea name="descr" id="event-admin-descr" cols="" rows=""></textarea><div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div></div>
                  </div>
                  <? if($this->registry->langid==1){?>
				    <div class="alert-html-tags"><i></i>Работа с применением HTML-тэгов. Для особо продвинутых :)</div>
				  <?}?>
                  <div class="links">
                    <div class="labels">
                      <div class="label"><label><?=$this->registry->trans['eventprofiles'];?></label></div>
                    </div>
                    <ul class="jlist">
                      <li class="placeholder">
                        <div class="input-text"><div class="r"><div class="l"><input name="" type="text" /></div></div></div>
                        <div class="remove-link"><span><?=$this->registry->trans['deletelink'];?><i class="i"></i></span></div>
                        <div class="handle"></div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="brands">
                  <div class="labels">
                      <label class="label"><input type="checkbox" class="brand-offer" />Предложение для брендов</label>
                  </div>
                  <div class="labels brands-filter-radios">
                      <label class="label"><input type="radio" class="brand-offer-all" value="1" name="brandsfilter" />Для всех</label>
                      <label class="label"><input type="radio" class="brand-offer-select" value="2" name="brandsfilter" />Для выбранных</label>
                  </div>
                  <div class="brands-list">
                    <div class="labels">
                      <div class="label"><label>Список предложений</label></div>
                    </div>
                    <ul class="jlist">
                      <li class="placeholder">
                        <div class="brands-select"><select name=""><option value="0">Выберите из списка</option></select></div>
                        <div class="remove-link"><span>Удалить бренд<i class="i"></i></span></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="submit">
              <div class="remove-button button"><div class="r"><div class="l"><button><?=$this->registry->trans['delevent'];?></button></div></div></div>
              <div class="save-button button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
              <!--div class="save-template button"><div class="r"><div class="l"><button type="button">Сохранить шаблон</button></div></div></div-->
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="widget-content-bot"></div>
  </div>
</div>

<script type="text/javascript">
    var brandlist = $.parseJSON('<?=$this->view->brandlist;?>'),
        eventInner = $.parseJSON('<?=$this->view->eventinner;?>'),
        defaultAvatar = '<?=$this->view->defaultcover;?>',
        defaultPoster = '<?=$this->view->defaultposter;?>',
        avatarPreviews = $.parseJSON('<?=$this->view->coverlist;?>'),
        posterPreviews = $.parseJSON('<?=$this->view->posterlist;?>');

    $('.event-admin').eventAdmin();
</script>