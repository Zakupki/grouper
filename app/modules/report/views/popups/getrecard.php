			<div class="popup-src edit-recard" id="new-recard">
				<h1>Новая карта (ReCard)</h1>
				<form class="validate" action="/recards/updaterecard/" method="post" enctype="multipart/form-data">
					<? if($this->view->recardinner['id']){?>
					<input name="id" type="hidden" value="<?=$this->view->recardinner['id'];?>" >
					<?}?>
					<? if($this->view->recardinner['fileurl']){?>
					<input name="fileurl" type="hidden" value="<?=$this->view->recardinner['fileurl'];?>" >
					<?}?>
					<? if($this->view->recardinner['filename']){?>
					<input name="filename" type="hidden" value="<?=$this->view->recardinner['filename'];?>" >
					<?}?>
					<div class="params clearfix">
						<div class="clubs-count">
							<h6>Кол-во заведений</h6>
							<div class="bignum">
								<span class="co count-0<?=(tools::int($this->view->recardinner['filtertype'])<1)?' active':'';?>"><?=$this->view->clubsnum;?></span>
								<span class="co count-1<?=($this->view->recardinner['filtertype']==1)?' active':'';?>"><?=tools::int($this->view->clubsfav);?></span>
								<span class="co count-2<?=($this->view->recardinner['filtertype']==2)?' active':'';?>"><?=count($this->view->recardinner['siteids']);?></span>
							</div>
						</div>
						<div class="date-range clearfix">
							<div class="date-field date-from col4">
								<h6>Начало</h6>
								<input class="date-input" name="dateFrom" type="hidden" value="<?=$this->view->recardinner['date_start'];?>">
								<div class="date-display"><span class="day"></span> <span class="month"></span> <span class="year"></span></div>
							</div>
							<div class="date-field date-to col4 last-col">
								<h6>Конец</h6>
								<input class="date-input" name="dateTo" type="hidden" value="<?=$this->view->recardinner['date_end'];?>">
								<div class="date-display"><span class="day"></span> <span class="month"></span> <span class="year"></span></div>
							</div>
						</div>
					</div>
					<div class="title-field">
						<label for="new-recard-title-input">Название карты</label>
						<input id="new-recard-title-input" class="txt required" type="text" name="title" value="<?=$this->view->recardinner['name'];?>">
					</div>
					<div class="desc-field">
						<label for="new-recard-desc-input">Описание</label>
						<textarea id="new-recard-desc-input" class="txt required" name="desc"><?=$this->view->recardinner['detail_text'];?></textarea>
					</div>
					<div class="clubs-filter">
						<div class="clubs-filter-list">
							<label>Укажите названия заведений для этой операции</label>
							<input class="ids-input txt" name="clubs-filter-ids" type="text" value="<?=implode(',',$this->view->recardinner['siteids']);?>">
							<input class="clubs-list-input txt" name="clubs-filter-list" value="<?=implode(';',$this->view->recardinner['sitenames']);?>">
						</div>
						<div class="radios clearfix">
							<div class="col4">
								<label><input type="radio" name="clubsFilter" value="2"<?=($this->view->recardinner['filtertype']==2)?' checked':'';?>> Создать свой список заведений</label>
							</div>
							<div class="col3">
								<label><input type="radio" name="clubsFilter" value="0"<?=(tools::int($this->view->recardinner['filtertype'])<1)?' checked':'';?>> Для всех заведений</label>
							</div>
							<div class="col5 last-col">
								<label><input type="radio" name="clubsFilter" value="1"<?=($this->view->recardinner['filtertype']==1)?' checked':'';?>> Для избранных заведений</label>
							</div>
						</div>
					</div>
					<div class="actions clearfix">
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
