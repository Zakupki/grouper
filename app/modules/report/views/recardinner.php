			<div class="centerwrap">
				<div class="recard-report">
					<h1><?=$this->registry->trans['recardplace'];?></h1>
					<div class="params clearfix">
						<div class="clubs-count col4">
							<h6><?=$this->registry->trans['clubstotal'];?> <a class="help" href="#help-0"></a></h6>
							<div class="txt bignum"><?=count($this->view->recardinner['sites']);?></div>
						</div>
						<div class="reports-count col4">
							<h6><?=$this->registry->trans['reporttotal'];?> <a class="help" href="#help-0"></a></h6>
							<div class="txt bignum">0</div>
						</div>
						<div class="date col4">
							<h6><?=$this->registry->trans['activationdate'];?></h6>
							<div class="txt"><?=tools::GetDate($this->view->recardinner['date_start']);?></div>
						</div>
						<div class="code col4 last-col">
							<h6><?=$this->registry->trans['opercode'];?></h6>
							<div class="txt">E<?=$this->view->recardinner['id'];?></div>
						</div>
					</div>

					<div class="recard-preview">
						<h5 class="title"><?=$this->view->recardinner['name'];?></h5>
						<div class="desc">
							<?=$this->view->recardinner['detail_text'];?>
						</div>
						<div class="meta clearfix">
							<? if($this->view->recardinner['fileurl']){?>
							<a class="attached" target="_blank" href="<?=$this->view->recardinner['fileurl'];?>"><?=$this->view->recardinner['filename'];?></a>
							<?}
							$filetertypes=array(0=>$this->registry->trans['filtertypeall'],1=>$this->registry->trans['filtertypefav'],2=>$this->registry->trans['filtertypesel']);
							?>
							<div class="clubs-status"><?=$filetertypes[$this->view->recardinner['filtertype']];?></div>
						</div>
					</div>

					<? if(count($this->view->recardinner['sites'])>0){?>
					<div class="recard-report-list bottom-list">
						<div class="head clearfix">
							<div class="c title"><?=$this->registry->trans['placename'];?></div>
							<div class="c total">Всего <a class="help" href="#help-41"></a></div>
							<div class="c used">Погашено <a class="help" href="#help-42"></a></div>
							<div class="c act">% Погаш. <a class="help" href="#help-0"></a></div>
							<div class="c percent-used">Активных <a class="help" href="#help-0"></a>.</div>
							<div class="c prosr">Просроч. <a class="help" href="#help-0"></a>.</div>
							<div class="c users">Пользоват. <a class="help" href="#help-0"></a></div>
							<div class="c count-avg">Цена <a class="help" href="#help-0"></a></div>
							<!--<div class="c btns"></div>-->
						</div>
						<?
						foreach($this->view->recardinner['sites'] as $site){
						?>
						<div class="item<?=($site['new'])?' new':'';?> clearfix" rel="<?=$site['id'];?>">
							<div class="c title">
								<a class="button star<?=($site['favourite'])?' active':'';?>" href="#"></a>
								<span class="txt">
                                    <?
                                    if(strlen($site['name'])>25)
                                        $site['name']=substr(strip_tags($site['name']), 0, 22)."...";
                                    ?>
                                    <?=$site['name'];?>
								</span>
								<? if($site['evcount']>0){?>
								<sup class="bubble"><?=$site['evcount'];?></sup>
								<?}?>
							</div>
							<div class="c total"><?=($site['TotalCoupon'])?$site['TotalCoupon']:0;?></div>
							<div class="c used"><?=($site['CouponsRedempt'])?$site['CouponsRedempt']:0;?></div>
							<div class="c act"><?=($site['RedemptionRatio'])?$site['RedemptionRatio']:'0%';?></div>
							<div class="c percent-used"><?=($site['ActiveCoupons'])?$site['ActiveCoupons']:0;?></div>
							<div class="c prosr"><?=($site['CouponsExpired'])?$site['CouponsExpired']:0;?></div>
							<div class="c users"><?=($site['ParticipantsCount'])?$site['ParticipantsCount']:0;?></div>
							<div class="c count-avg"><?=($site['price'])?$site['price']:0;?></div>
							<!--<div class="c btns"><a class="download" href="#"></a></div>-->
						</div>
						<?}?>
						
					</div>
					<?}?>
				</div>
			</div>
