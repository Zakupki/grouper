			<div class="centerwrap clearfix">
				<h1>
				   Предложения
				</h1>
				<div class="events-offers" data-perpage="<?=$this->view->takeevents;?>" data-typeid="<?=$this->view->typeid;?>">
					<ul class="eo-dates-list">
						<?=$this->view->offerlist;?>
					</ul>
					<? if(count($this->view->events['events'])>0){?>
					<div class="list-actions">
						<a class="button more" href="#"><?=$this->registry->trans['loadmore'];?></a>
					</div>
					<?}?>
				</div>
			</div>