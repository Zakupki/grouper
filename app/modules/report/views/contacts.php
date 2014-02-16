			<div class="centerwrap">
				<h1>Обратная связь</h1>

				<div class="form-feedback">
					<form class="validate" method="post" action="/sendfeedback/">
						<div class="clearfix">
							<div class="col6">
								<label for="feedback-email">E-mail</label>
								<input class="txt required" id="feedback-email" type="text" name="email">
								<label for="feedback-subject">Тема</label>
								<select id="feedback-subject" name="subject">
									<? foreach($this->view->supporttypes as $type){?>
									<option value="<?=$type['id'];?>"><?=$type['name'];?></option>
									<?}?>
								</select>
							</div>
							<div class="col10 last-col">
								<label for="feedback-message">Сообщение</label>
								<textarea class="txt required" id="feedback-message" name="message"></textarea>
								<div class="actions">
									<a class="button submit" href="#">Отправить</a>
									<!--<div class="upload widget">
										<a class="button attach" href="#"></a>
										<div class="label">Прикрепить файл (до 1Мб)</div>
										<a class="button remove" href="#"></a>
										<input type="file" name="file" class="file-input">
									</div>-->
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="contact-info clearfix">
					<div class="col6">
						<h5>Служба поддержки</h5>
						<div class="txt"><a href="mailto:support@clubsreport.com">support@grouper.com.ua</a></div>
					</div>
					<!--<div class="col5">
						<h5>Менеджер проект Яна Селина</h5>
						<div class="txt">+38 067 250 26 25</div>
					</div>-->
					<div class="col5 last-col">
						<h5>Куратор проекта Роман Олейник</h5>
						<div class="txt">+38 044 538 10 10</div>
					</div>
				</div>

			</div>