<div class="m2">
  <ul>
    <li<?=(!$this->registry->routername || $this->registry->routername=='index' || $this->registry->routername=='news2' || $this->registry->routername=='news')?' class="act"':'';?>><span class="a"><a href="/news/"><span class="title"><?=$this->registry->trans['recommended'];?></span></a></span></li>
    <li class="last <?=($this->view->registry->routername=='newslatest' || $this->view->registry->routername=='newslatestinner' ||  $this->view->registry->routername=='newslatest2')?'act':'';?>">
      <span class="a">
        <a href="/news/latest/">
          <span class="title"><?=$this->registry->trans['latest'];?></span>
		  <? if($this->view->newitemnum>0){?>
          <span class="new"><span class="r"><span class="l"><span class="text">+<?=$this->view->newitemnum;?></span></span></span></span>
		  <?}?>
        </a>
      </span>
    </li>
    <!--<li class="last<?=($this->registry->routername=='newsservice')?' act':'';?>"><span class="a"><a href="/news/service/"><span class="title">Служебные</span></a></span></li>-->
  </ul>
</div>