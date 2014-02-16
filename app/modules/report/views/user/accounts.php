<div class="centerwrap account-content">
	<h1>Мои социальные сети</h1>
	<h3>Добавить аккаунты</h3>
	<div class="add-accounts">
		<a class="add-account-vk" href="/social/vkconnect/">Добавить аккаунт<br><b>Vkontakte</b></a>
		<!--<a class="add-account-facebook" href="/social/fbconnect/">Добавить аккаунт<br><b>Facebook</b></a>-->
	</div>
	<h3>Мои аккаунты</h3>
	<ul class="accounts-list">
	<? foreach($this->view->accounts as $account){?>
	<li data-id="<?=$account['id'];?>"><a class="account-link <?=($account['socialid']==255?'facebook':'vk');?>" href="#"><?=$account['name'];?> <?=$account['last_name'];?></a><a class="remove"></a></li>
	<?}?>
	</ul>
</div>
