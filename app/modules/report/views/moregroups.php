						<?
						$total=0;
						foreach($this->view->clubs['sites'] as $club){
						$total++;	
						?>
						<li rel="<?=$club['id'];?>" class="group<?=(!$this->view->clubs['hasmore'] && $total==count($this->view->clubs['sites']))?' last':'';?><?=($club['userid']==$_SESSION['User']['id'])?' user-group':'';?>">
							<a class="logo" href="/group/<?=$club['id'];?>/">
								<img class="bw" src="<?=$club['logogray'];?>" />
								<img class="rollover" src="<?=$club['logo'];?>" />
							</a>
							<div class="head">
								<div class="title">
									<a class="button star<?=($club['favourite'])?' active':'';?>" href="#"></a>
									<a class="hl" href="/group/<?=$club['id'];?>/"><span class="txt"><?=$club['name'];?></span>
										<? if($this->view->clubs['data'][$club['id']]['eventnum']>0){?>
										<sup class="bubble"><?=$this->view->clubs['data'][$club['id']]['eventnum'];?></sup>
										<?}?>
										<? if($club['new']){?>
										<sup class="bubble orange"><b><?=$this->registry->trans['newsm'];?></b></sup>
										<?}?>
									</a>
								</div>
								<a class="address i vk"><?=$club['subject'];?></a>
							</div>
							<a class="hl stats" href="/group/<?=$club['id'];?>/">
								<div class="col age">
									<h6><?=$this->registry->trans['avage'];?></h6>
									<div class="value bignum"><?=tools::int($club['age']);?></div>
								</div>
								<div class="col price">
									<h6>Цена за пост</h6>
									<div class="value bignum"><?=$club['price'];?></div>
									<div class="rating stars-<?=ceil($club['checks']/$this->view->clubs['checksmax']);?>"></div>
								</div>
								<div class="col contactprice">
									<h6>Стоим. контакта</h6>
									<div class="value bignum"><?=round($club['price']/$club['likes'],4);?></div>
									<div class="rating stars-0"></div>
								</div>
								<div class="col refusal">
									<h6>% отказа</h6>
									<div class="value bignum"><?=tools::int($club['visits']);?></div>
									<div class="rating stars-<?=ceil($club['visits']/$this->view->clubs['visitsmax']);?>"></div>
								</div>
								<div class="col grp-followers">
									<h6>Кол-во подписчиков</h6>
									<div class="value bignum"><?=tools::int($club['likes']);?></div>
									<div class="rating stars-<?=ceil($club['likes']/$this->view->clubs['likesmax']);?>"></div>
								</div>
							</a>
							<div class="overlay actions">
                                <? //if(!$club['notconnected']){ ?>
								<a class="ir edit" href="/groups/update?id=<?=$club['id'];?>"></a>
                                <?//}?>
								<a class="ir delete" href="#"></a>
							</div>
							<? if($club['notconnected']){ ?>
							<!--<div class="overlay error">
								<div class="txt">Вам необходимо подключить аккаунт соц.сети в которой находится данная группа</div>
							</div>-->
							<?}?>
						</li>
						<?}?>
	