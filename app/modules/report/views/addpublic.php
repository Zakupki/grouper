<div class="centerwrap">
	<h1>Разместить</h1>
	<div class="add-public" data-balance="<?=$this->view->pricerange['balance'];?>">
		<form action="/public/updatepublic/" method="post">
    <input type="hidden" class="public-id-input" name="id" value="<?=$_GET['id'];?>">
		<div class="public-switcher clearfix">
			<input type="hidden" class="public-switch-input" name="type" value="publication">
			<div class="col8">
				<a class="publication switch on">
					<h2>Публикацию</h2>
					<p>Данный список создаётся на основе сравнения названий вновь созданных и удалявшихся ранее статей. Попадание статей в список может быть случайным, не означает их вандальный или спамовый характер и всегда требует ручной проверки.</p>
				</a>
			</div>
			<div class="col8 last-col">
				<a class="repost switch">
					<h2>Репост</h2>
					<p>Данный список создаётся на основе сравнения названий вновь созданных и удалявшихся ранее статей. Попадание статей в список может быть случайным, не означает их вандальный или спамовый характер и всегда требует ручной проверки.</p>
				</a>
			</div>
		</div>
		<div class="clearfix">
			<div class="col11">
				<div class="dates">
					<label>Дата и время публикации</label>
					<div class="field date-field with-time">
						<input class="date-input" type="hidden" name="date" value="<?=$this->view->publicinner['date_start'];?>">
						<div class="date-display">
							<span class="day"></span> <span class="month"></span> <span class="year"></span>, <span class="time"></span>
						</div>
					</div>
				</div>

				<div class="switched-content publication-only">
					<label>Публикация</label>
					<div class="field publication">
						<textarea class="txt" name="publication"><?=$this->view->publicinner['detail_text'];?></textarea>
					</div>
				</div>
				<div class="switched-content repost-only fixed-height">
					<label>Ссылка</label>
					<div class="field url">
						<input class="txt" name="RepostUrl" value="">
					</div>
				</div>
                <div class="groups-filter radios">
                    <div class="field"><label><input type="radio" name="groups-filter" value="1" <?=($this->view->publicinner['filtertype']<2)?" checked='checked'":"";?>> Для всех групп <b>(<span class="count allgroups-count"><?=$this->view->othergroups;?></span>)</b></label></div>
					<div class="field"><label><input type="radio" name="groups-filter" value="2" <?=($this->view->publicinner['filtertype']==2)?" checked='checked'":"";?>> Для избранных групп <b>(<span class="count favgroups-count"><?=tools::int($this->view->favnum);?></span>)</b></label></div>
					<div class="field"><label><input type="radio" name="groups-filter" value="3" <?=($this->view->publicinner['filtertype']==3)?" checked='checked'":"";?>> Для конкретных групп</label></div>
				</div>
				
				<div class="general-groups">
					<label>Темы групп</label>
					<div class="field topics field-frame switchboxes">
						<? foreach($this->view->subjects as $subject){?>
						<label><input type="checkbox" name="GroupTopics[]" value="<?=$subject['id'];?>"><?=$subject['name'];?> (<?=$subject['cnt'];?>)</label>
						<?}?>
					</div>

					<label>Страны, в которых проживают доминирующие количество пользователей выбранных групп</label>
					<div class="field countries field-frame switchboxes">
						<? foreach($this->view->countries as $country){?>
						<label><input type="checkbox" name="GroupСountries[]" value="<?=$country['id'];?>"><?=$country['name'];?> (<?=$country['cnt'];?>)</label>
						<?}?>
					</div>

					<label>Доминирующий пол в выбранных группах</label>
					<div class="field gender-filter field-frame radios">
						<div class="field gender-all"><label><input type="radio" name="gender-filter" value="0" checked>Все <b>(<span class="count"><?=$this->view->othergroups;?></span>)</b></label></div>
						<? if($this->view->gender['male']>0){?>
	                    <div class="field gender-male"><label><input type="radio" name="gender-filter" value="1">Больше мужчины <b>(<span class="count"><?=$this->view->gender['male'];?></span>)</b></label></div>
	                    <?} if($this->view->gender['female']>0){?>
	                    <div class="field gender-female"><label><input type="radio" name="gender-filter" value="2">Больше женщины <b>(<span class="count"><?=$this->view->gender['female'];?></span>)</b></label></div>
					    <?}?>
	                </div>

					<label>Средний возраст в группах</label>
					<div class="field-frame range-select">
						<div class="field age-range" data-min="<?=$this->view->agerange['agemin'];?>" data-max="<?=$this->view->agerange['agemax'];?>" data-units="лет">
							<div class="range">
							</div>
							<input class="value-bottom" type="hidden" name="" value="<?=$this->view->agerange['agemin'];?>">
							<input class="value-top" type="hidden" name="" value="<?=$this->view->agerange['agemax'];?>">
						</div>
					</div>
					<div class="switched-content publication-only">
						<label>Стоимость публикации</label>
						<div class="field-frame range-select">
							<div class="field price-range" data-min="<?=$this->view->pricerange['pricemin'];?>" data-max="<?=$this->view->pricerange['pricemax'];?>" data-units="<?=$this->view->currencyname;?>">
								<div class="range">
								</div>
								<input class="value-bottom" type="hidden" name="" value="<?=$this->view->pricerange['pricemin'];?>">
								<input class="value-top" type="hidden" name="" value="<?=$this->view->pricerange['pricemax'];?>">
							</div>
						</div>
					</div>

					<div class="switched-content repost-only">
						<label>Стоимость репоста</label>
						<div class="field-frame range-select">
							<div class="field repost-price-range" data-min="<?=$this->view->pricerange['pricemin'];?>" data-max="<?=$this->view->pricerange['pricemax'];?>" data-units="<?=$this->view->currencyname;?>">
								<div class="range">
								</div>
								<input class="value-bottom" type="hidden" name="" value="<?=$this->view->pricerange['pricemin'];?>">
								<input class="value-top" type="hidden" name="" value="<?=$this->view->pricerange['pricemax'];?>">
							</div>
						</div>
					</div>

					<label>Количество подписчиков в группе</label>
					<div class="field-frame range-select">
						<div class="field subscribers-range" data-min="<?=$this->view->statsrange['statsmin'];?>" data-max="<?=$this->view->statsrange['statsmax'];?>" data-units="чел.">
							<div class="range">
							</div>
							<input class="value-bottom" type="hidden" name="" value="<?=$this->view->statsrange['statsmin'];?>">
							<input class="value-top" type="hidden" name="" value="<?=$this->view->statsrange['statsmax'];?>">
						</div>
					</div>
				</div>

				<div class="special-groups">
					<div class="special-groups-list">
<? if($this->view->publicinner['filtertype']==3) {
    foreach($this->view->publicinner['sites'] as $group){?>
        <div class="item" data-id="<?=$group['groupid'];?>"><a class="link vk" href="#" target="_blank"><?=$group['name'];?></a><a class="remove"></a></div>
<?  }
}
?>
                        <?if($this->view->groupdata['id']>0){?>
                        <div class="item" data-id="<?=$this->view->groupdata['id'];?>"><a class="link vk" href="#" target="_blank"><?=$this->view->groupdata['name'];?></a><a class="remove"></a></div>
                        <?}?>
					</div>
					<div class="field special-group-field">
						<input class="txt special-group-input" name="specialGroup" value="">
					</div>
				</div>

				<div class="disclaimer">
					Нажимая кнопку "Разместить", вы принимаете наше <a href="/useragreement/">пользовательское соглашение</a><br><br>
                    Условия размещения: публикация размещается на 24 часа. Сообщение находится в топе первый час.<br>
                    Цена указана за один час на первом месте в ленте. Потом Ваша публикация спускается вниз по ленте в зависимости от появления новых постов. И держится 24 часа.
				</div>

				<div class="actions">
					<a class="button submit">Разместить</a>
				</div>
			</div>
			<div class="col4 last-col">
				<div class="switched-content publication-only">
					<div class="cover-field field">
						<label>Картинка:</label>
						<div class="cover-input-default cover-input">
							<span class="img">
                                <img src="<?=$this->view->publicinner['filethumb'];?>" alt="" />
                            </span>
							<span class="upload-link"><span><input name="image" id="upload-image" type="file" /></span><i class="i"></i></span>
							<span class="remove-link"><i class="i"></i></span>
							<i class="i-frame"></i>
						</div>
					</div>
				</div>
				<div class="switched-content repost-only fixed-height">
				</div>
				<div class="stats">
					<dl>
						<dt>Кол-во групп <a class="help" href="#help-0"></a></dt>
						<dd class="bignum groups-count"><?=$this->view->othergroups;?></dd>
						<dt>Общее число подписчиков <a class="help" href="#help-0"></a></dt>
						<dd class="bignum subscribers-count"><?=$this->view->statsrange['statstotal'];?></dd>
						<dt>Коэффициент<a class="help" href="#help-0"></a></dt>
						<dd class="bignum ratio">0.15</dd>
						<dt>Кол-во потенциальных контактов<a class="help" href="#help-0"></a></dt>
						<dd class="bignum potential-contacts-count">654</dd>
						<dt>Стоимость одного контакта (<?=$this->view->currencyname;?>)<a class="help" href="#help-0"></a></dt>
						<dd class="bignum contact-price"><?=round($this->view->pricerange['pricetotal']/$this->view->statsrange['statstotal'],4);?></dd>
						<dt>Макс. стоимость кампании (<?=$this->view->currencyname;?>)<a class="help" href="#help-0"></a></dt>
						<dd class="bignum max-campaign-cost<?=($this->view->pricerange['balance'] < $this->view->pricerange['pricetotal'] ? ' red' : '');?>"><?=$this->view->pricerange['pricetotal'];?></dd>
						<dt>Баланс (<?=$this->view->currencyname;?>)<a class="help" href="#help-0"></a></dt>
						<dd class="bignum balance"><?=$this->view->pricerange['balance'];?></dd>
					</dl>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>
<? if($this->view->filterdata){ ?>
<script>
	var publicData = <?=$this->view->filterdata;?>;
</script>
<? } ?>
