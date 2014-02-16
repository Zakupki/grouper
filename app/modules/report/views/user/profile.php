			<div class="centerwrap clearfix">
				<h1>
				   Личный кабинет
				</h1>
				<!--<p>Здесь можно изменить свои данные.</p>-->
				<div class="profile-form col6">
          <form class="" action="/user/updateprofile/" method="post">
              <label for="field-email">Email:</label>
              <input class="txt" id="field-email" type="text" value="<?=$this->view->profile['email'];?>" <?=($_SESSION['User']['noemail'])?'':'disabled="disabled"';?> name="email">
              <? if(!$this->view->profile['email']){?>
              <input class="visuallyhidden" type="submit">
              <div class="actions clearfix">
              	<a class="button submit">Сохранить</a>
              </div>
              <?}?>
          </form>
          <h3>Изменение пароля:</h3>
					<div class="password-change-form clearfix">
                        <form class="validate noajax" action="/user/changepass/" method="post">
                            <? //tools::print_r($this->view->profile);?>
                            <? if($this->view->profile['haspassword']){ ?>
                            <label for="field-old-password">Старый пароль:</label>
							<input class="txt required" id="field-old-password" type="password" name="oldpassword">
							<?}?>
                            <label for="field-new-password">Новый пароль:</label>
							<input class="txt required" id="field-new-password" type="password" name="password">
							<label for="field-new-password-repeat">Повторите новый пароль:</label>
							<input class="txt required" id="field-new-password-repeat" type="password" name="passwordrepeat">
							<div class="error-message-2"></div>
							<input class="visuallyhidden" type="submit">
							<a class="button submit">Сохранить</a>
						</form>
					</div>
				</div>
			</div>
<div class="popup-src" id="popup-password-changed">
	<h2>
		Пароль был успешно изменен.
	</h2>
	<div class="clearfix">
		<a class="ir ok" href="#"></a>
	</div>
</div>
<div class="popup-src" id="popup-password-not-changed">
	<h2>
		Пароль НЕ БЫЛ изменен.
	</h2>
	<div class="clearfix">
		<a class="ir ok" href="#"></a>
	</div>
</div>