<div class="popup-request-inner">
    <h2>Заявка <span>е<?=$this->view->requestdata['id'];?></span> на проведение InDoor</h2>
    <h3 class="fl"><?=$this->view->requestdata['brand'];?></h3>
    <h3 class="fr"><?=tools::getDate($this->view->requestdata['date_start']);?></h3>
    <div class="description">
			<h3><?=$this->view->requestdata['name'];?></h3>
			<p><?=$this->view->requestdata['detail_text'];?></p>
    </div>
    <? if($this->view->requestdata['file_name']){?>
	<a class="download" target="_blank" href="<?=$this->view->requestdata['fileurl'];?>">Скачать материалы</a>
	<?}?>
</div>
