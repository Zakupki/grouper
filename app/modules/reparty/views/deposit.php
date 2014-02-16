<h1>Пополнение кошелька</h1>

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
          <div class="input-text"><div class="r"><div class="l"><input name="sum" id="deposit-sum" type="text" class="digits required" /></div></div></div>
          <div class="button"><div class="r"><div class="l"><button type="submit">Пополнить</button></div></div></div>
        </div>
      </div>
    </form>

  </div>

  <div class="br"></div>

  <div class="col">
    <div class="text">
      <p><label for="deposit-code">Вы можете активировать секретный код, который даст Вам скидку<br />на все наши услуги.</label></p>
    </div>
  </div>

  <div class="col">

    <form action="/cabinet/activatediscount/" method="post" class="code-form">
      <div class="field">
        <div class="label"><label for="deposit-code">Секретный код</label></div>
        <div class="wrap">
          <div class="input-text"><div class="r"><div class="l"><input name="code" id="deposit-code" type="text" class="required" /></div></div></div>
          <div class="button"><div class="r"><div class="l"><button type="submit">Активировать</button></div></div></div>
          <div class="discount">Cкидка <span>99%</span></div>
        </div>
      </div>
    </form>

  </div>

</div>