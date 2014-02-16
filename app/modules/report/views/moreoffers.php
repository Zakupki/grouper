						<?
						$cnt=0;
						$total=0;
						foreach($this->view->events['events'] as  $event){
						$total++;	
					
						if($prev_date!=$event['date_start'] || $prev_type!=$event['offer']){
						if($cnt>0){?>
						</ul>
						</li>
						<?}?>
						<li class="eo-date<?=($prev_date==$event['date_start'])?' duplicate':'';?><?=($event['offer'])?' offers':'';?><?=(!$this->view->events['hasmore'] && $total==$this->view->events['datenum'])?' last':'';?>">
							<div class="date">
								<div class="day"><?=$event['dayinmonth'];?></div>
								<div class="month"><?=tools::GetMonth($event['month'],$this->registry->langid);?></div>
								<div class="weekday"><?=tools::GetDayOfWeek($event['dayinweek'],$this->registry->langid);?></div>
							</div>
							<ul class="eo-list">
						<?}?>
								<li class="event clearfix">
									<a class="club-logo" href="#">
										<img class="bw" src="<?=$event['logogray'];?>" />
										<img class="rollover" src="<?=$event['logo'];?>" />
										<i class="mask"></i>
									</a>
									<div class="img"><img src="<?=$event['avatar2'];?>" alt=""></div>
									<div class="head">
										<div class="club-title" rel="<?=$event['siteid'];?>">
											<a class="button star<?=($event['favourite'])?' active':'';?>" href="#"></a>
											<a class="hl" target="_blank" href="http://<?=$event['domain'];?>"><span class="txt"><?=$event['sitename'];?></span> 
												<? if($this->view->events['eventnums'][$event['siteid']]>0){?>
												<sup class="bubble"><?=$this->view->events['eventnums'][$event['siteid']];?></sup>
												<?} if($club['newclub']){?>
												<sup class="bubble orange"><b>новый</b></sup>
												<?}?>
											</a>
										</div>
										<a class="address" href="<?=$event['maplink'];?>"><?=$event['address'];?></a>
									</div>
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
								</li>
						<?
						$prev_date=$event['date_start'];
						$prev_type=$event['offer'];
						$cnt++;
						if($cnt==count($this->view->events['events'])){?>
						</ul>
						</li>
						<?}						
						}?>