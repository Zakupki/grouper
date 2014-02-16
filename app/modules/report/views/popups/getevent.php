			<div class="popup-src edit-event" id="edit-event-1">
				<h1>Новый InDoor</h1>
				<form class="validate" action="/events/updateevent/" method="post" enctype="multipart/form-data">
					<? if($this->view->eventinner['id']){?>
					<input name="id" type="hidden" value="<?=$this->view->eventinner['id'];?>" >
					<?}?>
					<? if($this->view->eventinner['fileurl']){?>
					<input name="fileurl" type="hidden" value="<?=$this->view->eventinner['fileurl'];?>" >
					<?}?>
					<? if($this->view->eventinner['filename']){?>
					<input name="filename" type="hidden" value="<?=$this->view->eventinner['filename'];?>" >
					<?}?>
					<div class="params clearfix">
						<div class="clubs-count">
							<h6>Кол-во заведений</h6>
							<div class="bignum">
								<span class="co count-0<?=(tools::int($this->view->eventinner['filtertype'])<1)?' active':'';?>"><?=$this->view->clubsnum;?></span>
								<span class="co count-1<?=($this->view->eventinner['filtertype']==1)?' active':'';?>"><?=tools::int($this->view->clubsfav);?></span>
								<span class="co count-2<?=($this->view->eventinner['filtertype']==2)?' active':'';?>"><?=count($this->view->eventinner['siteids']);?></span>
							</div>
						</div>
						<div class="date-field date col4">
							<h6>Дата InDoor</h6>
							<input class="date-input" name="date" type="hidden" value="<?=$this->view->eventinner['date_start'];?>">
							<div class="date-display"><span class="day"></span> <span class="month"></span> <span class="year"></span></div>
						</div>
					</div>
					<div class="title-field">
						<?php
							$indoorTitle = $this->view->eventinner['name'];
						?>
						<label for="new-event-title-input">Тип InDoor</label>
						<select id="new-event-title-input" name="title">
							<option value="Ротация рекламных роликов"<?=($indoorTitle=='Ротация рекламных роликов'?' checked="checked"':'');?>>Ротация  рекламных роликов</option>
							<option value="Распространение печатных материалов"<?=($indoorTitle=='Распространение печатных материалов'?' checked="checked"':'');?>>Распространение печатных материалов</option>
							<option value="Программы лояльности"<?=($indoorTitle==''?' checked="checked"':'');?>>Программы лояльности</option>
							<option value="Брендинг"<?=($indoorTitle=='Брендинг'?' checked="checked"':'');?>>Брендинг</option>
							<option value="Организация ивентов"<?=($indoorTitle=='Организация ивентов'?' checked="checked"':'');?>>Организация ивентов</option>
							<option value="Присутствие товаров вашего бренда в меню"<?=($indoorTitle=='Присутствие товаров вашего бренда в меню'?' checked="checked"':'');?>>Присутствие товаров вашего бренда в меню</option>
							<option value="Распространение образцов товаров вашего бренда"<?=($indoorTitle=='Распространение образцов товаров вашего бренда'?' checked="checked"':'');?>>Распространение образцов товаров вашего бренда</option>
							<option value="Кросс маркетинговые акции"<?=($indoorTitle=='Кросс маркетинговые акции'?' checked="checked"':'');?>>Кросс маркетинговые акции</option>
							<option value="Другое"<?=($indoorTitle=='Другое'?' checked="checked"':'');?>>Другое</option>
						</select>
					</div>
					<div class="desc-field">
						<label for="new-event-desc-input">Описание InDoor</label>
						<textarea id="new-event-desc-input" class="txt required" name="desc"><?=$this->view->eventinner['detail_text'];?></textarea>
					</div>
					<div class="clubs-filter">
						<div class="clubs-filter-list">
							<label>Укажите названия заведений для этой операции</label>
							<input class="ids-input txt" name="clubs-filter-ids" type="text" value="<?=implode(',',$this->view->eventinner['siteids']);?>">
							<input class="clubs-list-input txt" name="clubs-filter-list" value="<?=implode(';',$this->view->eventinner['sitenames']);?>">
						</div>
						<div class="radios clearfix">
							<div class="col4">
								<label><input type="radio" name="clubsFilter" value="2"<?=($this->view->eventinner['filtertype']==2)?' checked':'';?>> Создать свой список заведений</label>
							</div>
							<div class="col3">
								<label><input type="radio" name="clubsFilter" value="0"<?=(tools::int($this->view->eventinner['filtertype'])<1)?' checked':'';?>> Для всех заведений</label>
							</div>
							<div class="col5 last-col">
								<label><input type="radio" name="clubsFilter" value="1"<?=($this->view->eventinner['filtertype']==1)?' checked':'';?>> Для избранных заведений</label>
							</div>
						</div>
					</div>
					<div class="actions clearfix">
						<input class="visuallyhidden" type="submit" value="">
						<a class="button submit" href="#">Разместить</a>
						<div class="upload widget">
							<a class="button attach" href="#"></a>
							<div class="label">Прикрепить файл</div>
							<a class="button remove" href="#"></a>
							<input type="file" name="file" class="file-input">
						</div>
					</div>
				</form>
			</div>
