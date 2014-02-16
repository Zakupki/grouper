			<div class="centerwrap">
				<div class="banner-report">
					<h1>Размещение баннера</h1>
					<div class="plan-fact clearfix">
						<div class="plan col4">
							<h3>План</h3>
							<dl>
								<dt>
									Кол-во заведений
									<a class="help" href="#help-8"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['plan']['sites'];?></dd>
								<dt>
									Посещений
									<a class="help" href="#help-9"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['plan']['visits'];?></dd>
								<dt>
									Уникальных посещений
									<a class="help" href="#help-10"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['plan']['visitors'];?></dd>
								<dt>
									Кол-во просмотров
									<a class="help" href="#help-11"></a>
								</dt>
								<dd class="bignum">-</dd>
								<dt>
									Стоимость одного контакта (грн.)
									<a class="help" href="#help-12"></a>
								</dt>
								<dd class="bignum"><?=$this->registry->bannerprice;?></dd>
								<dt>
									Стоимость кампании (грн.)
									<a class="help" href="#help-13"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['plan']['visitors']*$this->registry->bannerprice;?></dd>
							</dl>
						</div>
						<div class="fact col4">
							<h3>Факт</h3>
							<dl>
								<dt>
									Кол-во заведений
									<a class="help" href="#help-14"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['fact']['sites'];?></dd>
								<dt>
									Посещений
									<a class="help" href="#help-15"></a>
								</dt>
								<dd class="bignum"><?=tools::int($this->view->bannerinner['fact']['visits']);?></dd>
								<dt>
									Уникальных посещений
									<a class="help" href="#help-16"></a>
								</dt>
								<dd class="bignum"><?=tools::int($this->view->bannerinner['fact']['visitors']);?></dd>
								<dt>
									Кол-во просмотров
									<a class="help" href="#help-17"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['displayfact']['value'];?></dd>
								<dt>
									Стоимость одного контакта (грн.)
									<a class="help" href="#help-18"></a>
								</dt>
								<dd class="bignum"><?=$this->registry->bannerprice;?></dd>
								<dt>
									Стоимость кампании (грн.)
									<a class="help" href="#help-19"></a>
								</dt>
								<dd class="bignum"><?=$this->view->bannerinner['fact']['visitors']*$this->registry->bannerprice;?></dd>
							</dl>
						</div>
						<div class="banner-report-right col8 last-col">
							<div class="params clearfix">
								<div class="date-from col3">
									<h6>Начало кампании</h6>
									<div class="txt"><?=tools::GetDate($this->view->bannerinner['date_start']);?></div>									
								</div>
								<div class="date-to col3">
									<h6>Конец кампании</h6>
									<div class="txt"><?=tools::GetDate($this->view->bannerinner['date_end']);?></div>									
								</div>
								<div class="code col2 last-col">
									<h6>Код операции</h6>
									<div class="txt">b<?=$this->view->bannerinner['id'];?></div>									
								</div>
							</div>
							<div class="banner-preview">
								<div class="img"><img src="<?=$this->view->bannerinner['fileurl'];?>" alt=""></div>
								<div class="meta clearfix">
									<? if($this->view->bannerinner['fileurl']){?>
									<a class="attached" target="_blank" href="<?=$this->view->bannerinner['fileurl'];?>"><?=$this->view->bannerinner['filename'];?></a>
									<?}
									$filetertypes=array(0=>'Для всех заведений',1=>'Для избранных заведений',2=>'Для выбраных заведений');
									?>
									<div class="clubs-status"><?=$filetertypes[$this->view->bannerinner['filtertype']];?></div>
								</div>
							</div>
						</div>
					</div>
					<? if(count($this->view->bannerinner['sites'])>0){?>
					<div class="banner-report-list bottom-list">
						<div class="head clearfix">
							<div class="c title">Название заведения</div>
							<div class="c visits">Посещения <a class="help" href="#help-20"></a></div>
							<div class="c unique">Уник. посещения <a class="help" href="#help-21"></a></div>
							<div class="c clicks">Просмотры <a class="help" href="#help-22"></a></div>
							<div class="c clicks">Переходы <a class="help" href="#help-23"></a></div>
							<div class="c price">Стоимость (грн.) <a class="help" href="#help-24"></a></div>
							<!--<div class="c link">Ссылка на сайт</div>-->
						</div>
						<?
						foreach($this->view->bannerinner['sites'] as $site){
						?>
						<div class="item<?=($site['new'])?' new':'';?> clearfix" rel="<?=$site['id'];?>">
							<div class="c title">
								<a class="button star<?=($site['favourite'])?' active':'';?>" href="#"></a>
								<a href="/club/<?=$site['id'];?>/"><span class="txt">
                                    <?
                                    if(strlen($site['name'])>25)
                                        $site['name']=substr(strip_tags($site['name']), 0, 22)."...";
                                    ?>
                                    <?=$site['name'];?>
								</span>
								<? if($site['evcount']>0){?>
								<sup class="bubble"><?=$site['evcount'];?></sup>
								<?}?>
								</a>
							</div>
							<div class="c visits"><?=tools::int($this->view->bannerinner['analytics'][$site['id']]['visits']);?></div>
							<div class="c unique"><?=tools::int($this->view->bannerinner['analytics'][$site['id']]['visitors']);?></div>
							<div class="c clicks"><?=tools::int($this->view->bannerinner['displays'][$site['id']]);?></div>
							<div class="c clicks"><?=tools::int($this->view->bannerinner['clicks'][$site['id']]);?></div>
							<div class="c price"><?=$this->registry->bannerprice*$this->view->bannerinner['analytics'][$site['id']]['visitors'];?></div>
							<!--
							<div class="c link">
															<a href="#">http://www.mantra.dj</a>
														</div>-->
							
						</div>
						<?}?>
					</div>
					<?}?>
				</div>
			</div>
