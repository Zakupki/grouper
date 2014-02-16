<?
if (is_array($this->view->error)) {
    foreach ($this->view->error as $k=>$v) {
        $errorfield[$k]='field-error ';
    }
}
?>

<h1>Личные данные</h1>

<div class="user-form-edit user-form">
  <form action="/cabinet/updateregisterinfo/" method="post">
    <div class="field">
      <div class="label">Логин</div>
      <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input"><?=$this->view->profile['login'];?></span></div></div></div>
    </div>
  
    <div class="field">
      <div class="label"><label for="userEmail">E-mail</label></div>
      <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input"><?=$this->view->profile['email'];?></span></div></div></div>
    </div>

    <div class="<?=$errorfield['password_old'];?>field">
      <div class="label"><label for="user-form-password-old">Старый пароль</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="password_old" id="user-form-password-old" type="password" autocomplete="off" />
        <? if (isset($this->view->error['password_old'])) { ?>
          <label for="user-form-password-old" class="error"><?=$this->view->error['password_old'];?></label>
        <? } ?>
      </div></div></div>
    </div>
  
    <div class="<?=$errorfield['password'];?>field">
      <div class="label"><label for="user-form-password">Новый пароль</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="password" id="user-form-password" type="password" autocomplete="off" />
        <? if (isset($this->view->error['password'])) { ?>
          <label for="user-form-password" class="error"><?=$this->view->error['password'];?></label>
        <? } ?>
      </div></div></div>
    </div>
  
    <div class="<?=$errorfield['password_check'];?>field-password-check field">
      <div class="label"><label for="user-form-password-check">Новый пароль ещё разок</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="password_check" id="user-form-password-check" type="password" autocomplete="off" />
        <? if(isset($this->view->error['password_check'])) { ?>
          <label for="user-form-password-check" class="error"><?=$this->view->error['password_check'];?></label>
        <? } ?>
      </div></div></div>
    </div>

    <!--<div class="<?=$errorfield['country'];?>field-country field">
      <div class="label"><label for="user-form-country">Страна проживания</label></div>
      <div class="select">
        	<select name="country" id="user-form-country">
          <?
		  $other=1;
		  foreach($this->view->countries as $country){
		  if($this->view->profile['countryid']==$country['id'])
		  $other=null;
		  ?>
		  <option <?=($this->view->profile['countryid']==$country['id'])?' selected="selected"':'';?> value="<?=$country['id'];?>"><?=$country['name_ru'];?></option>
		  <?}?>
		  <option <?=($other)?' selected="selected"':'';?> value="0">Другая</option>
        </select>
        <? if(isset($this->view->error['country'])) { ?>
          <label for="user-form-country" class="error"><?=$this->view->error['country'];?></label>
        <? } ?>
      </div>
    </div>-->
  
    <div class="submit">
      <div class="button"><div class="r"><div class="l"><button type="submit">Сохранить</button></div></div></div>
    </div>
  </form>
</div>