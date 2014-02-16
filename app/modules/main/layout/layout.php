<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <title><?=$this->registry->sitetitle;?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="base" content="/" />
  <meta name="title" content="<?=$this->registry->sitetitle;?>" />
  <meta name="description" content="<?=$this->registry->sitedesc;?>" />
  <meta property="og:url" content="<?=$this->view->sharehost;?>" />
  <meta property="og:title" content="<?=$this->view->sharetitle;?>" />
  <meta property="og:description" content="<?=$this->view->sharedesc;?>" />
  <? if($this->view->shareimage2){?>
  <meta property="og:image" content="<?=$this->view->shareimage2;?>" />
  <?}?>
  <meta property="og:image" content="<?=$this->view->shareimage;?>" />
  <link rel="stylesheet" href="/css/reactor/main.css?<?=time();?>" type="text/css" />
  <script src="/js/reactor/lib.js?<?=time();?>" type="text/javascript"></script>
  <script src="/js/reactor/lang-ru.js?<?=time();?>" type="text/javascript"></script>
  <script src="/js/reactor/main.js?<?=time();?>" type="text/javascript"></script>
  <link rel="icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35424272-4']);
  _gaq.push(['_setDomainName', 'reactor.ua']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div class="layout-main">

  <div class="layout-top">
    <? if ($this->view->Session->User['id']) { ?>
  	  <ul class="user-links">
        <? if ($this->registry->action=='profileAction') { ?>
          <li class="link-profile"><?=$this->registry->trans['personal_account'];?> (<?=$this->view->User['displayname'];?>)<i class="i"></i></li>
        <? } else { ?>
          <li class="link-profile"><a href="/cabinet/profile/"><?=$this->registry->trans['personal_account'];?> (<?=$this->view->User['displayname'];?>)<i class="i"></i></a></li>
        <? } ?>
        <? if ($this->registry->action=='myreccountsAction') { ?>
          <li class="link-reccounts"><?=$this->registry->trans['my_reccounts'];?> (<?=tools::int(count($_SESSION['User']['reccounts']));?>)<i class="i"></i></li>
        <? } else{ ?>
          <li class="link-reccounts"><a href="/cabinet/myreccounts/"><?=$this->registry->trans['my_reccounts'];?> (<?=tools::int(count($_SESSION['User']['reccounts']));?>)<i class="i"></i></a></li>
        <? } ?>
        <li class="link-history"><a href="/cabinet/balance/"><?=$this->registry->trans['operations_history'];?><i class="i"></i></a></li>
        <? if ($this->registry->action=='messagesAction') { ?>
          <li class="<? if ($this->view->Session->User['messages'] > 0) { ?>link-notifications-new <? } ?>link-notifications"><?=$this->registry->trans['notices'];?> <span class="total">(<?=$this->view->Session->User['messages'];?>)</span><i class="i"></i></li>
        <? } else { ?>
          <li class="<? if ($this->view->Session->User['messages'] > 0) { ?>link-notifications-new <? } ?>link-notifications"><a href="/cabinet/messages/"><?=$this->registry->trans['notices'];?> <span class="total">(<?=$this->view->Session->User['messages'];?>)</span><i class="i"></i></a></li>
        <? } ?>
        <? if ($this->registry->action=='depositAction') { ?>
          <!--soon-popup-link -->
		  <li class="link-balance"><?=$this->view->Session->User['money'];?> <?=$this->view->Session->User['currency'];?><i class="i"></i></li>
          <li class="link-deposit"><?=$this->registry->trans['top_up'];?></li>
        <? } else { ?>
          <li class="link-balance"><a href="/cabinet/deposit/"><?=($this->view->Session->User['money'])?$this->view->Session->User['money']:'0';?>  <?=$this->view->Session->User['currencylocal'];?><i class="i"></i></a></li>
          <li class="link-deposit"><a href="/cabinet/deposit/"><?=$this->registry->trans['top_up'];?></a></li>
        <? } ?>
      </ul>

      <div class="auth-link"><a href="/user/logout/"><i class="i-logout"></i></a></div>
    <? } else { ?> 
      <ul class="social-links">
        <!--<li class="link-vkontakte"><a href="#" target="_blank"><i class="i"></i></a></li>-->
        <li class="link-facebook"><a href="http://facebook.com/reactorpro/" target="_blank"><i class="i"></i></a></li>
<!--         <li class="link-twitter"><a href="http://twitter.com" target="_blank"><i class="i"></i></a></li> -->
      </ul>

      <?=$this->view->newslineblock;?>

      <div class="auth-popup-link auth-link"><i class="i-logon"></i></div>

      <div class="register-link"><a href="/register/"><?=$this->registry->trans['registration'];?></a></div>
    <? } ?>
  </div>

  <div class="layout-header">

    <div class="logo"><a href="/"><img src="/img/reactor/logo.png" alt="Reactor PRO" width="279" height="56" /></a></div>
  
    <div class="<? if ($this->view->submenu) { ?>nav-m2 <?}?>nav">
      <ul class="m1">
        <? if ($this->registry->controller=='releases') { ?>
          <li class="first-act first"><a href="/releases/"><span><?=$this->registry->trans['releases'];?><i class="i"></i></span></a></li>
        <? } else { ?>
          <li class="first"><a href="/releases/"><span><?=$this->registry->trans['releases'];?></span></a></li>
        <? } ?>
        <? if ($this->registry->controller=='news') { ?>
          <li class="act"><a href="/news/"><span><?=$this->registry->trans['news'];?><i class="i"></i></span></a></li>
        <? } else { ?>
          <li><a href="/news/"><span><?=$this->registry->trans['news'];?></span></a></li>
        <? } ?>

        <? if ($this->registry->controller=='reccounts') { ?>
          <li class="act"><a href="/reccounts/"><span><?=$this->registry->trans['reccounts'];?><i class="i"></i></span></a></li>
        <? } else { ?>
          <li><a href="/reccounts/"><span><?=$this->registry->trans['reccounts'];?></span></a></li>
        <? } ?>
        <? if ($this->view->Session->User['id']) { ?>
          <? if ($this->registry->action=='about') { ?>
            <li class="act"><a href="/about/"><span><?=$this->registry->trans['about'];?><i class="i"></i></span></a></li>
          <? } else { ?>
            <li><a href="/about/"><span><?=$this->registry->trans['about'];?></span></a></li>
          <? } ?>
          <? if($this->registry->action=='profile' || $this->registry->action=='editprofile' || $this->registry->action=='registerinfo'){?>
            <li class="last-act last"><a href="/cabinet/profile/"><span><i class="i-user"></i><i class="i"></i></span></a></li>
		      <? } else { ?>
            <li class="last"><a href="/cabinet/profile/"><span><i class="i-user"></i></span></a></li>
          <? } ?>
        <? } else { ?>
          <? if ($this->registry->action=='about') { ?>
            <li class="last-act last"><a href="/about/"><span><?=$this->registry->trans['about'];?><i class="i"></i></span></a></li>
          <? } else { ?>
            <li class="last"><a href="/about/"><span><?=$this->registry->trans['about'];?></span></a></li>
          <? } ?>
        <? } ?>
      </ul>

  	  <?=$this->view->submenu;?>

    </div>

  </div>

  <div class="layout-content">
    <?=$this->view->content;?>
  </div>

  <div class="layout-content-browser layout-content">
    <h1>Вы используете устаревший браузер!</h1>
    <div class="browser">
      <div class="text">
        <p>Ваш Браузер: Internet Explorer 6.</p>
        <p>Пожалуйста, обновите его <br /> и вы сможете пользоваться нашим сайтом:</p>
      </div>
      <div class="list">
        <ul>
          <li>
            <a href="http://windows.microsoft.com/ru-RU/internet-explorer/downloads/ie" target="_blank">
              <i class="i-ie"></i>
              <span class="title"><span>Internet Explorer</span></span>
              <span class="link">windows.microsoft.com/ru-RU/internet-explorer/downloads/ie</span>
            </a>
          </li>
          <li>
            <a href="https://www.google.com/chrome/" target="_blank">
              <i class="i-chrome"></i>
              <span class="title"><span>Google Chrome</span></span>
              <span class="link">google.com/chrome/</span>
            </a>
          </li>
          <li class="last">
            <a href="http://firefox.com/" target="_blank">
              <i class="i-ff"></i>
              <span class="title"><span>Mozilla Firefox</span></span>
              <span class="link">firefox.com</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <? if ($this->registry->action=='newsinner' || $this->registry->action=='releaseinner') { ?>
    <div class="player">
      <div class="jplayer">
        <div class="jplayer-controls">
          <div class="jplayer-play"></div>
          <div class="jplayer-download-disabled jplayer-download"></div>
        </div>
        <div class="jplayer-position">
          <div class="jplayer-title">
            <div class="jplayer-title-artist"></div>
            <div class="jplayer-title-sep">&nbsp;&mdash;&nbsp;</div>
            <div class="jplayer-title-name"></div>
          </div>
          <div class="jplayer-time">
            <div class="jplayer-time-position"></div>
            <div class="jplayer-time-sep">&nbsp;/&nbsp;</div>
            <div class="jplayer-time-duration"></div>
          </div>
          <div class="jplayer-position-bar">
            <div class="jplayer-loaded-bar"></div>
            <div class="jplayer-position-handle ui-slider-handle"></div>
          </div>
        </div>
        <div class="jplayer-volume">
          <div class="jplayer-mute"></div>
          <div class="jplayer-volume-bar">
            <div class="jplayer-volume-handle ui-slider-handle"></div>
          </div>
        </div>
      </div>
		</div>
  <? } ?>

  <div class="beta-ribbon"></div>
</div>

<div class="layout-footer">

   <ul class="nav-footer">
    <li><a href="/about/#content4"><?=$this->registry->trans['customer_agreement'];?></a></li>
    <!--<li><a href="/about/#content2">Зарабатывай</a></li>-->
    <?
	  if($_SESSION['User']['id']>0){
	  if ($this->registry->action=='supportAction') { ?>
      <li><?=$this->registry->trans['support'];?></li>
    <? } else { ?>
      <li><a href="/support/"><?=$this->registry->trans['support'];?></a></li>
    <? } }?>
    <li><a href="/faq/"><?=$this->registry->trans['faq'];?></a></li>
    <li><a href="/feedback/"><?=$this->registry->trans['feedback'];?></a></li>
  </ul>
			
  <div class="share">
    <input name="url" value="/_share.php" type="hidden" />
    <div class="title"><?=$this->registry->trans['share'];?><i class="i"></i></div>
    <div class="links">
      <div class="r">
        <div class="l">
          <ul>
          	
            <li class="link-twitter"><a href="http://twitter.com/home?status=<?=MAIN_NAME;?>%20http%3A%2F%2F<?=MAIN_HOST;?>%2F" rel="twitter" target="_blank"><span class="total"><?=tools::getTwCount(MAIN_HOST);?></span></a></li>
            <li class="link-facebook"><a href="http://facebook.com/sharer.php?t=<?=$this->view->sharetitle;?>&amp;u=<?=$this->view->sharehost;?>" rel="facebook" target="_blank"><span class="total"><?=tools::getFbCount(MAIN_HOST);?></span></a></li>
            <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=MAIN_HOST;?>%2F" rel="vkontakte" target="_blank"><span class="total"><?=tools::getVkCount(MAIN_HOST);?></span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="copy">&copy; <?=date('Y');?> Reactor&trade;</div>

</div>

<? if (!$this->view->Session->User['id']) { ?>
<div class="popup-src" id="auth-popup-src">
  <div class="auth-popup">
    <form action="/user/login/" method="post">
      <input name="url" value="<?=$this->view->request_uri;?>" type="hidden" />
      <div class="links">
		<div class="link"><a class="retrieve-password" href="#"><?=$this->registry->trans['forgotpassword'];?></a></div>
        <div class="link-last link"><a href="/register/"><?=$this->registry->trans['registration'];?></a></div>
        <!--div class="link-last link"><a href="#">Зачем?</a></div-->
      </div>

      <div class="login-block">
          <div class="fields">
            <div class="field-username field">
              <div class="label"><label for="authLogin">E-mail</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="email" id="authLogin" type="text" class="required" /></div></div></div>
            </div>
            <div class="field-password field">
              <div class="label"><label for="authPassword"><?=$this->registry->trans['password'];?></label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="password" id="authPassword" type="password" class="required" /></div></div></div>
            </div>
            <div class="status"></div>
          </div>
          <div class="submit">
            <div class="input-remember input-checkbox">
              <input name="remember" id="authRemember" checked="checked" type="checkbox" />
              <label for="authRemember"><?=$this->registry->trans['rememberme'];?></label>
            </div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['signin'];?></button></div></div></div>
          </div>
      </div>

      <div class="password-block">
          <div class="fields">
              <div class="field-username field">
                  <div class="label"><label for="auth-login">E-mail</label></div>
                  <div class="input-text"><div class="r"><div class="l"><input name="retrieve-email" type="text" class="required" /></div></div></div>
              </div>
          </div>
          <div class="submit">
              <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['getnewpassword'];?></button></div></div></div>
          </div>
      </div>

      <div class="social-networks-login">
        <a class="facebook" href="http://reactor-pro.com/facebook/connect2/?url=<?=urlencode($_SERVER['HTTP_HOST']);?>&sescode=<?=$_SESSION['sescode'];?>"></a>
        <span><?=$this->registry->trans['loginwith'];?>:</span>
      </div>
    </form>
  </div>
</div>
<? } ?>

<div class="popup-src" id="soon-popup-src">
  <div class="soon-popup">
    <form action="/soon/" method="post">
      <div class="text">
        <p>К&nbsp;сожалению&nbsp;Вы не&nbsp;можете пока пополнить свой кошелек, так как проект находится на&nbsp;финальной стадии тестирования.<br />Оставьте e-mail и&nbsp;мы&nbsp;позовем Вас ;)</p>
      </div>
      <div class="row">
        <div class="field">
          <div class="label"><label for="soon-popup-email">Ваш e-mail</label></div>
          <div class="input-text"><div class="r"><div class="l"><input name="email" id="soon-popup-email" type="text" value="<?=$_SESSION['User']['email'];?>" class="email required" /></div></div></div>
        </div>
        <div class="button"><div class="r"><div class="l"><button type="submit">Продолжить</button></div></div></div>
      </div>
    </form>
  </div>
</div>

<input name="token" id="token" value="<?=$this->view->token;?>" type="hidden" />
<script type="text/javascript">Cufon.now();</script>
</body>
</html>