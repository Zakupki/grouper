	<!--[if !IE]>start login<![endif]-->
			<?
			if(is_array($this->view->error))
			{
			?>
			<div class="error">
				<div class="error_inner">
					<strong>Доступ запрещен</strong> | <span><?=implode('. ', $this->view->error);?></span>
				</div>
			</div>
			<?
			}
			?>
			
			<form action="/admin/login/" method="post">
				<fieldset>
					<?=$this->view->token;?>
					
					
					
					
					<h1 id="logo"><a href="#">websitename Administration Panel</a></h1>
					<div class="formular">
						<div class="formular_inner">
						
						<label>
							<strong>Логин:</strong>
							<span class="input_wrapper">
								<input name="email" type="text" />
							</span>
						</label>
						<label>
							<strong>Пароль:</strong>
							<span class="input_wrapper">
								<input name="password" type="password" />
							</span>
						</label>
						<label class="inline">
							<input class="checkbox" name="" type="checkbox" value="" />
							запомнить меня на этом компьютере
						</label>
						
						
						<ul class="form_menu">
							<li><span class="button"><span><span>Войти</span></span><input type="submit" name=""/></span></li>
							<li><a href="#"><span><span>Напомнить</span></span></a></li>
						</ul>
						
						</div>
					</div>
				</fieldset>
			</form>
			<!--[if !IE]>end login<![endif]-->