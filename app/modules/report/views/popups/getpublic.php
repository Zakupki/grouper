			<div class="popup-src edit-public" id="new-public">
				<h1><?=($this->view->publicinner['public']['id'])?'Редактировать паблик':'Новый паблик';?></h1>
				<div class="clearfix">
					<form class="validate" action="/public/updatepublic/" method="post" enctype="multipart/form-data">
					<div class="clearfix">
						<div class="col4 params">
							<dl>
								<dt>Кол-во групп <a class="help" href="#help-27"></a></dt>
								<dd class="bignum groups-count">
									<span class="co count-0<?=(tools::int($this->view->publicinner['public']['filtertype'])<1)?' active':'';?>"><?=$this->view->publicinner['allpublic']['groups'];?></span>
									<span class="co count-1<?=($this->view->publicinner['public']['filtertype']==1)?' active':'';?>"><?=tools::int($this->view->publicinner['favpublic']['groups']);?></span>
									<span class="co count-2<?=($this->view->publicinner['public']['filtertype']==2)?' active':'';?>"><?=tools::int($this->view->publicinner['custpublic']['groups']);?></span>
								</dd>
								<dt>Кол-во подписчиков <a class="help" href="#help-28"></a></dt>
								<dd class="bignum grp">
									<span class="co count-0<?=(tools::int($this->view->publicinner['public']['filtertype'])<1)?' active':'';?>"><?=tools::int($this->view->publicinner['allpublic']['followers']);?></span>
									<span class="co count-1<?=($this->view->publicinner['public']['filtertype']==1)?' active':'';?>"><?=tools::int($this->view->publicinner['favpublic']['followers']);?></span>
									<span class="co count-2<?=($this->view->publicinner['public']['filtertype']==2)?' active':'';?>"><?=tools::int($this->view->publicinner['custpublic']['followers']);?></span>
								</dd>
								<dt>Коэффициент <a class="help" href="#help-29"></a></dt>
								<dd class="bignum public-ratio"><?=$this->registry->publiccoef;?></dd>
								<dt>Кол-во контактов <a class="help" href="#help-30"></a></dt>
								<dd class="bignum contacts-total">
									<span class="co count-0<?=(tools::int($this->view->publicinner['public']['filtertype'])<1)?' active':'';?>"><?=ceil(tools::int($this->view->publicinner['allpublic']['followers'])*$this->registry->publiccoef);?></span>
									<span class="co count-1<?=($this->view->publicinner['public']['filtertype']==1)?' active':'';?>"><?=ceil(tools::int($this->view->publicinner['favpublic']['followers'])*$this->registry->publiccoef);?></span>
									<span class="co count-2<?=($this->view->publicinner['public']['filtertype']==2)?' active':'';?>"><?=ceil(tools::int($this->view->publicinner['custpublic']['followers'])*$this->registry->publiccoef);?></span>
								</dd>
								<dt>Стоимость одного контакта (грн.) <a class="help" href="#help-31"></a></dt>
								<dd class="bignum contact-cost"><?=$this->registry->contactprice;?></dd>
								<dt>Макс. стоимость кампании (грн.) <a class="help" href="#help-32"></a></dt>
								<dd class="bignum max-campaign-cost">
									<span class="co count-0<?=(tools::int($this->view->publicinner['public']['filtertype'])<1)?' active':'';?>"><?=ceil(tools::int($this->view->publicinner['allpublic']['followers'])*$this->registry->publiccoef)*$this->registry->contactprice;?></span>
									<span class="co count-1<?=($this->view->publicinner['public']['filtertype']==1)?' active':'';?>"><?=ceil(tools::int($this->view->publicinner['favpublic']['followers'])*$this->registry->publiccoef)*$this->registry->contactprice;?></span>
									<span class="co count-2<?=($this->view->publicinner['public']['filtertype']==2)?' active':'';?>"><?=ceil(tools::int($this->view->publicinner['custpublic']['followers'])*$this->registry->publiccoef)*$this->registry->contactprice;?></span>
								</dd>
							</dl>
						</div>
						<div class="col8 last-col">
								<? if($this->view->publicinner['public']['id']){?>
								<input name="id" type="hidden" value="<?=$this->view->publicinner['public']['id'];?>" >
								<?}?>
								<? if($this->view->publicinner['public']['fileurl']){?>
								<input name="fileurl" type="hidden" value="<?=$this->view->publicinner['public']['fileurl'];?>" >
								<?}?>
								<? if($this->view->publicinner['public']['filename']){?>
								<input name="filename" type="hidden" value="<?=$this->view->publicinner['public']['filename'];?>" >
								<?}?>
								<div class="date-field">
									<h6>Начало рекламной кампании</h6>
									<input class="date-input" name="date" type="hidden" value="<?=$this->view->publicinner['public']['date_start'];?>">
									<div class="date-display"><span class="day"></span> <span class="month"></span> <span class="year"></span></div>
								</div>
								<div class="desc-field">
									<label for="new-public-desc-input">Публикация</label>
									<textarea id="new-public-desc-input" class="txt" name="desc"><?=$this->view->publicinner['public']['detail_text'];?></textarea>
								</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="groups-filter">
							<div class="groups-filter-list">
								<label>Укажите названия групп для этой операции</label>
								<input class="ids-input txt" name="groups-filter-ids" type="text" value="<?=implode(',',$this->view->publicinner['public']['siteids']);?>">
								<input class="groups-list-input txt" name="groups-filter-list" value="<?=implode(';',$this->view->publicinner['public']['sitenames']);?>">
							</div>
							<div class="radios clearfix">
								<div class="col4">
									<label><input type="radio" name="groupsFilter" value="2"<?=($this->view->publicinner['public']['filtertype']==2)?' checked':'';?>> Создать свой список групп</label>
								</div>
								<div class="col3">
									<label><input type="radio" name="groupsFilter" value="0"<?=(tools::int($this->view->publicinner['public']['filtertype'])==0)?' checked':'';?>> Для всех групп</label>
								</div>
								<div class="col5 last-col">
									<label><input type="radio" name="groupsFilter" value="1"<?=($this->view->publicinner['public']['filtertype']==1)?' checked':'';?>> Для избранных групп</label>
								</div>
							</div>
						</div>
						<div class="actions">
							<input class="visuallyhidden" type="submit" value="">
							<a class="button submit" href="#"><?=($this->view->publicinner['public']['id'])?'Редактировать':'Разместить';?></a>
							<div class="upload widget">
								<a class="button attach" href="#"></a>
								<div class="label">Прикрепить файл</div>
								<a class="button remove" href="#"></a>
								<input type="file" name="file" class="file-input">
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
