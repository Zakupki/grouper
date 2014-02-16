<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Re:Port</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="/css/report/main.css">
	<script src="/js/report/vendor/modernizr-2.6.1.min.js"></script>
</head>
<body class="enter">

	<div id="main">

		<div id="content">
			<div class="centerwrap">
				<div class="logo"><a href="#"><img src="<?=($this->view->branddata['logo'])?$this->view->branddata['logo']:'/img/report/report-logo-header.png';?>" alt=""></a></div>
				<div class="form-login">
					<form class="validate" method="post" action="/user/login/">
						<input type="hidden" value="/" name="url">
						<div class="fields clearfix">
							<div class="col4">
								<label for="login-email">E-mail</label>
								<input class="txt required" id="login-email" type="text" name="email">
							</div>
							<div class="col4 last-col">
								<label for="login-password">Пароль</label>
								<input class="txt required" id="login-password" type="password" name="password">
							</div>
						</div>
						<div class="actions clearfix">
							<div class="field-keep-logged">
								<input type="checkbox" id="check-keep-logged" name="remember" value="1"><label for="check-keep-logged">Оставаться в системе</label>
								<!--<a class="forgot" href="#">Забыл пароль</a>-->
							</div>
							<input class="visuallyhidden" type="submit" value="">
							<a class="button bordered submit" href="#">Войти</a>
						</div>
						<div class="error-wrap"><div class="error-message"></div></div>
					</form>
				</div>
				<div class="form-forgot">
					<form class="validate">
						<div class="fields">
							<label for="forgot-email">E-mail</label>
							<input class="txt required" id="forgot-email" type="text" name="email">
						</div>
						<div class="actions">
							<a class="login" href="#">Войти</a>
							<a class="button bordered submit" href="#">Напомнить</a>
						</div>
						<div class="error-wrap"><div class="error-message"></div></div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<div class="centerwrap clearfix">
			<div class="copyright col4">
				<img src="/img/report/report-logo-footer.png" alt="">
				<div class="txt">© 2012-2013 Reactor-Pro, LLC</div>
			</div>
		</div>
	</footer>
	
	<div id="social-side">
		<a class="ir facebook" href="https://www.facebook.com/reactorpro">facebook</a>
		<a class="ir vk" href="http://vk.com/reparty">vk</a>
		<a class="ir twitter" href="#">twitter</a>
		<a class="ir youtube" href="http://www.youtube.com/user/ReactorProRu/videos">youtube</a>		
	</div>
	
	<div class="popup-src" id="help-1">
		<h2>Название какой-то непонятки (help)</h2>
		<p>Международное научное издание New Scientist опубликовало составленный экспертами список загадочных фактов и явлений, которые уже долгое время порождают теории и дискуссии среди ученых. Первым в списке стоит эффект плацебо, когда человек выпивает вместо таблетки «пустышку» и выздоравливает, лишь поверив в то, что это панацея от болезни.</p>
	</div>

	<div class="popup-src form-join" id="form-join">
		<form class="validate">
			<label for="join-title">Название бренда / компании / агентства</label>
			<input class="txt required" id="join-title" type="text" name="title">
			<label for="join-site">Ссылка на сайт бренда / компании / агентства</label>
			<input class="txt" id="join-site" type="text" name="site">
			<div class="clearfix">
				<div class="col4">
					<label for="join-email">Ваш e-mail</label>
					<input class="txt required" id="join-email" type="text" name="email">
				</div>
				<div class="col4 last-col">
					<label for="join-phone">Номер Вашего телефона</label>
					<input class="txt" id="join-phone" type="text" name="phone">
				</div>
			</div>
			<div class="actions">
				<a class="button submit" href="#">Отправить заявку</a>
			</div>
			<div class="error-message"></div>
		</form>
	</div>

	<div class="popup-src form-login" id="form-login">
		<nav>
			<ul>
				<li><a class="popup form" href="#form-forgot">Забыл пароль</a></li>
				<li><a class="" href="/register/">Отправить заявку на регистрацию</a></li>
			</ul>
		</nav>		
		<form class="validate" method="post" action="ajax/login.php">
			<div class="clearfix">
				<div class="col4">
					<label for="login-email">E-mail</label>
					<input class="txt required" id="login-email" type="text" name="email">
				</div>
				<div class="col4 last-col">
					<label for="login-password">Пароль</label>
					<input class="txt required" id="login-password" type="password" name="password">
				</div>
			</div>
			<div class="actions">
				<div class="field-keep-logged">
					<input type="checkbox" id="check-keep-logged" name="keep-logged"><label for="check-keep-logged">Оставаться в системе</label>
				</div>
				<a class="button submit" href="#">Войти</a>
			</div>
			<div class="error-message"></div>
		</form>
	</div>

	<div class="popup-src form-forgot" id="form-forgot">
		<nav>
			<ul>
				<li><a class="active popup form" href="#form-forgot">Забыл пароль</a></li>
				<li><a class="popup form" href="#form-join">Отправить заявку на регистрацию</a></li>
			</ul>
		</nav>		
		<form class="validate">
			<label for="forgot-email">E-mail</label>
			<input class="txt required" id="forgot-email" type="text" name="email">
			<div class="actions">
				<a class="button submit" href="#">Напомнить</a>
			</div>
			<div class="error-message"></div>
		</form>
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/report/vendor/jquery-1.8.1.min.js"><\/script>')</script>
<script src="/js/report/plugins.js"></script>
<script src="/js/report/lang-ru.js"></script>
<script src="/js/report/main.js"></script>
</body>
</html>
