			<div class="popup-src edit-banner" id="edit-banner-1">
				<h1><?=($this->view->bannerinner['banner']['id'])?'Редактировать':'Новый';?> баннер</h1>
				<div class="clearfix">
					<form  class="validate" action="/banners/updatebanner/" method="post" enctype="multipart/form-data">
					<div class="clearfix">
						<div class="col4 params">
							<dl>
								<dt>Кол-во заведений <a class="help" href="#help-8"></a></dt>
								<dd class="bignum clubs-count">
									<span class="co count-0"><?=$this->view->bannerinner['allbanner']['sites'];?></span>
									<span class="co count-1"><?=$this->view->bannerinner['favbanner']['sites'];?></span>
									<span class="co count-2"><?=tools::int($this->view->bannerinner['castbanner']['sites']);?></span>
								</dd>
								<dt>Общая посещаемость сайтов <a class="help" href="#help-25"></a></dt>
								<dd class="bignum visits-total">
									<span class="co count-0"><?=$this->view->bannerinner['allbanner']['visits'];?></span>
									<span class="co count-1"><?=$this->view->bannerinner['favbanner']['visits'];?></span>
									<span class="co count-2"><?=$this->view->bannerinner['castbanner']['visits'];?></span>
								</dd>
								<dt>Цена контакта (грн.) <a class="help" href="#help-12"></a></dt>
								<dd class="bignum contact-cost"><?=$this->registry->bannerprice;?></dd>
								<dt>Макс. стоимость кампании <a class="help" href="#help-26"></a></dt>
								<dd class="bignum max-campaign-cost">
									<span class="co count-0"><?=ceil($this->view->bannerinner['allbanner']['visits']*$this->registry->bannerprice);?></span>
									<span class="co count-1"><?=ceil($this->view->bannerinner['favbanner']['visits']*$this->registry->bannerprice);?></span>
									<span class="co count-2"><?=ceil($this->view->bannerinner['castbanner']['visits']*$this->registry->bannerprice);?></span>
								</dd>
							</dl>
						</div>
						<div class="col8 last-col">
							<? if($this->view->bannerinner['banner']['id']){?>
							<input name="id" type="hidden" value="<?=$this->view->bannerinner['banner']['id'];?>" >
							<?}?>
							<? if($this->view->bannerinner['banner']['fileurl']){?>
							<input name="fileurl" type="hidden" value="<?=$this->view->bannerinner['banner']['fileurl'];?>" >
							<?}?>
							<? if($this->view->bannerinner['banner']['filename']){?>
							<input name="filename" type="hidden" value="<?=$this->view->bannerinner['banner']['filename'];?>" >
							<?}?>
							<div class="date-range clearfix">
								<div class="date-field date-from col4">
									<h6>Начало рекламной кампании</h6>
									<input class="date-input" name="dateFrom" type="hidden" value="<?=$this->view->bannerinner['banner']['date_start'];?>">
									<div class="date-display"><span class="day"></span> <span class="month"></span> <span class="year"></span></div>
								</div>
								<div class="date-field date-to col4 last-col">
									<h6>Конец рекламной кампании</h6>
									<input class="date-input" name="dateTo" type="hidden" value="<?=$this->view->bannerinner['banner']['date_end'];?>">
									<div class="date-display"><span class="day"></span> <span class="month"></span> <span class="year"></span></div>
								</div>
							</div>
							<div class="banner-preview">
								<img src="<?=($this->view->bannerinner['banner']['fileurl2'])?$this->view->bannerinner['banner']['fileurl2']:'/img/report/banner-placeholder.png';?>" alt=""></div>
							<div class="link-field">
								<label for="new-banner-link-input">Ссылка (не обязательно)</label>
								<input id="new-banner-link-input" class="txt" type="text" name="link" value="<?=$this->view->bannerinner['banner']['link'];?>">
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="clubs-filter">
							<div class="clubs-filter-list">
								<label>Укажите названия заведений для этой операции</label>
								<input class="ids-input txt" name="clubs-filter-ids" type="text" value="<?=implode(',',$this->view->bannerinner['banner']['siteids']);?>">
								<input class="clubs-list-input txt" name="clubs-filter-list" value="<?=implode(';',$this->view->bannerinner['banner']['sitenames']);?>">
							</div>
							<div class="radios clearfix">
								<?=$this->view->bannerinner['filtertype'];?>
							<div class="col4">
								<label><input type="radio" name="clubsFilter" value="2"<?=($this->view->bannerinner['banner']['filtertype']==2)?' checked':'';?>> Создать свой список заведений</label>
							</div>
							<div class="col3">
								<label><input type="radio" name="clubsFilter" value="0"<?=(tools::int($this->view->bannerinner['banner']['filtertype'])==0)?' checked':'';?>> Для всех заведений</label>
							</div>
							<div class="col5 last-col">
								<label><input type="radio" name="clubsFilter" value="1"<?=($this->view->bannerinner['banner']['filtertype']==1)?' checked':'';?>> Для избранных заведений</label>
							</div>
						</div>
						</div>
						<div class="actions">
							<input class="visuallyhidden" type="submit" value="">
							<a class="button submit" href="#">Разместить</a>
							<div class="upload widget">
								<a class="button attach" href="#"></a>
								<div class="label">Загрузить баннер 980 X 220 pix. (*.jpg)</div>
								<a class="button remove" href="#"></a>
								<input type="file" name="file" class="file-input">
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
