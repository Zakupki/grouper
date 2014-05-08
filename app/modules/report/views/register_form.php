<?
if (is_array($this->view->error)) {
    foreach ($this->view->error as $k=>$v) {
        $errorfield[$k]='field-error ';
    }
}
?>
<div class="centerwrap clearfix">
  <h1>Регистрация</h1>
  <div class="user-form-register user-form col8">
    <form action="/register/" method="post" autocomplete="off" class="">
    	<input name="makeregister" value="1" type="hidden" />
    	<div class="<?=$errorfield['name'];?>field">
        <div class="label"><label for="user-form-login">Имя</label></div>
        <div class="input-text"><div class="r"><div class="l">
          <input name="name" value="<?=$this->view->Post->name;?>" id="user-form-name" type="text" class="txt latnum required" />
          <? if (isset($this->view->error['name'])) { ?>
            <label for="user-form-login" class="error"><?=$this->view->error['name'];?></label>
          <? } ?>
        </div></div></div>
      </div>
    
      <div class="<?=$errorfield['email'];?>field">
        <div class="label"><label for="user-form-email">E-mail</label></div>
        <div class="input-text"><div class="r"><div class="l">
          <input name="email" value="<?=$this->view->Post->email;?>" id="user-form-email" type="text" class="txt email required" />
          <? if (isset($this->view->error['email'])) { ?>
            <label for="user-form-email" class="error"><?=$this->view->error['email'];?></label>
          <? } ?>
        </div></div></div>
      </div>
    
      <div class="<?=$errorfield['password'];?>field">
        <div class="label"><label for="user-form-password">Пароль</label></div>
        <div class="input-text"><div class="r"><div class="l">
          <input name="password" id="user-form-password" type="password" class="txt required" />
          <? if (isset($this->view->error['password'])) { ?>
            <label for="user-form-password" class="error"><?=$this->view->error['password'];?></label>
          <? } ?>
        </div></div></div>
      </div>
    
      <div class="<?=$errorfield['password_check'];?>field-password-check field">
        <div class="label"><label for="user-form-password-check">Пароль ещё разок</label></div>
        <div class="input-text"><div class="r"><div class="l">
          <input name="password_check" id="user-form-password-check" type="password" class="txt required" />
          <? if(isset($this->view->error['password_check'])) { ?>
            <label for="user-form-password-check" class="error"><?=$this->view->error['password_check'];?></label>
          <? } ?>
        </div></div></div>
      </div>
      <div class="field checkbox"> 
                    <input type="checkbox" name="legal" value="1" id="checkbox-legal">
                    <label for="checkbox-legal">Я ознакомился и принимаю условия Пользовательского Соглашения</label>
                </div>

                <div class="disclaimer">
                    Нажимая кнопку "Сохранить", вы принимаете условия Пользовательского Соглашения (ссылка на пользовательское соглашение -добавить ссылку или убрать текст в скобках). В случае невыполнения условий данного Соглашения, ваш аккаунт может быть заблокирован или удален, без возвращения средств, оставшихся на вашем счету.
                </div>
      <div class="submit">
        <a class="button submit">Зарегистрироваться</a>
      </div>
    </form>
  </div>
  <div class="col8 last-col">
    <div class="login-via">
      <!--<a class="login-via-vk" href="/social/vkconnect/">Войти через <b>Vkontakte</b></a>-->
      <!--<a class="login-via-facebook" href="/social/fbconnect/">Войти через <b>Facebook</b></a>-->
    </div>
  </div>
</div>