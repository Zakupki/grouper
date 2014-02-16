<div class="centerwrap">
  <h1>Пополнить</h1>

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
          <div class="label"><label for="deposit-sum">Сумма в UAH</label></div>
          <div class="wrap">
            <input name="sum" id="deposit-sum" type="text" class="digits required txt" />
            <a class="button submit">Пополнить</a>
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
          <div class="label"><label for="deposit-code">Секретный код</label></div>
          <div class="wrap">
            <input name="code" id="deposit-code" type="text" class="txt required" />
            <a class="button submit">Активировать</a>
            <div class="discount">Cкидка <span>99%</span></div>
          </div>
        </div>
      </form>

    </div>

  </div>
</div>