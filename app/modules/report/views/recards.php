			<div class="centerwrap">
				<h1>ReCard</h1>
				<div class="widget recards">
					
					<?
					if(count($this->view->recards['recards'])){
						$future=0;
						$past=0;
						foreach($this->view->recards['recards'] as $recard){
						if(!$future && $recard['future']){
							$future=1;
						?>
						<ul class="recards-list new">
						<?}
						if(!$past && !$recard['future']){
							$past=1;
							if($future)
							echo '</ul>';
						?>
						<ul class="recards-list old">
						<?}?>
						<li class="recard" rel="<?=$recard['id'];?>">
							<a class="hl" href="/recards/<?=$recard['id'];?>/">
								<div class="head">
									<div class="id">r<?=$recard['id'];?></div>
									<div class="date"><?=tools::GetDate($recard['date_start'], $this->registry->langid);?> 
										<? if($this->view->recards['newsites'][$recard['id']]>0){?>
										<sup class="orange bubble">+<?=$this->view->recards['newsites'][$recard['id']];?></sup>
										<?}?>
									</div>
								</div>
								<div class="stats">
									<div class="col desc">
										<h5 class="title"><?=$recard['name'];?></h5>
										<div class="txt">
											<?=$recard['detail_text'];?>
										</div>
									</div>
									<div class="col clubs">
										<h6><?=$this->registry->trans['clubs'];?></h6>
										<div class="value bignum"><?=$recard['sites'];?></div>
									</div>
									<div class="col reports">
										<h6><?=$this->registry->trans['reports'];?></h6>										
										<div class="value bignum">0</div>
									</div>
								</div>
							</a>
							<div class="overlay actions">
								<a class="ir edit<?=($recard['future'])?'':' disabled';?>" href="#"></a>
								<a class="ir delete<?=($recard['future'])?'':' disabled';?>" href="#"></a>
								<a class="ir open" href="/recards/<?=$recard['id'];?>/"></a>
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
