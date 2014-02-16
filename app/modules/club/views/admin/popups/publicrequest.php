<div class="popup-request-inner">
    <h2>Заявка <span>p<?=$this->view->requestdata['id'];?></span> на размещение «Паблика»</h2>
    <h3 class="fl"><?=$this->view->requestdata['brand'];?></h3>
    <h3 class="fr"><?=tools::getDate($this->view->requestdata['date_start']);?></h3>
		<div class="description">
			<p><?=$this->view->requestdata['detail_text'];?></p>
		</div>
    <? if($this->view->requestdata['file_name']){?>
    <a class="download" target="_blank" href="<?=$this->view->requestdata['fileurl'];?>">Скачать материалы</a>
    <?}?>
</div>
