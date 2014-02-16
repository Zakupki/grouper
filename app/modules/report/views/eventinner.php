			<div class="centerwrap">
				<div class="event-report">
					<h1>Размещение InDoor</h1>
					<div class="params clearfix">
						<div class="clubs-count col4">
							<h6>Кол-во заведений <a class="help" href="#help-39"></a></h6>
							<div class="txt bignum"><?=tools::int($this->view->eventinner['sitesrequested']);?></div>
						</div>
						<div class="offers-count col4">
							<h6>Кол-во предложений <a class="help" href="#help-40"></a></h6>
							<div class="txt bignum"><?=count($this->view->eventinner['sites']);?></div>
						</div>
						<div class="date col4">
							<h6>Дата InDoor</h6>
							<div class="txt"><?=tools::GetDate($this->view->eventinner['date_start']);?></div>
						</div>
						<div class="code col4 last-col">
							<h6>Код операции</h6>
							<div class="txt">E<?=$this->view->eventinner['id'];?></div>
						</div>
					</div>

					<div class="event-preview">
						<h5 class="title"><?=$this->view->eventinner['name'];?></h5>
						<div class="desc">
							<?=nl2br($this->view->eventinner['detail_text']);?>
						</div>
						<div class="meta clearfix">
							<? if($this->view->eventinner['fileurl']){?>
							<a class="attached" target="_blank" href="<?=$this->view->eventinner['fileurl'];?>"><?=$this->view->eventinner['filename'];?></a>
							<?}
							$filetertypes=array(0=>'Для всех заведений',1=>'Для избранных заведений',2=>'Для выбраных заведений');
							?>
							<div class="clubs-status"><?=$filetertypes[$this->view->eventinner['filtertype']];?></div>
						</div>
					</div>
                    <? if(count($this->view->eventinner['sites'])>0){?>
					<div class="event-report-list bottom-list">
						<div class="head clearfix">
							<div class="c title">Название заведения</div>
							<div class="c age">Ср. возраст</div>
							<div class="c check">Чек <a class="help" href="#help-3"></a></div>
							<div class="c recards">ReCards <a class="help" href="#help-2"></a></div>
							<div class="c grp">GRP <a class="help" href="#help-4"></a></div>
							<div class="c grpf">GRPF <a class="help" href="#help-5"></a></div>
							<div class="c link"></div>
						</div>
						<?
						foreach($this->view->eventinner['sites'] as $site){
						?>
						<div class="item<?=($site['new'])?' new':'';?> clearfix" rel="<?=$site['requestid'];?>">
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
							<div class="c age"><?=tools::int($site['age']);?></div>
							<div class="c check"><?=tools::int($site['checks']);?></div>
							<div class="c recards">0</div>
							<div class="c grp"><?=tools::int($site['visits']);?></div>
							<div class="c grpf"><?=tools::int($this->view->eventinner['likes'][$site['id']]);?></div>
							<div class="c link">
									<a href="#geteventreport">Посмотреть предложение</a>
							</div>
						</div>
						<?}?>
					</div>
                    <?}?>
				</div>
			</div>