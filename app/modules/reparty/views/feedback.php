<h1>Обратная связь</h1>

<div class="feedback-form">
  <form action="/user/sendfeedback/" method="post" enctype="multipart/form-data">

    <div class="left">

      <div class="field-email field">
        <div class="label"><label for="feedback-form-email">Ваш E-mail</label></div>
        <div class="input-text"><div class="r"><div class="l"><input name="email" id="feedback-form-email" type="text" value="<?=$_SESSION['User']['email'];?>" class="email required" /></div></div></div>
      </div>

      <div class="field-subject field">
        <div class="select">
          <div class="label"><label for="feedback-form-subject">Тема</label></div>
          <select name="subject" id="feedback-form-subject">
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
          <!--<div class="li" id="feedback-form-subject-note1" style="display: block;">
            <p>В случае обнаружения Вами каких-то ошибок, убедительная просьба указывать название и версию Вашего броузера. А за print-screen отдельное спасибо.</p>
          </div>
          <div class="li" id="feedback-form-subject-note2">
            <p>Примечание касающееся пункта 2</p>
          </div>-->
        </div>
      </div>  

    </div>
    
    <div class="right">

      <div class="field-message field">

        <div class="label"><label for="feedback-form-message">Сообщение</label></div>

        <div class="textarea">
          <textarea name="message" id="feedback-form-message" cols="" rows="" class="required"></textarea>
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
        <div class="button"><div class="r"><div class="l"><button type="submit">Отправить</button></div></div></div>
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