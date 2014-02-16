<h1><?=$this->registry->trans['notices'];?></h1>
<table class="notifications">
<tr>
  <th class="num">
    №
    <input name="url" value="/user/readmessage/" type="hidden" />
  </th>
  <th class="date"><?=$this->registry->trans['date'];?> / <?=$this->registry->trans['time'];?></th>
  <th class="message">
    <span class="title"><?=$this->registry->trans['message'];?></span>
    <span class="note">
    <?
	if($this->registry->langid==1){
	?>
	Кликните по сообщению, чтобы пометить его как &laquo;Прочитанное&raquo;
	<?}elseif($this->registry->langid==2){?>
	Click on the message to make it read.
	<?}?>
	<i class="i"></i></span>
  </th>
</tr>
<?
$cnt=count($this->view->messages);
foreach ($this->view->messages as $message) {
  if ($message['new']==1) {
      $new_class = ' class="new"';
  } else {
      $new_class = '';
  }
?>
<tr<?=$new_class;?>>
  <td class="num">
    <?=$cnt;?>
    <input name="id" value="<?=$message['id'];?>" type="hidden" />
  </td>
  <td class="date"><?=$message['date_create'];?></td>
  <td class="message"><?=$message['detail_text'];?></td>
</tr>
<?

$cnt--;
}
?>
</table>