<div class="popup-report-inner">
	<h2>Отчет о размещении «Паблика»</h2>
	<form action="/user/sendpublicreport/" method="post">
		<?
			$cnt=0;
			foreach($this->view->requestdata as $report){?>
			<div class="field-link field icon">
				<?=(!$cnt)?'<div class="label"><label>Ссылки на размещение</label></div>':'';?>
				<input type="hidden" name="id[<?=$cnt;?>]" value="<?=$report['id'];?>">
				<input type="hidden" name="requestid[<?=$cnt;?>]" value="<?=$report['requestid'];?>">
				<input type="hidden" name="socialid[<?=$cnt;?>]" value="<?=$report['socialid'];?>">
				<input class="txt with-icon" style="background-image:url(<?=$report['image'];?>);" name="link[<?=$cnt;?>]" value="<?=$report['link'];?>" type="text">
		</div>
			<?
			$cnt++;
			}?>
			<div class="actions">
					<a class="button submit">Отправить</a>
			</div>
	</form>
</div>