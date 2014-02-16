			<div class="centerwrap">
				<h1><?=$this->registry->trans['place'];?></h1>
				<div class="widget club" rel="<?=$this->view->clubinner['id'];?>">
					<div class="summary">
						<div class="head">
							<div class="title">
								<a class="button star<?=($this->view->clubinner['favourite'])?' active':'';?>" href="#"></a>
								<a target="_blank" href="http://<?=$this->view->clubinner['domain'];?>"><span class="txt"><?=$this->view->clubinner['name'];?></span> 
									<? if(count($this->view->events['events'])>0){?>
									<sup class="bubble"><?=count($this->view->events['events']);?></sup> 
									<?}?>
									<? if($this->view->clubinner['new']){?>
									<sup class="bubble orange"><b>новый</b></sup>
									<?}?>
								</a>
							</div>
							<a class="address" href="<?=$this->view->clubinner['maplink'];?>"><?=$this->view->clubinner['address'];?></a>
						</div>
						<div class="stats clearfix">
							<div class="col age">
								<h6>Ср. возраст</h6>
								<div class="value bignum"><?=tools::int($this->view->clubinner['age']);?></div>
							</div>
							<!--<div class="col param-1">
								<h6>Параметр #1</h6>
								<div class="value bignum">23</div>
								<div class="rating stars-3"></div>
							</div>
							<div class="col param-2">
								<h6>Параметр #2</h6>
								<div class="value bignum">46</div>
								<div class="rating stars-3"></div>
							</div>-->
							<div class="col check">
								<h6>Чек <a class="help" href="#help-3"></a></h6>
								<div class="value bignum"><?=tools::int($this->view->clubinner['checks']);?></div>
								<div class="rating stars-<?=ceil($this->view->clubinner['checks']/$this->view->checkmax);?>"></div>
							</div>
							<div class="col recard">
								<h6>ReCard <a class="help" href="#help-2"></a></h6>
								<div class="value bignum">0</div>
								<div class="rating stars-0"></div>
							</div>
							<div class="col grp">
								<h6>Gross Rating Point <a class="help" href="#help-4"></a></h6>
								<div class="value bignum"><?=tools::int($this->view->clubinner['visits']);?></div>
								<div class="rating stars-<?=ceil($this->view->clubinner['visits']/$this->view->visitsmax);?>"></div>
							</div>
							<div class="col grp-followers">
								<h6>GRP Followers <a class="help" href="#help-5"></a></h6>
								<div class="value bignum"><?=tools::int($this->view->clubinner['likes']);?></div>
								<div class="rating stars-<?=ceil($this->view->clubinner['likes']/$this->view->likesmax);?>"></div>
							</div>
							<? if(tools::int($this->view->clubinner['plazma'])>0){?>
							<div class="col param-1">
								<h6>Кол. плазм</h6>
								<div class="value bignum"><?=tools::int($this->view->clubinner['plazma']);?></div>
							</div>
							<?}?>
							<div class="col param-2">
								<h6>Кол. барных стоек</h6>
								<div class="value bignum"><?=($this->view->clubinner['bar']==null)?1:$this->view->clubinner['bar'];?></div>
								<!--<div class="rating stars-3"></div>-->
							</div>
						</div>
					</div>

					<?
					if(count($this->view->statstypesdata)>0){ 
					?>
					<div class="widget club-graph">
						<div class="graph-select">
							<select name="graphSelect" class="custom">
								<?
								$cnt=0;
								foreach($this->view->statstypesdata as $stattype){?>
								<option value="<?=$stattype['id'];?>" style="background-image: url(/img/report/icon-club-<?=$stattype['code'];?>.png)"<?=($cnt)?'':' selected';?>><?=$stattype['name'];?></option>
								<?
								$cnt++;
								}?>
							</select>
						</div>

						<h2 class="title"></h2>

						<div class="graph-container">
							<?
							foreach($this->view->statstypesdata as $stattype){?>
							<div id="graph-<?=$stattype['id'];?>" class="graph"></div>
							<?}?>
						</div>

						<ul class="legend">
							<?
							foreach($this->view->statstypesdata as $stattype){?>
							<li class="param" rel="<?=$stattype['id'];?>" title="<?=$stattype['name'];?>">
								<!--<i class="dots" style="background-color: #<?/*=$stattype['color'];*/?>"></i>-->
								<img class="icon" src="/img/report/icon-club-<?=$stattype['code'];?>.png" alt="">
								<span class="count bignum"><?=$stattype['value'];?></span>
							</li>
							<?}?>
						</ul>
					</div>
					<?}?>

					<ul class="events-list">
						

						
						<?
						$offernum=0;
						foreach($this->view->events['events'] as $event){
						if($event['offer'])	
						$offernum++;
						?>
							
						<li class="event<?=($event['offer'])?' offer':'';?> clearfix">
							<a href="http://<?=$this->view->clubinner['domain'];?>/event/<?=$event['id'];?>/">
							<div class="date">
								<div class="day"><?=$event['dayinmonth'];?></div>
								<div class="month"><?=tools::GetMonth($event['month'],$this->registry->langid);?></div>
								<div class="weekday"><?=tools::GetDayOfWeek($event['dayinweek'],$this->registry->langid);?></div>
							</div>
							<div class="img"><img src="<?=$event['avatar2'];?>" alt=""></div>
							<div class="info">
								<? if(strlen(trim($event['name']))>0) {?>
								<h3 class="block title"><?=$event['name'];?></h3>
								<?} if(is_array($this->view->events['artists'][$event['itemid']])){
								
								  $artistHTML=null;
					              $supportHTML=null;
					              foreach($this->view->events['artists'][$event['itemid']] as $artist){
					                  if($artist['support'])
					                  $supportHTML.='
									  <li class="guest">
										<div class="name">'.$artist['name'].'</div>
									  </li>';
					                  else
					                  $artistHTML.='
									  <li class="guest">
										<div class="name">'.$artist['name'].'</div>
										<div class="label">'.$artist['comment'].'</div>
									  </li>';
					              }
					             if($artistHTML){?>
								<ul class="block top-guests clearfix">
									<?=$artistHTML;?>
								</ul>
								<?}if($supportHTML){?>
								<ul class="block guests clearfix">
									<?=$supportHTML;?>
								</ul>
								<?}}?>
								<div class="block desc">
								 <?
					            if(strlen($event['detail_text'])>270){
					            $event['detail_text']=mb_substr(strip_tags($event['detail_text']), 0, 267, 'UTF-8')."...";}
					            echo $event['detail_text'];?>
								</div>
							</div>
							</a>
						</li>
						<?}?>

						<!--<li class="event offer clearfix">
							<div class="date">
								<div class="day">31</div>
								<div class="month">июня</div>
								<div class="weekday">Понедельник</div>
							</div>
							<div class="img"><img src="/img/report/club-event-1.jpg" alt=""></div>
							<div class="info">
								<ul class="block top-guests clearfix">
									<li class="guest">
										<div class="name">Steve Lowler</div>
										<div class="label">Viva music, Flamingo Records (UK)</div>
									</li>
									<li class="guest">
										<div class="name">Fedde Le Grand </div>
										<div class="label">Flamingo Records</div>
									</li>
								</ul>
								<ul class="block guests clearfix">
									<li class="guest">
										<div class="name">Sender</div>
									</li>
									<li class="guest">
										<div class="name">Goshva</div>
									</li>
								</ul>
								<div class="block desc">Steve Lawler djing live in south america at Creamfields Buenos Aires, Argentina. The tenth edition of Creamfields Buenos Aires (November 13, 2010), the festival's most important electronic music of Argentina, will take place next Saturday at the Speedway of Buenos Aires. The celebration of 10 years will reach the most diverse line up...</div>
							</div>
						</li>
						<li class="event clearfix">
							<div class="date">
								<div class="day">31</div>
								<div class="month">июня</div>
								<div class="weekday">Понедельник</div>
							</div>
							<div class="img"><img src="/img/report/club-event-1.jpg" alt=""></div>
							<div class="info">
								<h3 class="block title">To Life Love and Loot</h3>
								<ul class="block guests clearfix">
									<li class="guest">
										<div class="name">Sender</div>
									</li>
									<li class="guest">
										<div class="name">Goshva</div>
									</li>
								</ul>
								<div class="block desc">Steve Lawler djing live in south america at Creamfields Buenos Aires, Argentina. The tenth edition of Creamfields Buenos Aires (November 13, 2010), the festival's most important electronic music of Argentina, will take place next Saturday at the Speedway of Buenos Aires. The celebration of 10 years will reach the most diverse line up...</div>
							</div>
						</li>-->
					</ul>

					<ul class="list-actions clearfix">
						<? if($offernum>0){?>
						<li>
							<a class="offers"><span class="bignum count"><?=$offernum;?></span> <span class="txt">предложения</span></a>
							<a class="help" href="#help-0"></a>
						</li>
						<?}?>
						<?if(count($this->view->events['events'])>0){?>
						<li>
							<a class="events"><span class="bignum count"><?=count($this->view->events['events']);?></span> <span class="txt">ивента</span></a>
						</li>
						<?}?>
					</ul>

				</div>
			</div>
