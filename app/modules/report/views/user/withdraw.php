<div class="centerwrap clearfix">
	<h1>Вывод денег</h1>
	<div class="withdraw">
	<form action="/user/updatewithdraw" method="post">
		<div class="col8">
<? if(false){ ?>

 			<div class="field select-payment-system radios">
                <? foreach($this->view->paytype as $k=>$pt){?>
                    <label><input type="radio" name="paytypeid"<?=(!$k)?' checked="checked"':'';?> value="<?=$pt['id'];?>"><img src="/img/report/<?=$pt['image'];?>" alt="<?=$pt['title'];?>"></label>
                <?}?>
			</div>
<? } ?>
            <label>Номер кошелька/карты</label>
            <div class="field wallet-number bold-numbers">
				<!--<label class="label-1">Номер кошелька</label>
				<label class="label-2">Номер карты</label>-->
				<input class="txt" type="text" name="account" value="">
			</div>


			<label>Фамилия</label>
			<div class="field last-name">
				<input class="txt" type="text" name="name" value="">
			</div>

			<label>Имя</label>
			<div class="field first-name">
				<input class="txt" type="text" name="firstname" value="">
			</div>

			<label>Cумма</label>
			<div class="field sum bold-numbers">
				<input class="txt" type="text" name="value" value="">
			</div>

			<label>Комментарий</label>
			<div class="field comments">
				<textarea class="txt" type="text" name="comments"></textarea>
			</div>

			<!--<div class="disclaimer">Нажимая кнопку "Разместить заказ", вы соглашаетесь с Facebook Statement of Rights and Responsibilities, включая ваше обязательство выполнять требования Facebook Advertising Guidelines. Мы не используем конфиденциальные личные данные для выборы целевой аудитории реклам. Темы, которые вы выбираете для направленности своей рекламы, не отражают вероисповедание, личные качества или достоинства пользователей. Несоблюдение Условий использования и требований Руководства по рекламе может повлечь различные последствия, включая отмену любых размещенных вами рекламных объявлений и отключение вашего аккаунта. Вы понимаете, что если вы проживаете в США или Канаде, или основная активность вашей компании проходит там, вы заключаете договор с Facebook, Inc. В других случаях вы заключаете договор с Facebook Ireland, Ltd</div>-->

			<div class="field i-agree">
				<label><input type="checkbox" name="" value="1"> Я ознакомился с условиями</label>
			</div>

			<div class="actions">
				<a class="button submit">Вывести</a>
			</div>

		</div>
		<div class="col4 placeholder-col"></div>
		<div class="col4 last-col">
			<div class="stats balance-status">
				<dl>
                    <dt>В вашем кошельке</dt>
                    <dd class="bignum"><?=$this->view->balance+$this->view->reserved;?> <span class="currency"><?=$this->view->currencyname;?></span></dd>
                    <dt>Доступно для снятия<a class="help" href="#help-0"></a></dt>
                    <dd class="bignum available"><span class="value"><?=$this->view->balance;?></span> <span class="currency"><?=$this->view->currencyname;?></span></dd>
                    <dt>Забронировано<a class="help" href="#help-0"></a></dt>
                    <dd class="bignum"><?=$this->view->reserved;?> <span class="currency"><?=$this->view->currencyname;?></span></dd>
				</dl>
			</div>
		</div>	
	</form>
	</div>
</div>