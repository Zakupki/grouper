<h1><?=$this->registry->trans['support'];?></h1>

<div class="support-form">
  <form action="/cabinet/sendsupport/" method="post" enctype="multipart/form-data">

    <div class="left">

      <div class="field-subject field">
        <div class="select">
          <div class="label">
            <label for="support-form-subject"><?=$this->registry->trans['subject'];?></label>
          </div>
          <select name="subject" id="support-form-subject">
          <?
          if(is_array($this->view->supporttype)) {
            foreach($this->view->supporttype as $type) {
          ?>
            <option value="<?=$type['id'];?>"><?=$type['name'];?></option>
          <?
            }
          }
          ?>
          </select>
        </div>
          
        <div class="notes">
          <div class="li" style="display: block;">
            <p>В случае обнаружения Вами каких-то ошибок, убедительная просьба указывать название и версию Вашего броузера. А за print-screen отдельное спасибо.</p>
          </div>
          <!--<div class="li" id="support-form-subject-note2">
            <p>Примечание касающееся пункта 2</p>
          </div>-->
        </div>
      </div>  

    </div>
    
    <div class="right">

      <div class="field-message field">

        <div class="label">
          <label for="support-form-message"><?=$this->registry->trans['message'];?></label>
        </div>

        <div class="textarea">
          <textarea name="message" id="support-form-message" cols="" rows="" class="required"></textarea>
          <!--<div class="input-file">
            <div class="pick">
              <div class="browse-link"><i class="i"></i></div>
              <div class="title">Прикрепить файл (до 1 МБ) <a href="/_help.php" target="_blank" class="help-link"><img src="/img/reactor/px.gif" alt="" /></a></div>
              <div class="input"><input name="attach" type="file" /></div>
            </div>
            <div class="hidden info">
              <div class="name"></div>
              <div class="clear-link"><i class="i"></i></div>
            </div>
          </div>-->
          <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
        </div>

      </div>

      <div class="submit">
        <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['send'];?></button></div></div></div>
      </div>

    </div>

  </form>
</div>


<div class="hotline">
  <div class="hr"><div class="l"></div></div>
  <!--<ul>
    <li>reactorpro<i class="i-skype"></i></li>
    <li class="last">+<noscript></noscript>38 044 3445456<i class="i-phone"></i></li>
  </ul>-->
</div>


<div class="support-requests">
  <h2><?=$this->registry->trans['myrequests'];?></h2>

  <table>
  <tr>
    <th class="num">№</th>
    <th class="date"><?=$this->registry->trans['date'];?> / <?=$this->registry->trans['time'];?></th>
    <th class="qa"><?=$this->registry->trans['question'];?> / <?=$this->registry->trans['answer'];?></th>
  </tr>
  <?
  if (is_array($this->view->questions)) {
    foreach($this->view->questions as $question) {
  ?>
    <tr<?=($question['new']==1)?' class="answered"':'';?>>
      <td class="num"><?=$question['id'];?></td>
      <td class="date"><?=$question['date_create'];?></td>
      <td class="qa">
        <div class="text-wrap">
          <div class="text">
            <div class="question">
              <p><?=($question['status']>1)?'<span class="notice">Есть ответ!</span> ':'';?><span class="kind"><?=$question['supporttype'];?></span> <?=$question['question'];?></p>
            </div>
            <? if(strlen($question['answer'])>0 && $question['status']>1) { ?>
            <div class="answer">
              <p><em><?=$question['answer'];?></em></p>
            </div>
            <? } ?>
          </div>
        </div>
        <div class="arr"></div>
      </td>
    </tr>
  <?
    }
  }
  ?>
  </table>
</div>