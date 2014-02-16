<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Grouper</title>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="Grouper" />
	<meta property="og:image" content="http://grouper.com.ua/img/report/socialimage.jpg" />
    <meta property="og:url" content="http://grouper.com.ua/" />
    <meta property="og:title" content="Grouper" />
    <meta property="og:description" content="Открытая биржа тематических сообществ" />
	<link rel="stylesheet" href="/css/report/main.css?<?=time();?>">
	<script src="/js/report/vendor/modernizr-2.6.1.min.js"></script>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35424272-3']);
  _gaq.push(['_setDomainName', 'clubsreport.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<?
$bodyclass['index']=array('index'=>' home','notfound'=>' error error-404','contacts'=>' feedback contact');
/*if($this->registry->controller=='index')
$bodyclass="home";
else
$bodyclass="logged-in";
if($this->registry->action=='notfound')
$bodyclass="error error-404";
if($this->registry->action=='contacts')
$bodyclass="feedback contact";*/
?>
<body class="<?=($_SESSION['User']['id'])?'logged-in':'';?><?=$bodyclass[$this->registry->controller][$this->registry->action];?>">
	<div id="top">
		<? if($_SESSION['User']['id']){?>
		<nav>
			<ul>
				<li class="cabinet"><a>Личный кабинет</a>
				    <ul class="submenu">
                        <li class="c-vcard profile-link"><a href="/user/profile/">Личные данные</a></li>
                        <li class="c-backintime history-link"><a class="under-construction" href="/user/balance/">История операций</a></li>
                        <li class="c-openbook public-link"><a class="under-construction" href="/user/accounts/">Мои аккаунты</a></li>
                        <li class="c-openbook public-link"><a class="under-construction" href="/public/">Мои публикации</a></li>
                        <li class="c-users groups-link"><a href="/user/groups/">Мои группы</a></li>
                        <li class="c-users groups-link"><a href="/user/withdraw/">Вывод денег</a></li>
                    </ul>
				</li>
				<li class="favorities"><a href="/groups/favourites/"><?=$this->registry->trans['favgroups'];?><sup class="bubble count"><?=tools::int($this->view->clubsfav);?></sup></a>
				</li>
				<li class="c-download requests-link"><a href="/user/requests/">Запросы<sup class="orange bubble count"><span class="value"><?=tools::int($this->view->newrequests);?></span></sup></a></li>
				<li class="balance-link"><a class="under-construction" href="/user/balance/"><span class="txt"><?=$_SESSION['User']['money'];?> грн</span></a></li>
				<li class="deposit-link"><a class="under-construction" href="/user/deposit">Пополнить</a></li>
				<!--<li class="history"><a href="#">История операций</a></li>
				<li class="notifications"><a href="#">Уведомления<sup class="orange bubble count">+3</sup></a></li>-->
			</ul>
		</nav>
		<div class="login-status"><a class="logout" href="/user/logout/">Выход</a></div>
		<?}else{?>
		<!--<nav>
			<ul>
				<li><a class="disabled">English version</a></li>
			</ul>
		</nav>-->
		<div class="login-status"><a class="login popup form" href="#form-login">Вход</a></div>
		<?}?>
	</div>

	<div id="main">
		<header>
			<div class="centerwrap clearfix">
				<div class="logo"><a href="/"><img src="/img/report/logo<?=$this->view->logocolor;?>.png" alt=""></a></div>
				<? if($_SESSION['User']['id']){?>
				<nav>
					<div class="clearfix">
						<ul class="buttons gray">
						    <li class="first"><a class="button" href="/groups/">Все группы</a></li>
							<!--<li class="last"><a class="button" href="/groups/create/">Добавить группу</a></li>-->
							
							
						</ul>
						<a class="orange button" href="/public/add/">Разместить публикацию</a>
						<!--<? if($this->registry->controller=='banners'){?>
						<a class="button orange popup" href="#new-banner"><?=$this->registry->trans['locatebanner'];?></a>
						<?}elseif($this->registry->controller=='events'){?>
						<a class="button orange popup" href="#new-event"><?=$this->registry->trans['locateindoor'];?></a>
						<?}elseif($this->registry->controller=='recards'){?>
						<a class="button orange popup" href="#new-recard"><?=$this->registry->trans['locaterecard'];?></a>
						<?}elseif($this->registry->controller=='public'){?>
						<a class="button orange popup" href="#new-public"><?=$this->registry->trans['locatepublic'];?></a>
						<?}?>-->
					</div>
				</nav>
				<?}else{?>
				<nav>
					<div class="clearfix">
						<ul class="buttons gray">
							<li class="first"><a class="button" href="/howitworks/">Как это работает?</a></li>
							<li><a class="button" href="/groups/"><?=$this->registry->trans['groups'];?></a></li>
							<li class="last"><a class="button" href="/contacts/"><?=$this->registry->trans['contacts'];?></a></li>
						</ul>
						<a class="orange button" href="/register/"><?=$this->registry->trans['join'];?></a>
					</div>
				</nav>
				<?}?>
			</div>
		</header>

		<div id="content">
		    <?=$this->view->content;?>
		</div>
	</div>

	<footer>
		<div class="centerwrap clearfix">
			<div class="copyright col4">
				<img src="/img/report/repost-logo-footer.png" alt="">
				<div class="txt">© 2013 Сloud9 agency</div>
			</div>
			<?
			if($_SESSION['User']['id']){
			?>
			<div class="col4">
				<nav>
					<ul>
						<li class="groups"><a href="/groups/"><?=$this->registry->trans['groups'];?><sup class="bubble count"><?=$this->view->clubsnum;?></sup></a></li>
						<li><a class="disabled"></a></li>
						<!--<li><a href="/clubs/events/"><?=$this->registry->trans['allevents'];?></a></li>-->
					</ul>
				</nav>
			</div>
			<div class="col4">
				<nav>
					<ul>
						<li><a href="/useragreement/">Пользовательское соглашение</a></li>
						<li><a href="/contacts/"><?=$this->registry->trans['feedback'];?></a></li>
						<li><a href="#" class="disabled"><?=$this->registry->trans['faq'];?></a></li>
					</ul>
				</nav>
			</div>
			<?}else{?>
			<div class="col4">
				<nav>
					<ul>
						<li><a href="/about/"><?=$this->registry->trans['about'];?></a></li>
						<li class="groups"><a href="/groups/">Все группы<sup class="bubble count"><?=$this->view->clubsnum;?></sup></a></li>
					</ul>
				</nav>
			</div>
			<div class="col4">
				<nav>
					<ul>
						<li><a href="/useragreement/">Пользовательское соглашение</a></li>
						<li><a href="/contacts/"><?=$this->registry->trans['feedback'];?></a></li>
						<!--<li><a href="#">Логотипы и др. материалы</a></li>-->
					</ul>
				</nav>
			</div>
			<?}?>
			<div class="actions col4 last-col">
				<?
				if(!$_SESSION['User']['id']){
				?>
				<div class="widget share">
					<a class="open" href="#"><?=$this->registry->trans['share'];?></a>
					<div class="popup">
						<div class="l">
							<div class="body">
								<a class="facebook" target="_blank" href="http://facebook.com/sharer.php?t=<?=$this->view->sharetitle;?>&amp;u=<?=$this->view->sharehost;?>"><span class="count">0</span></a>
								<a class="vk" href="http://vkontakte.ru/share.php?url=<?=$this->view->sharehost;?>" target="_blank"><span class="count">0</span></a>
								<a class="twitter" href="http://twitter.com/home?status=Re:Port%20<?=$this->view->sharehost;?>" target="_blank"><span class="count">0</span></a>
							</div>
						</div>
					</div>
				</div>
				<?}?>
					<!--<div class="country-select">
					<a class="country" href="#">Украина</a>
					<div class="ddlist select popup-outer">
						<ul>
							<li><a href="#">Украина</a></li>
							<li><a href="#">США</a></li>
							<li><a href="#">Россия</a></li>
							<li><a href="#">Грузия</a></li>
						</ul>
					</div>
					</div>-->
			</div>
		</div>
	</footer>
	
	<? if($this->registry->langid==1){?>
	<div id="social-side">
		<a class="ir facebook" href="#">facebook</a>
		<a class="ir vk" href="#">vk</a>
		<a class="ir twitter" href="#">twitter</a>
		<a class="ir youtube" href="#">youtube</a>		
	</div>
	<?}elseif($this->registry->langid==2){?>
	<div id="social-side">
		<a class="ir facebook" href="#">facebook</a>
		<a class="ir twitter" href="#">twitter</a>
		<a class="ir youtube" href="#">youtube</a>		
	</div>
	<?}?>
	
	<div class="popup-src" id="help-1">
		<h2>Чек</h2>
		<p>Чек - Общая сумма по позициям: эспрессо, коктектейль Mojito, коктейль Long Island, вода 0,5 типа "Бонаква"; ценовой показатель, уровень платежеспособности целевой аудитории в данном клубе.</p>
	</div>
	<div class="popup-src" id="help-2">
		<h2>ReCard</h2>
		<p>ReCard - Количество владельцев мобильного приложения, через которое посетители клуба могут получать систематические рассылки. База формируется с помощью скачивания QR-кода посетителем клуба. Это скидочные карты, купоны, флаера, подарки в электронном виде, которые позволяют накапливать базу данных клубной аудитории.</p>
	</div>
	<div class="popup-src" id="help-3">
		<h2>Gross Rating Point</h2>
		<p>Gross Rating Point –  Количество посещений клуба в среднем за уикенд. Данный  показатель предоставляет клуб. Администрация Re:Port за правдивость данного показателя отвественности не несет.</p>
	</div>
	<div class="popup-src" id="help-4">
		<h2>Gross Rating Point Followers</h2>
		<p>Gross Rating Point Followers – общее количество followers  (подписчиков) в группах клубов в трех основных социальных сетях — Facebook, Vkontakte, Twitter.</p>
	</div>

	<div class="popup-src form-login" id="form-login">
		<nav>
			<ul>
				<li><a class="popup form" href="#form-forgot"><?=$this->registry->trans['forgotpass'];?></a></li>
				<li><a class="" href="/register/"><?=$this->registry->trans['register'];?></a></li>
			</ul>
		</nav>		
		<form class="validate" method="post" action="/user/login/">
			<input type="hidden" name="url" value="<?=$_SERVER['REQUEST_URI'];?>"/>
			<div class="clearfix">
				<div class="col4">
					<label for="login-email">E-mail</label>
					<input class="txt required" id="login-email" type="text" name="email">
				</div>
				<div class="col4 last-col">
					<label for="login-password"><?=$this->registry->trans['password'];?></label>
					<input class="txt required" id="login-password" type="password" name="password">
				</div>
			</div>
			<div class="actions">
				<div class="field-keep-logged">
					<input type="checkbox" id="check-keep-logged" name="remember" value="1"><label for="check-keep-logged"><?=$this->registry->trans['staylogged'];?></label>
				</div>
				<input class="visuallyhidden" type="submit" value="">
				<a class="button submit" href="#"><?=$this->registry->trans['login'];?></a>
			</div>
			<div class="error-message"></div>
		</form>
	</div>

	<div class="popup-src form-forgot" id="form-forgot">
		<nav>
			<ul>
				<li><a class="active popup form" href="#form-forgot"><?=$this->registry->trans['forgotpass'];?></a></li>
				<li><a href="/register/"><?=$this->registry->trans['register'];?></a></li>
			</ul>
		</nav>		
		<form class="validate">
			<label for="forgot-email">E-mail</label>
			<input class="txt required" id="forgot-email" type="text" name="email">
			<div class="actions">
				<input class="visuallyhidden" type="submit" value="">
				<a class="button submit" href="#"><?=$this->registry->trans['retrievepass'];?></a>
			</div>
			<div class="error-message"></div>
		</form>
	</div>

	<div class="popup-src" id="popup-done">
		<h2>
			<? if($this->registry->langid==1){?>
			Уважаемый (ая), Ваше письмо отправлено.<br> Наш курьер доставит его с минуты на минуту.
			<?}elseif($this->registry->langid==2){?>\
			You will receive an email with futher details.
			<?}?>
		</h2>
		<div class="clearfix">
			<a class="ir ok" href="#"></a>
		</div>
	</div>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
<script>window.jQuery || document.write('<script src="/js/report/vendor/jquery-1.8.1.min.js"><\/script>')</script>
<script src="/js/report/plugins.js"></script>
<script src="/js/report/lang-ru.js"></script>
<? if($this->registry->controller=='clubs' && $this->registry->action=='clubinner'){?>
<script src="/js/report/vendor/highcharts.js"></script>
<?}?>
<script src="/js/report/main.js?<?=time();?>"></script>
</body>
</html>
