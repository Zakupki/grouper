<div class="centerwrap">
	<h1>История операций</h1>
	<div class="transactions widget clearfix" data-perpage="<?=$this->view->take?>">

		<div class="col12">

			<div class="transactions-filter">
				<select name="type">
					<option value="0">Все операции</option>
					<? foreach($this->view->operationtypes as $type){?>
					<option value="<?=$type['id'];?>"><?=$type['name'];?></option>
					<?}?>
				</select>
			</div>

			<div class="transactions-list">

				<div class="head clearfix">
					<div class="c type"></div>
					<div class="c date"></div>
					<div class="c description"></div>
					<div class="c amount"><span class="txt">Сумма<br>операции (<?=$this->view->currencyname;?>)</span></div>
					<div class="c balance"><span class="txt">Остаток (<?=$this->view->currencyname;?>)</span></div>
				</div>
		 		<?=$this->view->operationlist;?>
        </div>

			<div class="list-actions">
				<a class="button more" href="#"><?=$this->registry->trans['loadmore'];?></a>
			</div>

		</div>

		<div class="col4 last-col">
			<div class="balance-status">
				<dl>
					<dt>В вашем кошельке</dt>
					<dd class="bignum"><?=$this->view->balance+$this->view->reserved;?> <span class="currency"><?=$this->view->currencyname;?></span></dd>
					<dt>Доступно для снятия<a class="help" href="#help-0"></a></dt>
					<dd class="bignum"><?=$this->view->balance;?> <span class="currency"><?=$this->view->currencyname;?></span></dd>
					<dt>Забронировано<a class="help" href="#help-0"></a></dt>
					<dd class="bignum"><?=$this->view->reserved;?> <span class="currency"><?=$this->view->currencyname;?></span></dd>
				</dl>
				<div class="actions clearfix">
					<a class="button" href="/user/deposit/">Пополнить</a>
					<a class="button" href="#">Снять</a>
				</div>
			</div>
		</div>

	</div>
</div>
