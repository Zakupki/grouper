			<div class="centerwrap">
				<h1>InDoors</h1>
				<div class="widget events">
					<?
					if(count($this->view->events['events'])){
						$future=0;
						$past=0;
						foreach($this->view->events['events'] as $event){
						if(!$future && $event['future']){
							$future=1;
						?>
						<ul class="events-list new">
						<?}
						if(!$past && !$event['future']){
							$past=1;
							if($future)
							echo '</ul>';
						?>
						<ul class="events-list old">
						<?}?>
						<li class="event" rel="<?=$event['id'];?>" data-fileurl="<?=$event['fileurl'];?>">
							<a class="hl" href="/event/<?=$event['id'];?>/">
								<div class="head">
									<div class="id">e<?=$event['id'];?></div>
									<div class="date"><?=tools::GetDate($event['date_start']);?>
										<? if($this->view->events['newsites'][$event['id']]>0){?>
										<sup class="orange bubble">+<?=$this->view->events['newsites'][$event['id']];?></sup>
										<?}?>
									</div>
								</div>
								<div class="stats">
									<div class="col desc">
										<h5 class="title"><?=$event['name'];?></h5>
										<div class="txt">
											<?=$event['detail_text'];?>
										</div>
									</div>
									<div class="col clubs">
										<h6>Заведения</h6>
										<div class="value bignum"><?=$event['sites'];?></div>
									</div>
									<div class="col offers">
										<h6>Заявок</h6>										
										<div class="value bignum"><?=$event['sitesrequested'];?></div>
									</div>
								</div>
							</a>
							
							<div class="overlay actions">
								<a class="ir edit<?=($past?' disabled':'')?>" href="#"></a>
								<a class="ir delete" href="#"></a>
								<a class="ir open" href="/event/<?=$event['id'];?>/"></a>
							</div>
							
						</li>
						<?}?>
					</ul>
					<?}?>
					
					<!--<div class="list-actions">
						<a class="button more" href="#">Загрузить еще</a>
					</div>-->
				</div>
			</div>
