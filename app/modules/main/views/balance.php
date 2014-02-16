    <h1><?=$this->registry->trans['mybalance'];?></h1>

    <div class="balance">

      <div class="content">
        <h2><?=$this->registry->trans['onaccount'];?></h2>
        <div class="sum"><?=$this->view->total;?> <?=$_SESSION['User']['currencylocal'];?></div>
      </div>

      <div class="teaser">
        <a href="/cabinet/deposit/"><span class="title"><?=$this->registry->trans['topupaccount'];?></span>
	        <span class="text">Никакие платежи не сгорают со временем, всё происходит ровно так, как вы предполагаете.</span>
	        <i class="i-balance"></i>
	        <i class="act"></i>
    		</a>
      </div>

    </div>

    <div class="operations">

      <h2><?=$this->registry->trans['operations_history'];?></h2>

      <table>
      <tr>
        <th class="num">№</th>
        <th class="date"><?=$this->registry->trans['date'];?> / <?=$this->registry->trans['time'];?></th>
        <th class="descr"><?=$this->registry->trans['description'];?></th>
        <th class="sum"><?=$this->registry->trans['summ'];?></th>
		<th class="sum"><?=$this->registry->trans['status'];?></th>
      </tr>
	 
	  <?foreach($this->view->operations as $operation){
	  if($operation['value']>0)
	  $class='in';
	  elseif($operation['value']<1)
	  $class='out';
	  ?>
	  <tr class="<?=$class;?>">
        <td class="num"><?=$operation['id'];?></td>
        <td class="date"><?=tools::GetDate($operation['date_create'],$this->registry->langid);?> / <?=tools::GetTime($operation['date_create']);?></td>
        <td class="descr"><?=$operation['name'];?></td>
        <td class="sum"><?=$operation['value'];?></td>
		<td class="sum"><?=$operation['status'];?></td>
      </tr>
	  <?}?>
      <tr class="total">
        <td class="blank"></td>
        <td class="blank"></td>
		<td class="descr"></td>
       <!--<td class="descr"><a href="#">Снять деньги со счета</a></td>-->
        <td class="sum"><?=$this->view->total;?> <?=$_SESSION['User']['currencylocal'];?></td>
      </tr>
      </table>

    </div>

    <!--<ul class="archive-links">
      <li><a href="#">Архив истории операций за 2010 г.</a></li>
      <li><a href="#">Архив истории операций за 2009 г.</a></li>
    </ul>-->