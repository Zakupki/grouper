qwe
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

      <form action="<?=$this->view->liqurl;?>" method="post">
        <input type='hidden' name='operation_xml' value='<?=$this->view->xml_encoded;?>' />
    	  <input type='hidden' name='signature' value='<?=$this->view->lqsignature;?>' />
        <div class="field">
          <div class="label"><label for="deposit-sum">Сумма в UAH</label></div>
          <div class="wrap">
            <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input"><?=$_POST['sum'];?></span></div></div></div>
            <a class="button submit">Пополнить</a>
          </div>
        </div>
      </form>
      
    </div>

  </div>
</div>
