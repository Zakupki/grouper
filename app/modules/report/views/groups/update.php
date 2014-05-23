<div class="centerwrap clearfix">
	<h1>Редактировать группу</h1>
	<div class="groups-update" data-remoteimage="<?=$this->view->groupdata->remote;?>">
		<form action="/groups/update" method="post">
			<div class="col8">
				<input type="hidden" name="gid" value="<?=$this->view->groupdata->gid;?>"/>
				<input type="hidden" name="id" value="<?=$this->view->groupdata->id;?>"/>
				<input type="hidden" name="code" value="<?=$this->view->groupdata->screen_name;?>"/>
				<input type="hidden" name="type" value="<?=$this->view->groupdata->type;?>"/>
                <input type="hidden" name="accountid" value="<?=$this->view->groupdata->accountid;?>"/>
				<input type="hidden" name="socialid" value="<?=$this->view->groupdata->socialid;?>"/>
				<div class="field">
					<label for="group-url-input">URL:</label>
                    <? if($this->view->groupdata->code)
                        $this->view->groupdata->screen_name=$this->view->groupdata->code;
                    ?>  
					<input id="group-url-input" type="text" name="url" class="txt" value="<?=$this->view->groupdata->url;?>" disabled>
				</div>
				<div class="field">
					<label for="group-name-input">Название:</label>
					<input id="group-name-input" type="text" name="name" class="txt" value="<?=$this->view->groupdata->name;?>">
				</div>
                <div class="field">
                    <label for="group-name-input">Админ группы:</label>
                    <input id="group-name-input" type="text" name="adminname" class="txt" value="<?=$this->view->groupdata->adminname;?>">
                </div>
                <div class="field">
                    <label for="group-name-input">Контакты админа:</label>
                    <input id="group-name-input" type="text" name="admincontact" class="txt" value="<?=$this->view->groupdata->admincontact?>">
                </div>
                <div class="clearfix">
					<div class="field col4">
						<label>Тематика группы:</label>
						<select name="groupsubjectid">
							<? foreach($this->view->grouptypes as $gtype){?>
							<option<?=($this->view->groupdata->groupsubjectid==$gtype['id'])?' selected="selected"':'';?> value="<?=$gtype['id'];?>"><?=$gtype['name'];?></option>
							<?}?>
						</select>
					</div>
					<div class="field col4 last-col">
						<label>Большинство пользователей из</label>
						<select name="countryid">
							<? foreach($this->view->countrylist as $country){?>
							<option<?=($this->view->groupdata->countryid==$country['id'] || $country['name_en']==$this->view->groupdata->location->country)?' selected="selected"':'';?> value="<?=$country['id'];?>"><?=$country['name'];?></option>
							<?}?>
						</select>
						<!--<input type="hidden" name="countryid" value="<?=$country['id'];?>">-->
					</div>
				</div>
                <div class="radios clearfix">
					<div class="field col4">
						<input type="radio" name="gender" value="1" id="radio-gender-1">
						<label for="radio-gender-1">В этой группе больше мужчин</label>
					</div>
					<div class="field col4 last-col">
						<input type="radio" name="gender" value="0" id="radio-gender-2">
						<label for="radio-gender-2">В этой группе больше женщин</label>
					</div>
                    <?if($this->view->groupdata->socialid==1257){?>
					<!--<input type="hidden" name="gender" value="<?=$this->view->groupdata->gender;?>">-->
                    <?}?>
				</div>
				<div class="number-inputs clearfix">
					<div class="field col2">
						<label for="group-age-input">Средний возраст:</label>
						<input id="group-age-input" type="text" name="age" class="txt short" value="<?=$this->view->groupdata->age;?>" <?=($this->view->groupdata->socialid==1257)?' disabled':'';?>>
						<?if($this->view->groupdata->socialid==1257){?>
                        <!--<input type="hidden" name="age" value="<?=$this->view->groupdata->age;?>">-->
                        <?}?>
					</div>
					<div class="field col3">
						<label for="group-price-input">Цена за пост (<?=$this->view->currencyname;?>):</label>
						<input id="group-price-input" type="text" name="price" class="txt short" value="<?=($this->view->groupdata->price)?$this->view->groupdata->price:ceil($this->view->membernum*$this->view->postprice+$this->view->postpriceadd*$this->view->currencyprice);?>">
					</div>
					<div class="field col3 last-col">
						<label for="group-repost-price-input">Цена за перепост (<?=$this->view->currencyname;?>):</label>
						<input id="group-repost-price-input" type="text" name="pricerepost" class="txt short" value="<?=($this->view->groupdata->pricerepost)?$this->view->groupdata->pricerepost:ceil(($this->view->membernum*$this->view->postprice+$this->view->postpriceadd)*0.9*$this->view->currencyprice);?>">
					</div>
				</div>
                <div class="field">
                    <label for="group-name-input">Условие размещение поста:</label>
                    <textarea name="postdetails"><?=$this->view->groupdata->postdetails?></textarea>

                </div>
				<!--<div class="field checkbox"> 
					<input type="checkbox" name="legal" value="1" id="checkbox-legal">
					<label for="checkbox-legal">Данная группа не содержит сисек, писек, призыва к насилию т.д.</label>
				</div>-->

				<div class="disclaimer">
				    Нажимая кнопку "Сохранить", вы подтверждаете, что являетесь владельцем группы, которую размещаете в качестве рекламной площадки. Также вы обязуетесь следовать правилам Сервиса, указанным в Пользовательском Соглашении и согласны с  санкциями, которые могут быть приняты в случае их несоблюдения.
				</div>

				<div class="actions">
					<a class="button submit">Сохранить</a>
				</div>
			</div>
			<div class="col4">
				<div class="cover-field field">
					<label>Аватарка:</label>
					<div class="cover-input-default cover-input">
						<span class="img"><img src="<?=$this->view->groupdata->photo_big;?>" alt="" /></span>
						<span class="upload-link"><span><input name="image" id="upload-image" type="file" /></span><i class="i"></i></span>
						<span class="remove-link"><i class="i"></i></span>
						<i class="i-frame"></i>
					</div>
				</div>
			</div>
			<div class="col4 last-col">
				<div class="stats">
					<dl>
                        <? $likenum=($this->view->groupdata->socialid==257)?$this->view->membernum:$this->view->groupdata->likes;?>
						<? if($likenum>0){?>
                        <dt>Число подписчиков данной группы</dt>
						<dd class="bignum"><?=$likenum;?></dd>
                        <?}?>
						<dt>Рекомендуемая цена за публикацию<a class="help" href="#help-45"></a></dt>
						<dd class="bignum"><?=ceil($this->view->membernum*$this->view->postprice+$this->view->postpriceadd*$this->view->currencyprice);?> <span class="units"><?=$this->view->currencyname;?></span></dd>
						<dt>Рекомендуемая цена за репост<a class="help" href="#help-46"></a></dt>
						<dd class="bignum"><?=ceil(($this->view->membernum*$this->view->postprice+$this->view->postpriceadd)*0.9*$this->view->currencyprice);?> <span class="units"><?=$this->view->currencyname;?></span></dd>
						<dt>Комиссия сервиса<a class="help" href="#help-44"></a></dt>
						<dd class="bignum"><?=$this->view->comission;?> <span class="units">%</span></dd>
					</dl>
				</div>
			</div>
		</form>
	</div>
</div>