<div class="centerwrap">
  
  <h1>Пополнение кошелька</h1>
  
  <div class="html">
    <p>Вы действительно хотите пополнить ваш счет на <strong><?=$_POST['sum'];?></strong> UAH?</p>
  </div>

  <div class="deposit cols">

    <div class="col">

      <ul class="systems">
        <li><i class="i-liqpay"></i></li>
        <li><i class="i-visa"></i></li>
        <li class="last"><i class="i-mastercard"></i></li>
      </ul>

    </div>

    <div class="col">
      <form name="payment" id="inerkassa_form" action="http://www.interkassa.com/lib/payment.php" method="post" target="_top" enctype="application/x-www-form-urlencoded" accept-charset="cp1251">
          <fieldset>
          <input type="hidden" name="ik_shop_id" value="41DF4447-0FDB-344C-16B8-6DAB1F5CD7D9">
          <input type="hidden" name="ik_payment_amount" value="<?=$_POST['sum'];?>">
          <input type="hidden" name="ik_payment_id" value="<?=$this->view->oper_id;?>">
          <input type="hidden" name="ik_payment_desc" value="Заказ №<?=$this->view->oper_id;?>">
          <input type="hidden" name="ik_paysystem_alias" value="">
          <input type="hidden" name="ik_baggage_fields" value="tel: 0931520242">

           <div class="field confirm">
              <div class="label"><label for="deposit-sum">Сумма в UAH</label></div>
              <div class="wrap">
                <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input"><?=$_POST['sum'];?></span></div></div></div>
                <div class="button"><div class="r"><div class="l"><button type="submit" name="process" >Пополнить</button></div></div></div>
              </div>
            </div>
          </fieldset>
      </form>
      
    </div>

  </div>
</div>
