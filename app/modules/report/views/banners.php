			<div class="centerwrap">
				<h1>Баннер</h1>
				<div class="widget banners">
						<?
						$future=0;
						$past=0;
						foreach($this->view->bannerlist['banners'] as $banner){
						if(!$future && $banner['future']){
							$future=1;
						?>
						<ul class="banners-list new">
						<?}
						if(!$past && !$banner['future']){
							$past=1;
							if($future)
							echo '</ul>';
						?>
						<ul class="banners-list old">
						<?}?>
						<li class="banner" rel="<?=$banner['id'];?>" data-fileurl="<?=$banner['fileurl'];?>">
							<a class="hl" href="/banner/<?=$banner['id'];?>/">
								<div class="img"><img src="<?=$banner['url'];?>" /></div>
								<div class="head">
									<div class="id">b<?=$banner['id'];?></div>
									<div class="date"><?=tools::getDate($banner['date_start']);?> - <?=tools::getDate($banner['date_end']);?> 
										<? if($this->view->bannerlist['newsites'][$banner['id']]>0){?>
										<sup class="orange bubble">+<?=$this->view->bannerlist['newsites'][$banner['id']];?></sup>
										<?}?>
									</div>
								</div>
								<div class="stats">
									<div class="col clubs">
										<h6>Заведения</h6>
										<div class="value bignum"><?=tools::int($this->view->bannerlist['plan'][$banner['id']]['sites']);?></div>
									</div>
									<div class="col plan">
										<h6>План (грн.)</h6>										
										<div class="value bignum"><?=ceil($this->view->bannerlist['plan'][$banner['id']]['visitors']*$this->registry->bannerprice);?></div>
									</div>
									<div class="col contacts">
										<h6>Возможно контактов</h6>										
										<div class="value bignum"><?=tools::int($this->view->bannerlist['plan'][$banner['id']]['visitors']);?></div>
									</div>
								</div>
							</a>
							<div class="overlay actions">
								<a class="ir edit<?=($past?' disabled':'')?>" href="#"></a>
								<a class="ir delete<?=($past?' disabled':'')?>" href="#"></a>
								<a class="ir open" href="/banner/<?=$banner['id'];?>/"></a>
							</div>
						</li>
						<?}?>
						
					</ul>
					<!--<ul class="banners-list old">
						<li class="banner">
							<a class="hl" href="#">
								<div class="img"><img src="/img/report/banner-thumb-3.jpg" /></div>
								<div class="head">
									<div class="id">b2334</div>
									<div class="date">23 января 2013 - 3 февраля 2013 <sup class="orange bubble">+3</sup></div>
								</div>
								<div class="stats">
									<div class="col clubs">
										<h6>Заведения</h6>
										<div class="value bignum">23</div>
									</div>
									<div class="col plan">
										<h6>План (грн.)</h6>										
										<div class="value bignum">4366</div>
									</div>
									<div class="col contacts">
										<h6>Возможно контактов</h6>										
										<div class="value bignum">234567</div>
									</div>
								</div>
							</a>
							<div class="actions">
								<a class="ir edit" href="#"></a>
								<a class="ir delete" href="#"></a>
							</div>
						</li>
						<li class="banner">
							<a class="hl" href="#">
								<div class="img"><img src="/img/report/banner-thumb-4.jpg" /></div>
								<div class="head">
									<div class="id">b2334</div>
									<div class="date">23 января 2013 - 3 февраля 2013 <sup class="orange bubble">+3</sup></div>
								</div>
								<div class="stats">
									<div class="col clubs">
										<h6>Заведения</h6>
										<div class="value bignum">23</div>
									</div>
									<div class="col plan">
										<h6>План (грн.)</h6>										
										<div class="value bignum">4366</div>
									</div>
									<div class="col contacts">
										<h6>Возможно контактов</h6>										
										<div class="value bignum">234567</div>
									</div>
								</div>
							</a>
							<div class="actions">
								<a class="ir edit" href="#"></a>
								<a class="ir delete" href="#"></a>
							</div>
						</li>
					</ul>-->
					<!--<div class="list-actions">
						<a class="button more" href="#">Загрузить еще</a>
					</div>-->
				</div>
			</div>			