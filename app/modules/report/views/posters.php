<div class="centerwrap">
	<h1>Постеры</h1>
	<div class="widget posters" data-perpage="<?=$this->view->takeposters;?>">
		<ul class="posters-list clearfix">
			<?=$this->view->posterlist;?>
		</ul>
		<? if(count($this->view->events['events'])>0){?>
		<div class="list-actions">
			<a class="button more" href="#"><?=$this->registry->trans['loadmore'];?></a>
		</div>
		<?}?>
	</div>
</div>
<div class="popup-src edit-poster" id="edit-poster">
	<h1>Сообщение заведению</h1>
	<div class="clearfix">
		<form  class="" action="/ajax/posterreply/" method="post" enctype="multipart/form-data">
			<input type="hidden" name="posterid" value="">
			<input type="hidden" name="eventid" value="">			
			<div class="contact-field">
				<label>Кому</label>
				<div class="txt disabled"></div>
			</div>
			<div class="subject-field">
				<label>Тема</label>
				<div class="txt disabled"></div>
			</div>
			<div class="message-field">
				<label for="edit-poster-message-input">Сообщение</label>
				<textarea id="edit-poster-message-input" class="txt required" name="message"></textarea>
			</div>
			<div class="actions">
				<input class="visuallyhidden" type="submit" value="">
				<a class="button submit">Отправить</a>
				<div class="upload widget">
					<a class="button attach"></a>
					<div class="label">Прикрепить файл</div>
					<a class="button remove"></a>
					<input type="file" name="file" class="file-input">
				</div>
			</div>
		</form>
	</div>
</div>
