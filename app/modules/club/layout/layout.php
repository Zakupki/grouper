<!DOCTYPE html>
<html<?=($this->view->Session->User['id']==$this->view->Session->Site['userid'])?' class="admin"':''?>>
<head>
  <title><?=$this->view->sitetitle;?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="<?=$this->view->sitetitle;?>" />
  <meta name="keywords" content="<?=str_replace('"','',$this->view->sitekeywords);?>" />
  <meta name="description" content="<?=str_replace('"','',$this->view->sitedescription);?>" />
  <link href="/css/club/main.css?<?=time();?>" type="text/css" rel="stylesheet" />
  <script src="/js/club/lib.js?<?=time();?>" type="text/javascript"></script>
  <script src="/js/club/lang-ru.js?<?=time();?>" type="text/javascript"></script>
  <script src="/js/club/main.js?<?=time();?>" type="text/javascript"></script>
  <link href="<?=$this->view->sitedata['favicon'];?>" rel="icon" type="image/x-icon" />
  <link href="<?=$this->view->sitedata['favicon'];?>" rel="shortcut icon" type="image/x-icon" />
  <script type="text/javascript" src="/uploadify/swfobject.js?<?=time();?>"></script>
  <style type="text/css">
      .jplayer-title-sep,
      .jplayer-title-artist,
      .jplayer-time-position,
      .galleries h3 a,
      .gallery .header h1,
      .tracks h3 a,
      .event h2,
      .events .title strong,
      .widget-m1 a:hover,
      .widget-m2 a:hover,
      .widget-m2 .act,
      .widget-m2 .act a,
      .widget-m2 .act a:hover,
      .widget-title h2,
      .widget-title h2 a,
      .widget-title h2 a:hover,
      .widget-more-link:hover span,
      .place .descr h2,
      .place .descr h2 a,
      .place .descr h2 a:hover,
      .place .gallery-link h3 a,
      .place .gallery-link h3 a:hover,
      .gallery-admin .date-input-weekend,
      .teasers .jflow-pi-act span,
      .teasers .jflow-pi span:hover,
      .videos h3 a,
      .contacts .email a:hover,
      .place .descr .location a:hover {
          color: #<?=$this->view->sitedata['color'];?> !important;
      }
      .events .guests .i,
      .event .guests .i {
          background: url('/uploads/star/<?=$this->view->sitedata['color'];?>.png') no-repeat center center !important;
      }
      .events .poster .i-popular {
          background: url('/uploads/eventlike/<?=$this->view->sitedata['color'];?>.png') no-repeat center center !important;
      }
      .events .i-today,
      .events .i-tomorrow {
          background: url('/uploads/today/<?=$this->view->sitedata['color'];?>.png') no-repeat 0px 0px !important;
      }
      .jplayer-loaded-bar {
          background: url('/uploads/playerbar/<?=$this->view->sitedata['color'];?>.png') repeat-x bottom center !important;
      }
  </style>
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35424272-4']);
  _gaq.push(['_setDomainName', '<?=$_SERVER['HTTP_HOST'];?>']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body<?=($this->view->sitedata['pagepattern'])?' style="background:url('.$this->view->sitedata['pagepattern'].') repeat top center;"':'';?>>
<?
?>
	<div class="layout-body"<?=($this->view->sitedata['pagebg'])?' style="background:url('.$this->view->sitedata['pagebg'].') no-repeat 50% 40px;"':''?>>
  <div class="layout-top">
      <ul class="user-links">
        <? if ($this->view->Session->User['id']==$this->view->Session->Site['userid']) { ?>
            <li class="profile-link"><a href="/user/profile/">Личный кабинет<i class="i"></i></a>
              <!--<ul class="submenu">
                <li class="profile2-link"><a href="/user/profile/">Профиль<i class="i"></i></a></li>
                <li class="clubcard-link"><a href="/user/card/">Клубная карта<i class="i"></i></a></li>
              </ul>-->
            </li>
            <!--<li class="visitors-link"><a href="/clients/">Посетители<i class="i"></i></a>
              <ul class="submenu">
                <li class="visitors2-link"><a href="/clients/">Посетители<span class="new visible"><span class="r"><span class="l"><span class="text">43</span></span></span></span><i class="i"></i></a></li>
                <li class="clubcards-link"><a href="/clients/cards/">Клубные карты<i class="i"></i></a></li>
              </ul>
            </li>-->
	        <li class="reccount-link"><a href="/admin/reccount/"><?=$this->registry->trans['options'];?><i class="i"></i></a></li>
	        <li class="design-link"><a href="/admin/design/"><?=$this->registry->trans['design'];?><i class="i"></i></a></li>
          	<? if($this->registry->langid==1){?>
          	<li class="notifications-link"><a href="/admin/requests"><?=$this->registry->trans['notices'];?><span class="new"><span class="r"><span class="l"><span class="text"></span></span></span></span><i class="i"></i></a></li>
          	<?}?>
          	<li class="sync-link"><a class="disabled"><?=$this->registry->trans['synchronization'];?><i class="i"></i></a></li>
	        <li class="second-dates"><a class="disabled"><?=$this->registry->trans['seconddates'];?><i class="i"></i></a></li>
	        <!--
	        <li class="recard"><a href="/admin/recard/">ReCard<span class="new"><span class="r"><span class="l"><span class="text"></span></span></span></span><i class="i"></i></a></li>
	        -->
	        <!--<li class="base"><a class="disabled">База<i class="i"></i></a></li>-->
	      <? if($_SESSION['Site']['languageid']==1){?>
			<li class="sponsors"><a href="/admin/form/"><?=$this->registry->trans['sponsors'];?><i class="i"></i></a></li>
	      <?}?>  
          <? } elseif($this->view->Session->User['id']>0 && $this->view->Session->User['id']!==$this->view->Session->Site['userid']) { ?>
            <li class="profile-link"><a href="/user/profile/"><?=$this->registry->trans['profile'];?><i class="i"></i></a></li>
			<li class="notifications-link"><a class="disabled"><?=$this->registry->trans['notices'];?><span class="total">(0)</span><i class="i"></i></a></li>
            <?}else{?>
			<? if ($this->view->sitedata['phone']) { ?>
                <li class="phone"><?=$this->view->sitedata['phone'];?><i class="i"></i></li>
            <? } ?>
            <? if ($this->view->sitedata['address']){?>
                <? if ($this->view->sitedata['maplink']){?>
                    <li class="map"><a href="<?=$this->view->sitedata['maplink'];?>" target="_blank"><?=$this->view->sitedata['address'];?><i class="i"></i></a></li>
                <? } else { ?>
                    <li class="map"><?=$this->view->sitedata['address'];?><i class="i"></i></li>
                <? } ?>
            <? } ?>
        <? } ?>
      </ul>
	        <div class="auth-link">
        <? if ($this->view->Session->User['id']>0) { ?>
            <a href="/user/logout/"><i class="i-logout"></i></a>
        <? } else { ?>
            <i class="auth-popup-link i-logon"></i>
        <? } ?>
      </div>
  </div>

  <div class="layout-header">
    <div class="header-flash">
      <? if($this->view->banner['url']){?>
          <script type="text/javascript">
          var flashvars = {},
            params = {wmode: "transparent"};
          swfobject.embedSWF("<?=$this->view->banner['url'];?>", "sitebanner", "<?=$this->view->banner['width'];?>", "<?=$this->view->banner['height'];?>", "9.0.0", "expressInstall.swf", flashvars, params);
          </script>
      <?}?>
      <div class="content" style="min-height:<?=tools::int($this->view->sitedata['margin']);?>px;">
        <div id="sitebanner" ></div>
      </div>
      <? if (tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0) { ?>
        <div class="controls">
          <i class="i-settings"><a href="/admin/design/"></a></i>
        </div>
      <? } ?>
    </div>
  </div>

  <? if(is_array($this->view->socialblock)){ ?>
        <div class="social-links" style="margin-top:-<?=count($this->view->socialblock) * 25 + 15;?>px">
         <? foreach($this->view->socialblock as $social){
            $prottype='http://';
            if(strstr($social['url'],'https://')){
            $prottype='https://';
            $social['url']=str_replace('https://', '', $social['url']);
            }
            elseif(strstr($social['url'],'http://')){
            $social['url']=str_replace('http://', '', $social['url']);
            $prottype='http://';
            }?>
             <div><a href="<?=$prottype;?><?=$social['url'];?>" target="_blank"><i class="i"><img src="<?=$social['img'];?>" alt="<?=$social['name'];?>" /></i></a></div>
         <? } ?>
      </div>
  <? } ?>

  <div class="layout-content">
    <div class="widgets">
      <div class="widgets-content">
      <?=$this->view->content;?>
      </div>
      <div class="widgets-top"></div>
      <div class="widgets-bot"></div>
    </div>
  </div>

  <script type="text/javascript">
    <? if(is_array($this->view->tracklist)){
        foreach($this->view->tracklist as $track) {
            $i = 0;

            if(!$track['mp3'] && $track['stream']) {
                $track['mp3']=$track['stream'].tools::getStreamParam($track['socialid']);
            };
            $trackJs[]="{
                artist: '".$this->view->sitename."',
                name: '".tools::str($track['name'])."',
                url: '".$track['mp3']."',
                download: false
            }";
        }
    } ?>

    var playerData = {
        autoPlay: false,
        playlist: [
            <?=(is_array($trackJs))?implode(',',$trackJs):'';?>
        ]
    };
  </script>

  <div class="player">
    <div class="jplayer">
      <div class="jplayer-controls">
        <div class="jplayer-play"></div>
        <div class="jplayer-download-disabled jplayer-download"></div>
      </div>
      <div class="jplayer-position">
        <div class="jplayer-title">
          <div class="jplayer-title-artist"><?=(is_array($trackJs))?$this->view->sitename:'';?></div>
          <div class="jplayer-title-sep">&nbsp;&mdash;&nbsp;</div>
          <div class="jplayer-title-name"><?=$this->view->tracklist[0]['name']?></div>
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

</div>

<div class="popup-src" id="auth-popup-src">
  <div class="auth">
    <form action="/user/login/" method="post">
      <input name="url" value="<?=$this->view->request_uri;?>" type="hidden" />
      <div class="links">
        <div class="link"><a class="retrieve-password" href="#"><?=$this->registry->trans['forgotpassword'];?></a></div>
        <div class="link link-last"><a href="/register/"><?=$this->registry->trans['registration'];?></a></div>
        <!--div class="link-last link"><a href="#">Зачем?</a></div-->
      </div>

      <div class="login-block">
          <div class="fields">
            <div class="field-username field">
              <div class="label"><label for="auth-login">Email</label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="email" id="auth-login" type="text" class="required" /></div></div></div>
            </div>
            <div class="field-password field">
              <div class="label"><label for="auth-password"><?=$this->registry->trans['password'];?></label></div>
              <div class="input-text"><div class="r"><div class="l"><input name="password" id="auth-password" type="password" class="required" /></div></div></div>
            </div>
            <div class="status"></div>
          </div>
          <div class="submit">
            <div class="input-remember input-checkbox">
              <input name="stay" id="auth-remember" checked="checked" type="checkbox" />
              <label for="auth-remember"><?=$this->registry->trans['rememberme'];?></label>
            </div>
            <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['login'];?></button></div></div></div>
          </div>
          <div class="social-networks-login">
            <div class="social-networks-login-inner">
             <a class="facebook" href="http://reactor-pro.com/facebook/connect2/?url=<?=urlencode($_SERVER['HTTP_HOST']);?>&sescode=<?=$_SESSION['sescode'];?>"></a>
             <!--<a class="vk" href="#"></a>-->
             <span><?=$this->registry->trans['loginwith'];?>:</span>
            </div>
          </div>
          <div class="attention">
              <h2>Reactor EcoSystem</h2>
              <? if($this->registry->langid==1){?>
              Если Вы уже регистрировались на каком-либо сайте с таким знаком, Вам не нужно это делать повторно.
              <?}elseif($this->registry->langid==2){?>
              If you have already registered on any site with this logo you can login here without new registration
              <?}?>
          </div>
        </div>

        <div class="password-block">
            <div class="fields">
                <div class="field-username field">
                    <div class="label"><label for="auth-login">Email</label></div>
                    <div class="input-text"><div class="r"><div class="l"><input name="retrieve-email" type="text" class="required" /></div></div></div>
                </div>
            </div>
            <div class="submit">
                <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['sendpassword'];?></button></div></div></div>
            </div>
        </div>
    </form>
  </div>
</div>

<script type="text/javascript">
    var langBackToLogin = 'Back to login',
        langForgotPassword = 'Forgot password?';

    Cufon.now();
</script>

</body>
</html>