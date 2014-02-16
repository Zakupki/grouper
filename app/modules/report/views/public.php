			<div class="centerwrap">
				<h1>Мои публикации</h1>
				<div class="widget publics<?=isset($_GET['create'])?' create':'';?>">
					<?
					if(count($this->view->publics)){
						$future=0;
						$past=0;
						foreach($this->view->publics['publics'] as $public){
						if(!$future && $public['future']){
							$future=1;
						?>
						<ul class="publics-list new">
						<?}
						if(!$past && !$public['future']){
							$past=1;
							if($future)
							echo '</ul>';
						?>
						<ul class="publics-list old">
						<?}?>
						
						<li class="public" rel="<?=$public['id'];?>" data-fileurl="<?=$public['fileurl'];?>">
							<a class="hl" href="/public/<?=$public['id'];?>/">
								<div class="head">
									<div class="id"><?=($public['publictypeid']==2)?'репост':'публикация';?> #<?=$public['id'];?></div>
									<div class="date"><?=tools::GetDate($public['date_start']);?>
										<? if($this->view->publics['newsites'][$public['id']]>0){?>
										<sup class="orange bubble">+<?=$this->view->publics['newsites'][$public['id']];?></sup>
										<?}?>
									</div>
								</div>
								<div class="stats">
									<div class="col desc">
										<div class="txt">
											<?=$public['detail_text'];?>
										</div>
									</div>
									<div class="col clubs">
										<h6>Охват</h6>
										<div class="value bignum"><?=$public['sites'];?></div>
									</div>
									<div class="col plan">
										<h6>План (грн.)</h6>										
										<div class="value bignum">0</div>
									</div>
									<div class="col contacts">
										<h6>Возможно контактов</h6>										
										<div class="value bignum">0</div>
									</div>
								</div>
							</a>
							<div class="overlay actions">
								<a class="ir edit<?=($past?' disabled':'')?>" href="/public/add/?id=<?=$public['id'];?>"></a>
								<a class="ir delete<?=($past?' disabled':'')?>" href="#"></a>
								<a class="ir open" href="/public/<?=$public['id'];?>/"></a>
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
