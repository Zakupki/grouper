			<div class="centerwrap">
				<div class="public-report">
					<h1><?=($this->view->publicinner['id']==2)?'Репост':'Публикация';?> #<?=$this->view->publicinner['id'];?></h1>
					<div class="plan-fact clearfix">
						<div class="plan col4">
							<h3>План</h3>
							<dl>
								<dt>
									Кол-во групп
									<a class="help" href="#help-27"></a>
								</dt>
								<dd class="bignum"><?=$this->view->publicinner['plan']['groups'];?></dd>
								<dt>
									Кол-во подписчиков
									<a class="help" href="#help-28"></a>
								</dt>
								<dd class="bignum"><?=tools::int($this->view->publicinner['plan']['followers']);?></dd>
								<dt>
									Коэффициент
									<a class="help" href="#help-29"></a>
								</dt>
								<dd class="bignum"><?=$this->registry->publiccoef;?></dd>
								<dt>
									Кол-во контактов
									<a class="help" href="#help-30"></a>
								</dt>
								<dd class="bignum"><?=ceil($this->view->publicinner['plan']['followers']*$this->registry->publiccoef);?></dd>
								<dt>
									Стоимость одного контакта (грн.)
									<a class="help" href="#help-31"></a>
								</dt>
								<dd class="bignum"><?=$this->registry->contactprice;?></dd>
								<dt>
									Стоимость кампании (грн.)
									<a class="help" href="#help-32"></a>
								</dt>
								<dd class="bignum"><?=$this->view->publicinner['plan']['totalprice'];?></dd>
							</dl>
						</div>
						<div class="fact col4">
							<h3>Факт</h3>
                            <dl>
                                <dt>
                                    Кол-во групп
                                    <a class="help" href="#help-33"></a>
                                </dt>
                                <dd class="bignum"><?=tools::int($this->view->publicinner['fact']['groups']);?></dd>
                                <dt>
                                    Кол-во подписчиков
                                    <a class="help" href="#help-34"></a>
                                </dt>
                                <dd class="bignum"><?=tools::int($this->view->publicinner['fact']['followers']);?></dd>
                                <dt>
                                    Коэффициент
                                    <a class="help" href="#help-35"></a>
                                </dt>
                                <dd class="bignum"><?=$this->registry->publiccoef;?></dd>
                                <dt>
                                    Кол-во контактов
                                    <a class="help" href="#help-36"></a>
                                </dt>
                                <dd class="bignum"><?=ceil($this->view->publicinner['fact']['followers']*$this->registry->publiccoef);?></dd>
                                <dt>
                                    Стоимость одного контакта (грн.)
                                    <a class="help" href="#help-37"></a>
                                </dt>
                                <dd class="bignum"><?=$this->registry->contactprice;?></dd>
                                <dt>
                                    Стоимость кампании (грн.)
                                    <a class="help" href="#help-38"></a>
                                </dt>
                                <dd class="bignum"><?=$this->view->publicinner['fact']['totalprice'];?></dd>
                            </dl>
						</div>
						<div class="public-report-right col8 last-col">
							<div class="params clearfix">
								<div class="date col4">
									<h6>Начало рекламной кампании</h6>
									<div class="txt"><?=tools::GetDate($this->view->publicinner['date_start']);?></div>
								</div>
								<div class="code col4 last-col">
									<h6>Код операции</h6>
									<div class="txt">#<?=$this->view->publicinner['id'];?></div>
								</div>
							</div>

							<div class="public-preview">
								<div class="desc">
									<?=$this->view->publicinner['detail_text'];?>
								</div>
								<div class="meta clearfix">
									<? if($this->view->publicinner['fileurl']){?>
									<a class="attached" target="_blank" href="<?=$this->view->publicinner['fileurl'];?>"><?=$this->view->publicinner['filename'];?></a>
									<?}
									$filetertypes=array(0=>'Для всех групп',1=>'Для избранных групп',2=>'Для выбраных групп');
									?>
									<div class="clubs-status"><?=$filetertypes[$this->view->publicinner['filtertype']];?></div>
								</div>
							</div>

						</div>
					</div>
                    <? if(count($this->view->publicinner['sites'])>0){?>
					<div class="public-report-list bottom-list">
						<div class="head clearfix">
							<div class="c title">Название группы</div>
							<div class="c network">Сеть</div>
							<div class="c followers">Кол-во. подписчиков <a class="help" href="#help-34"></a></div>
							<div class="c contacts">Контакты <a class="help" href="#help-36"></a></div>
							<div class="c price">Стоимость</div>
							<div class="c link">Ссылка на отчет</div>
							<div class="c pay"> </div>
						</div>
						<?
						foreach($this->view->publicinner['sites'] as $group){
						?>
						<div class="item<?=($group['new'])?' new':'';?>" rel="<?=$group['id'];?>">
							<div class="line clearfix">
									<div class="c title">
									<a class="button star<?=($group['favourite'])?' active':'';?>" href="#"></a>
									<a href="/club/<?=$group['id'];?>/"><span class="txt">
                                        <?
                                        if(strlen($group['name'])>25)
                                            $group['name']=substr(strip_tags($group['name']), 0, 22)."...";
                                        ?>
                                        <?=$group['name'];?>
									</span>
									</a>
									</div>
								<div class="c network"><a href="<?=$group['url'];?>"><i style="background:url(<?=$group['image'];?>);"></i></a></div>
								<div class="c followers"><?=tools::int($group['likes']);?></div>
								<div class="c contacts"><?=ceil($group['likes']*$this->registry->publiccoef);?></div>
								<div class="c price"><?=$group['price'];?></div>
								<div class="c link">
                                    <?
                                    if(strlen(trim($group['link']))>0){
                                        $prottype='http://';
                                        if(strstr($group['link'],'https://')){
                                            $prottype='https://';
                                            $group['link']=str_replace('https://', '', $group['link']);
                                        }
                                        elseif(strstr($group['link'],'http://')){
                                            $group['link']=str_replace('http://', '', $group['link']);
                                            $prottype='http://';
                                        }
                                    }
                                    ?>
                                    <a target="_blank" href="<?=$prottype;?><?=$group['link'];?>"><?=$prottype;?><?=$group['link'];?></a>
								</div>
                                <div class="c pay">
                                    <? if($group['payed']){?>
                                    Оплачено
                                    <?}else{?>
                                    <a href="#" data-groupid="<?=$group['id'];?>">Оплатить</a>
                                    <?}?>
                                </div>
							</div>
						</div>
						<?}?>
					</div>
                    <?}?>
				</div>
			</div>
