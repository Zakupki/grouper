			<div class="centerwrap">
				<!--<div class="top-search">
					<form>
						<input class="txt query" type="text" name="query" value="" placeholder="Поиск">
						<a class="button submit" href="#"></a>
					</form>
				</div>-->
				<h1>
                    <? if($this->view->listtype==1){?>
                    Группы
                    <?}elseif($this->view->listtype==2){?>
                    Мои подключенные группы
                    <?}elseif($this->view->listtype==3){?>
                    Избранные группы
                    <?}?>
                </h1>
				<div class="widget groups" data-perpage="<?=$this->view->take;?>" data-listtype="<?=$this->view->listtype;?>">
					<div class="groups-filter">
						<div class="col city-select">
							<form>
								<select name="city">
									<option value="0"><?=$this->registry->trans['all'];?> тематики</option>
									<? foreach($this->view->grouptypes as $city){?>
									
									<option<?=($city['id']==tools::int($_GET['groupsubject']))?' selected="selected"':'';?> value="<?=$city['id'];?>"><?=$city['name'];?></option>
									<?}?>
								</select>
							</form>
						</div>
						<div class="col age">
							<h6><?=$this->registry->trans['avage'];?></h6>
							<a class="sort" href="#"></a>
						</div>
						<div class="col price">
							<h6>Цена за пост<a class="help" href="#help-3"></a></h6>
							<a class="sort" href="#"></a>
						</div>
						<div class="col contactprice">
							<h6>Стоим. контакта<a class="help" href="#help-43"></a></h6>
							<a class="sort" href="#"></a>
						</div>
						<div class="col refusal">
							<h6>% отказа<a class="help" href="#help-4"></a></h6>
							<a class="sort" href="#"></a>
						</div>
						<div class="col grp-followers">
							<h6>Кол-во подписчиков</h6>
							<a class="sort" href="#"></a>
						</div>
					</div>
					<ul class="groups-list">
					 <?=$this->view->clublist;?>
					</ul>
					<?
					if($this->view->clubsnum>count($this->view->clubs['sites'])){
					?>
					<div class="list-actions">
						<a class="button more" href="#"><?=$this->registry->trans['loadmore'];?></a>
					</div>
					<?}?>
                    <?
                    if ($this->registry->controller=="user" && $this->registry->action=="groups" && count($this->view->socialgroups)>0){?>
                    <h1>Мои неподключенные группы</h1>
                    <ul class="groups-list other-groups">
                        <? foreach($this->view->socialgroups as $acc){
                            foreach($acc as $g){?>
						<li rel="<?=$g['id'];?>" class="group user-group">
							<a class="logo" target="_blank" href="<?=$g['url'];?>">
								<img src="<?=$g['img'];?>" />
							</a>
							<div class="head">
								<div class="title">
									<a class="hl" target="_blank" href="<?=$g['url'];?>"><span class="txt"><?=$g['name'];?></span> 
									</a>
								</div>
								<a class="address i vk"><?=$g['subject'];?></a>
							</div>
							<a class="hl stats" target="_blank" href="<?=$g['url'];?>">
								<div class="col age">
									<h6><?=$this->registry->trans['avage'];?></h6>
									<div class="value bignum">0</div>
								</div>
								<div class="col price">
									<h6>Цена за пост</h6>
									<div class="value bignum">0</div>
									<div class="rating stars-0"></div>
								</div>
								<div class="col contactprice">
									<h6>Стоим. контакта</h6>
									<div class="value bignum">0</div>
									<div class="rating stars-0"></div>
								</div>
								<div class="col refusal">
									<h6>% отказа</h6>
									<div class="value bignum">0</div>
									<div class="rating stars-0"></div>
								</div>
								<div class="col grp-followers">
									<h6>Кол-во подписчиков</h6>
                    <div class="value bignum"><?=$g['count'];?></div>
									<div class="rating stars-0"></div>
								</div>
							</a>
							<div class="overlay actions">
								<a class="ir plus" href="/groups/update/?url=<?=urlencode($g['url']);?>"></a>
							</div>							
						</li>

                        <?}}?>
                    <ul>
                <?}?>
				</div>
			</div>