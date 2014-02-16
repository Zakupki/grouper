<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="tpl" content="" />
  <meta name="base" content="" />
  <meta name="lang" content="" />
  <meta name="token" content="<?=$this->view->token;?>" />
  <script src="/js/reparty/lib.js" type="text/javascript"></script>
  <link href="/css/reparty/main.css" type="text/css" rel="stylesheet" />
  <script src="/js/reparty/main.js" type="text/javascript"></script>
  <link href="favicon.ico" rel="icon" type="image/x-icon" />
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
<div class="layout-body">

  <div class="layout-top">
    
  <? if ($this->view->Session->User['id']) { ?>
    <ul class="top-user-links">
      <li class="li-profile"><a href="/cabinet/profile/">Личный кабинет (orange)<i class="i"></i></a></li>
      <li class="li-reccounts"><a href="/cabinet/myreccounts/">Мои реккаунты<i class="i"></i></a></li>
      <li class="li-history"><a href="/cabinet/balance/">История операций<i class="i"></i></a></li>
      <li class="li-notifications-new li-notifications"><a href="/cabinet/messages/">Уведомления <span class="total">(2)</span><i class="i"></i></a></li>
      <li class="li-balance"><a href="/cabinet/deposit/">120 UAH<i class="i"></i></a></li>
      <li class="li-deposit"><a href="/cabinet/deposit/">Пополнить</a></li>
    </ul>
    <div class="top-auth-link"><a href="/user/logout/" title="Выход"><i class="i-logout"></i></a></div>
  <? } else { ?>
    <ul class="social-links">
      <!-- <li class="link-vkontakte"><a href="#" target="_blank"><i class="i"></i></a></li> -->
      <li class="link-facebook"><a href="http://facebook.com/reactorpro/" target="_blank"><i class="i"></i></a></li>
      <!-- <li class="link-twitter"><a href="http://twitter.com" target="_blank"><i class="i"></i></a></li> -->
    </ul>
    <?=$this->view->newslineblock;?>
    <div class="auth-popup-link auth-link"><i class="i-logon"></i></div>
    <div class="register-link"><a href="/register/">Регистрация</a></div>
  <? } ?>
  </div>

  <div class="layout-header">
    <div class="header-logo"><a href="/"><img src="/img/reparty/header-logo.png" alt="logo" width="230" height="45" /></a></div>
    <div class="header-nav">
      <ul class="m1">
        <!--<li class="first"><a href="#"><span class="act">События</span></a><i class="i-act"></i></li>-->
        <? if ($this->registry->controller=='events') { ?>
          <li class="first"><a href="/events/"><span class="act">События<i class="i-act"></i></span></a></li>
        <? } else { ?>
          <li class="first"><a href="/events/"><span>События</span></a></li>
        <? }
		if ($this->registry->controller=='places') { ?>
		<li><a href="/places/"><span class="act">Места<i class="i-act"></i></span></a></li>
		<?}else{?>
		<li><a href="/places/"><span>Места</span></a></li>
		<?}?>
        <li><a href="/reccounts/"><span>Реккаунты</span></a></li>
        <li><a href="/about/"><span>О проекте</span></a></li>
        <? if($_SESSION['User']['id']>0){?>
          <li><a href="/cabinet/profile/"><span><i class="i-user"></i></span></a></li>
        <? } ?>
        <li class="last"><a href="/search/"><span><i class="i-search"></i></span></a></li>
      </ul>
	  <?=$this->view->submenu;?>
    </div>
  </div>
  <div class="layout-content">
    <?=$this->view->content;?>
  </div>
</div>

<div class="layout-footer">

  <ul class="footer-nav">
    <li><a href="/about/#content4">Пользовательское соглашение</a></li>
    <!--<li><a href="#">Зарабатывай</a></li>-->
    <li><a href="/support/">Служба поддержки</a></li>
    <li><a href="/faq/">Вопросы и ответы</a></li>
    <li><a href="/feedback/">Обратная связь</a></li>
  </ul>

  <!--<div class="footer-share">
    <input name="url" value="/_share.php" type="hidden">
    <div class="title">Поделиться<i class="i"></i></div>
    <div class="links">
      <div class="r">
        <div class="l">
          <ul>
            <li class="li-twitter"><a href="http://twitter.com/home?status=ATELIER%20http%3A%2F%2Fatelier.ua%2F" target="_blank"><span class="total">12</span><input name="service" value="twitter" type="hidden" /></a></li>
            <li class="li-facebook"><a href="http://facebook.com/sharer.php?t=ATELIER&amp;u=http%3A%2F%2Fatelier.ua%2F" target="_blank"><span class="total">12</span><input name="service" value="facebook" type="hidden" /></a></li>
            <li class="li-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2Fatelier.ua%2F" target="_blank"><span class="total">12</span><input name="service" value="vkontakte" type="hidden" /></a></li>
            <li class="li-gplus"><a href="http://www.google.com/buzz/post?url=http%3A%2F%2Fatelier.ua%2F" target="_blank"><span class="total">12</span><input name="service" value="gplus" type="hidden" /></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>-->

  <div class="footer-copy">&copy; Re:Party&trade;</div>

</div>

<script type="text/javascript">Cufon.now();</script>

<div class="popup-src" id="region-popup-src">
  <div class="region-popup">
    <div class="descr">
      <div class="i"></div>
      <div class="text">
        <p>Создайте свой &laquo;регион&raquo; (город или группа городов), за&nbsp;событиями которого&nbsp;Вы хотелибы следить. Если у&nbsp;нас нет информации по&nbsp;заданному &laquo;региону&raquo;, то&nbsp;у&nbsp;Вас есть отличная <a href="№">перспектива</a> стать официальным представителем Re:Party в&nbsp;Вашем городе!</p>
      </div>
    </div>
    <div class="form">
      <form action="_region_form.php" method="post">
        <div class="fieldset">
          <div class="field-placeholder field-blank field">
            <div class="input-text"><div class="r"><div class="l"><input name="city[0]" type="text" /></div></div></div>
            <div class="remove-link"><span>Удалить город<i class="i"></i></span></div>
            <div class="handle"></div>
          </div>
        </div>
        <div class="submit">
          <div class="button"><div class="r"><div class="l"><button type="submit">Сохранить</button></div></div></div>
        </div>
      </form>
    </div>
  </div>
</div>

<? if (!$this->view->Session->User['id']) { ?>
<div class="popup-src" id="auth-popup-src">
  <div class="auth-popup">
    <form action="/user/login/" method="post">
      <input name="url" value="<?=$this->view->request_uri;?>" type="hidden" />
      <div class="links">
      <div class="link"><a href="#">Забыли пароль?</a></div>
      <div class="link-last link"><a href="/register/">Регистрация</a></div>
<!--         <div class="link-last link"><a href="#">Зачем?</a></div> -->
      </div>
      <div class="fields">
        <div class="field-username field">
          <div class="label"><label for="authLogin">Логин</label></div>
          <div class="input-text"><div class="r"><div class="l"><input name="login" id="authLogin" type="text" class="required" /></div></div></div>
        </div>
        <div class="field-password field">
          <div class="label"><label for="authPassword">Пароль</label></div>
          <div class="input-text"><div class="r"><div class="l"><input name="password" id="authPassword" type="password" class="required" /></div></div></div>
        </div>
        <div class="status"></div>
      </div>
      <div class="submit">
        <div class="input-remember input-checkbox">
          <input name="remember" id="authRemember" checked="checked" type="checkbox" />
          <label for="authRemember">Оставаться в системе</label>
        </div>
        <div class="button"><div class="r"><div class="l"><button type="submit">Вход</button></div></div></div>
      </div>
    </form>
  </div>
</div>
<? } ?>

</body>
</html>