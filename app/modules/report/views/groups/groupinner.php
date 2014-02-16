<div class="group-stats centerwrap">
	<h1><a target="_blank" class="group-link" href="http://vk.com/<?=$this->view->groupdata['code'];?>"><span class="icon vk">http://vk.com/<?=$this->view->groupdata['code'];?></span></a>
		Статистика группы</h1>
<? if($this->view->hasdata==1){?>
<script>
var graphData = <?=$this->view->graphData;?>;
</script>
	<div class="tabs">
		<nav class="tabs-nav stats-nav">
			<ul class="clearfix">
				<li><a class="tab coverage" href="#tab-coverage">Города и демография группы в день</a></li> 
				<li><a class="tab visits" href="#tab-visits">Посещения в день</a></li>
				<li><a class="tab reach" href="#tab-reach">Охват в день</a></li>
			</ul>
		</nav>
		<div class="tabs-content">
			<div class="tab-pane clearfix" id="tab-coverage">
				<div class="clearfix">
					<div class="col5 bar chart" id="age-chart"></div>
					<div class="col5 pie chart" id="sex-chart"></div>
					<div class="col5 bar chart last-col" id="cities-chart"></div>
				</div>
			</div>
			<div class="tab-pane" id="tab-visits">
				<div id="visitors-chart" class="line chart"></div>
			</div>
			<div class="tab-pane" id="tab-reach">
				<div id="reach-chart" class="line chart"></div>
			</div>
		</div>
	</div>
    <?}else{?>
    Статистика вашей группы пока не доступна.
    <?}?>
</div>