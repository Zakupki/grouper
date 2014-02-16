<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration Panel</title>
<link media="screen" rel="stylesheet" type="text/css" href="/css/admin/admin.css"  />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="/css/admin/admin-ie.css" /><![endif]-->
<script type="text/javascript" src="/js/admin/main.js?<?=time();?>"></script>
</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		<!--[if !IE]>start head<![endif]-->
		<div id="head">
			
			<!--[if !IE]>start logo and user details<![endif]-->
			<div id="logo_user_details">
				<h1 id="logo"><a href="/admin/">websitename Administration Panel</a></h1>
				<!--[if !IE]>start user details<![endif]-->
				<div id="user_details">
					<ul id="user_details_menu">
						<li>Welcome <strong>Administrator</strong></li>
						<li>
							<ul id="user_access">
								<li class="first"><a href="#">My account</a></li>
								<li class="last"><a href="/admin/logout/">Выйти</a></li>
							</ul>
						</li>
						<li><a class="new_messages" href="#">4 new messages</a></li>
					</ul>
					<div id="server_details">
						<dl>
							<dt>Server time :</dt>
							<dd>6:45 AM</dd>
						</dl>
						<dl>
							<dt>Last login ip :</dt>
							<dd>192.168.0.15</dd>
						</dl>
					</div>
					<!--[if !IE]>start search<![endif]-->
					
					<!--[if !IE]>end search<![endif]-->
				</div>
				
				<!--[if !IE]>end user details<![endif]-->
				
				
				
			</div>
			
			<!--[if !IE]>end logo end user details<![endif]-->
			
			
			
			<!--[if !IE]>start menus_wrapper<![endif]-->
			<div id="menus_wrapper">
				<div id="main_menu">
					<ul>
						<? if($this->view->registry->controller=='index'){?>
							<li><a href="/admin/" class="selected"><span><span>Главная</span></span></a></li>
						<?}else{?>
							<li><a href="/admin/"><span><span>Главная</span></span></a></li>
						<?} 
						if($this->view->registry->controller=='users'){?>
							<li><a href="/admin/users/" class="selected"><span><span>Пользователи</span></span></a></li>
						<?}else{?>
							<li><a href="/admin/users/"><span><span>Пользователи</span></span></a></li>
						<?} if($this->view->registry->controller=='payrequest'){?>
							<li><a href="/admin/payrequest/" class="selected"><span><span>Вывод денег</span></span></a></li>
						<?}else{?>
							<li><a href="/admin/payrequest/"><span><span>Вывод денег</span></span></a></li>
						<?}?>
						
						<!--<li><a href="#"><span><span>Server Settings</span></span></a></li>
						<li><a href="#"><span><span>Product Management</span></span></a></li>
						<li><a href="#"><span><span>User Accounts</span></span></a></li>
						<li><a href="#"><span><span>SEO</span></span></a></li>-->
					</ul>
				</div>
				<div id="sec_menu">
						<ul>
						<? if($this->view->registry->controller=='users'){?>
						<li><a href="/admin/users/" class="sm4">Пользователи</a></li>
						<li><a href="/admin/users/discounts/" class="sm2">Скидки</a></li>
						<li><a href="/admin/user/" class="sm4">Добавить пользователя</a></li>
						<?}?>
						<? if($this->view->registry->controller=='geo'){?>
						<li><a href="/admin/geo/" class="sm2">Города</a></li>
						<li><a href="/admin/geo/countries/" class="sm4">Страны</a></li>
						<?}
						if($this->view->registry->controller=='brands'){?>
						<li><a href="/admin/brands/" class="sm4">Бренды</a></li>
						<li><a href="/admin/brands/offers/" class="sm4">Предложения клубов</a></li>
						<li><a href="/admin/brands/requests/" class="sm4">Заявки брендов</a></li>
						<?}?>
						</ul>
				<!--	<ul>
						<li><a href="#" class="sm1">Security Settings</a></li>
						<li><a href="#" class="sm2">Chat and PMs</a></li>
						<li><a href="#" class="sm3">Search Options</a></li>
						<li><a href="#" class="sm4">Moderators</a></li>
						<li><a href="#" class="sm5">Upload Options</a></li>
						<li><a href="#" class="sm6">Download Options</a></li>
						<li><a href="#" class="sm7">Emails</a></li>
						<li>
							<span class="drop"><span><span><a href="#" class="sm8">More</a></span></span></span>
							<ul>
								<li><a class="sm6" href="#">Download options</a></li>
								<li><a class="sm4" href="#">Menu item</a></li>
								<li><a class="sm6" href="#">Download options</a></li>
								<li><a class="sm6" href="#">Download options</a></li>
								<li><a class="sm6" href="#">Download options</a></li>
							</ul>
						</li>
					</ul>-->
				</div>
			</div>
			<!--[if !IE]>end menus_wrapper<![endif]-->
			
			
			
		</div>
		<!--[if !IE]>end head<![endif]-->
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
			
			
			
			
			<!--[if !IE]>start page<![endif]-->
			<div id="page">
				<div class="inner">
					
					
					
					<!--[if !IE]>start section<![endif]-->	
					<?=$this->view->content;?>
					<!--[if !IE]>end section<![endif]-->
					
					
					<!--[if !IE]>start section<![endif]-->	
					
					<!--[if !IE]>end section<![endif]-->
					
					
						
				</div>
			</div>
			<!--[if !IE]>end page<![endif]-->
			<!--[if !IE]>start sidebar<![endif]-->
			<!--<div id="sidebar">
				<div class="inner">
					<div class="section">
						<div class="title_wrapper">
							<h2>Sidebar Menu</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<ul class="sidebar_menu">
													<li><a href="#">View pending orders list</a></li>
													<li><a href="#">Shipping and handling fees</a></li>
													<li><a href="#">Setup registration</a></li>
													<li><a href="#">Manage filters</a></li>
													<li><a href="#">Dashboard links</a></li>
													<li><a href="#">Product Categories</a></li>
													<li class="last"><a href="#">SEO Settings</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
						</div>
					</div>
				</div>
			</div>-->
			<!--[if !IE]>end sidebar<![endif]-->
			
			
			
			
		</div>
		<!--[if !IE]>end content<![endif]-->
		
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
	
	<!--[if !IE]>start footer<![endif]-->
	<div id="footer">
		<div id="footer_inner">
		
		<dl class="copy">
			<dt><strong>HyperAdmin</strong> <em>build 26122008</em></dt>
			<dd>&copy; 2008 Yourcompany.com  All rights reserved.</dd>
		</dl>
		
		<dl class="quick_links">
			<dt><strong>Quick Links :</strong></dt>
			<dd>
				<ul>
					<li><a href="#">Dashboard </a></li>
					<li><a href="#">My Account</a></li>
					<li><a href="#">General Settings</a></li>
					<li><a href="#">Static Pages</a></li>
					<li><a href="#">Users</a></li>
					<li><a href="#">Products</a></li>
					<li><a href="#">Marketing</a></li>
					<li class="last"><a href="#">Log out</a></li>
				</ul>
			</dd>
		</dl>
		
		
		<dl class="help_links">
			<dt><strong>Need Help ?</strong></dt>
			<dd>
				<ul>
					<li><a href="#">Live Help</a></li>
					<li><a href="#">FAQ</a></li>
					<li class="last"><a href="#">Knowledgebase</a></li>
				</ul>
			</dd>
		</dl>
	
		</div>
	</div>
	<!--[if !IE]>end footer<![endif]-->
	
</body>
</html>
