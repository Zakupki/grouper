<div class="user-wrap">

  <div class="h1">
    <h1>Редактировать профиль</h1>
  </div>
  <!--profile-form-activated-->
  <div class="profile-form">
    <form action="/cabinet/updateprofile/" method="post" enctype="multipart/form-data">

      <div class="<?=($this->view->profile['url']) ? '' : 'image-na ';?>image">
        <input name="image_removed" value="0" type="hidden" />
        <input name="image_new" value="<?=$this->view->profile['url'];?>" type="hidden" />
        <input name="image_current" value="<?=$this->view->profile['url'];?>" type="hidden" />
        <input name="image_size" value="4" type="hidden" />
        <input name="userid" value="<?=$this->view->profile['id'];?>" type="hidden" />
        <input name="login" value="<?=$this->view->profile['login'];?>" type="hidden" />
        <input name="image_crop" value="/file/crop/" type="hidden" />
        <input name="image_upload" value="/file/uploadimage/" type="hidden" />
        <div class="img">
          <? if ($this->view->profile['url']) { ?>
            <img src="<?=$this->view->profile['url'];?>" alt="" />
          <? } ?>
        </div>
        <div class="upload">
          <div class="i"><input name="image" type="file" /></div>
        </div>
        <div class="remove">
          <div class="i"></div>
          <div class="confirm">Вы действительно хотите удалить изображение профиля?</div>
        </div>
      </div>

      <div class="content">

        <?
    if($_SESSION['User']['reccounts']){?>
    <div class="field-use-reccount-info field">
          <div class="input-checkbox">
            <input name="use_reccount_info" <?=($this->view->profile['siteid'])?'checked=cheched':'';?> id="profileUseReccountInfo" type="checkbox" />
            <label for="profileUseReccountInfo">Показывать в профайле информацию из реккаунта</label>
          </div>
        </div>
    <?}?>

        <div class="<?=($this->view->profile['siteid'])?'':'hidden';?> reccount-info">
          <div class="field-reccount field">
            <div class="label"><label for="profileReccountInfo">Из какого именно?</label></div>
            <div class="select">
              <select name="reccount_info" id="profileReccountInfo">
                <?
        foreach($this->view->reccounts as $rec){?>
        <option <?=($rec['id']==$this->view->profile['siteid'])?'selected=selected':'';?> value="<?=$rec['id'];?>"><?=$rec['name'];?></option>
        <?}?>
              </select>
            </div>
          </div>
        </div>

        <div class="<?=($this->view->profile['siteid'])?'hidden':'';?> user-info">

          <div class="row">
            <div class="field-name field">
              <div class="label"><label for="profileName">Отображаемое имя</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="name" id="profileName" value="<?=($this->view->profile['displayname'])?$this->view->profile['displayname']:$this->view->profile['login'];?>" type="text" /></div></div></div>
            </div>
            <div class="field-site field">
              <div class="label"><label for="profileSite">Персональный сайт</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="site" id="profileSite" value="<?=$this->view->profile['website'];?>" type="text" /></div></div></div>
            </div>
          </div>
  
          <div class="user-info field-about field">
            <div class="label"><label for="profileAbout">Обо мне</label></div>
            <div class="textarea">
              <textarea name="about" id="profileAbout" cols="" rows="" class="required"><?=$this->view->profile['preview_text'];?></textarea>
              <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
            </div>
          </div>
  
          <div class="field-refs field">
            <div class="label">Ссылки</div>
            <ul class="refs">
              <? 
        if(is_array($this->view->profile['links'])){
          foreach($this->view->profile['links'] as $k=>$v){
          ?>
          <li>
                  <div class="url input-text"><div class="r"><div class="l">
                    <input name="ref[<?=$k;?>]" value="<?=$v['url'];?>" type="text" />
                    <input name="ref_id[<?=$k;?>]" value="<?=$v['id'];?>" type="hidden" />
                  </div></div></div>
                  <div class="hide input-checkbox">
                    <input name="ref_hide[<?=$k;?>]" id="profileRefHide0" <?=($v['active']==0)?'checked=checked ':'';?>type="checkbox" />
                    <label for="profileRefHide<?=$k;?>">Скрыть</label>
                  </div>
                  <div class="remove"><span>Удалить<i class="i"></i></span></div>
                  <div class="drag"></div>
                  <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
                </li>
          <?  
          }
        }
        else{?>
        <li>
                <div class="url input-text"><div class="r"><div class="l">
                  <input name="ref[0]" value="" type="text" />
                  <input name="ref_id[0]" value="" type="hidden" />
                </div></div></div>
                <div class="hide input-checkbox">
                  <input name="ref_hide[0]" id="profileRefHide0" type="checkbox" />
                  <label for="profileRefHide0">Скрыть</label>
                </div>
                <div class="remove"><span>Удалить<i class="i"></i></span></div>
                <div class="drag"></div>
                <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
              </li>  
        <?}?>
        
              <!--<li class="ref-hidden">
                <div class="url input-text"><div class="r"><div class="l">
                  <input name="ref[1]" value="http://facebook.com/spongebob" type="text" />
                  <input name="ref_id[1]" value="754" type="hidden" />
                </div></div></div>
                <div class="hide input-checkbox">
                  <input name="ref_hide[1]" id="profileRefHide1" type="checkbox" checked="checked" />
                  <label for="profileRefHide1">Скрыть</label>
                </div>
                <div class="remove"><span>Удалить<i class="i"></i></span></div>
                <div class="drag"></div>
                <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
              </li>
              <li>
                <div class="url input-text"><div class="r"><div class="l">
                  <input name="ref[2]" value="http://soundcloud.com/spongebob" type="text" />
                  <input name="ref_id[2]" value="825" type="hidden" />
                </div></div></div>
                <div class="hide input-checkbox">
                  <input name="ref_hide[2]" id="profileRefHide2" type="checkbox" />
                  <label for="profileRefHide2">Скрыть</label>
                </div>
                <div class="remove"><span>Удалить<i class="i"></i></span></div>
                <div class="drag"></div>
                <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
              </li>-->
            </ul>
          </div>

        </div>

        <div class="submit">
          <div class="<?=($this->view->profile['siteid'])?'hidden':'';?> user-info ref-add-link"><span>Добавить сылку<i class="i"></i></span></div>
          <div class="button"><div class="r"><div class="l"><button type="submit">Сохранить</button></div></div></div>
        </div>

      </div>

    </form>
  </div>

</div>