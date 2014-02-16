<div class="popup-report-inner">
  <h2>Отчет о размещении «Паблика»</h2>
  <form action="/admin/sendpublicreport/" method="post">
	  <?
      $cnt=0;
      foreach($this->view->requestdata as $report){?>
      <div class="field-link field icon">
	      <?=(!$cnt)?'<div class="label"><label>Ссылки на размещение</label></div>':'';?>
	      <div class="input-text"><div class="r"><div class="l">
              <input type="hidden" name="id[<?=$cnt;?>]" value="<?=$report['id'];?>">
              <input type="hidden" name="requestid[<?=$cnt;?>]" value="<?=$report['requestid'];?>">
              <input type="hidden" name="socialid[<?=$cnt;?>]" value="<?=$report['socialid'];?>">
              <input style="background-image:url(<?=$report['image'];?>);" name="link[<?=$cnt;?>]" value="<?=$report['link'];?>" type="text">
          </div></div></div>
	  </div>
      <?
      $cnt++;
      }?>
      <div class="button-set">
          <div class="button"><div class="r"><div class="l"><button type="submit">Отправить</button></div></div></div>
      </div>
  </form>
</div>