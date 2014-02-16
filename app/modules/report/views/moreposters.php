<? foreach($this->view->events['events'] as $event){ ?>
			<li class="poster<?=($event['posterid']!=$event['posterchangeid'] && $event['posterchangeid']>0)?' new':''?><?=$event['approve']==1?' approved':''?><?=(!$this->view->events['hasmore'])?' last':'';?>" rel="<?=$event['id'];?>" data-posterid="<?=$event['posterid'];?>">
			 	<a class="img" href="<?=$event['posterbig'];?>" rel="gallery">
					<img src="<?=$event['poster'];?>" width="220" height="310">
				</a>
				<div class="overlay actions">
					<a class="ir edit"></a>
					<a class="ir approve"></a>
				</div>
				<div class="data">
					<div class="contact"><?=$event['email']?></div>
					<div class="subject">Правка постера: <?=$event['name']?></div>
				</div>
			</li>
<?}?>
