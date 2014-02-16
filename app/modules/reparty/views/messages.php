<h1>Уведомления</h1>
<table class="notifications">
<tr>
  <th class="num">
    №
    <input name="url" value="/user/readmessage/" type="hidden" />
  </th>
  <th class="date">Дата / время</th>
  <th class="message">
    <span class="title">Сообщение</span>
    <span class="note">Кликните по сообщению, чтобы пометить его как &laquo;Прочитанное&raquo;<i class="i"></i></span>
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