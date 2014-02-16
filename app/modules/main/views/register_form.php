<?
if (is_array($this->view->error)) {
    foreach ($this->view->error as $k=>$v) {
        $errorfield[$k]='field-error ';
    }
}
?>

<h1>Регистрация</h1>

<div class="user-form-register user-form">
  <form action="/register/" method="post" autocomplete="off">
    <div class="facebook-login">
        Вход через:
        <a class="button-facebook" href="/facebook/connect2/"></a>
    </div>
  	<input name="makeregister" value="1" type="hidden" />
  	<div class="<?=$errorfield['login'];?>field">
      <div class="label"><label for="user-form-login">Логин</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="login" value="<?=$this->view->Post->login;?>" id="user-form-login" type="text" class="latnum required" />
        <? if (isset($this->view->error['login'])) { ?>
          <label for="user-form-login" class="error"><?=$this->view->error['login'];?></label>
        <? } ?>
      </div></div></div>
    </div>
  
    <div class="<?=$errorfield['email'];?>field">
      <div class="label"><label for="user-form-email">E-mail</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="email" value="<?=$this->view->Post->email;?>" id="user-form-email" type="text" class="email required" />
        <? if (isset($this->view->error['email'])) { ?>
          <label for="user-form-email" class="error"><?=$this->view->error['email'];?></label>
        <? } ?>
      </div></div></div>
    </div>
  
    <div class="<?=$errorfield['password'];?>field">
      <div class="label"><label for="user-form-password">Пароль</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="password" id="user-form-password" type="password" class="required" />
        <? if (isset($this->view->error['password'])) { ?>
          <label for="user-form-password" class="error"><?=$this->view->error['password'];?></label>
        <? } ?>
      </div></div></div>
    </div>
  
    <div class="<?=$errorfield['password_check'];?>field-password-check field">
      <div class="label"><label for="user-form-password-check">Пароль ещё разок</label></div>
      <div class="input-text"><div class="r"><div class="l">
        <input name="password_check" id="user-form-password-check" type="password" class="required" />
        <? if(isset($this->view->error['password_check'])) { ?>
          <label for="user-form-password-check" class="error"><?=$this->view->error['password_check'];?></label>
        <? } ?>
      </div></div></div>
    </div>

    <div class="<?=$errorfield['country'];?>field-country field">
      <div class="label"><label for="user-form-country">Страна проживания</label></div>
      <div class="select">
        <select name="country" id="user-form-country">
          <?
		  $other=1;
		  foreach($this->view->countries as $country){
		  if(apache_note("GEOIP_COUNTRY_CODE")==$country['code'])
		  $other=null;
		  ?>
		  <option <?=(apache_note("GEOIP_COUNTRY_CODE")==$country['code'])?' selected="selected"':'';?> value="<?=$country['id'];?>"><?=$country['name_ru'];?></option>
		  <?}?>
		  <option <?=($other)?' selected="selected"':'';?> value="0">Другая</option>
        </select>
        <? if(isset($this->view->error['country'])) { ?>
          <label for="user-form-country" class="error"><?=$this->view->error['country'];?></label>
        <? } ?>
      </div>
    </div>
  
    <div class="field-agree field">
      <div class="input-checkbox">
        <input name="agree" value="1" id="user-form-agree" type="checkbox" class="required" />
        <label for="user-form-agree">Я принимаю <a href="/about/#content4" target="_blank">пользовательское соглашение сайта Reactor PRO</a></label>
        <? if(isset($this->view->error['agree'])) { ?>
          <label for="user-form-agree" class="error"><?=$this->view->error['agree'];?></label>
        <? } ?>
      </div>
    </div>

    <div class="field">
        <input name="notifyreply" value="1" id="user-form-when-reply" type="checkbox" /><label for="user-form-when-reply">Я хочу получать уведомления на почту, когда кто-то отвечает на мои комментарии</label>
    </div>

    <div class="field">
        <input name="notifycomment" value="1" id="user-form-when-comment" type="checkbox" /><label for="user-form-when-comment">Я хочу получать уведомления на почту, когда кто-то комментирует мои публикации</label>
    </div>
  
    <div class="submit">
      <div class="button"><div class="r"><div class="l"><button type="submit">Зарегистрироваться</button></div></div></div>
    </div>
  </form>
</div>