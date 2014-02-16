<h1><?=$this->registry->trans['top_up'];?></h1>

<div class="deposit cols">

  <div class="col">

    <ul class="systems">
      <li><i class="i-liqpay"></i></li>
      <li><i class="i-visa"></i></li>
      <li class="last"><i class="i-mastercard"></i></li>
    </ul>

  </div>

  <div class="col">

    <form action="/cabinet/clicknbuy/" method="post" class="buy-form">
      <div class="field">
        <div class="label"><label for="deposit-sum"><?=$this->registry->trans['summ'];?> <?=$this->registry->trans['in'];?> UAH</label></div>
        <div class="wrap">
          <div class="input-text"><div class="r"><div class="l"><input name="sum" id="deposit-sum" type="text" class="digits required" /></div></div></div>
          <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['top_up'];?></button></div></div></div>
        </div>
      </div>
    </form>

  </div>

  <div class="br"></div>

  <div class="col">
    <div class="text">
      <p><label for="deposit-code">
      	<?
		if($this->registry->langid==1){
		?>
		Вы можете активировать секретный код, который даст Вам скидку<br />на все наши услуги.
		<?}elseif($this->registry->langid==2){?>
		You can activate secret code that will give you a discount<br />for all our services.
		<?}?>
		</label></p>
    </div>
  </div>

  <div class="col">

    <form action="/cabinet/activatediscount/" method="post" class="code-form">
      <div class="field">
        <div class="label"><label for="deposit-code"><?=$this->registry->trans['secretcode'];?></label></div>
        <div class="wrap">
          <div class="input-text"><div class="r"><div class="l"><input name="code" id="deposit-code" type="text" class="required" /></div></div></div>
          <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['activate'];?></button></div></div></div>
          <div class="discount">Cкидка <span>99%</span></div>
        </div>
      </div>
    </form>

  </div>

</div>