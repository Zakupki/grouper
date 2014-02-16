<div class="popup-request-inner">
    <h2>Заявка <span>b<?=$this->view->requestdata['id'];?></span> на размещение баннера</h2>
    <h3 class="fl"><?=$this->view->requestdata['brand'];?></h3>
    <h3 class="fr"><?=tools::getDate($this->view->requestdata['date_start']);?> - <?=tools::getDate($this->view->requestdata['date_end']);?> </h3>
		<div class="description">
            <?
            if(strlen(trim($this->view->requestdata['link']))>0){
                $prottype='http://';
                if(strstr($this->view->requestdata['link'],'https://')){
                    $prottype='https://';
                    $this->view->requestdata['link']=str_replace('https://', '', $this->view->requestdata['link']);
                }
                elseif(strstr($this->view->requestdata['link'],'http://')){
                    $this->view->requestdata['link']=str_replace('http://', '', $this->view->requestdata['link']);
                    $prottype='http://';
                }
            }
            ?>
			<p><a target="_blank" href="<?=$prottype;?><?=$this->view->requestdata['link'];?>"><img src="<?=$this->view->requestdata['url'];?>"/></a></p>
		</div>
    <!--<a class="download" href="#">Скачать баннер</a>-->
</div>
