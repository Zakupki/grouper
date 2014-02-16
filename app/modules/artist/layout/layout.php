<!DOCTYPE html>
<html>
<head>
    <title><?=$this->view->sitename;?></title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="title" content="<?=$this->view->sitename;?>" />
	<meta name="description" content="<?=str_replace('"','',$this->view->sitedesc);?>" />
	<link rel="image_src" href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=$this->view->pagebg;?>" />
	<link rel="stylesheet" type="text/css" href="/css/artist/main.css?<?=time();?>" media="screen"/>
    <link href="<?=$this->view->favicon['url'];?>" rel="icon" type="image/x-icon" />
    <link href="<?=$this->view->favicon['url'];?>" rel="shortcut icon" type="image/x-icon" />
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/artist/ie.css" media="screen"/>
    <![endif]-->
	<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'];?>/" />
	<meta property="og:title" content="<?=$this->view->sitename;?>" />
  	<meta property="og:description" content="<?=str_replace('"','',$this->view->sitedesc);?>" />
  	<meta property="og:image" content="http://<?=$_SERVER['HTTP_HOST'];?>/<?=$this->view->pagebg;?>" />
	<script type="text/javascript" src="/js/artist/admin/jquery.js"></script>
    <script type="text/javascript" src="/js/artist/jquery.ui.custom.min.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/jquery.history.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/jquery.fancybox.pack.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/soundmanager2.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/jquery.thatplayer.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/jquery.columnizer.min.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/utils.js?<?=time();?>"></script>
    <script type="text/javascript">
        var pageBg = '<?=$this->view->pagebg;?>';
		$(function() {
            var playlistData = [
                <?
                foreach($this->view->playertracks as $track){
                $tracklistArr[]="{
                    artist:'".addslashes($track['author'])."',
                    title:'".addslashes($track['name'])."',
                    url: '".$track['url']."',
					download_url: '/file/getmp3/?f=".$track['mp3id']."',
					download: ".$track['download']."
                }";
                }
                if(is_array($tracklistArr))
                echo implode(',',$tracklistArr);
                ?>
            ];

            $('.g-player').thatplayer({
                playlist: playlistData,
                volume: 80,
                autoplay: <?=($_SESSION['User']['id'] || !$_SESSION['Site']['autoplay'])?'false':'true';?>
            });
        });
    </script>
    <style type="text/css">
        .g-navigation .b-navigation-list li.current a,
        .g-content h2,
        .g-content h2.white sup,
        .g-content h3,
        .thatplayer-container .colored,
        .b-slider li.gallery-item span,
        .b-slider li h4,
        .b-slider li h5 sup,
        .b-slider li i.label,
        .b-slider li.gigs-item .place {
            color:#<?=$this->view->color;?> !important;
        }
        .tp-buffer-bar {
            background: url('/uploads/playerbar/<?=$this->view->color;?>.png') 0 -5px repeat-x !important;
        }
        .g-content .b-rager a.active,
        .g-content .b-pager li.active {
            background-color: #<?=$this->view->color;?> !important;
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
<body>
<!--<iframe width="100" height="100" frameborder="no" src="http://reactor.ua/user/clientlogin/"></iframe>-->

<!-- global wrapper (begin) -->
<div class="g-wrap">
	<!-- header (begin) -->
    <?if($this->view->Session->User['id']){?>
    <ul class="g-header">
        <li>
            <a href="/reccount/menu/" class="reccount-settings"><?=$this->registry->trans['account_settings'];?></a>
        </li><li>
            <a href="/design/" class="design-settings"><?=$this->registry->trans['design_settings'];?></a>
        </li><li>
            <a href="/admin/messages/" class="notifications"><?=$this->registry->trans['notices'];?> <span class="counter"><? if ($this->view->messageum>0) { ?> (<?=$this->view->messageum;?>)<? } ?></span></a>
        </li><li>
            <a href="/reccount/synchro/" class="synchronization"><?=$this->registry->trans['sync'];?></a>
        </li><li>
            <a href="/admin/<?=($curmodule)?''.$curmodule.'/':'';?>" class="exit-edit-mode"><?=$this->registry->trans['edition_mode'];?></a>
        </li><li class="logout">
            <a href="/user/logout/" title="Logout">&nbsp;</a>
        </li>
    </ul>
    <?}else{?>
    <ul class="g-header">
        <?
		//tools::print_r($this->view->socialblock);
		foreach($this->view->socialblock as $social){
			$prottype='http://';
			if(strstr($social['url'],'https://')){
			$prottype='https://';
			$social['url']=str_replace('https://', '', $social['url']);
			}
			elseif(strstr($social['url'],'http://')){
			$social['url']=str_replace('http://', '', $social['url']);
			$prottype='http://';
			}
			
			if($_SESSION['Site']['socialmodeid']==3 && $social['id']==222){
			$twStr='<li><a href="'.$prottype.$social['url'].'" class="social-network" style="background-image: url(/uploads/social/icon-twitter2.png)"  target="_blank"></a></li>';
			$twStrUrl=$social['url'];			}
			else{
			if(!$social['img'])
			$social['img']='/img/reactor/release/links_link.png';
			?>
		    <li><a href="<?=$prottype;?><?=$social['url'];?>" class="social-network" style="background-image: url(<?=$social['img'];?>)"  target="_blank"></a></li>
        <?}}?>
		<?=$twStr;?>
		<li>
            <?
			if($_SESSION['Site']['socialmodeid']==3){?>
				<i><?=$this->view->twitter;?></i>
			<?}
			elseif($_SESSION['Site']['socialmodeid']==2){
			if(count($this->view->twitter)>0){
			foreach($this->view->twitter as $tw){
			?>
				<i><a href="http://<?=MAIN_HOST;?>/new/<?=$tw['itemid'];?>/"><?=$tw['name'];?></a></i>
			<?
			}
			}
			}?>
        </li>
        <li class="login"><a href="#" title="Login"></a></li>
    </ul>
    <?}?>
    <!-- header (end) -->

    <!-- navigation (begin) -->
    <div class="g-navigation">
        <ul class="b-navigation-list">
            <?=$this->view->mainmenu;?>
        </ul>
    </div>
    <!-- navigation (end) -->

    <!-- background (begin) -->
    <div class="g-background">
        <img src="<?=$this->view->pagebg;?>" />
		<? if($this->view->logo['url']){?>
        <div class="g-logo-container">
            <a href="/" class="logo <?=$this->view->logo['position'];?>"><h1><?=$this->view->sitename;?></h1><img src="<?=$this->view->logo['url'];?>"/></a>
        </div>
		<?}?>
    </div>
    <!-- background (end) -->

    <!-- main column (begin) -->
    <div class="g-content-wrap">
        <div class="g-content-bg">
            <div class="g-content">
                <?=$this->view->content;?>
            </div>
        </div>
       
        <!-- player (begin) -->
        <div class="g-player-wrap">
            <?
            if(!$this->view->playertracks){
            ?>
            <div class="g-player-overlay"></div>
            <?}?>
            <div class="g-player">
                <div class="thatplayer-container">
                    <div class="tp-type-single">
                        <div class="tp-gui tp-interface">
                            <div class="controls-wrap">
                                <ul class="tp-controls">
                                    <li><a href="#" class="tp-playpause" tabindex="1">play</a></li>
                                    <li><a class="download off" href="#" target="_blank"></a></li>
                                </ul>
                            </div>
                            <div class="progress-wrap">
                                <div class="tp-title"></div>
                                <div class="tp-time-holder" <?if(!$this->view->playertracks){?>style="display:none;"<?}?>>
                                        <div class="tp-current-time colored">0:00</div><span> / </span><div class="tp-duration">0:00</div>
                                    </div>
                                <div class="tp-progress">
                                    <div class="tp-seek-bar">
                                        <div class="tp-buffer-bar"></div>
                                        <div class="tp-play-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="volume-wrap">
                                <div class="tp-volume-bar">
                                    <div class="tp-volume-bar-value"></div>
                                </div>
                                <a href="#" class="tp-mute" tabindex="1" title="mute">mute</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- player (end) -->

        <!-- footer (begin) -->
        <ul class="g-footer">
            <li class="social-networks-plugins">
              <ul>
                    <li class="link-twitter"><a href="http://twitter.com/home?status=<?=MAIN_NAME;?>%20http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="twitter" target="_blank"><span class="total"><?=tools::getTwCount($_SERVER['HTTP_HOST']);?></span></a></li>
                    <li class="link-facebook"><a href="http://facebook.com/sharer.php?t=<?=MAIN_NAME;?>&amp;u=http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="facebook" target="_blank"><span class="total"><?=tools::getFbCount($_SERVER['HTTP_HOST']);?></span></a></li>
                    <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="vkontakte" target="_blank"><span class="total"><?=tools::getVkCount($_SERVER['HTTP_HOST']);?></span></a></li>
              </ul>
            </li>
            <li class="copyright"><a></a> &copy; Reactor</li>
        </ul>
        <!-- footer (end) -->
    </div>
     <!-- main column (end) -->

</div>
<!-- global wrapper (end) -->

<!-- login box (begin) -->
<div class="b-login-box-overlay"></div>
<div class="b-login-box">
    <a class="close" href="#">X</a>
    <a class="forgot-password" href="#"><?=$this->registry->trans['forgot_pass'];?>?</a>
    
    <form class="login-form" action="/" method="post">
    	<?=$this->view->token;?>
        <i class="login-caption">Email</i><i class="password-caption"><?=$this->registry->trans['password'];?></i>
        <input class="login" name="email" type="text" /><input class="password" name="password" type="password" />
        <div class="button-set">
            <input class="submit" type="submit" value="<?=$this->registry->trans['login'];?>" />
            <label class="remember-me"><input type="checkbox" name="remember" /> <?=$this->registry->trans['remember_me'];?></label>
            <span class="alert"></span>
        </div>
        <!--<div class="social-networks-login">
            <a class="facebook" href="#"></a>
            <span>Вход через:</span>
        </div>-->
    </form>
    
    <form class="retrieve-password-form" action="/user/retrieve/" >
        <i class="email-caption">E-mail</i>
        <input class="email" type="text" />
        <div class="button-set">
            <input class="submit" type="submit" value="<?=$this->registry->trans['sendpass'];?>" />
            <span class="alert"></span>
        </div>
    </form>
</div>
<!-- login box (end) -->

<!-- old browsers alert (begin) -->
<div class="b-old-browser">
    <h3>Вы используете устаревший броузер</h3>

    <p>Ваш броузер: <span class="b-browser-name"></span>.<br/>
    Пожалуйста, обновите его, и вы сможете пользоваться сайтом.</p>

    <div class="b-broswers-list">
        <a href="http://windows.microsoft.com/ru-RU/internet-explorer/products/ie/home" target="_blank" class="ie">windows.microsoft.com/ru-ru/ie9</a>
        <a href="http://www.google.com/chrome/" target="_blank" class="chrome">google.com/chrome</a>
        <a href="http://www.mozilla.org/ru/firefox/new/" target="_blank" class="firefox">mozilla.org/ru/firefox</a>
    </div>

    <div class="b-copy">&copy; <?=date('Y');?> Reactor&trade;</div>
</div>
<!-- old browsers alert (end) -->

</body>
</html>