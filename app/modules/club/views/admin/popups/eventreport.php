<div class="popup-report-inner">
  <h2>Отправить предложение на InDoor</h2>
  <form action="/admin/sendeventreport/" method="post" enctype="multipart/form-data">
   		<? if($this->view->requestdata['id']){?>
		<input name="id" type="hidden" value="<?=$this->view->requestdata['id'];?>" >
		<?}?>
		<? if($this->view->requestdata['file_name']){?>
		<input name="fileurl" type="hidden" value="<?=$this->view->requestdata['file_name'];?>" >
		<?}?>
		<? if($this->view->requestdata['file_oldname']){?>
		<input name="filename" type="hidden" value="<?=$this->view->requestdata['file_oldname'];?>" >
		<?}?>
	  <div class="field-message field">
	      <div class="label"><label>Описание</label></div>
	      <div class="textarea">
	          <textarea name="report"><?=$this->view->requestdata['report'];?></textarea>
	          <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
	      </div>
	  </div>

	  <div class="button-set">
	      <div class="upload widget">
	          <input type="file" name="file" class="file-input">
	          <div class="button button-attach"><div class="r"><div class="l">
	              <div style="overflow: hidden; width:35px; height:35px; margin:0 -20px 0 0; background:url('/img/club/icons/icon-attach-file.png') no-repeat center center;">
	              </div>
	          </div></div></div>
	          <span class="filename"></span>
	      </div>

	      <div class="button button-submit"><div class="r"><div class="l"><button type="submit">Отправить</button></div></div></div>
	  </div>


  </form>
</div>
